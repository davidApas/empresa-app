<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adelanto extends Model
{
    use HasFactory,SoftDeletes;
   
    protected $fillable = ['ID_Persona', 'Fecha', 'Monto', 'Entregado_Por', 'Descripcion'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'ID_Persona')->withTrashed(); // Incluye eliminados

    }
    
    public function entregadoPor()
    {
        return $this->belongsTo(Persona::class, 'Entregado_Por', 'id');
    }
    
}
