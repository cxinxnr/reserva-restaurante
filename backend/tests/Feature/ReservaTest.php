<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    private function getDataValidaNaoDomingo(): string
    {
        $data = now()->addDay();

        while ($data->isSunday()) {
            $data->addDay();
        }

        return $data->format('Y-m-d');
    }

    public function test_usuario_pode_criar_reserva_valida()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getDataValidaNaoDomingo();

        $resposta = $this->post('/reservas', [
            'data' => $data,
            'mesa' => 1,
            'hora_inicio' => '19:00',
            'hora_fim' => '20:00',
            'cliente_nome' => 'Pedro',
            'cliente_telefone' => '11999999999',
        ]);

        $resposta->assertRedirect(); // ou ->assertOk() se preferir

        $this->assertDatabaseHas('reservas', [
            'mesa' => 1,
            'cliente_nome' => 'Pedro',
        ]);
    }

    public function test_nao_permite_reserva_em_horario_invalido()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getDataValidaNaoDomingo();

        $resposta = $this->post('/reservas', [
            'data' => $data,
            'mesa' => 1,
            'hora_inicio' => '17:00',
            'hora_fim' => '18:00',
            'cliente_nome' => 'Maria',
            'cliente_telefone' => '11988888888',
        ]);

        $resposta->assertSessionHasErrors();
    }

    public function test_nao_permite_reserva_em_dia_invalido()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $domingo = now()->next(Carbon::SUNDAY)->format('Y-m-d');

        $resposta = $this->post('/reservas', [
            'data' => $domingo,
            'mesa' => 1,
            'hora_inicio' => '19:00',
            'hora_fim' => '20:00',
            'cliente_nome' => 'Lucas',
            'cliente_telefone' => '11977777777',
        ]);

        $resposta->assertSessionHasErrors();
    }

    public function test_nao_permite_reserva_com_conflito_de_horario()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getDataValidaNaoDomingo();

        Reserva::create([
            'user_id' => $user->id,
            'mesa' => 1,
            'data' => $data,
            'hora_inicio' => '19:00',
            'hora_fim' => '20:00',
            'cliente_nome' => 'Carlos',
            'cliente_telefone' => '11966666666',
        ]);

        $resposta = $this->post('/reservas', [
            'data' => $data,
            'mesa' => 1,
            'hora_inicio' => '19:30',
            'hora_fim' => '20:30',
            'cliente_nome' => 'Ana',
            'cliente_telefone' => '11955555555',
        ]);

        $resposta->assertSessionHasErrors();
    }
}
