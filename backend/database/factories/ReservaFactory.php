<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Gera uma data aleatória para os próximos 7 dias (exceto domingo)
        do {
            $data = fake()->dateTimeBetween('now', '+7 days');
        } while (Carbon::parse($data)->isSunday());

        // Gera hora de início entre 18:00 e 22:00
        $horaInicio = fake()->dateTimeBetween('18:00', '22:00');
        $horaFim = (clone $horaInicio)->modify('+1 hour');

        return [
            'cliente_nome' => fake()->name(),
            'cliente_telefone' => fake()->phoneNumber(),
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'data' => $data->format('Y-m-d'),
            'mesa' => fake()->numberBetween(1, 15),
            'hora_inicio' => $horaInicio->format('H:i'),
            'hora_fim' => $horaFim->format('H:i'),
        ];
    }
}
