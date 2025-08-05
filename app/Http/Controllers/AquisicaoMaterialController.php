<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelCatalogoMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ModelSolMaterial;
use App\Models\ModelTipoCategoriaMt;
use App\Models\ModelTipoStatusSolMt;
use App\Models\ModelSetor;
use App\Models\ModelCor;
use App\Models\ModelDocumento;
use App\Models\ModelEmbalagem;
use App\Models\ModelFaseEtaria;
use App\Models\ModelMarca;
use App\Models\ModelSexo;
use App\Models\ModelTamanho;
use App\Models\ModelEmpresa;
use App\Models\ModelItemCatalogoMaterial;
use App\Models\ModelMatProposta;
use App\Models\ModelUnidadeMedida;
use App\Models\ModelPessoa;
use App\Models\ModelDeposito;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;


use function Laravel\Prompts\select;

class AquisicaoMaterialController extends Controller
{

    public function index(Request $request)
    {

        $usuario = session('usuario.id_usuario');
        $setor = session('usuario.setor');
        $excluirSol = $request->excluirSol;
        $sol = ModelSolMaterial::find($excluirSol);

        //dd($setor);
        $query = ModelSolMaterial::with(['matProposta', 'tipoStatus', 'setor']);

        if ($request->status_material) {
            $query->where('status', $request->status_material);
        }
        if ($request->classe) {
            $query->where('id_classe_mt', $request->classe);
        }
        if ($request->servicos) {
            $query->where('id_tp_mt', $request->servicos);
        }
        if ($request->setor) {
            $query->where('id_setor', $request->setor);
        }

        $aquisicao = $query->orderBy('prioridade', 'asc')->orderBy('id', 'asc')->paginate(20);

        //dd($aquisicao);

        $status = ModelTipoStatusSolMt::all();

        $categoriaAquisicao = ModelTipoCategoriaMt::all();
        $todosSetor = ModelSetor::orderBy('nome')->get();

        $prioridadesExistentes = ModelSolMaterial::pluck('prioridade')->unique()->toArray();

        // Se existirem prioridades, encontra a maior e adiciona 1
        if (!empty($prioridadesExistentes)) {
            $maiorPrioridade = max($prioridadesExistentes);
            $numeros = range(1, $maiorPrioridade + 1); // Gera uma lista de 1 até a maior prioridade + 1
        } else {
            // Se não houver prioridades, você pode definir o range inicial como desejado, por exemplo, 1
            $numeros = range(1, 1);
        }


        return view('solMaterial.gerenciar-aquisicao-material', compact('sol', 'aquisicao', 'categoriaAquisicao', 'status', 'todosSetor', 'numeros', 'usuario', 'setor'));
    }
    public function retornaNomeMateriais($idClasse)
    {
        $materiais = DB::table('catalogo_materiais')
            ->where('id_cl_mt', $idClasse)
            ->select('id', 'descricao')
            ->get();


        // dd($cidadeDadosResidenciais);

        return response()->json($materiais);
    }
    private function reorganizarPrioridades()
    {
        // Obtém todas as solicitações com prioridade, ordenadas pela prioridade
        $solicitacoes = ModelSolMaterial::whereNotNull('prioridade')
            ->orderBy('prioridade')
            ->get();

        $prioridadeAtual = 1;

        foreach ($solicitacoes as $solicitacao) {
            // Ajusta a prioridade para que seja sequencial
            if ($solicitacao->prioridade != $prioridadeAtual) {
                $solicitacao->prioridade = $prioridadeAtual;
                $solicitacao->save();
            }
            $prioridadeAtual++;
        }
    }
    public function aprovarEmLote(Request $request)
    {
        $usuario = session('usuario.id_usuario');
        $prioridades = $request->input('prioridade');
        $materiais = $request->input('setor');

        $this->processarLote($prioridades, $materiais, [
            'status' => 3,
            'aut_usu_adm' => $usuario,
            'dt_usu_adm' => now(),
        ]);

        app('flasher')->addSuccess('Solicitações aprovadas com sucesso');
        return redirect('/gerenciar-aquisicao-material');
    }
    public function homologarEmLote(Request $request)
    {
        $usuario = session('usuario.id_usuario');
        $prioridades = $request->input('prioridade');
        $materiais = $request->input('setor');

        $this->processarLote($prioridades, $materiais, [
            'status' => 3,
            'aut_usu_pres' => $usuario,
            'dt_usu_pres' => now(),
        ]);

        app('flasher')->addSuccess('Solicitações homologadas com sucesso');
        return redirect('/gerenciar-aquisicao-material');
    }
    private function processarLote($prioridades, $materiais, array $camposAdicionais)
    {
        foreach ($prioridades as $id => $novaPrioridade) {
            if (isset($materiais[$id]) && isset($novaPrioridade)) {
                $solicitacao = ModelSolMaterial::find($id);

                if ($solicitacao) {
                    $prioridadeAtual = $solicitacao->prioridade;

                    // Verifica se aut_usu_pres é nulo antes de alterar a prioridade
                    if (is_null($solicitacao->aut_usu_pres)) {
                        // Ajuste das prioridades intermediárias se houver alteração
                        if ($novaPrioridade != $prioridadeAtual) {
                            if ($novaPrioridade > $prioridadeAtual) {
                                // Reduz prioridades entre a atual e a nova
                                ModelSolMaterial::whereBetween('prioridade', [$prioridadeAtual + 1, $novaPrioridade])
                                    ->decrement('prioridade');
                            } elseif ($novaPrioridade < $prioridadeAtual) {
                                // Aumenta prioridades entre a nova e a atual
                                ModelSolMaterial::whereBetween('prioridade', [$novaPrioridade, $prioridadeAtual - 1])
                                    ->increment('prioridade');
                            }

                            // Atualiza a prioridade apenas se a condição for atendida
                            $solicitacao->update(['prioridade' => $novaPrioridade]);
                        }
                    }

                    // Atualiza os outros campos conforme os parâmetros fornecidos
                    $solicitacao->update(array_merge([
                        'id_resp_mt' => $materiais[$id],
                    ], $camposAdicionais));
                }
            }
        }

        // Reorganização das prioridades após as atualizações
        $this->reorganizarPrioridades();
    }
    public function store(Request $request)
    {

        $idUsuario = session('usuario.id_pessoa');
        //dd($idUsuario);

        $solicitacaoMaterial = ModelSolMaterial::create([
            'data' => Carbon::now(),
            'status' => '1',
            'tipo_sol_material' => '1',
            'id_resp_sol_mt' => $idUsuario,
        ]);

        app('flasher')->addSuccess('Solicitação Criada com Sucesso, Adicione os materiais Necessários');
        return redirect("/incluir-aquisicao-material-2/{$solicitacaoMaterial->id}");
    }
    public function create($id)
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
        //dd($materiais);

        //dd($documentoMaterial);

        return view('solMaterial.incluir-aquisicao-material-2', compact('documentos', 'buscaDeposito', 'solicitacao', 'bucaItemCatalogo', 'materiais', 'idSolicitacao', 'buscaSetor', 'buscaUnidadeMedida', 'buscaCategoria', 'buscaMarca', 'buscaTamanho', 'buscaCor', 'buscaFaseEtaria', 'buscaSexo', 'buscaEmpresa'));
    }
    public function store2(Request $request, $id)
    {
        $idSolicitacao = $id;
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
            'id_marca' => $request->input('marcaMaterial'),
            'id_tamanho' => $request->input('tamanhoMaterial'),
            'id_cor' => $request->input('corMaterial'),
            'id_fase_etaria' => $request->input('faseEtariaMaterial'),
            'id_tp_sexo' => $request->input('sexoMaterial'),
            'id_embalagem' => $request->input('embalagemMaterial'),
            'id_item_catalogo' => $request->input('nomeMaterial'),
            'id_sol_mat' => $idSolicitacao,
            'dt_cadastro' => Carbon::now(),
            'observacao' => $request->input('observacaoMaterial'),
            'adquirido' => true,
            'dt_validade' => $request->input('dataValidadeMaterial'),
            'componente' => $request->input('componenteMaterial'),
            'dt_fab' => $request->input('dataFabricacaoMaterial'),
            'dt_fab_modelo' => $request->input('dataFabricacaoModeloMaterial'),
            'id_tipo_material' => $request->input('tipoMaterial'),
            'avariado' => $checkAvariado,
            'aplicacao' => $checkAplicacao,
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

                $material = ModelMatProposta::create($dados);

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

                $material = ModelMatProposta::create($dados);

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

                $material = ModelMatProposta::create($dados);

                $this->criarMovimentacaoFisica($material->id);
            }
        } else {
            $material = ModelMatProposta::create(array_merge($dadosComuns, [
                'quantidade' => $quantidade,
                'num_serie' => null,
                'placa' => null,
                'renavam' => null,
                'chassi' => null,
            ]));

            $this->criarMovimentacaoFisica($material->id);
        }



        app('flasher')->addSuccess('Material adicionado com sucesso!');
        return redirect("/incluir-aquisicao-material-2/{$idSolicitacao}");
    }
    public function destroyMaterial(Request $request)
    {
        // Busca e exclusão do material
        $material = ModelMatProposta::find($request->material_id);

        if ($material) {
            $material->delete();

            // Retorna sucesso
            app('flasher')->addSuccess('Material excluído com sucesso!');
            return redirect()->back();
        }

        // Caso o material não seja encontrado
        app('flasher')->addError('Material não encontrado.');
        return redirect()->back();
    }
    public function store3(Request $request, $id)
    {
        // Função para limpar o valor monetário
        function limparValor($valor)
        {
            return $valor !== null ? str_replace(['R$', ',', ' '], ['', '', ''], $valor) : null;
        }
        //dd($request->all());
        $idSolicitacoes = $id;
        //dd($id);
        $materiais = ModelMatProposta::where('id_sol_mat', $idSolicitacoes)->get();
        $materiaisIds = $materiais->pluck('id');
        $documentoMaterial = ModelDocumento::whereIn('mat_proposta', $materiaisIds)->get();
        $solicitacao = ModelSolMaterial::find($idSolicitacoes);
        //dd($solicitacao, $materiais, $solicitacao);

        ModelSolMaterial::where('id', $id)->update([
            'motivo' => $request->motivoSolicitacao,
            'id_setor' => $request->idSetorSolicitacao,
        ]);

        if ($request->activeButton === 'material') {

            ModelSolMaterial::where('id', $id)->update([
                'tipo_sol_material' => '2',
            ]);

            foreach ($materiais as $index => $material) {
                // Verifica se os índices existem no request antes de atualizar
                $data = [
                    'id_cat_material' => $request->categoriaPorMaterial[$index],
                    'nome' => $request->nomePorMaterial[$index],
                    'id_embalagem' => $request->UnidadeMedidaPorMaterial[$index],
                    'quantidade' => $request->quantidadePorMaterial1[$index],
                    'id_marca' => $request->marcaPorMaterial[$index],
                    'id_tamanho' => $request->tamanhoPorMaterial[$index],
                    'id_cor' => $request->corPorMaterial[$index],
                    'id_fase_etaria' => $request->faseEtariaPorMaterial[$index],
                    'id_tp_sexo' => $request->sexoPorMaterial[$index]
                ];

                // Atualiza apenas se houver dados a modificar
                if (!empty($data)) {
                    ModelMatProposta::where('id', $material->id)->update($data);
                }

                $documentosFiltrados = array_filter($request->razaoSocial1, function ($doc, $index) use ($request, $material) {
                    return $request->numMat[$index] == $material->id;
                }, ARRAY_FILTER_USE_BOTH);

                // Reinicializa o contador de propostas por material
                $contadorProposta = 0;

                // Itera sobre os três documentos para o material
                foreach ($documentosFiltrados as $index => $documento) {
                    //dd($request->all());
                    // Verifica se o arquivo foi enviado e armazena-o
                    $endArquivo1 = $request->hasFile("arquivoProposta1.$index")
                        ? $request->file("arquivoProposta1.$index")->store('documentos', 'public')
                        : $material->arquivo_proposta_1 ?? null;

                    $dadosComunsMaterial1 = [];

                    if (!empty($request->dt_inicial1[$index])) {
                        $dadosComunsMaterial1['dt_doc'] = $request->dt_inicial1[$index];
                    }
                    if (!empty($request->valor1[$index])) {
                        $dadosComunsMaterial1['valor'] = limparValor($request->valor1[$index]);
                    }
                    if (!empty($request->razaoSocial1[$index])) {
                        $dadosComunsMaterial1['id_empresa'] = $request->razaoSocial1[$index];
                    }
                    if (!empty($request->dt_final1[$index])) {
                        $dadosComunsMaterial1['dt_validade'] = $request->dt_final1[$index];
                    }
                    if (!empty($request->numero1[$index])) {
                        $dadosComunsMaterial1['numero'] = $request->numero1[$index];
                    }
                    if (!empty($request->tempoGarantia1[$index])) {
                        $dadosComunsMaterial1['tempo_garantia_dias'] = $request->tempoGarantia1[$index];
                    }
                    if (!empty($request->linkProposta1[$index])) {
                        $dadosComunsMaterial1['link_proposta'] = $request->linkProposta1[$index];
                    }
                    if (!empty($endArquivo1)) {
                        $dadosComunsMaterial1['end_arquivo'] = $endArquivo1;
                    }

                    $dadosComuns = array_merge([
                        'id_tp_doc' => '14',
                        'id_setor' => $solicitacao->id_setor,
                        'vencedor_inicial' => $contadorProposta === 0 ? '1' : '0',
                        'mat_proposta' => $material->id,
                        'vencedor_geral' => '0',
                        'id_sol_mat' => $id,
                    ], $dadosComunsMaterial1);

                    // Busca documento existente considerando a empresa e o número
                    $documentoQuery = ModelDocumento::where('mat_proposta', $material->id)
                        ->where('id_tp_doc', '14');

                    if (!empty($dadosComuns['numero'])) {
                        $documentoQuery->where('numero', $dadosComuns['numero']);
                    }

                    if (!empty($dadosComuns['id_empresa'])) {
                        $documentoQuery->where('id_empresa', $dadosComuns['id_empresa']);
                    }

                    $documento = $documentoQuery->first();

                    if ($documento) {
                        $documento->update($dadosComuns);
                    } else {
                        ModelDocumento::create($dadosComuns);
                    }

                    // Incrementa o contador
                    $contadorProposta++;
                }
            }
        } else if ($request->activeButton === 'empresa') {

            ModelSolMaterial::where('id', $idSolicitacoes)->update([
                'tipo_sol_material' => '1',
            ]);
            foreach ($materiais as $index => $material) {
                // Construção do array de atualização verificando a existência dos índices
                $data = [
                    'id_cat_material' => $request->categoriaPorEmpresa[$index],
                    'nome' => $request->nomePorEmpresa[$index],
                    'id_embalagem' => $request->embalagemPorEmpresa[$index],
                    'quantidade' => $request->quantidadePorEmpresa[$index],
                    'valor1' => limparValor($request->valorUnitarioEmpresa1[$index]),
                    'valor2' => limparValor($request->valorUnitarioEmpresa2[$index]),
                    'valor3' => limparValor($request->valorUnitarioEmpresa3[$index]),
                    'id_marca' => $request->marcaPorEmpresa[$index],
                    'id_tamanho' => $request->tamanhoPorEmpresa[$index],
                    'id_cor' => $request->corPorEmpresa[$index],
                    'id_fase_etaria' => $request->faseEtariaPorEmpresa[$index],
                    'id_tp_sexo' => $request->sexoPorEmpresa[$index]
                ];

                // Atualiza apenas se houver dados a modificar
                if (!empty($data)) {
                    ModelMatProposta::where('id', $material->id)->update($data);
                }
            }

            $documentosFiltrados2 = array_filter($request->razaoSocial1, function ($doc, $index) use ($request, $material) {
                return $request->numMat[$index] == $material->id;
            }, ARRAY_FILTER_USE_BOTH);

            foreach ($documentosFiltrados2 as $index => $documento) {
                $realIndex = $index + 1;

                $endArquivoPorEmpresa = $request->hasFile("arquivoPropostaPorEmpresa.$realIndex")
                    ? $request->file("arquivoPropostaPorEmpresa.$realIndex")->store('documentos', 'public')
                    : $documento->end_arquivo ?? null;

                $dadosDocumento = [];

                if (!empty($request->dt_inicialPorEmpresa[$realIndex])) {
                    $dadosDocumento['dt_doc'] = $request->dt_inicialPorEmpresa[$realIndex];
                }
                if (!empty($request->valorPorEmpresa[$realIndex])) {
                    $dadosDocumento['valor'] = limparValor($request->valorPorEmpresa[$realIndex]);
                }
                if (!empty($request->razaoSocialPorEmpresa[$realIndex])) {
                    $dadosDocumento['id_empresa'] = $request->razaoSocialPorEmpresa[$realIndex];
                }
                if (!empty($request->dt_finalPorEmpresa[$realIndex])) {
                    $dadosDocumento['dt_validade'] = $request->dt_finalPorEmpresa[$realIndex];
                }
                if (!empty($request->numeroPorEmpresa[$realIndex])) {
                    $dadosDocumento['numero'] = $request->numeroPorEmpresa[$realIndex];
                }
                if (!empty($request->tempoGarantiaPorEmpresa[$realIndex])) {
                    $dadosDocumento['tempo_garantia_dias'] = $request->tempoGarantiaPorEmpresa[$realIndex];
                }
                if (!empty($request->linkPropostaPorEmpresa[$realIndex])) {
                    $dadosDocumento['link_proposta'] = $request->linkPropostaPorEmpresa[$realIndex];
                }
                if (!empty($endArquivoPorEmpresa)) {
                    $dadosDocumento['end_arquivo'] = $endArquivoPorEmpresa;
                }

                $dadosComuns = array_merge([
                    'id_tp_doc' => '14',
                    'id_setor' => $solicitacao->id_setor,
                    'vencedor_inicial' => $index === 0 ? '1' : '0',
                    'id_sol_mat' => $idSolicitacoes,
                    'vencedor_geral' => '0',
                ], $dadosDocumento);

                $documentoQuery = ModelDocumento::where('id_sol_mat', $idSolicitacoes)
                    ->where('id_tp_doc', '14');

                if (!empty($dadosComuns['numero'])) {
                    $documentoQuery->where('numero', $dadosComuns['numero']);
                }

                if (!empty($dadosComuns['id_empresa'])) {
                    $documentoQuery->where('id_empresa', $dadosComuns['id_empresa']);
                }

                $documento = $documentoQuery->first();

                if ($documento) {
                    $documento->update($dadosComuns);
                } else {
                    ModelDocumento::create($dadosComuns);
                }
            }
        }

        app('flasher')->addSuccess('Propostas Realizadas com Sucesso');
        return redirect("/gerenciar-aquisicao-material");
    }
    public function aprovar($id)
    {
        $idSolicitacao = $id;

        $documentos = ModelDocumento::where('id_sol_mat', $idSolicitacao)->with('empresa')->get();
        //dd($documentos);
        $solicitacao = ModelSolMaterial::with('modelPessoa', 'setor')->find($idSolicitacao);
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
        $materiais = ModelMatProposta::with('documentoMaterial', 'tipoUnidadeMedida', 'tipoItemCatalogoMaterial', 'tipoCategoria', 'tipoMarca', 'tipoTamanho', 'tipoCor', 'tipoFaseEtaria', 'tipoSexo')->where('id_sol_mat', $id)->get();
        $todosSetor = ModelSetor::orderBy('nome')->get();
        //dd($materiais);

        // Recupera todas as prioridades existentes
        $prioridadesExistentes = ModelSolMaterial::pluck('prioridade')->unique()->toArray();

        // Se existirem prioridades, encontra a maior e adiciona 1
        if (!empty($prioridadesExistentes)) {
            $maiorPrioridade = max($prioridadesExistentes);
            $numeros = range(1, $maiorPrioridade + 1); // Gera uma lista de 1 até a maior prioridade + 1
        } else {
            // Se não houver prioridades, você pode definir o range inicial como desejado, por exemplo, 1
            $numeros = range(1, 1);
        }

        //dd($documentoMaterial);

        return view('solMaterial.aprovar-aquisicao-material', compact('documentos', 'todosSetor', 'numeros', 'solicitacao', 'bucaItemCatalogo', 'materiais', 'idSolicitacao', 'buscaSetor', 'buscaUnidadeMedida', 'buscaCategoria', 'buscaMarca', 'buscaTamanho', 'buscaCor', 'buscaFaseEtaria', 'buscaSexo', 'buscaEmpresa'));
    }
    public function aprovarStore(Request $request, $id)
    {
        $usuario = session('usuario.id_usuario');
        // Obtém o valor do ID da solicitação
        $aquisicaoId = $request->input('solicitacao_id');

        // Busca a aquisição no banco de dados
        $aquisicao = ModelSolMaterial::find($aquisicaoId);

        $novaPrioridade = $aquisicao->aut_usu_pres ?? $request->input('prioridade');

        // Verifica se a aquisição foi encontrada
        if (!$aquisicao) {
            app('flasher')->addError('Solicitação não encontrada.');
            return redirect('/gerenciar-aquisicao-servicos');
        }

        // Obtém o status enviado pelo formulário
        $status = $request->input('status');

        // Atualiza o status
        $aquisicao->status = $status;

        // Verifica o status e trata cada caso
        if ($status == '3') { // Aprovado

            $prioridadeAtual = $aquisicao->prioridade;

            if ($novaPrioridade > $prioridadeAtual) {
                // Desce as prioridades entre a atual e a nova prioridade
                ModelSolMaterial::whereBetween('prioridade', [$prioridadeAtual + 1, $novaPrioridade])
                    ->decrement('prioridade');
            } elseif ($novaPrioridade < $prioridadeAtual) {
                // Sobe as prioridades entre a nova e a atual prioridade
                ModelSolMaterial::whereBetween('prioridade', [$novaPrioridade, $prioridadeAtual - 1])
                    ->increment('prioridade');
            }

            // Define a nova prioridade da solicitação
            $aquisicao->id_resp_mt = $request->input('setorResponsavel');
            $aquisicao->prioridade = $novaPrioridade;

            // Impede que a prioridade fique abaixo de 1
            if ($aquisicao->prioridade < 1) {
                $aquisicao->prioridade = 1;
            }

            // Salva a solicitação
            $aquisicao->aut_usu_adm = $usuario;
            $aquisicao->dt_usu_adm = now();
            $aquisicao->motivo_recusa = null;
            $aquisicao->save();

            // Reorganiza as prioridades para garantir que não haja lacunas
            $this->reorganizarPrioridades();

            app('flasher')->addSuccess('A solicitação foi aprovada.');
        } elseif ($status == '1' || $status == '7') { // Devolver ou Cancelar

            $aquisicao->aut_usu_adm = $usuario;
            $aquisicao->dt_usu_adm = now();
            $aquisicao->id_setor_resp_sv = null;
            $aquisicao->prioridade = null;
            $aquisicao->motivo_recusa = $request->input('motivoRejeicao');
            $aquisicao->save();

            $message = ($status == '1') ? 'A solicitação foi devolvida.' : 'A solicitação foi cancelada.';
            app('flasher')->addWarning($message);
        }

        return redirect("/gerenciar-aquisicao-material");
    }
    public function homologar($id)
    {
        $idSolicitacao = $id;

        $documentos = ModelDocumento::where('id_sol_mat', $idSolicitacao)->with('empresa')->get();
        //dd($documentos);
        $solicitacao = ModelSolMaterial::with('modelPessoa', 'setor')->find($idSolicitacao);
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
        $materiais = ModelMatProposta::with('documentoMaterial', 'tipoUnidadeMedida', 'tipoItemCatalogoMaterial', 'tipoCategoria', 'tipoMarca', 'tipoTamanho', 'tipoCor', 'tipoFaseEtaria', 'tipoSexo')->where('id_sol_mat', $id)->get();
        $todosSetor = ModelSetor::orderBy('nome')->get();
        //dd($materiais);

        // Recupera todas as prioridades existentes
        $prioridadesExistentes = ModelSolMaterial::pluck('prioridade')->unique()->toArray();

        // Se existirem prioridades, encontra a maior e adiciona 1
        if (!empty($prioridadesExistentes)) {
            $maiorPrioridade = max($prioridadesExistentes);
            $numeros = range(1, $maiorPrioridade + 1); // Gera uma lista de 1 até a maior prioridade + 1
        } else {
            // Se não houver prioridades, você pode definir o range inicial como desejado, por exemplo, 1
            $numeros = range(1, 1);
        }
        //dd($documentoMaterial);

        return view('solMaterial.homologar-aquisicao-material', compact('documentos', 'todosSetor', 'numeros', 'todosSetor', 'solicitacao', 'bucaItemCatalogo', 'materiais', 'idSolicitacao', 'buscaSetor', 'buscaUnidadeMedida', 'buscaCategoria', 'buscaMarca', 'buscaTamanho', 'buscaCor', 'buscaFaseEtaria', 'buscaSexo', 'buscaEmpresa'));
    }
    public function homologarStore(Request $request, $id)
    {
        dd($id);
        $usuario = session('usuario.id_usuario');
        // Obtém o valor do ID da solicitação
        $aquisicaoId = $request->input('solicitacao_id');

        // Busca a aquisição no banco de dados
        $aquisicao = ModelSolMaterial::find($aquisicaoId);

        $novaPrioridade = $aquisicao->aut_usu_pres ?? $request->input('prioridade');

        // Verifica se a aquisição foi encontrada
        if (!$aquisicao) {
            app('flasher')->addError('Solicitação não encontrada.');
            return redirect('/gerenciar-aquisicao-servicos');
        }

        // Obtém o status enviado pelo formulário
        $status = $request->input('status');

        // Atualiza o status
        $aquisicao->status = $status;

        // Verifica o status e trata cada caso
        if ($status == '3') { // Aprovado

            $prioridadeAtual = $aquisicao->prioridade;

            if ($novaPrioridade > $prioridadeAtual) {
                // Desce as prioridades entre a atual e a nova prioridade
                ModelSolMaterial::whereBetween('prioridade', [$prioridadeAtual + 1, $novaPrioridade])
                    ->decrement('prioridade');
            } elseif ($novaPrioridade < $prioridadeAtual) {
                // Sobe as prioridades entre a nova e a atual prioridade
                ModelSolMaterial::whereBetween('prioridade', [$novaPrioridade, $prioridadeAtual - 1])
                    ->increment('prioridade');
            }

            // Define a nova prioridade da solicitação
            $aquisicao->id_setor_resp_sv = $request->input('setorResponsavel');
            $aquisicao->prioridade = $novaPrioridade;

            // Impede que a prioridade fique abaixo de 1
            if ($aquisicao->prioridade < 1) {
                $aquisicao->prioridade = 1;
            }

            // Salva a solicitação
            $aquisicao->aut_usu_adm = $usuario;
            $aquisicao->dt_usu_adm = now();
            $aquisicao->motivo_recusa = null;
            $aquisicao->save();

            // Reorganiza as prioridades para garantir que não haja lacunas
            $this->reorganizarPrioridades();

            app('flasher')->addSuccess('A solicitação foi aprovada.');
        } elseif ($status == '1' || $status == '7') { // Devolver ou Cancelar

            $aquisicao->aut_usu_adm = $usuario;
            $aquisicao->dt_usu_adm = now();
            $aquisicao->id_setor_resp_sv = null;
            $aquisicao->prioridade = null;
            $aquisicao->motivo_recusa = $request->input('motivoRejeicao');
            $aquisicao->save();

            $message = ($status == '1') ? 'A solicitação foi devolvida.' : 'A solicitação foi cancelada.';
            app('flasher')->addWarning($message);
        }

        return redirect("/gerenciar-aquisicao-material");
    }
    public function delete($id)
    {
        $solicitacao = ModelSolMaterial::find($id);

        if ($solicitacao) {
            $solicitacao->delete();
            app('flasher')->addSuccess('Solicitação excluída com sucesso');
        } else {
            app('flasher')->addError('Solicitação não encontrada');
        }

        return redirect('/gerenciar-aquisicao-material');

    }
}
