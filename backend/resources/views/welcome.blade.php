@extends('layouts.public')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">Bem-vindo ao Sistema de Reservas</h1>
        <p class="lead mt-3">Gerencie suas reservas com facilidade e praticidade.</p>

        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4">Ir para o Painel</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary mt-4">Fazer Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary mt-4">Criar Conta</a>
        @endauth
    </div>
@endsection
