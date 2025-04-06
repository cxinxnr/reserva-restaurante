<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;

    protected $fillable = [
        'cliente_nome',
        'cliente_telefone',
        'user_id',
        'data',
        'mesa',
        'hora_inicio',
        'hora_fim',
    ];
}
