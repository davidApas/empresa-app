<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Pago;
use App\Models\Persona;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Pagos extends Component
{
    use LivewireAlert;
    
    public $modalPago = false;
    public $pagoId;
    
    // Campos de pago
    public $ID_Persona;
    public $fecha;
    public $tipo_pago;
    public $nro_horas;
    public $precio_hora;
    public $dias_trabajados;
    public $precio_dia;
    public $total = 0;
    public $descripcion;
    public $modalFiltro = false;

    // Filtros
    public $selectedPersonaId = null;
    public $personas;
    public $pagos = [];
    public $filtro = [
        'fechaDesde' => null,
        'fechaHasta' => null,
    ];

    // Reglas de validación
    protected $rules = [
        'ID_Persona' => 'required|exists:personas,id',
        'fecha' => 'required|date',
        'tipo_pago' => 'required|in:horas,dia',
        'descripcion' => 'nullable|string|max:500',
    ];

    // Reglas dinámicas para horas o días
    public function getRulesProperty()
    {
        $baseRules = $this->rules;
        
        if ($this->tipo_pago === 'horas') {
            $baseRules['nro_horas'] = 'required|numeric|min:0';
            $baseRules['precio_hora'] = 'required|numeric|min:0';
        } elseif ($this->tipo_pago === 'dia') {
            $baseRules['dias_trabajados'] = 'required|numeric|min:0';
            $baseRules['precio_dia'] = 'required|numeric|min:0';
        }
        
        return $baseRules;
    }

    public function mount()
    {
        $this->personas = Persona::withTrashed()
            ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END')
            ->orderBy('Nombre')
            ->orderBy('Apellido')
            ->get();
        
        $this->loadPagos();
    }

    public function updatedTipoPago()
    {
        $this->calculateTotal();
    }

    public function updatedNroHoras()
    {
        $this->calculateTotal();
    }

    public function updatedPrecioHora()
    {
        $this->calculateTotal();
    }

    public function updatedDiasTrabajados()
    {
        $this->calculateTotal();
    }

    public function updatedPrecioDia()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if ($this->tipo_pago === 'horas') {
            $this->total = $this->nro_horas * $this->precio_hora;
        } elseif ($this->tipo_pago === 'dia') {
            $this->total = $this->dias_trabajados * $this->precio_dia;
        } else {
            $this->total = 0;
        }
    }

    public function showModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $this->pagoId = $id;
            $pago = Pago::findOrFail($id);

            // Carga los datos en las propiedades
            $this->ID_Persona = $pago->ID_Persona;
            $this->fecha = $pago->fecha;
            $this->tipo_pago = $pago->tipo_pago;
            $this->nro_horas = $pago->nro_horas;
            $this->precio_hora = $pago->precio_hora;
            $this->dias_trabajados = $pago->dias_trabajados;
            $this->precio_dia = $pago->precio_dia;
            $this->descripcion = $pago->descripcion;
            $this->total = $pago->total;
        }

        $this->modalPago = true;
    }

    public function store()
    {
        $this->validate($this->rules);

        if ($this->pagoId) {
            // Actualizar un pago existente
            $pago = Pago::findOrFail($this->pagoId);
            $pago->update([
                'ID_Persona' => $this->ID_Persona,
                'fecha' => $this->fecha,
                'tipo_pago' => $this->tipo_pago,
                'nro_horas' => $this->tipo_pago === 'horas' ? $this->nro_horas : null,
                'precio_hora' => $this->tipo_pago === 'horas' ? $this->precio_hora : null,
                'dias_trabajados' => $this->tipo_pago === 'dia' ? $this->dias_trabajados : null,
                'precio_dia' => $this->tipo_pago === 'dia' ? $this->precio_dia : null,
                'total' => $this->total,
                'descripcion' => $this->descripcion,
            ]);
            $this->alert('success', 'Pago actualizado correctamente.');
        } else {
            // Crear un nuevo pago
            Pago::create([
                'ID_Persona' => $this->ID_Persona,
                'fecha' => $this->fecha,
                'tipo_pago' => $this->tipo_pago,
                'nro_horas' => $this->tipo_pago === 'horas' ? $this->nro_horas : null,
                'precio_hora' => $this->tipo_pago === 'horas' ? $this->precio_hora : null,
                'dias_trabajados' => $this->tipo_pago === 'dia' ? $this->dias_trabajados : null,
                'precio_dia' => $this->tipo_pago === 'dia' ? $this->precio_dia : null,
                'total' => $this->total,
                'descripcion' => $this->descripcion,
            ]);
            $this->alert('success', 'Pago creado correctamente.');
        }

        $this->resetInputFields();
        $this->modalPago = false;
        $this->loadPagos();
    }

    private function resetInputFields()
    {
        $this->ID_Persona = null;
        $this->fecha = null;
        $this->tipo_pago = null;
        $this->nro_horas = 0;
        $this->precio_hora = 0;
        $this->dias_trabajados = 0;
        $this->precio_dia = 0;
        $this->total = 0;
        $this->descripcion = null;
        $this->pagoId = null;
    }

    public function loadPagos()
    {
        $query = Pago::with(['persona' => function ($query) {
            $query->withTrashed()
                ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END')
                ->orderBy('Nombre')
                ->orderBy('Apellido');
        }]);

        // Aplica el filtro por persona seleccionada
        if ($this->selectedPersonaId) {
            $query->where('ID_Persona', $this->selectedPersonaId);
        }

        // Aplica los filtros de rango de fecha
        if ($this->filtro['fechaDesde']) {
            $fechaDesde = Carbon::parse($this->filtro['fechaDesde'])->startOfDay();
            $query->where('fecha', '>=', $fechaDesde);
        }

        if ($this->filtro['fechaHasta']) {
            $fechaHasta = Carbon::parse($this->filtro['fechaHasta'])->endOfDay();
            $query->where('fecha', '<=', $fechaHasta);
        }

        $query->orderBy('fecha', 'desc');
        $this->pagos = $query->get();
    }

    public function render()
    {
        return view('livewire.pagos');
    }

    public function confirmarBorrado($id)
    {
        $this->pagoId = $id;

        $this->alert('warning', '¿Estás seguro de que deseas borrar este pago?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'eliminarPago',
            'showCancelButton' => true,
            'onDismissed' => 'cancelarBorrado',
            'confirmButtonText' => 'Sí, eliminar',
            'cancelButtonText' => 'No, cancelar',
        ]);
    }

    public function eliminarPago()
    {
        try {
            $pago = Pago::find($this->pagoId);
            if ($pago) {
                $pago->delete();
                $this->loadPagos();
                $this->alert('success', 'Pago eliminado correctamente');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Ocurrió un error al eliminar el pago');
        }
    }

    public function cancelarBorrado()
    {
        $this->pagoId = null;
        $this->alert('info', 'Operación cancelada');
    }

    public function aplicarFiltros()
    {
        $this->loadPagos();
        $this->alert('success', 'Filtros aplicados correctamente.');
        $this->modalFiltro = false;
    }
      
    public function limpiarFiltros()
    {
        // Reinicia los filtros a sus valores iniciales
        $this->filtro = [
            'fechaDesde' => null,
            'fechaHasta' => null,
        ];
        $this->selectedPersonaId = null;
    
        // Recarga todos los pagos sin aplicar filtros
        $this->loadPagos();
    
        // Muestra una alerta informativa
        $this->alert('info', 'Filtros limpiados.');
    }

    public function descargarPDF()
    {
        $datos = $this->pagos->map(function ($pago) {
            return [
                'Persona' => $pago->persona 
                    ? $pago->persona->Nombre . ' ' . $pago->persona->Apellido 
                    : 'No especificado',
                'Fecha' => $pago->fecha,
                'Tipo Pago' => $pago->tipo_pago === 'horas' ? 'Por Horas' : 'Por Día',
                'Cantidad' => $pago->tipo_pago === 'horas' 
                    ? $pago->nro_horas . ' horas' 
                    : $pago->dias_trabajados . ' días',
                'Precio Unitario' => $pago->tipo_pago === 'horas' 
                    ? $pago->precio_hora 
                    : $pago->precio_dia,
                'Total' => $pago->total,
                'Descripción' => $pago->descripcion ?? 'Sin descripción',
            ];
        });

        $pdf = Pdf::loadView('pdf.pagos', ['pagos' => $datos]);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'pagos.pdf'
        );
    }
}