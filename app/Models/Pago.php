<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos';

    protected $fillable = [
        'ID_Persona',
        'fecha',
        'tipo_pago', 
        'nro_horas',
        'precio_hora',
        'dias_trabajados',
        'precio_dia',
        'deuda',
        'relevo',
        'precio_relevo',
        'total'
    ];

    // Relación con la tabla `personas`
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'ID_Persona')->withTrashed();
    }
}
