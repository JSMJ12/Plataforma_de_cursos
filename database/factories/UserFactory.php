<?php
// Database\Factories\UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->firstName,
            'name2' => $this->faker->firstName,
            'apellidop' => $this->faker->lastName,
            'apellidom' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'ciudad' => $this->faker->city(),
            'celular' => $this->faker->numerify('##########'),
            'password' => static::$password ??= Hash::make('password'),
            'email_verified_at' => now(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'programa_maestria' => $this->faker->randomElement(['Ingeniería', 'Ciencias Sociales']),
            'fecha_graduacion' => $this->faker->date(),
            'empleado_actualmente' => $this->faker->randomElement(['Sí', 'No']),
            'nombre_empresa' => $this->faker->company,
            'cargo_actual' => $this->faker->jobTitle,
            'estudios_adicionales' => $this->faker->randomElement(['Sí', 'No']),
            'trabajo_vinculado' => $this->faker->randomElement(['totalmente','parcialmente','no']),
            'anos_experiencia_laboral' => $this->faker->randomElement(['Menos_de_1','1-3', '4-6','7-10','Mas_de_10']),
            'empleos_desde_graduacion' => $this->faker->numberBetween(0, 5),
            'satisfaccion_programa' => $this->faker->numberBetween(1, 5),
            'pertinencia_formacion' => $this->faker->randomElement(['totalmente','pertinente','poco_pertinente', 'nada_pertinente']),
            'desarrollo_profesional_continuo' => $this->faker->randomElement(['Sí', 'No']),
        ];
    }

    public function graduado(): static
    {
        return $this->state(fn (array $attributes) => [
            // Se pueden agregar atributos específicos de los graduados aquí si es necesario
        ]);
    }
}
