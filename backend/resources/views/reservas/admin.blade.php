@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Painel de Reservas</h2>
        <form method="GET" action="{{ route('admin.panel') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" id="data" name="data" class="form-control" value="{{ request('data') }}">
            </div>

            <div class="col-md-3">
                <label for="mesa" class="form-label">Mesa</label>
                <select id="mesa" name="mesa" class="form-select">
                    <option value="">Todas</option>
                    @for($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}" {{ request('mesa') == $i ? 'selected' : '' }}>Mesa {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </form>

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Telefone</th>
                    <th>Data</th>
                    <th>Mesa</th>
                    <th>Início</th>
                    <th>Fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->cliente_nome }}</td>
                        <td>{{ $reserva->cliente_telefone }}</td>
                        <td>{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}</td>
                        <td>{{ $reserva->mesa }}</td>
                        <td>{{ $reserva->hora_inicio }}</td>
                        <td>{{ $reserva->hora_fim }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection