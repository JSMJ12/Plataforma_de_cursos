<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Crear el rol de administrador si no existe
        if (!Role::where('name', 'Administrador')->exists()) {
            Role::create(['name' => 'Administrador']);
        }

        // Crear el usuario administrador
        $admin = User::create([
            'dni' => '0941723934',
            'name' => 'Jossel',
            'name2' => 'Javier',
            'apellidop' => 'Sánchez',
            'apellidom' => 'Muñiz',
            'email' => 'josseljavier1201@gmail.com',
            'ciudad' => 'Pedro Carbo',
            'celular' => '0968683502',
            'nivel_estudio' => 'Pregrado',
            'titulo' => 'ING. en Tecnologías de la Información',
            'especialidad' => 'Programación',
            'anos_experiencia' => 10,
            'password' => Hash::make('jossel01072001'),
        ]);

        // Asignar rol de administrador
        $admin->assignRole('Administrador');

        // Mensaje de éxito
        $this->command->info('Usuario administrador creado exitosamente.');
    }
}
