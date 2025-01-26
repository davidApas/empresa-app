<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pago;

class Pagos extends Component
{
    public $modalPago = false;
    public $pagos;
    public $fecha;
    public $nro_horas = 0; // Inicializa con 0
    public $precio_hora = 0; // Inicializa con 0
    public $deuda = 0;
    public $relevo = 0;
    public $precio_relevo = 0;
    public $operaciones = [];
    public $total;
    public function mount()
    {
        $this->pagos = Pago::all();
    }

    // Método computado para calcular el total
    public function calcularTotalPago()
    {
        if($this->nro_horas ==null || $this->precio_hora == null ){
            $total= 0;
        }
        else{
            $total = $this->nro_horas * $this->precio_hora;
        }
        return $total; 
    }

    public function guardarPago()
    {
        $pago = Pago::create([
            'fecha' => $this->fecha,
            'nro_horas' => $this->nro_horas,
            'precio_hora' => $this->precio_hora,
            'deuda' => $this->deuda,
            'relevo' => $this->relevo,
            'precio_relevo' => $this->precio_relevo,
        ]);

        $this->operaciones[] = "Pago registrado correctamente.";
        $this->reset(); // Limpia los campos
    }

    public function mostrarModal()
    {
        $this->modalPago = true;
    }
    public function cerrarModal()
    {
        $this->modalPago = false;
    }

    public function render()
    {
        return view('livewire.pagos');
    }
}
