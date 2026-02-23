<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'edificio_id',
    ];

    public function edificio()
    {
        return $this->belongsTo(Edificio::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
