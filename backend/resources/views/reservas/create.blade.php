@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Nova Reserva</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reservas.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome do Cliente</label>
                <input type="text" name="cliente_nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="cliente_telefone" class="form-control">
            </div>
            
            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" name="data" class="form-control" required min="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora de Início</label>
                <input type="time" name="hora_inicio" class="form-control" required min="18:00" max="23:59">
            </div>

            <div class="mb-3">
                <label for="hora_fim" class="form-label">Hora de Fim</label>
                <input type="time" name="hora_fim" class="form-control" required min="18:00" max="23:59">
            </div>

            <div class="mb-3">
                <label for="mesa" class="form-label">Mesa (1 a 15)</label>
                <input type="number" name="mesa" min="1" max="15" class="form-control" value="{{ old('mesa') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Reservar</button>
            <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection