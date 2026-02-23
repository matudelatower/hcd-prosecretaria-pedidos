<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios
        $user1 = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'activo' => true,
        ]);

        $user2 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@ejemplo.com',
            'password' => bcrypt('password'),
            'activo' => true,
        ]);

        $user3 = User::create([
            'name' => 'María García',
            'email' => 'maria@ejemplo.com',
            'password' => bcrypt('password'),
            'activo' => true,
        ]);

        // Asignar roles
        $adminRole = Role::where('name', 'administrador')->first();
        $userRole = Role::where('name', 'usuario')->first();

        if ($adminRole) {
            $user1->roles()->sync([$adminRole->id]);
        }

        if ($userRole) {
            $user2->roles()->sync([$userRole->id]);
            $user3->roles()->sync([$userRole->id]);
        }
    }
}
