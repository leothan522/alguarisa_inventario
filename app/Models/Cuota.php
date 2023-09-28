<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuota extends Model
{
    use HasFactory;
    protected $table = "cuotas";
    protected $fillable = [
        'mes',
        'codigo',
        'fecha'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ;
    }

    public function ajuste(): BelongsTo
    {
        return $this->belongsTo(Ajuste::class, 'codigo', 'codigo');
    }

}
