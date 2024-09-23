<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reiniciar los roles y permisos en caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos únicos para cada rol
        $permissions = [
            'Administrador' => 'gestionar todos los aspectos',
            'Capacitador' => 'gestionar cursos y asistencia',
            'Participante' => 'ver cursos y asistencia',
            'Secretaria' => 'control de cursos y pagos',
            'Graduados' => 'graduados',
            'Empresa' => 'empresa',
        ];

        foreach ($permissions as $roleName => $permissionName) {
            // Crear permiso único
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // Crear rol y asignar permiso
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($permission);
        }
    }
}
