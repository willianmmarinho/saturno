<?php

namespace App\Http\Controllers;

use App\Models\ModelPagamentos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ModelDocumento;
use App\Models\ModelSolMaterial;
use App\Models\ModelDeposito;
use App\Models\ModelTipoCategoriaMt;
use App\Models\ModelEmpresa;
use App\Models\ModelMarca;
use App\Models\ModelTamanho;
use App\Models\ModelCor;
use App\Models\ModelFaseEtaria;
use App\Models\ModelSexo;
use App\Models\ModelItemCatalogoMaterial;
use App\Models\ModelUnidadeMedida;
use App\Models\ModelSetor;
use App\Models\ModelMatProposta;

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  public function index()
    // {
    //     $result = DB::select("select * from pagamento");
    //     return $result;
    // }
    // public function indexPagamento()
    // {
    //     $result = $this->index();

    //     return view('pagamento.gerenciar-pagamento', ['result' => $result]);
    // }
    public function indexPagamento()
    {
        $result = ModelPagamentos::orderBy('id', 'asc')->paginate(20); // 20 por página
        return view('pagamento.gerenciar-pagamento', compact('result'));
    }
    public function createPagamento($id)
    {
         $idSolicitacao = $id;

        $documentos = ModelDocumento::where('id_sol_mat', $idSolicitacao)->with('empresa')->get();
        //dd($documentos);
        $solicitacao = ModelSolMaterial::with('modelPessoa', 'modelPessoaResponsavel', 'setor')->find($idSolicitacao);
        $buscaDeposito = ModelDeposito::all();
        //dd($solicitacao->modelPessoa->nome_completo);
        $setor = session('usuario.setor');
        $buscaCategoria = ModelTipoCategoriaMt::all();
        $buscaEmpresa = ModelEmpresa::all();
        $buscaMarca = ModelMarca::all();
        $buscaTamanho = ModelTamanho::all();
        $buscaCor = ModelCor::all();
        $buscaFaseEtaria = ModelFaseEtaria::all();
        $buscaSexo = ModelSexo::all();
        $bucaItemCatalogo = ModelItemCatalogoMaterial::all();
        $buscaUnidadeMedida = ModelUnidadeMedida::all();
        $buscaSetor = ModelSetor::whereIn('id', $setor)->get();
        $materiais = ModelMatProposta::with('documentoMaterial', 'TipoMaterial', 'tipoUnidadeMedida', 'Embalagem', 'tipoItemCatalogoMaterial', 'tipoCategoria', 'tipoMarca', 'tipoTamanho', 'tipoCor', 'tipoFaseEtaria', 'tipoSexo')->where('id_sol_mat', $id)->get();

        $result = ModelPagamentos::where('id', $id)->get();

        return view('pagamento.incluir-pagamento', compact('result', 'documentos', 'buscaDeposito', 'solicitacao', 'bucaItemCatalogo', 'materiais', 'idSolicitacao', 'buscaSetor', 'buscaUnidadeMedida', 'buscaCategoria', 'buscaMarca', 'buscaTamanho', 'buscaCor', 'buscaFaseEtaria', 'buscaSexo', 'buscaEmpresa'));
    }
    public function indexContrato()
    {
        $result = ModelPagamentos::orderBy('id', 'asc')->paginate(20);


        return view('pagamento.gerenciar-contrato', compact('result'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
