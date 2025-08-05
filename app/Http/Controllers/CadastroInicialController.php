<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ModelCadastroInicial;
use App\Models\ModelSolMaterial;
use App\Models\ModelDepositoMaterial;
use App\Models\ModelDestinacao;
use App\Models\ModelSetor;
use App\Models\ModelDocumento;
use App\Models\ModelEmpresa;
use App\Models\ModelItemCatalogoMaterial;
use App\Models\ModelTipoCategoriaMt;
use App\Models\ModelTipoMaterial;
use App\Models\ModelStatusCadastroInicial;
use App\Models\ModelTipoDocumento;
use App\Models\ModelUnidadeMedida;
use App\Models\ModelSexo;
use App\Models\ModelCor;
use App\Models\ModelFaseEtaria;
use App\Models\ModelMarca;
use App\Models\ModelTamanho;
use App\Models\ModelMatProposta;
use App\Models\ModelMovimentacaoFisica;
use Illuminate\Database\Eloquent\Model;

class CadastroInicialController extends Controller
{
    public function index(Request $request)
    {
        $deposito = ModelDepositoMaterial::all();
        $destinacao = ModelDestinacao::all();
        $categoriaMaterial = ModelTipoCategoriaMt::all();
        $empresa = ModelEmpresa::all();
        $nomeMaterial = ModelItemCatalogoMaterial::all();
        $tipoDocumento = ModelTipoDocumento::all();
        $tipoMaterial = ModelTipoMaterial::all();
        $solMat = ModelSolMaterial::all();
        $status = ModelStatusCadastroInicial::all();


        //dd($setor);
        $query = ModelCadastroInicial::with('Status', 'SolOrigem', 'DocOrigem', 'Deposito', 'Destinacao', 'CategoriaMaterial', 'TipoMaterial');

        if ($request->pesquisaDeposito) {
            $query->where('id_deposito', $request->pesquisaDeposito);
        }
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_cadastro', [
                $request->data_inicio . ' 00:00:00',
                $request->data_fim . ' 23:59:59'
            ]);
        }
        if ($request->pesquisaDestinacao) {
            $query->where('id_destinacao', $request->pesquisaDestinacao);
        }
        if ($request->pesquisaCategoriaMaterial) {
            $query->where('id_cat_material', $request->pesquisaCategoriaMaterial);
        }
        if ($request->pesquisaEmpresa) {
            $query->whereHas('DocOrigem', function ($q) use ($request) {
                $q->where('id_empresa', $request->pesquisaEmpresa);
            });
        }
        if ($request->pesquisaNomeMaterial) {
            $query->where('id_item_catalogo', $request->pesquisaNomeMaterial);
        }
        if ($request->pesquisaNumeroDocumento) {
            $query->whereHas('DocOrigem', function ($q) use ($request) {
                $q->where('numero', $request->pesquisaNumeroDocumento);
            });
        }
        if ($request->pesquisaDocumento) {
            $query->whereHas('DocOrigem', function ($q) use ($request) {
                $q->where('id_tp_doc', $request->pesquisaDocumento);
            });
        }
        if ($request->pesquisaTipoMaterial) {
            $query->where('id_tipo_material', $request->pesquisaMaterial);
        }
        if ($request->pesquisaSolicitacao) {
            $query->where('id_sol_origem', $request->pesquisaSolicitacao);
        }
        if ($request->pesquisaStatus) {
            $query->where('id_tp_status', $request->pesquisaStatus);
        }

        $CadastroInicial = $query->orderBy('id', 'asc')->paginate(20);

        return view('cadastroInicial.gerenciar-cadastro-inicial', compact('request', 'CadastroInicial', 'status', 'solMat', 'tipoMaterial', 'tipoDocumento', 'nomeMaterial', 'deposito', 'destinacao', 'categoriaMaterial', 'empresa'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }
    public function storeTermoDoacao()
    {

        $CadastroInicialDoacao = ModelDocumento::create([
            'id_tp_doc' => '16',
            'dt_doc' => Carbon::now(),

        ]);

        app('flasher')->addSuccess('Adicione os materiais referentes a essa doação');
        return redirect("/gerenciar-cadastro-inicial/doacao/{$CadastroInicialDoacao->id}");
    }
    public function createDoacao($id)
    {
        $idDocumento = $id;
        $setor = session('usuario.setor');

        $buscaCategoria = ModelTipoCategoriaMt::all();
        $buscaEmpresa = ModelEmpresa::all();
        $buscaMarca = ModelMarca::all();
        $buscaTamanho = ModelTamanho::all();
        $buscaCor = ModelCor::all();
        $buscaFaseEtaria = ModelFaseEtaria::all();
        $buscaSexo = ModelSexo::all();
        $bucaItemCatalogo = ModelItemCatalogoMaterial::all();
        $buscaSetor = ModelSetor::whereIn('id', $setor)->get();
        $materiais = ModelMatProposta::with('documentoMaterial', 'tipoUnidadeMedida', 'tipoItemCatalogoMaterial', 'tipoCategoria', 'tipoMarca', 'tipoTamanho', 'tipoCor', 'tipoFaseEtaria', 'tipoSexo')->where('id_sol_mat', $id)->get();
        $buscaTipoMaterial = ModelTipoMaterial::all();

        $resultDocumento = ModelDocumento::where('id', $id)->first();
        $result = ModelCadastroInicial::with('ItemCatalogoMaterial', 'Embalagem', 'CategoriaMaterial', 'TipoMaterial')->where('documento_origem', $id)->orderBy('id', 'asc')->paginate(10);

        return view("cadastroInicial.doacao-cadastro-inicial-item", compact('result', 'bucaItemCatalogo', 'resultDocumento', 'buscaSetor', 'buscaEmpresa', 'buscaCategoria', 'buscaTipoMaterial', 'idDocumento', 'buscaSexo'));
    }
    public function storeDoacao(Request $request, $id)
    {
        $sacola = $request->input('sacola', 0); // vai pegar o valor 0 ou 1
        $documento = ModelDocumento::with('empresa')->where('id', $id)->firstOrFail();
        $materiais = ModelCadastroInicial::with(['ItemCatalogoMaterial', 'Embalagem', 'CategoriaMaterial', 'TipoMaterial'])
            ->where('documento_origem', $id)
            ->get();
        ModelCadastroInicial::where('documento_origem', $id)->update([
            'sacola' => $sacola,
        ]);
        $usuario = session('usuario.nome');

        if (is_null($documento->end_arquivo)) {
            $pdf = Pdf::loadView('cadastroInicial.pdf-doacao', compact('documento', 'materiais', 'usuario'));

            // Define o caminho do arquivo
            $fileName = 'recibo_doacao_' . $id . '.pdf';
            $filePath = 'doacoes/' . $fileName;

            // Salva no disco 'public'
            Storage::disk('public')->put($filePath, $pdf->output());

            // Atualiza a coluna end_arquivo do documento com o caminho salvo
            $documento->end_arquivo = 'storage/' . $filePath;
            $documento->save();
        }
        // Se a sacola estiver selecionada, gerar um novo PDF com número, sem salvar
        if ($sacola == 1) {
            $pdfNumero = Pdf::loadView('cadastroInicial.pdf-doacao-numero', compact('documento', 'materiais'));

            // Codifica em base64 (não salva em disco)
            $pdfBase64 = base64_encode($pdfNumero->output());

            // Envia o base64 via sessão
            session()->flash('pdf_base64', $pdfBase64);
        }

        foreach ($materiais as $material) {
            // Verifica se já existe uma movimentação para esse material
            $jaExiste = ModelMovimentacaoFisica::where('id_cadastro_inicial', $material->id)->exists();

            if (!$jaExiste) {
                ModelMovimentacaoFisica::create([
                    'id_destinatario' => session('usuario.id_usuario'),
                    'data' => Carbon::now(),
                    'id_deposito_destino' => 1,
                    'id_tp_movimento' => 1,
                    'id_cadastro_inicial' => $material->id
                ]);
            }
        }

        return redirect()->route('CadastroInicial');
    }
    public function storeTermoCompra()
    {

        $CadastroInicialCompra = ModelDocumento::create([
            'id_tp_doc' => '1',
            'dt_doc' => Carbon::now(),

        ]);

        app('flasher')->addSuccess('Adicione os materiais referentes a essa compra');
        return redirect("/gerenciar-cadastro-inicial/compra-direta/{$CadastroInicialCompra->id}");
    }
    public function createCompraDireta(Request $request, $id)
    {
        $idDocumento = $id;
        $setor = session('usuario.setor');

        $tiposDocumento = ModelTipoDocumento::all();
        $buscaCategoria = ModelTipoCategoriaMt::all();
        $buscaEmpresa = ModelEmpresa::all();
        $buscaMarca = ModelMarca::all();
        $buscaTamanho = ModelTamanho::all();
        $buscaCor = ModelCor::all();
        $buscaFaseEtaria = ModelFaseEtaria::all();
        $buscaSexo = ModelSexo::all();
        $bucaItemCatalogo = ModelItemCatalogoMaterial::all();
        $buscaUnidadeMedida = ModelUnidadeMedida::where('tipo', '2')->get();
        $buscaSetor = ModelSetor::whereIn('id', $setor)->get();
        $materiais = ModelMatProposta::with('documentoMaterial', 'tipoUnidadeMedida', 'tipoItemCatalogoMaterial', 'tipoCategoria', 'tipoMarca', 'tipoTamanho', 'tipoCor', 'tipoFaseEtaria', 'tipoSexo')->where('id_sol_mat', $id)->get();
        $buscaTipoMaterial = ModelTipoMaterial::all();

        $resultDocumento = ModelDocumento::with('tipoDocumento')->where('id', $id)->first();
        $result = ModelCadastroInicial::with('ItemCatalogoMaterial', 'Embalagem', 'CategoriaMaterial', 'TipoMaterial')->where('documento_origem', $id)->orderBy('id', 'asc')->paginate(10);

        return view("cadastroInicial/compra-direta-cadastro-inicial-item", compact('result', 'tiposDocumento', 'bucaItemCatalogo', 'resultDocumento', 'buscaSetor', 'buscaEmpresa', 'buscaCategoria', 'buscaTipoMaterial', 'idDocumento', 'buscaUnidadeMedida', 'buscaSexo'));
    }
    public function storeCompraDireta(Request $request, $id)
    {
        $materiais = ModelCadastroInicial::with(['ItemCatalogoMaterial', 'Embalagem', 'CategoriaMaterial', 'TipoMaterial'])
            ->where('documento_origem', $id)
            ->get();

        foreach ($materiais as $material) {
            // Verifica se já existe uma movimentação para esse material
            $jaExiste = ModelMovimentacaoFisica::where('id_cadastro_inicial', $material->id)->exists();

            if (!$jaExiste) {
                ModelMovimentacaoFisica::create([
                    'id_destinatario' => session('usuario.id_usuario'),
                    'data' => Carbon::now(),
                    'id_deposito_destino' => 1,
                    'id_tp_movimento' => 1,
                    'id_cadastro_inicial' => $material->id
                ]);
            }
        }

        return redirect()->route('CadastroInicial');
    }
    public function storeMaterial(Request $request, $id)
    {
        $idDocumento = $id;
        $tipoDocumento = ModelDocumento::find($id)->id_tp_doc;
        $checkAvariado = isset($request->checkAvariado) ? 1 : 0;
        $checkAplicacao = isset($request->checkAplicacao) ? 1 : 0;
        $checkNumSerie = isset($request->checkNumSerie) ? 1 : 0;
        $checkVeiculo = isset($request->checkVeiculo) ? 1 : 0;
        $valorAquisicao = $request->input('valorAquisicaoMaterial');
        $valorVenda = $request->input('valorVendaMaterial');

        if (is_array($valorAquisicao)) {
            $valorAquisicao = $valorAquisicao[0] ?? null;
        }
        if (is_array($valorVenda)) {
            $valorVenda = $valorVenda[0] ?? null;
        }

        $dadosComuns = [
            'id_cat_material' => $request->input('categoriaMaterial'),
            'id_item_catalogo' => $request->input('nomeMaterial'),
            'id_tipo_material' => $request->input('tipoMaterial'),
            'id_embalagem' => $request->input('embalagemMaterial'),
            'modelo' => $request->input('modeloMaterial'),
            'observacao' => $request->input('observacaoMaterial'),
            'avariado' => $checkAvariado,
            'aplicacao' => $checkAplicacao,
            'data_validade' => $request->input('dataValidadeMaterial'),
            'id_marca' => $request->input('marcaMaterial'),
            'id_tamanho' => $request->input('tamanhoMaterial'),
            'id_cor' => $request->input('corMaterial'),
            'id_fase_etaria' => $request->input('faseEtariaMaterial'),
            'id_tp_sexo' => $request->input('sexoMaterial'),
            'placa' => $request->input('placaMaterial'),
            'renavam' => $request->input('renavamMaterial'),
            'chassi' => $request->input('chassiMaterial'),
            'valor_aquisicao' => $valorAquisicao,
            'valor_venda' => $valorVenda,
            'data_cadastro' => Carbon::now(),
            'adquirido' => in_array($tipoDocumento, [1, 4, 6, 7, 8]),
            'id_deposito' => '1',
            'id_tp_status' => '1',
            'documento_origem' => $id,
            'dt_fab' => $request->input('dataFabricacaoMaterial'),
            'dt_fab_modelo' => $request->input('dataFabricacaoModeloMaterial'),
        ];

        $quantidade = (int) $request->input('quantidadeMaterial');
        $tipoMaterial = (int) $request->input('tipoMaterial');

        if ($tipoMaterial === 1 && $checkNumSerie == 1) {
            $numerosSerie = $request->input('numerosSerie', []);

            for ($i = 0; $i < $quantidade; $i++) {
                $dados = array_merge($dadosComuns, [
                    'quantidade' => 1,
                    'num_serie' => $numerosSerie[$i] ?? null,
                ]);

                $material = ModelCadastroInicial::create($dados);

                $this->criarMovimentacaoFisica($material->id);
            }
        } else if ($tipoMaterial === 1 && $checkVeiculo == 1) {
            $numerosPlacas = $request->input('numerosPlacas', []);
            $numerosRenavam = $request->input('numerosRenavam', []);
            $numerosChassis = $request->input('numerosChassis', []);

            for ($i = 0; $i < $quantidade; $i++) {
                $dados = array_merge($dadosComuns, [
                    'quantidade' => 1,
                    'placa' => $numerosPlacas[$i] ?? null,
                    'renavam' => $numerosRenavam[$i] ?? null,
                    'chassi' => $numerosChassis[$i] ?? null,
                ]);

                $material = ModelCadastroInicial::create($dados);

                $this->criarMovimentacaoFisica($material->id);
            }
        } else if ($tipoMaterial === 1) {

            for ($i = 0; $i < $quantidade; $i++) {
                $dados = array_merge($dadosComuns, [
                    'quantidade' => 1,
                    'num_serie' => null,
                    'placa' => null,
                    'renavam' => null,
                    'chassi' => null,
                ]);

                $material = ModelCadastroInicial::create($dados);

                $this->criarMovimentacaoFisica($material->id);
            }
        } else {
            $material = ModelCadastroInicial::create(array_merge($dadosComuns, [
                'quantidade' => $quantidade,
                'num_serie' => null,
                'placa' => null,
                'renavam' => null,
                'chassi' => null,
            ]));

            $this->criarMovimentacaoFisica($material->id);
        }

        $rota = $this->definirRotaPorTipoDocumento($tipoDocumento);

        app('flasher')->addSuccess('Material adicionado com sucesso!');
        return redirect()->route($rota, ['id' => $idDocumento]);
    }
    public function storeTermoMaterial(Request $request, $id)
    {
        $idDocumento = $id;
        $tipoDocumento = ModelDocumento::find($id)->id_tp_doc;

        $dadosAtualizados = [];

        // Atualiza id_empresa se veio no request e não está vazio
        if ($request->filled('empresaDocDoacao')) {
            $dadosAtualizados['id_empresa'] = $request->input('empresaDocDoacao');
        }

        // Atualiza id_tp_doc se veio no request e não está vazio
        if ($request->filled('tipoDocCompra')) {
            $dadosAtualizados['id_tp_doc'] = $request->input('tipoDocCompra');
        }

        // Atualiza número se veio no request e não está vazio
        if ($request->filled('numeroDocDoacao')) {
            $dadosAtualizados['numero'] = $request->input('numeroDocDoacao');
        }

        // Atualiza valor se veio no request e não está vazio
        if ($request->filled('valorDocCompra')) {
            $dadosAtualizados['valor'] = $request->input('valorDocCompra');
        }

        // Verifica se um arquivo foi enviado e é válido
        if ($request->hasFile('arquivoDocDoacao') && $request->file('arquivoDocDoacao')->isValid()) {
            // Salva o arquivo no disco 'public' dentro da pasta 'termos-doacao'
            $caminhoArquivo = $request->file('arquivoDocDoacao')->store('termos-doacao', 'public');
            $dadosAtualizados['end_arquivo'] = $caminhoArquivo;
        }

        // Só atualiza se houver dados para atualizar
        if (!empty($dadosAtualizados)) {
            ModelDocumento::where('id', $idDocumento)->update($dadosAtualizados);
        }

        $rota = $this->definirRotaPorTipoDocumento($tipoDocumento);

        app('flasher')->addSuccess('Material adicionado com sucesso!');
        return redirect()->route($rota, ['id' => $idDocumento]);
    }
    public function gerarPDFDoacao($id)
    {
        $documento = ModelDocumento::with('empresa')->where('id', $id)->firstOrFail();
        $materiais = ModelCadastroInicial::with(['ItemCatalogoMaterial', 'Embalagem', 'CategoriaMaterial', 'TipoMaterial'])
            ->where('documento_origem', $id)
            ->get();
        $usuario = session('usuario.nome');

        $pdf = Pdf::loadView('cadastroInicial.pdf-doacao', compact('documento', 'materiais', 'usuario'));

        $fileName = 'recibo_doacao_' . $id . '.pdf';
        $filePath = 'doacoes/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $documento->end_arquivo = 'storage/' . $filePath;
        $documento->save();

        return $pdf->stream($fileName);
    }
    public function editMaterial(Request $request)
    {
        $idDocumento = $request->input('documento-id-editar');
        $tipoDocumento = ModelDocumento::find($idDocumento)->id_tp_doc;
        $idCadastro = $request->input('edit-id');
        $checkAvariado = isset($request->checkAvariadoEditar) ? 1 : 0;
        $checkAplicacao = isset($request->checkAplicacaoEditar) ? 1 : 0;
        $checkNumSerie = isset($request->checkNumSerieEditar) ? 1 : 0;
        $checkVeiculo = isset($request->checkVeiculoEditar) ? 1 : 0;
        $quantidade = (int) $request->input('quantidadeMaterialEditar');
        $tipoMaterial = (int) $request->input('tipoMaterialEditar');

        $dadosAtualizados = [
            'id_cat_material' => $request->input('categoriaMaterialEditar'),
            'id_item_catalogo' => $request->input('nomeMaterialEditar'),
            'id_tipo_material' => $request->input('tipoMaterialEditar'),
            'aplicacao' => $checkAplicacao,
            'modelo' => $request->input('modeloMaterialEditar'),
            'avariado' => $checkAvariado,
            'valor_aquisicao' => $request->input('valorAquisicaoMaterialEditar'),
            'valor_venda' => $request->input('valorVendaMaterialEditar'),
            'data_validade' => $request->input('dataValidadeMaterialEditar'),
            'id_marca' => $request->input('marcaMaterialEditar'),
            'id_tamanho' => $request->input('tamanhoMaterialEditar'),
            'id_cor' => $request->input('corMaterialEditar'),
            'id_fase_etaria' => $request->input('faseEtariaMaterialEditar'),
            'id_tp_sexo' => $request->input('sexoMaterialEditar'),
            'dt_fab' => $request->input('dataFabricacaoMaterialEditar'),
            'dt_fab_modelo' => $request->input('dataFabricacaoModeloMaterialEditar'),
            'observacao' => $request->input('observacaoMaterialEditar'),
        ];

        if ($tipoMaterial === 1 && $checkNumSerie == 1) {
            $numerosSerie = $request->input('numerosSerieEditar', []);
            $dados = array_merge($dadosAtualizados, [
                'quantidade' => 1,
                'num_serie' => $numerosSerie[0] ?? null,
                'placa' => null,
                'renavam' => null,
                'chassi' => null,
            ]);

            // Supondo que você tenha o ID do item a ser atualizado
            ModelCadastroInicial::where('id', $idCadastro)->update($dados);

            for ($i = 1; $i < $quantidade; $i++) {
                $dados = array_merge($dadosAtualizados, [
                    'quantidade' => 1,
                    'num_serie' => $numerosSerie[$i] ?? null,
                    'placa' => null,
                    'renavam' => null,
                    'chassi' => null,
                ]);

                ModelCadastroInicial::create($dados);
            }
        } else if ($tipoMaterial === 1 && $checkVeiculo == 1) {
            $numerosPlacas = $request->input('numerosPlacasEditar', []);
            $numerosRenavam = $request->input('numerosRenavamEditar', []);
            $numerosChassis = $request->input('numerosChassisEditar', []);

            $dados = array_merge($dadosAtualizados, [
                'quantidade' => 1,
                'placa' => $numerosPlacas[0] ?? null,
                'renavam' => $numerosRenavam[0] ?? null,
                'chassi' => $numerosChassis[0] ?? null,
                'num_serie' => null,
            ]);

            // Supondo que você tenha o ID do item a ser atualizado
            ModelCadastroInicial::where('id', $idCadastro)->update($dados);

            for ($i = 1; $i < $quantidade; $i++) {
                $dados = array_merge($dadosAtualizados, [
                    'quantidade' => 1,
                    'placa' => $numerosPlacas[$i] ?? null,
                    'renavam' => $numerosRenavam[$i] ?? null,
                    'chassi' => $numerosChassis[$i] ?? null,
                    'num_serie' => null,
                ]);

                ModelCadastroInicial::create($dados);
            }
        } else if ($tipoMaterial === 1) {

            $dados = array_merge($dadosAtualizados, [
                'quantidade' => 1,
                'num_serie' => null,
                'placa' => null,
                'renavam' => null,
                'chassi' => null,
            ]);

            ModelCadastroInicial::where('id', $idCadastro)->update($dados);

            for ($i = 1; $i < $quantidade; $i++) {
                $dados = array_merge($dadosAtualizados, [
                    'quantidade' => 1,
                    'num_serie' => null,
                    'placa' => null,
                    'renavam' => null,
                    'chassi' => null,
                ]);

                ModelCadastroInicial::create($dados);
            }
        } else {
            ModelCadastroInicial::where('id', $idCadastro)->update(array_merge($dadosAtualizados, [
                'quantidade' => $quantidade,
                'num_serie' => null,
                'placa' => null,
                'renavam' => null,
                'chassi' => null,
            ]));
        }

        $rota = $this->definirRotaPorTipoDocumento($tipoDocumento);

        app('flasher')->addSuccess('Material editado com sucesso!');
        return redirect()->route($rota, ['id' => $idDocumento]);
    }
    public function deleteMaterial(Request $request)
    {
        $idDocumento = $request->input('documento-id-excluir');
        $tipoDocumento = ModelDocumento::find($idDocumento)->id_tp_doc;
        $idMaterial = $request->input('delete-id');
        $material = ModelCadastroInicial::find($idMaterial);
        if ($material) {
            ModelMovimentacaoFisica::where('id_cadastro_inicial', $idMaterial)->delete();
            $material->delete();

            app('flasher')->addSuccess('Material deletado com sucesso!');
        } else {
            app('flasher')->addError('Material não encontrado!');
        }

        $rota = $this->definirRotaPorTipoDocumento($tipoDocumento);

        return redirect()->route($rota, ['id' => $idDocumento]);
    }
    private function criarMovimentacaoFisica($materialId)
    {
        ModelMovimentacaoFisica::create([
            'id_destinatario' => session('usuario.id_usuario'),
            'data' => Carbon::now(),
            'id_deposito_destino' => 1,
            'id_tp_movimento' => 1,
            'id_cadastro_inicial' => $materialId
        ]);
    }
    private function definirRotaPorTipoDocumento($tipoDocumento)
    {
        return match ($tipoDocumento) {
            16 => 'doacao',
            1, 4, 6, 7, 8 => 'compraDireta',
            default => 'CadastroInicial',
        };
    }
}
