<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oficina extends Model
{
    use HasFactory, SoftDeletes;

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
