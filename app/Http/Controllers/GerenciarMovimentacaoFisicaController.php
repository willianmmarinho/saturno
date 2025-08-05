<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelCadastroInicial;
use App\Models\ModelDocumento;
use App\Models\ModelEmpresa;
use App\Models\ModelMovimentacaoFisica;
use App\Models\ModelSetor;
use App\Models\ModelTipoDeposito;
use App\Models\ModelUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class GerenciarMovimentacaoFisicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $movimentacoes_fisicas = ModelMovimentacaoFisica::with([
            'cadastro_inicial',
            'remetente',
            'destinatario',
            'deposito_origem',
            'deposito_destino',
            'tipo_movimento'
        ])->get();

        $tipos_deposito = ModelTipoDeposito::all();
        // dd($movimentacoes_fisicas);

        return view('movimentacao-fisica.index', compact('movimentacoes_fisicas', 'tipos_deposito'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
    public function solicitar_teste()
    {

        $cadastro_inicial = ModelCadastroInicial::with(
            'Status',
            'SolOrigem',
            'DocOrigem',
            'Deposito',
            'Destinacao',
            'CategoriaMaterial',
            'TipoMaterial',
            'movimentacaoFisica',
            'ItemCatalogoMaterial',
            'Marca',
            'Cor',
            'Tamanho',
            'FaseEtaria',
            'TipoSexo'
        )
            ->whereHas('movimentacaoFisica', function ($query) {
                $query->where('id_tp_movimento', 1);
            })
            ->get();

        $documentos = ModelDocumento::all()->whereIn('id_tp_doc', [16, 17]);
        // dd($documentos);
        //   dd($cadastro_inicial);
        return view('movimentacao-fisica.novo-solicitar-teste', compact('cadastro_inicial', 'documentos'));
    }
    public function ajax_por_material($id)
    {
        $material = ModelCadastroInicial::with(
            'Status',
            'SolOrigem',
            'DocOrigem',
            'Deposito',
            'Destinacao',
            'CategoriaMaterial',
            'TipoMaterial',
            'movimentacaoFisica',
            'ItemCatalogoMaterial',
            'Marca',
            'Cor',
            'Tamanho',
            'FaseEtaria',
            'TipoSexo'
        )
            ->where('id', $id)
            ->first();
        return response()->json($material);
    }

    public  function solicitar_teste_ajax_para_material_por_data($data_inicio, $data_fim)
    {
        $cadastro_inicial = ModelCadastroInicial::with(
            'Status',
            'SolOrigem',
            'DocOrigem',
            'Deposito',
            'Destinacao',
            'CategoriaMaterial',
            'TipoMaterial',
            'movimentacaoFisica',
            'ItemCatalogoMaterial',
            'Marca',
            'Cor',
            'Tamanho',
            'FaseEtaria',
            'TipoSexo'
        )
            ->whereBetween('data_cadastro', [$data_inicio, $data_fim])
            ->whereHas('movimentacaoFisica', function ($query) {
                $query->where('id_tp_movimento', 1);
            })
            ->get();

        return response()->json($cadastro_inicial);
    }

    public function retorna_materiais()
    {
        $cadastro_inicial = ModelCadastroInicial::with(
            'Status',
            'SolOrigem',
            'DocOrigem',
            'Deposito',
            'Destinacao',
            'CategoriaMaterial',
            'TipoMaterial',
            'movimentacaoFisica',
            'Cor',
            'Marca',
            'Tamanho',
            'TipoSexo'
        )
            // ->whereBetween('data_cadastro', [$data_inicio, $data_fim])
            ->whereHas('movimentacaoFisica', function ($query) {
                $query->where('id_tp_movimento', 1);
            })
            ->get();

        return response()->json($cadastro_inicial);
    }

    public function solicitar_teste_confere(Request $request)
    {

        $ids = $request->all()['materiais1'];
        if (!$ids) {
            app('flasher')->addError('Selecione pelo menos um material para continuar.');
            return redirect()->back();
        }

        $materiais_enviados = ModelCadastroInicial::with([
            'Status',
            'SolOrigem',
            'DocOrigem',
            'Deposito',
            'Destinacao',
            'CategoriaMaterial',
            'TipoMaterial',
            'movimentacaoFisica',
            'Cor',
            'Marca',
            'Tamanho',
            'TipoSexo'
        ])->whereIn('id', $request->input('materiais1'))->get();


        // dd($materiais_enviados);
        $setores = ModelSetor::orderBy('sigla')->get();

        $usuarios = ModelUsuario::with('pessoa')->get();

        return view('movimentacao-fisica.solicitar-teste-confere', compact('materiais_enviados', 'setores', 'usuarios'));
    }
    public function homologar(Request $request)
    {

        $materiais_enviados = $request->input('materiais');

        $setor = $request->input('setor');


        return view('movimentacao-fisica.homologar', compact('materiais_enviados', 'setor'));
    }
    public function solicitar_teste_store(Request $request)
    {
        // dd($request->all());

        $cpf = $request->input('cpf');
        $senha = $request->input('senha');

        $result = DB::connection('pgsql2')->select("
                        select
                        u.id id_usuario,
                        p.id id_pessoa,
                        a.id id_associado,
                        p.cpf,
                        p.sexo,
                        p.nome_completo,
                        u.hash_senha,
                        string_agg(distinct u_p.id_perfil::text, ',') perfis,
                        string_agg(distinct u_d.id_Deposito::text, ',') depositos,
                        string_agg(distinct u_s.id_Setor::text, ',') setor
                        from usuario u
                        left join pessoas p on u.id_pessoa = p.id
                        left join associado a on a.id_pessoa = p.id
                        left join usuario_perfil u_p on u.id = u_p.id_usuario
                        left join usuario_deposito u_d on u.id = u_d.id_usuario
                        left join usuario_setor u_s on u.id = u_s.id_usuario
                        where u.ativo is true and p.cpf = '$cpf'
                        group by u.id, p.id, a.id
                        ");

        //dd($result);

        if (count($result) > 0) {
            $perfis = explode(',', $result[0]->perfis);
            $setores = explode(',', $result[0]->setor);
            $array_setores = $setores;

            $perfis = DB::table('rotas_perfil')->whereIn('id_perfil', $perfis)->orderBy('id_rotas')->pluck('id_rotas');
            $setores = DB::table('rotas_setor')->whereIn('id_setor', $setores)->orderBy('id_rotas')->pluck('id_rotas');

            $perfis = json_decode(json_encode($perfis), true);
            $setores = json_decode(json_encode($setores), true);

            $rotasAutorizadas = array_intersect($perfis, $setores);

            $hash_senha = $result[0]->hash_senha;

            if (Hash::check($senha, $hash_senha)) {


                app('flasher')->addSuccess('Acesso autorizado');

                // if ($cpf == $senha) {
                //     return view('/usuario/alterar-senha');
                // }
                // return view('login/home');
            }
        }
    }
}
