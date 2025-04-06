<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Auth::user()->reservas()->latest()->get();
        return view('reservas.index', compact('reservas'));
    }

    public function adminPanel(Request $request)
    {
        if (auth()->user()->email !== 'admin@teste.com') {
            abort(403, 'Acesso negado.');
        }
        $query = Reserva::query();

        if ($request->filled('data')) {
            $query->whereDate('data', $request->data);
        }
    
        if ($request->filled('mesa')) {
            $query->where('mesa', $request->mesa);
        }
    
        $reservas = $query->orderBy('data')->orderBy('hora_inicio')->get();

        return view('reservas.admin', compact('reservas'));
    }

    public function create()
    {
        return view('reservas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'cliente_telefone' => 'nullable|string|max:20',
            'data' => 'required|date',
            'mesa' => 'required|integer|between:1,15',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        // Verificar se é domingo
        if (date('w', strtotime($request->data)) == 0) {
            return back()->withErrors(['data' => 'Não é possível reservar aos domingos.']);
        }

        // Verifica se o horário está dentro do intervalo permitido
        $inicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $fim = Carbon::createFromFormat('H:i', $request->hora_fim);

        if ($inicio->lt(Carbon::createFromTime(18, 0)) || $fim->gt(Carbon::createFromTime(23, 59))) {
            return redirect()->back()->withErrors(['hora_inicio' => 'Horário permitido é entre 18:00 e 23:59.']);
        }

        // Verifica conflitos de horário para a mesma mesa e data
        $conflito = Reserva::where('data', $request->data)
            ->where('mesa', $request->mesa)
            ->where(function ($query) use ($inicio, $fim) {
                $query->whereBetween('hora_inicio', [$inicio, $fim])
                    ->orWhereBetween('hora_fim', [$inicio, $fim])
                    ->orWhere(function ($q) use ($inicio, $fim) {
                        $q->where('hora_inicio', '<=', $inicio)
                            ->where('hora_fim', '>=', $fim);
                    });
            })
            ->exists();

        if ($conflito) {
            return redirect()->back()->withErrors(['hora_inicio' => 'Este horário já está reservado para esta mesa.']);
        }

        $agora = Carbon::now();
        $dataReserva = Carbon::parse($request->data);
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);

        // Verifica se a data da reserva é anterior a hoje
        if ($dataReserva->isBefore($agora->startOfDay())) {
            return redirect()->back()->withErrors(['data' => 'Não é possível reservar em datas passadas.']);
        }

        // Se a reserva for hoje, verifica se o horário já passou
        if ($dataReserva->isToday() && $horaInicio->lt($agora)) {
            return redirect()->back()->withErrors(['hora_inicio' => 'Este horário já passou.']);
        }

        // Criar reserva
        Reserva::create([
            'cliente_nome' => $request->cliente_nome,
            'cliente_telefone' => $request->cliente_telefone,
            'user_id' => Auth::id(),
            'data' => $request->data,
            'mesa' => $request->mesa,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva realizada com sucesso!');
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);

        // Verifica se a reserva pertence ao usuário logado
        if ($reserva->user_id !== auth()->id()) {
            return redirect()->route('reservas.index')->with('error', 'Você não tem permissão para excluir esta reserva.');
        }

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva cancelada com sucesso!');
    }

}
