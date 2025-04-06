@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Minhas Reservas</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($reservas->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Mesa</th>
                        <th>Reservado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>Mesa {{ $reserva->cliente_nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reserva->hora_fim)->format('H:i') }}</td>

                            <td>Mesa {{ $reserva->mesa }}</td>
                            <td>{{ $reserva->created_at->diffForHumans() }}</td>
                            <td>
                                <form method="POST" action="{{ route('reservas.destroy', $reserva->id) }}"
                                    onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Cancelar</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não fez nenhuma reserva.</p>
        @endif

        <a href="{{ route('reservas.create') }}" class="btn btn-primary mt-3">Nova Reserva</a>
    </div>
@endsection