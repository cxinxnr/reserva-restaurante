<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria 1 usuário admin e 5 normais
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(5)->create();

        // Cria 30 reservas aleatórias
        Reserva::factory(30)->create();
    }
}
