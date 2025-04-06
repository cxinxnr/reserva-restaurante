@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h2 class="mb-3">Olá, {{ auth()->user()->name }}</h2>
        <p>Bem-vindo ao seu painel de controle.</p>

        <div class="mt-4">
            <a href="{{ route('reservas.index') }}" class="btn btn-success">Ver Minhas Reservas</a>

            @if(auth()->user()->email === 'admin@teste.com')
                <a href="{{ route('admin.panel') }}" class="btn btn-warning ms-2">Painel Administrativo</a>
            @endif
        </div>
    </div>
@endsection
