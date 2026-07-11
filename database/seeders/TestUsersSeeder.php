<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@mantenciones.local'],
            ['name' => 'Administrador', 'password' => bcrypt('password')]
        );
        $admin->assignRole('super_admin');

        $tecnico = User::firstOrCreate(
            ['email' => 'tecnico@mantenciones.local'],
            ['name' => 'Técnico de Turno', 'password' => bcrypt('password')]
        );
        $tecnico->assignRole('tecnico');

        $visor = User::firstOrCreate(
            ['email' => 'visualizador@mantenciones.local'],
            ['name' => 'Visualizador', 'password' => bcrypt('password')]
        );
        $visor->assignRole('supervisor');
    }
}
