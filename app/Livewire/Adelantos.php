<?php

namespace App\Livewire;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Persona;
use App\Models\Adelanto;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Adelantos extends Component
{
    use LivewireAlert;
    
    public $selectedDate; // Fecha seleccionada para el filtro
    public $lideres; // Variable para almacenar los líderes
    public $adelantos = [];
    public $adelantoId;
    public $selectedPersonaId = null; // ID de la persona seleccionada
    public $personas; // Lista de personas disponibles
    public $modalVisible = false;
    public $ID_Persona;
    public $personaSeleccionada, $fecha, $monto, $entregadoPor, $descripcion;
    public $modalFiltro;

    public $filtro = [
        'fechaDesde' => null,
        'fechaHasta' => null,
    ];
    protected $rules = [
        'ID_Persona' => 'required|exists:personas,id',
        'fecha' => 'required|date',
        'monto' => 'required|numeric|min:0',
        'entregadoPor' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->adelantos = Adelanto::with('persona')
            ->orderBy('Fecha', 'desc')  // o ->latest() si prefieres por created_at
            ->get();
        $this->personas = Persona::withTrashed()
            ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END')
            ->orderBy('Nombre')
            ->orderBy('Apellido')
            ->get();
            $this->selectedDate = null; // Inicializar el filtro de fecha como nulo
            $this->lideres = Persona::where('Puesto_Trabajo', 'Líder')->get(); // Solo líderes
    }

    public function updatedSelectedPersonaId()
    {
        $this->loadAdelantos();
    }

    public function loadAdelantos()
    {
        $query = Adelanto::with(['persona' => function ($query) {
            $query->withTrashed()
                ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END')
                ->orderBy('Nombre')
                ->orderBy('Apellido');
        }]);

        // Aplica el filtro por persona seleccionada
        if ($this->selectedPersonaId) {
            $query->where('ID_Persona', $this->selectedPersonaId);
        }

        // Aplica el filtro por fecha seleccionada
        if ($this->selectedDate) {
            $query->whereDate('Fecha', $this->selectedDate);
        }

        // Aplica los filtros de rango de fecha
        if ($this->filtro['fechaDesde']) {
            $fechaDesde = Carbon::parse($this->filtro['fechaDesde'])->startOfDay();
            $query->where('Fecha', '>=', $fechaDesde);
        }

        if ($this->filtro['fechaHasta']) {
            $fechaHasta = Carbon::parse($this->filtro['fechaHasta'])->endOfDay();
            $query->where('Fecha', '<=', $fechaHasta);
        }
        $query->orderBy('Fecha', 'desc');
        $this->adelantos = $query->get();
    }


    public function showModal($id = null)
    {
        $this->resetInputFields(); // Limpia campos previos

        if ($id) {
            $this->adelantoId = $id;
            $adelanto = Adelanto::findOrFail($id);

            // Carga los datos en las propiedades
            $this->ID_Persona = $adelanto->ID_Persona;
            $this->fecha = $adelanto->Fecha;
            $this->monto = $adelanto->Monto;
            $this->entregadoPor = $adelanto->Entregado_Por;
            $this->descripcion = $adelanto->Descripcion;
        }

        $this->modalVisible = true; // Muestra el modal
    }

    public function hideModal()
    {
        $this->modalVisible = false;
    }
    
        public function store()
    {
        $this->validate();

        if ($this->adelantoId) {
            // Actualizar un adelanto existente
            $adelanto = Adelanto::findOrFail($this->adelantoId);
            $adelanto->update([
                'ID_Persona' => $this->ID_Persona,
                'Fecha' => $this->fecha,
                'Monto' => $this->monto,
                'Entregado_Por' => $this->entregadoPor,
                'Descripcion' => $this->descripcion,
            ]);
            $this->alert('success', 'Adelanto actualizado correctamente.');
        } else {
            // Crear un nuevo adelanto
            Adelanto::create([
                'ID_Persona' => $this->ID_Persona,
                'Fecha' => $this->fecha,
                'Monto' => $this->monto,
                'Entregado_Por' => $this->entregadoPor,
                'Descripcion' => $this->descripcion,
            ]);
            $this->alert('success', 'Adelanto creado correctamente.');
        }

        $this->resetInputFields();
        $this->hideModal();
        $this->loadAdelantos(); // Recarga la lista de adelantos
    }

    
    private function resetInputFields()
    {
        $this->ID_Persona = '';
        $this->fecha = '';
        $this->monto = '';
        $this->entregadoPor = '';
        $this->descripcion = '';
    }
    
    public function buscarAdelantos()
    {
        // Inicia la consulta base
        $query = Adelanto::with(['persona' => function ($query) {
            $query->withTrashed()
                ->orderByRaw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END')
                ->orderBy('Nombre')
                ->orderBy('Apellido');
        }]);

        // Aplica el filtro por persona seleccionada, si existe
        if ($this->selectedPersonaId) {
            $query->where('ID_Persona', $this->selectedPersonaId);
        }

        // Aplica el filtro por fecha seleccionada, si existe
        if ($this->selectedDate) {
            $query->whereDate('Fecha', $this->selectedDate);
        }

        // Obtén los resultados y almacénalos en $adelantos
        $this->adelantos = $query->get();
    }

    
    public function render()
    {
        return view('livewire.adelantos');
    }


    public function confirmarBorrado($id)
    {
        $this->adelantoId = $id;

        $this->alert('warning', '¿Estás seguro de que deseas borrar este adelanto?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'eliminarAdelanto',
            'showCancelButton' => true,
            'onDismissed' => 'cancelarBorrado',
            'confirmButtonText' => 'Sí, eliminar',
            'cancelButtonText' => 'No, cancelar',
        ]);
    }


    protected function getListeners()
    {
        return [
            'eliminarAdelanto',
            'cancelarBorrado'
        ];
    }


    public function eliminarAdelanto()
    {
        try {
            $adelanto = Adelanto::find($this->adelantoId);
            if ($adelanto) {
                $adelanto->delete();
                $this->loadAdelantos();
                $this->alert('success', 'Adelanto eliminado correctamente');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Ocurrió un error al eliminar el adelanto');
        }
    }


    public function cancelarBorrado()
    {
        $this->adelantoId = null;
        $this->alert('info', 'Operación cancelada');
    }

        public function descargarPDF()
    {
        $datos = $this->adelantos->map(function ($adelanto) {
            return [
                'Persona' => $adelanto->persona 
                    ? $adelanto->persona->Nombre . ' ' . $adelanto->persona->Apellido 
                    : 'No especificado',
                'Fecha' => $adelanto->Fecha,
                'Monto' => $adelanto->Monto,
                'Entregado Por' => $adelanto->entregadoPor 
                    ? $adelanto->entregadoPor->Nombre . ' ' . $adelanto->entregadoPor->Apellido 
                    : 'No especificado',
                'Descripción' => $adelanto->Descripcion ?? 'Sin descripción',
            ];
        });

        $pdf = Pdf::loadView('pdf.adelantos', ['adelantos' => $datos]);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'adelantos.pdf'
        );
    }


    public function aplicarFiltros()
    {
        $this->loadAdelantos();
        $this->modalFiltro = false;
        $this->alert('success', 'Filtros aplicados correctamente.');
    }
      
    
    public function limpiarFiltros()
    {
        // Reinicia los filtros a sus valores iniciales
        $this->filtro = [
            'fechaDesde' => null,
            'fechaHasta' => null,
        ];
    
        // Recarga todos los adelantos sin aplicar filtros
        $this->adelantos = Adelanto::with('persona')->get();
    
        // Cierra el modal de filtros
        $this->modalFiltro = false;
    
        // Muestra una alerta informativa
        $this->alert('info', 'Filtros limpiados.');
    }
    
}
