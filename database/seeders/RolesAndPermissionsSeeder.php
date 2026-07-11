<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Rename panel_user to supervisor if it exists
        $panelUser = Role::where('name', 'panel_user')->first();
        if ($panelUser) {
            $panelUser->name = 'supervisor';
            $panelUser->save();
        }

        // Get the roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor', 'guard_name' => 'web']);
        $tecnico    = Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'web']);

        // 2. Define permissions based on Filament Shield naming conventions
        $permissions = [
            // Maquinaria (MantencionResource is 'mantencion', MaquinariaResource is 'maquinaria', etc)
            'view_any_maquinaria', 'view_maquinaria', 'create_maquinaria', 'update_maquinaria', 'delete_maquinaria',
            // Mantencion
            'view_any_mantencion', 'view_mantencion', 'create_mantencion', 'update_mantencion', 'delete_mantencion',
            // Repuesto
            'view_any_repuesto', 'view_repuesto', 'create_repuesto', 'update_repuesto', 'delete_repuesto',
            // Users and Roles (Filament Shield)
            'view_any_user', 'view_user', 'create_user', 'update_user', 'delete_user',
            'view_any_role', 'view_role', 'create_role', 'update_role', 'delete_role',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Assign permissions to roles

        // Técnico:
        // Maquinarias: Solo ver
        // Mantenciones: Ver, Editar (NO crear porque las crea el supervisor, NO eliminar)
        // Repuestos: Ver, Crear, Editar
        $tecnico->syncPermissions([
            'view_any_maquinaria', 'view_maquinaria',
            'view_any_mantencion', 'view_mantencion', 'update_mantencion',
            'view_any_repuesto', 'view_repuesto', 'create_repuesto', 'update_repuesto'
        ]);

        // Supervisor (Es el mismo técnico en la práctica):
        // Maquinarias: Ver, Crear, Editar, Eliminar
        // Mantenciones: Ver, Crear, Editar, Eliminar
        // Repuestos: Ver, Crear, Editar, Eliminar
        $supervisor->syncPermissions([
            'view_any_maquinaria', 'view_maquinaria', 'create_maquinaria', 'update_maquinaria', 'delete_maquinaria',
            'view_any_mantencion', 'view_mantencion', 'create_mantencion', 'update_mantencion', 'delete_mantencion',
            'view_any_repuesto', 'view_repuesto', 'create_repuesto', 'update_repuesto', 'delete_repuesto',
        ]);

        // Super Admin gets everything (Filament Shield uses Implicit Grants usually, but let's assign anyway)
        $superAdmin->syncPermissions(Permission::all());

        // Update the visualizador test user to have the 'supervisor' role (was panel_user)
        $visorUser = User::where('email', 'visualizador@mantenciones.local')->first();
        if ($visorUser) {
            $visorUser->syncRoles(['supervisor']);
        }
    }
}
