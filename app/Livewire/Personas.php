<?php

namespace App\Livewire;

use App\Models\Persona;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Personas extends Component
{
    use LivewireAlert;

    public $personaId;
    public $personas;
    public $modalVisible = false; // Controla la visibilidad del modal
    public $nombre, $apellido, $dni, $telefono, $domicilio, $correoElectronico, $puestoTrabajo;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|numeric|unique:personas,DNI,' . $this->personaId,
            'telefono' => 'nullable|string|max:15',
            'domicilio' => 'nullable|string|max:255',
            'correoElectronico' => 'nullable|email|unique:personas,Correo_Electronico,' . $this->personaId,
            'puestoTrabajo' => 'nullable|string|max:255',
        ];
    }
    

    public function mount()
    {
        $this->personas = Persona::orderBy('Apellido', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.persona'); // Usar el diseño de Jetstream
    }

    public function showModal($id=null)
    {
        $this->resetInputFields();

        if ($id) {
            $this->personaId = $id;
            $persona = Persona::findOrFail($id);

            $this->nombre = $persona->Nombre;
            $this->apellido = $persona->Apellido;
            $this->dni = $persona->DNI;
            $this->telefono = $persona->Telefono;
            $this->domicilio = $persona->Domicilio;
            $this->correoElectronico = $persona->Correo_Electronico;
            $this->puestoTrabajo = $persona->Puesto_Trabajo;
        }

        $this->modalVisible = true;
    }

    public function hideModal()
    {
        $this->modalVisible = false;
    }

    public function store()
    {
        $this->validate($this->rules());

        Persona::updateOrCreate(
            ['id' => $this->personaId],
            [
            'Nombre' => $this->nombre,
            'Apellido' => $this->apellido,
            'DNI' => $this->dni,
            'Telefono' => $this->telefono,
            'Domicilio' => $this->domicilio,
            'Correo_Electronico' => $this->correoElectronico,
            'Puesto_Trabajo' => $this->puestoTrabajo,
        ]);

        $this->personas = Persona::all(); // Actualizar la lista
        $this->hideModal();
        session()->flash('message', 'Persona creada exitosamente.');
    }

    private function resetInputFields()
    {
        $this->personaId = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->dni = '';
        $this->telefono = '';
        $this->domicilio = '';
        $this->correoElectronico = '';
        $this->puestoTrabajo = '';
    }

        public function delete($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        $this->personas = Persona::all(); // Actualizar la lista
        session()->flash('message', 'Persona eliminada exitosamente.');
    }

    public function confirmarBorrado($id)
    {
        $this->personaId = $id;

        $this->alert('warning', '¿Estás seguro de que deseas eliminar esta persona?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'eliminarPersona',
            'showCancelButton' => true,
            'onDismissed' => 'cancelarBorrado',
            'confirmButtonText' => 'Sí, eliminar',
            'cancelButtonText' => 'No, cancelar',
        ]);
    }

    protected function getListeners()
    {
        return [
            'eliminarPersona',
            'cancelarBorrado'
        ];
    }

    public function eliminarPersona()
    {
        try {
            $persona = Persona::find($this->personaId);
            if ($persona) {
                $persona->delete();
                $this->personas = Persona::all();
                $this->alert('success', 'Persona eliminada correctamente');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Ocurrió un error al eliminar la persona');
        }
    }

    public function cancelarBorrado()
    {
        $this->personaId = null;
        $this->alert('info', 'Operación cancelada');
    }
}
