<?php

// database/seeders/GraduadoSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GraduadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el rol de Graduado si no existe
        $graduadoRole = 'Graduados'; 

        // Crear 200 usuarios con el factory
        $users = User::factory(200)->graduado()->create();

        // Asignar el rol de Graduado a cada usuario
        foreach ($users as $user) {
            $user->assignRole($graduadoRole);
        }
    }
}
