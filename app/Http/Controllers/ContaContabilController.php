<?php

namespace App\Http\Controllers;

use App\Models\ModelTipoClasseContaContabil;
use App\Models\ModelTipoGrupoContaContabil;
use Illuminate\Http\Request;
use App\Models\ModelContaContabil;
use App\Models\ModelTipoCatalogoContaContabil;
use App\Models\ModelTipoNaturezaContaContabil;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class ContaContabilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {



        // Parte dos campos estrangeiros para pesquisa.
        $grupos_contabeis = ModelTipoGrupoContaContabil::all();
        $naturezas_contabeis = ModelTipoNaturezaContaContabil::all();
        $catalogos_contabeis = ModelTipoCatalogoContaContabil::all();
        $classes_contabeis = ModelTipoClasseContaContabil::all();

        // Contador de Contas Contábeis
        $contador_contabil_conta_contabil = ModelContaContabil::count();

        // Campos para pesquisa
        $pesquisa_descricao = $request->input('descricao');
        $pesquisa_grupo_contabil = $request->input('grupo_contabil');
        $pesquisa_natureza_contabil = $request->input('natureza_contabil');
        $pesquisa_catalogo_contabil = $request->input('catalogo_contabil');
        $pesquisa_classe_contabil = $request->input('classe_contabil');
        $pesquisa_status_conta_contabil = $request->input('status_conta_contabil');
        //Campos de Niveis
        $pesquisa_nivel_1 = $request->input('nivel_1', null);
        $pesquisa_nivel_2 = $request->input('nivel_2', null);
        $pesquisa_nivel_3 = $request->input('nivel_3', null);
        $pesquisa_nivel_4 = $request->input('nivel_4', null);
        $pesquisa_nivel_5 = $request->input('nivel_5', null);
        $pesquisa_nivel_6 = $request->input('nivel_6', null);


        // Pesquisa
        $contas_contabeis = ModelContaContabil::with([
            'natureza_contabil',
            'catalogo_contabil',
            'grupo_contabil',
            'classe_contabil'
        ])
            ->selectRaw("*, CASE WHEN data_fim IS NULL THEN 'Ativo' ELSE 'Inativo' END as status")
            ->when($pesquisa_descricao, fn($query) => $query->where('descricao', 'like', '%' . $pesquisa_descricao . '%'))
            ->when($pesquisa_grupo_contabil, fn($query) => $query->where('id_tipo_grupo_conta_contabil', $pesquisa_grupo_contabil))
            ->when($pesquisa_natureza_contabil, fn($query) => $query->where('id_tipo_natureza_conta_contabil', $pesquisa_natureza_contabil))
            ->when($pesquisa_catalogo_contabil, fn($query) => $query->where('id_tipo_catalogo', $pesquisa_catalogo_contabil))
            ->when($pesquisa_classe_contabil, fn($query) => $query->where('id_tipo_classe_conta_contabil', $pesquisa_classe_contabil))
            ->when($pesquisa_nivel_1, fn($query) => $query->where('nivel_1', $pesquisa_nivel_1))
            ->when($pesquisa_nivel_2, fn($query) => $query->where('nivel_2', $pesquisa_nivel_2))
            ->when($pesquisa_nivel_3, fn($query) => $query->where('nivel_3', $pesquisa_nivel_3))
            ->when($pesquisa_nivel_4, fn($query) => $query->where('nivel_4', $pesquisa_nivel_4))
            ->when($pesquisa_nivel_5, fn($query) => $query->where('nivel_5', $pesquisa_nivel_5))
            ->when($pesquisa_nivel_6, fn($query) => $query->where('nivel_6', $pesquisa_nivel_6))
            ->when($pesquisa_status_conta_contabil == 1, fn($query) => $query->whereNull('data_fim'))
            ->when($pesquisa_status_conta_contabil == 2, fn($query) => $query->whereNotNull('data_fim'))
            ->get();

        //Recursivo para niveis
        // foreach ($contas_contabeis as $conta) {
        //     switch ($conta->grau) {
        //         case 2:
        //             $nomes_acumulados = $array_de_nomes = DB::table('conta_contabil')
        //                 ->select('descricao')
        //                 ->where('nivel_1', $conta->nivel_1)
        //                 ->where('nivel_2', null)
        //                 ->where('nivel_3', null)
        //                 ->where('nivel_4', null)
        //                 ->where('nivel_5', null)
        //                 ->where('nivel_6', null)
        //                 ->get();


        //             $nomes = [];
        //             foreach ($nomes_acumulados as $nome) {
        //                 $nomes[]  = $nome->descricao;
        //             }

        //             $conta->nomes_acumulado =  implode(" > ",  $nomes);

        //         case 3:
        //             $nomes_acumulados = $array_de_nomes = DB::table('conta_contabil')
        //                 ->select('descricao')
        //                 ->where('nivel_1', $conta->nivel_1)
        //                 ->where('nivel_2', $conta->nivel_2)
        //                 ->where('nivel_3', null)
        //                 ->where('nivel_4', null)
        //                 ->where('nivel_5', null)
        //                 ->where('nivel_6', null)
        //                 ->get();


        //             $nomes = [];
        //             foreach ($nomes_acumulados as $nome) {
        //                 $nomes[]  = $nome->descricao;
        //             }

        //             $conta->nomes_acumulado =  implode(" > ",  $nomes);
        //         case 4:
        //             $nomes_acumulados = $array_de_nomes = DB::table('conta_contabil')
        //                 ->select('descricao')
        //                 ->where('nivel_1', $conta->nivel_1)
        //                 ->where('nivel_2', $conta->nivel_2)
        //                 ->where('nivel_3', $conta->nivel_3)
        //                 ->where('nivel_4', null)
        //                 ->where('nivel_5', null)
        //                 ->where('nivel_6', null)
        //                 ->get();


        //             $nomes = [];
        //             foreach ($nomes_acumulados as $nome) {
        //                 $nomes[]  = $nome->descricao;
        //             }

        //             $conta->nomes_acumulado =  implode(" >  ",  $nomes);
        //         case 5:
        //             $nomes_acumulados = $array_de_nomes = DB::table('conta_contabil')
        //                 ->select('descricao')
        //                 ->where('nivel_1', $conta->nivel_1)
        //                 ->where('nivel_2', $conta->nivel_2)
        //                 ->where('nivel_3', $conta->nivel_3)
        //                 ->where('nivel_4', $conta->nivel_4)
        //                 ->where('nivel_5', null)
        //                 ->where('nivel_6', null)
        //                 ->get();
        //             $nomes = [];
        //             foreach ($nomes_acumulados as $nome) {
        //                 $nomes[]  = $nome->descricao;
        //             }

        //             $conta->nomes_acumulado =  implode(" > ",  $nomes);
        //         case 6:
        //             $nomes_acumulados = $array_de_nomes = DB::table('conta_contabil')
        //                 ->select('descricao')
        //                 ->where('nivel_1', $conta->nivel_1)
        //                 ->where('nivel_2', $conta->nivel_2)
        //                 ->where('nivel_3', $conta->nivel_3)
        //                 ->where('nivel_4', $conta->nivel_4)
        //                 ->where('nivel_5', $conta->nivel_5)
        //                 ->where('nivel_6', null)
        //                 ->get();
        //             $nomes = [];
        //             foreach ($nomes_acumulados as $nome) {
        //                 $nomes[]  = $nome->descricao;
        //             }

        //             $conta->nomes_acumulado =  implode(" > ",  $nomes);

        //         default:
        //             break;
        //     }
        // }
        foreach ($contas_contabeis as $conta) {
            $nomes_acumulados = DB::table('conta_contabil')
                ->select('descricao')
                ->where('nivel_1', $conta->nivel_1)
                ->where('nivel_2', $conta->nivel_2 ?? null)
                ->where('nivel_3', $conta->nivel_3 ?? null)
                ->where('nivel_4', $conta->nivel_4 ?? null)
                ->where('nivel_5', $conta->nivel_5 ?? null)
                ->where('nivel_6', $conta->nivel_6 ?? null)
                ->get()
                ->pluck('descricao')
                ->toArray();

            $conta->nomes_acumulado = implode(" > ", $nomes_acumulados);
        }


        // Agora execute a consulta

        $numeros = range(1, 100);

        // Para debug:
        // dd($contas_contabeis->toSql(), $contas_contabeis->getBindings());
        return view("contas.index", compact(
            "contas_contabeis",
            "grupos_contabeis",
            "naturezas_contabeis",
            "catalogos_contabeis",
            "classes_contabeis",
            "numeros",
            "pesquisa_nivel_1",
            "pesquisa_nivel_2",
            "pesquisa_nivel_3",
            "pesquisa_nivel_4",
            "pesquisa_nivel_5",
            "pesquisa_nivel_6",
            "pesquisa_status_conta_contabil"
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $numeros = [];
        for ($i = 0; $i <= 100; $i++) {
            $numeros[] = $i;
        }
        $catalogo_conta_contabil = ModelTipoCatalogoContaContabil::all();
        $natureza_conta_contabil = ModelTipoNaturezaContaContabil::all();
        $classe_conta_contabil = ModelTipoClasseContaContabil::all();
        $grupo_conta_contabil = ModelTipoGrupoContaContabil::all();


        return view("contas.create", compact("numeros", "catalogo_conta_contabil", "classe_conta_contabil", "grupo_conta_contabil", "natureza_conta_contabil"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'id_tipo_catalogo' => 'required|exists:tipo_catalogo_conta_contabil,id',
            'descricao' => 'required|string|max:255',
            'id_tipo_natureza_conta_contabil' => 'required|exists:tipo_natureza_conta_contabil,id',
            'id_tipo_grupo_conta_contabil' => 'required|exists:tipo_grupo_conta_contabil,id',
            'grau' => 'required|integer|between:1,6',
            'nivel_1' => 'required|integer|between:1,99',
            'nivel_2' => 'nullable|integer|between:1,99',
            'nivel_3' => 'nullable|integer|between:1,99',
            'nivel_4' => 'nullable|integer|between:1,99',
            'nivel_5' => 'nullable|integer|between:1,99',
            'nivel_6' => 'nullable|integer|between:1,99',
        ]);

        if (ModelContaContabil::hasDuplicateLevels($request)) {
            app('flasher')->addError('Já existe uma conta Contabil com esse registro');
            return redirect()->back();
        }

        ModelContaContabil::create([
            'data_inicio' => Carbon::now()->toDateString(),
            'id_tipo_catalogo' => $request->input('id_tipo_catalogo'),
            'descricao' => $request->input('descricao'),
            'id_tipo_natureza_conta_contabil' => $request->input('id_tipo_natureza_conta_contabil'),
            'id_tipo_grupo_conta_contabil' => $request->input('id_tipo_grupo_conta_contabil'),
            'grau' => $request->input('grau'),
            'nivel_1' => $request->input('nivel_1'),
            'nivel_2' => $request->input('nivel_2'),
            'nivel_3' => $request->input('nivel_3'),
            'nivel_4' => $request->input('nivel_4'),
            'nivel_5' => $request->input('nivel_5'),
            'nivel_6' => $request->input('nivel_6'),
        ]);

        app('flasher')->addSaved("Conta Contabil Gerada com Sucesso.");
        return redirect()->route('conta-contabil.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $numeros = [];
        for ($i = 0; $i <= 100; $i++) {
            $numeros[] = $i;
        }
        $catalogo_conta_contabil = ModelTipoCatalogoContaContabil::all();
        $natureza_conta_contabil = ModelTipoNaturezaContaContabil::all();
        $classe_conta_contabil = ModelTipoClasseContaContabil::all();
        $grupo_conta_contabil = ModelTipoGrupoContaContabil::all();
        $contaContabil = ModelContaContabil::with([
            'natureza_contabil',
            'catalogo_contabil',
            'grupo_contabil',
            'classe_contabil'
        ])->findOrFail($id);

        return view('contas.edit', compact('contaContabil', 'grupo_conta_contabil', 'classe_conta_contabil', 'natureza_conta_contabil', 'catalogo_conta_contabil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_tipo_catalogo' => 'required|exists:tipo_catalogo_conta_contabil,id',
            'descricao' => 'required|string|max:255',
            'id_tipo_natureza_conta_contabil' => 'required|exists:tipo_natureza_conta_contabil,id',
            'id_tipo_grupo_conta_contabil' => 'required|exists:tipo_grupo_conta_contabil,id',
            'grau' => 'required|integer|between:1,6',
            'nivel_1' => 'required|integer|between:1,99',
            'nivel_2' => 'nullable|integer|between:1,99',
            'nivel_3' => 'nullable|integer|between:1,99',
            'nivel_4' => 'nullable|integer|between:1,99',
            'nivel_5' => 'nullable|integer|between:1,99',
            'nivel_6' => 'nullable|integer|between:1,99',
        ]);

        // Verifica se já existe um registro com os mesmos níveis, excluindo o atual
        $duplicate = ModelContaContabil::where('nivel_1', $request->input('nivel_1'))
            ->where('nivel_2', $request->input('nivel_2'))
            ->where('nivel_3', $request->input('nivel_3'))
            ->where('nivel_4', $request->input('nivel_4'))
            ->where('nivel_5', $request->input('nivel_5'))
            ->where('nivel_6', $request->input('nivel_6'))
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            app('flasher')->addError('Já existe uma conta Contabil com esse registro');
            return redirect()->back();
        }

        $contaContabil = ModelContaContabil::findOrFail($id);
        $contaContabil->update([
            'data_inicio' => Carbon::now()->toDateString(),
            'id_tipo_catalogo' => $request->input('id_tipo_catalogo'),
            'descricao' => $request->input('descricao'),
            'id_tipo_natureza_conta_contabil' => $request->input('id_tipo_natureza_conta_contabil'),
            'id_tipo_grupo_conta_contabil' => $request->input('id_tipo_grupo_conta_contabil'),
            'grau' => $request->input('grau'),
            'nivel_1' => $request->input('nivel_1'),
            'nivel_2' => $request->input('nivel_2'),
            'nivel_3' => $request->input('nivel_3'),
            'nivel_4' => $request->input('nivel_4'),
            'nivel_5' => $request->input('nivel_5'),
            'nivel_6' => $request->input('nivel_6'),
        ]);

        app('flasher')->addSaved("Conta Contabil atualizada com sucesso.");
        return redirect()->route('conta-contabil.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inativar(string $id)
    {
        $contaContabil = ModelContaContabil::findOrFail($id);
        $contaContabil->update([
            'data_fim' => Carbon::now()->toDateString(),
        ]);
        return redirect()->route('conta-contabil.index');
    }
}
