<?php

namespace App\Http\Controllers;

use App\Models\ModelDeposito;
use App\Models\ModelSala;
use App\Models\ModelTipoDeposito;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;

class GerenciarDepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Monta a query base, já carregando relações
        $query = ModelDeposito::with(['tipoDeposito', 'sala']);

        // 2. Aplica filtros, somente se preenchidos
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%'.$request->nome.'%');
        }

        if ($request->filled('sigla')) {
            $query->where('sigla', 'like', '%'.$request->sigla.'%');
        }

        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo);
        }

        // 3. Ordena e paginar (10 por página)
        $depositos = $query
            ->orderBy('nome')
            ->paginate(10);

        // 4. Retorna view com os dados paginados
        return view('depositos.index', compact('depositos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipo_deposito = ModelTipoDeposito::all();
        $sala = ModelSala::with('depositos')->whereDoesntHave('depositos')->get();
        // dd($tipo_deposito);
        return view('depositos.create', compact('tipo_deposito', 'sala'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:10',
            'tipo_deposito' => 'required|exists:tipo_deposito,id',
            'sala' => ['required', Rule::exists('pgsql2.salas', 'id')],
            'comprimento' => 'required|numeric|min:0.01',
            'largura' => 'required|numeric|min:0.01',
            'altura' => 'required|numeric|min:0.01',
            'largura_porta' => 'required|numeric|min:0.01',
            'altura_porta' => 'required|numeric|min:0.01',
        ]);

        try {
            // Conversão de vírgulas para pontos diretamente no validado
            $input_nome =  $request->input('nome');
            $input_sigla =  $request->input('sigla');
            $input_tipo_deposito =  $request->input('tipo_deposito');
            $input_sala =  $request->input('sala');
            $input_comprimento =  str_replace(',', '.', $request->input('comprimento'));
            $input_largura =  str_replace(',', '.', $request->input('largura'));
            $input_altura =  str_replace(',', '.', $request->input('altura'));
            $input_largura_porta =  str_replace(',', '.', $request->input('largura_porta'));
            $input_altura_porta =  str_replace(',', '.', $request->input('altura_porta'));
            $request_input_comprimento =  str_replace(',', '.', $request->input('comprimento'));
            $request_input_capacidade =     $input_comprimento * $input_largura * $input_altura;
            $input_sala = str_replace(',', '.', $request->input('sala'));




            $capacidade = (float)$validated['comprimento'] * (float)$validated['largura'] * (float)$validated['altura'];

            // Criação do registro
            ModelDeposito::create([
                'nome' => $input_nome,
                'sigla' => $input_sigla,
                'id_tp_deposito' => $input_tipo_deposito,
                'id_sala' => $input_sala,
                'comprimento' => $input_comprimento,
                'largura' => $input_largura,
                'altura' => $input_altura,
                'largura_porta' => $input_largura_porta,
                'altura_porta' => $input_altura_porta,
                'capacidade_volume' => $request_input_capacidade,
                'ativo' => true,
            ]);

            return redirect()->route('deposito.index')
                ->with('success', 'Depósito criado com sucesso!');

        } catch (Exception $e) {
            logger()->error('Erro ao criar depósito', ['error' => $e->getMessage()]);

            return back()->withInput()
                ->with('error', 'Erro ao criar depósito: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deposito = ModelDeposito::findOrFail($id); // Localiza o depósito pelo ID
        $tipo_deposito = ModelTipoDeposito::all();
        $sala = ModelSala::all();

        return view('depositos.show', compact('deposito', 'tipo_deposito', 'sala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deposito = ModelDeposito::findOrFail($id);
        $tipo_deposito = ModelTipoDeposito::all();
        $sala = ModelSala::all();
        // dd($deposito);

        return view('depositos.edit', compact('deposito', 'tipo_deposito', 'sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'tipo_deposito' => 'required|exists:tipo_deposito,id',
            'sala' => ['required', Rule::exists('pgsql2.salas', 'id')],
            'comprimento' => 'required|numeric|min:0',
            'largura' => 'required|numeric|min:0',
            'altura' => 'required|numeric|min:0',
            'largura_porta' => 'required|numeric|min:0',
            'altura_porta' => 'required|numeric|min:0',
        ]);

        // Localiza o depósito que será atualizado
        $deposito = ModelDeposito::findOrFail($id);

        // Atualiza os dados do depósito com os dados recebidos do formulário
        $deposito->update([
            'nome' => $request->nome,
            'sigla' => $request->sigla,
            'id_tp_deposito' => $request->tipo_deposito,
            'id_sala' => $request->sala,
            'comprimento' => $request->comprimento,
            'largura' => $request->largura,
            'altura' => $request->altura,
            'largura_porta' => $request->largura_porta,
            'altura_porta' => $request->altura_porta,
            'capacidade_volume' => $request->comprimento *
             $request->largura *
              $request->altura, // Atualiza a capacidade
        ]);

        // Redireciona para a lista de depósitos com uma mensagem de sucesso
        return redirect()->route('deposito.index')->with('success', 'Depósito atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Depois volta e verficar se o depósito pode ser excluído
        $deposito = ModelDeposito::findOrFail($id);
        //desativa o deposito
        $deposito->update(['ativo' => false]);
        // $deposito->delete();
        return redirect()->route('deposito.index')->with('success', 'Depósito excluído com sucesso!');

    }
    private function parseDecimalInputs(Request $request)
    {
        return [
            'nome' => $request->input('nome'),
            'sigla' => $request->input('sigla'),
            'tipo_deposito' => $request->input('tipo_deposito'),
            'sala' => $request->input('sala'),
            'comprimento' => (float) str_replace(',', '.', $request->input('comprimento')),
            'largura' => (float) str_replace(',', '.', $request->input('largura')),
            'altura' => (float) str_replace(',', '.', $request->input('altura')),
            'largura_porta' => (float) str_replace(',', '.', $request->input('largura_porta')),
            'altura_porta' => (float) str_replace(',', '.', $request->input('altura_porta')),
            'capacidade' => (float) str_replace(',', '.', $request->input('capacidade')),
        ];
    }
    public function reativar($id)
    {
        $deposito = ModelDeposito::findOrFail($id);
        $deposito->update(['ativo' => true]);
        return redirect()->route('deposito.index')->with('success', 'Depósito reativado com sucesso!');
    }
}
