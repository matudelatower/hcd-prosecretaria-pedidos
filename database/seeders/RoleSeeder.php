<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrador',
                'description' => 'Acceso completo a todo el sistema',
                'activo' => true,
            ],
            [
                'name' => 'usuario',
                'description' => 'Acceso solo a gestión de pedidos',
                'activo' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
