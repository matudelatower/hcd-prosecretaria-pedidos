<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'cargo',
        'dependencia',
        'notas',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    // Relaciones
    public function pedidosSolicitados()
    {
        return $this->hasMany(Pedido::class, 'solicitado_por_id');
    }

    public function pedidosRecibidosDestino()
    {
        return $this->hasMany(Pedido::class, 'recibido_destino_por_id');
    }

    // Scope para obtener solo activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
