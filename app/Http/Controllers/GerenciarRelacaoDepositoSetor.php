<?php

namespace App\Http\Controllers;

use App\Models\ModelDeposito;
use Illuminate\Http\Request;
use App\Models\ModelRelDepositoSetor;
use App\Models\ModelSetor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GerenciarRelacaoDepositoSetor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $relacoes_deposito_setor = null;
        $relacoes_deposito_setor = ModelRelDepositoSetor::with(['Deposito', 'Setor'])->where('dt_fim', null)->get();
        // dd($relacoes_deposito_setor);
        $setores = ModelSetor::all();
        $depositos = ModelDeposito::all();
        return view('relacao-deposito-setor.index', compact('relacoes_deposito_setor', 'setores', 'depositos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setores = ModelSetor::all();
        // $depositos = ModelDeposito::with('relacaoDepositoSetor')->get();
        $depositos = ModelDeposito::doesntHave('relacaoDepositoSetor')
            ->get();

        return view('relacao-deposito-setor.create', compact('setores', 'depositos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            // 'setor_id' => 'required|exists:setores,id',
            // 'deposito_id' => 'required|exists:depositos,id',
        ]);
        $relacao = new ModelRelDepositoSetor();
        $relacao->id_setor = $request->input('setor_id');
        $relacao->id_deposito = $request->input('deposito_id');
        $relacao->dt_inicio = Carbon::now();
        $relacao->save();

        return redirect()->route('relacao-deposito-setor.index')->with('success', 'Relação Depósito/Setor criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $relacao = ModelRelDepositoSetor::findOrFail($id);
        if (!$relacao) {
            return redirect()->route('relacao-deposito-setor.index')->with('error', 'Relação não encontrada.');
        }
        // Carrega as relações de depósito e setor
        $relacao_atual = ModelRelDepositoSetor::with(['Deposito', 'Setor'])
            ->where('id', $id)
            ->first();

        $relacoes = ModelRelDepositoSetor::where('id_setor',  $relacao_atual->Setor->id)
            ->orderBy('dt_inicio', 'desc')
            ->with(['Deposito', 'Setor'])
            // ->where('dt_fim', null)
            // ->where('id', '!=', $id)
            // ->where('id_setor', $relacao_atual->Setor->id)
            ->get();
        //    dd($relacao_atual, $relacoes);


        return view('relacao-deposito-setor.show', compact('relacao_atual', 'relacoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $relacao = ModelRelDepositoSetor::findOrFail($id);
        $deposito_banco = $relacao->Deposito;
        // dd($deposito);
        $setores = ModelSetor::all();
        $setor_banco =  $relacao->Setor;
        $depositos = ModelDeposito::all();
        // dd($relacao);


        return view('relacao-deposito-setor.edit', compact('relacao', 'setores', 'depositos', 'deposito_banco', 'setor_banco'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all(), $id);

        $relacao = ModelRelDepositoSetor::findOrFail($id);
        $relacao->dt_fim = Carbon::now();
        $relacao->save();
        $relacao = new ModelRelDepositoSetor();
        $relacao->id_setor = $request->input('setor_id');
        $relacao->id_deposito = $request->input('deposito_id');
        $relacao->dt_inicio = Carbon::now()->subDays(1); // Ajuste para o dia anterior
        $relacao->save();
        return redirect()->route('relacao-deposito-setor.index')->with('success', 'Relação Depósito/Setor atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
