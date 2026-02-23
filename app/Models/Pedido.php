<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_expediente',
        'descripcion',
        'fecha_solicitud',
        'solicitado_por_id',
        'solicitado_por_usuario',
        'area_destino_id',
        'fecha_recepcion',
        'recibido_por',
        'fecha_envio',
        'enviado_por',
        'recibido_destino_por_id',
        'recibido_destino_por_usuario',
        'fecha_recibido_destino',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_solicitud' => 'date',
            'fecha_recepcion' => 'date',
            'fecha_envio' => 'date',
            'fecha_recibido_destino' => 'date',
        ];
    }

    public function solicitadoPor()
    {
        return $this->belongsTo(Solicitante::class, 'solicitado_por_id');
    }

    public function solicitadoPorUsuario()
    {
        return $this->belongsTo(User::class, 'solicitado_por_usuario');
    }

    public function recibidoPor()
    {
        return $this->belongsTo(User::class, 'recibido_por');
    }

    public function enviadoPor()
    {
        return $this->belongsTo(User::class, 'enviado_por');
    }

    public function recibidoDestinoPor()
    {
        return $this->belongsTo(Solicitante::class, 'recibido_destino_por_id');
    }

    public function recibidoDestinoPorUsuario()
    {
        return $this->belongsTo(User::class, 'recibido_destino_por_usuario');
    }

    public function areaDestino()
    {
        return $this->belongsTo(Area::class, 'area_destino_id');
    }

    // Accessors para obtener el nombre del solicitante
    public function getSolicitadoPorNombreAttribute()
    {
        return $this->solicitadoPor?->nombre ?? ($this->solicitadoPorUsuario?->name ?? 'No especificado');
    }

    // Accessors para obtener el nombre del receptor en destino
    public function getRecibidoDestinoPorNombreAttribute()
    {
        return $this->recibidoDestinoPor?->nombre ?? ($this->recibidoDestinoPorUsuario?->name ?? 'No especificado');
    }
}
