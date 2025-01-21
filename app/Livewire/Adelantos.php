<?php

namespace App\Livewire;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Persona;
use App\Models\Adelanto;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

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

    protected $rules = [
        'ID_Persona' => 'required|exists:personas,id',
        'fecha' => 'required|date',
        'monto' => 'required|numeric|min:0',
        'entregadoPor' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:500',
    ];

    public function mount()
{
    $this->adelantos = Adelanto::with('persona')->get();
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
    // Inicia una consulta base para Adelanto
    $query = Adelanto::with('persona');

    // Aplica el filtro por persona seleccionada si existe
    if ($this->selectedPersonaId) {
        $query->where('ID_Persona', $this->selectedPersonaId);
    }

    // Aplica el filtro por fecha seleccionada si existe
    if ($this->selectedDate) {
        $query->whereDate('Fecha', $this->selectedDate);
    }

    // Obtén los resultados de la consulta
    $this->adelantos = $query->get();
    //
    $this->adelantos = Adelanto::with(['persona', 'Entregado_Por'])->get();
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
        return view('livewire.adelantos')->layout('layouts.app');
    }


    public function confirmarBorrado($adelantoId)
    {
        $this->adelantoId = $adelantoId;

        // Lanza el popup de confirmación
        $this->alert('warning', '¿Estás seguro de que deseas borrar este adelanto?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí, borrar',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'onConfirmed' => 'borrarAdelanto',  // Método a ejecutar si el usuario confirma
            'onDismissed' => 'cancelarBorrado', // Método a ejecutar si el usuario cancela
            'timer' => null,
            'position' => 'center',
            'toast' => null,
        ]);
    }

    #[On('borrarAdelanto')]
    public function borrarAdelanto($adelantoId)
    {
        $adelanto = Adelanto::find($adelantoId);

        if ($adelanto) {
            $adelanto->delete(); // Elimina el adelanto
            $this->alert('success', 'El adelanto se eliminó correctamente.', [
                'position' => 'center',
                'toast' => null,
            ]);
        } else {
            $this->alert('error', 'No se encontró el adelanto.', [
                'position' => 'center',
                'toast' => null,
            ]);
        }

        $this->adelantoId = null; // Limpia el ID del adelanto
        $this->adelantos = Adelanto::all(); // Actualizar la lista
    }

    #[On('cancelarBorrado')]
    public function cancelarBorrado()
    {
        // Mensaje de cancelación opcional
        $this->alert('info', 'La eliminación fue cancelada.', [
            'position' => 'center',
            'toast' => null,
        ]);

        $this->adelantoId = null; // Limpia el ID del adelanto
    }



public function descargarPDF()
{
    $datos = $this->adelantos->map(function ($adelanto) {
        return [
            'Persona' => $adelanto->persona->Nombre . ' ' . $adelanto->persona->Apellido,
            'Fecha' => $adelanto->Fecha,
            'Monto' => $adelanto->Monto,
            'Entregado Por' => $adelanto->Entregado_Por,
            'Descripción' => $adelanto->Descripcion,
        ];
    });

    $pdf = Pdf::loadView('pdf.adelantos', ['adelantos' => $datos]);
    return response()->streamDownload(
        fn () => print($pdf->output()),
        'adelantos.pdf'
    );
}
// Modelo Adelanto.php
public function entregadoPor()
{
    return $this->belongsTo(Persona::class, 'entregadoPor'); // Clave foránea en la tabla adelantos
}


}
