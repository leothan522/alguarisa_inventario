<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;
    protected $table = "municipios";
    protected $fillable = [
      'nombre',
      'mini',
      'parroquias',
      'familias',
      'estatus'
    ];

    public function parroquia(): HasMany
    {
        return $this->hasMany(Parroquia::class, 'municipios_id', 'id');
    }

    public function ajustes(): HasMany
    {
        return $this->hasMany(Ajuste::class, 'municipios_id', 'id');
    }

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('nombre', 'LIKE', "%$keyword%")
            ->orWhere('mini', 'LIKE', "%$keyword%")
            ;
    }

}


