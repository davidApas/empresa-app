<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'personas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Nombre',
        'Apellido',
        'DNI',
        'Telefono',
        'Domicilio',
        'Correo_Electronico',
        'Puesto_Trabajo',
    ];

    public function adelantos()
    {
        return $this->hasMany(Adelanto::class, 'id');
    }
}
