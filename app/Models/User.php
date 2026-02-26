<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',
        'oficina_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class);
    }

    public function pedidosSolicitados()
    {
        return $this->hasMany(Pedido::class, 'solicitado_por_usuario');
    }

    public function pedidosRecibidos()
    {
        return $this->hasMany(Pedido::class, 'recibido_por');
    }

    public function pedidosEnviados()
    {
        return $this->hasMany(Pedido::class, 'enviado_por');
    }

    public function pedidosRecibidosDestino()
    {
        return $this->hasMany(Pedido::class, 'recibido_destino_por_usuario');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('administrador');
    }

    public function isUser()
    {
        return $this->hasRole('usuario');
    }
}
