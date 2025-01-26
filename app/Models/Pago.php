<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'ID_Pago'; // Llave primaria

    protected $fillable = [
        'fecha',
        'nro_horas',
        'precio_hora',
        'deuda',
        'relevo',
        'precio_relevo',
        'total'
    ];
    

    public $timestamps = false; // Si no usas las columnas created_at y updated_at
}
