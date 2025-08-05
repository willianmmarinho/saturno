@extends('layouts.app')

@section('title')
    Termo de Compra
@endsection

@section('content')
    <form class="form-horizontal mt-4" method="POST" action="/cadastro-inicial-material/compra-direta/{{ $idDocumento }}">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="col-12" style="color: #355089">
                                    Termo de Compra
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <label>ID do Documento</label>
                                    <br>
                                    <input type="text" class="form-control"
                                        value="{{ $resultDocumento->id ?? 'Não especificado' }}" disabled>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label>Número do Documento</label>
                                    <br>
                                    <input type="text" class="form-control"
                                        value="{{ $resultDocumento->numero ?? 'Não especificado' }}" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <!-- Ambos os botões na mesma div -->
                                <div class="col-md d-flex justify-content-start">
                                    <button type="button" class="btn btn-success me-2" id="addMaterial"
                                        data-bs-toggle="modal" data-bs-target="#modalIncluirMaterial">
                                        Adicionar Material
                                    </button>
                                    <button type="button" class="btn btn-success" id="addTermo" data-bs-toggle="modal"
                                        data-bs-target="#modalIncluirTermo">
                                        Incluir Nota Fiscal
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>QTD.</th>
                                            <th>Categoria do Material</th>
                                            <th>Item Material</th>
                                            <th>Tipo</th>
                                            <th>Embalagem</th>
                                            <th>Observação</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($result as $results)
                                            <tr>
                                                <td>{{ $results->id ?? 'N/A' }}</td>
                                                <td>{{ $results->quantidade ?? 'N/A' }}</td>
                                                <td>{{ $results->CategoriaMaterial->nome ?? 'N/A' }}</td>
                                                <td>{{ $results->ItemCatalogoMaterial->nome ?? 'N/A' }}</td>
                                                <td>{{ $results->TipoMaterial->nome ?? 'N/A' }}</td>
                                                <td>
                                                    @php
                                                        $emb = $results->Embalagem;
                                                        $partes = [];

                                                        if ($emb && $emb->qtde_n4 && $emb->unidadeMedida4) {
                                                            $partes[] = "{$emb->qtde_n4} {$emb->unidadeMedida4->nome}";
                                                        }
                                                        if ($emb && $emb->qtde_n3 && $emb->unidadeMedida3) {
                                                            $partes[] = "{$emb->qtde_n3} {$emb->unidadeMedida3->nome}";
                                                        }
                                                        if ($emb && $emb->qtde_n2 && $emb->unidadeMedida2) {
                                                            $partes[] = "{$emb->qtde_n2} {$emb->unidadeMedida2->nome}";
                                                        }
                                                        if ($emb && $emb->qtde_n1 && $emb->unidadeMedida) {
                                                            $partes[] = "{$emb->qtde_n1} {$emb->unidadeMedida->nome}";
                                                        }

                                                        $descricao = implode(' / ', $partes);
                                                    @endphp

                                                    {{ $descricao }}
                                                </td>
                                                <td>{{ $results->observacao }}</td>
                                                <td>
                                                    <a type="button"
                                                        class="btn btn-sm btn-outline-warning btn-editar-material"
                                                        data-id="{{ $results->id }}"
                                                        data-categoria="{{ $results->id_cat_material }}"
                                                        data-nome="{{ $results->id_item_catalogo }}"
                                                        data-tipoId="{{ $results->id_tipo_material }}"
                                                        data-tipo="{{ $results->tipoMaterial->nome }}"
                                                        data-aplicacao="{{ $results->aplicacao }}"
                                                        data-embalagem="{{ $results->id_embalagem }}"
                                                        data-quantidade="{{ $results->quantidade }}"
                                                        data-modelo="{{ $results->modelo }}"
                                                        data-avariado="{{ $results->avariado }}"
                                                        data-valor_aquisicao="{{ $results->valor_aquisicao }}"
                                                        data-valor_venda="{{ $results->valor_venda }}"
                                                        data-data_validade="{{ $results->data_validade }}"
                                                        data-marca="{{ $results->id_marca }}"
                                                        data-tamanho="{{ $results->id_tamanho }}"
                                                        data-cor="{{ $results->id_cor }}"
                                                        data-fase_etaria="{{ $results->id_fase_etaria }}"
                                                        data-sexo="{{ $results->id_tp_sexo }}"
                                                        data-veiculo_placas="{{ is_array($results->placa) ? implode(',', $results->placa) : $results->placa }}"
                                                        data-veiculo_renavam="{{ is_array($results->renavam) ? implode(',', $results->renavam) : $results->renavam }}"
                                                        data-veiculo_chassis="{{ is_array($results->chassi) ? implode(',', $results->chassi) : $results->chassi }}"
                                                        data-num_serie="{{ is_array($results->num_serie) ? implode(',', $results->num_serie) : $results->num_serie }}"
                                                        data-data_fabricacao="{{ $results->dt_fab }}"
                                                        data-documento-id="{{ $results->documento_origem }}"
                                                        data-data_fabricacao_modelo="{{ $results->dt_fab_modelo }}"
                                                        data-observacao="{{ $results->observacao }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalEditarMaterial" title="Editar Material"
                                                        style="font-size: 1rem; color:#303030">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-outline-danger excluirSolicitacao"
                                                        data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                        data-placement="top" title="Excluir" data-bs-toggle="modal"
                                                        data-bs-target="#modalExcluirMaterial"
                                                        data-id="{{ $results->id }}"
                                                        data-documento-id="{{ $results->documento_origem }}"
                                                        data-nome='{{ $results->ItemCatalogoMaterial->nome ?? 'N/A' }}'>
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-right: 10px; margin-left: 10px">
                                {{ $result->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Botões Confirmar e Cancelar --}}
        <div class="botões">
            <a href="/gerenciar-cadastro-inicial" class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>
    <x-modal-incluir id="modalIncluirMaterial" labelId="modalIncluirMaterialLabel"
        action="{{ url('/cadastro-inicial-material/incluir-material/' . $idDocumento) }}" title="Inclusão de Material">
        <div class="row material-item">
            <div class="col-md-6" style="margin-top: 10px">
                <label>Categoria do Material</label>
                <select class="form-select  select2" id="categoriaMaterial" style="border: 1px solid #999999; padding: 5px;"
                    name="categoriaMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($buscaCategoria as $buscaCategorias)
                        <option value="{{ $buscaCategorias->id }}">
                            {{ $buscaCategorias->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <label>Nome do Material</label>
                <select class="form-select js-nome-material select2" id="nomeMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="nomeMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Tipo do Material</label>
                <!-- Campo visível: apenas para mostrar o nome -->
                <input type="text" id="tipoMaterialNome" class="form-control" disabled>
                <!-- Campo oculto: envia o ID no form -->
                <input type="hidden" id="tipoMaterial" name="tipoMaterial">
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Aplicação</label>
                <br>
                <input type="checkbox" id="checkAplicacao" name="checkAplicacao" disabled>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Embalagem</label>
                <select class="form-select js-nome-material select2" id="embalagemMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="embalagemMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Quantidade</label>
                <input type="number" class="form-control" id="quantidadeMaterial" name="quantidadeMaterial" required>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Modelo</label>
                <input type="text" class="form-control" name="modeloMaterial">
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Avariado</label>
                <br>
                <input type="checkbox" id="checkAvariado" name="checkAvariado">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Valor de Aquisição</label>
                <select class="form-select js-marca-material select2" id="valorAquisicaoMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="valorAquisicaoMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Valor de Venda</label>
                <select class="form-select js-marca-material select2" id="valorVendaMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="valorVendaMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Validade</label>
                <input type="date" class="form-control" name="dataValidadeMaterial">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Marca</label>
                <select class="form-select js-marca-material select2" id="marcaMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="marcaMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Tamanho</label>
                <select class="form-select js-tamanho-material select2" id="tamanhoMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="tamanhoMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Cor</label>
                <select class="form-select js-cor-material select2" id="corMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="corMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Fase Etária</label>
                <select class="form-select js-fase-material select2" id="faseEtariaMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="faseEtariaMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Sexo</label>
                <select class="form-select js-sexo-material select2" id="sexoMaterial"
                    style="border: 1px solid #999999; padding: 5px;" name="sexoMaterial">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($buscaSexo as $buscaSexos)
                        <option value="{{ $buscaSexos->id }}">
                            {{ $buscaSexos->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Veículo</label>
                <br>
                <input type="checkbox" id="checkVeiculo" name="checkVeiculo" disabled>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Número de Série</label>
                <br>
                <input type="checkbox" id="checkNumSerie" name="checkNumSerie" disabled>
            </div>
            <div>
                <div id="containerNumerosSerie" class="col-md" style="display: none; margin-top: 10px;">
                    <label>Números de Série:</label>
                    <div id="inputsNumerosSerie"></div>
                </div>
            </div>
            <div>
                <div id="containerVeiculo" class="col-md" style="display: none; margin-top: 10px;">
                    <div id="inputsVeiculo"></div>
                </div>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Fabricação</label>
                <input type="date" class="form-control" name="dataFabricacaoMaterial">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Fab. Modelo</label>
                <input type="date" class="form-control" name="dataFabricacaoModeloMaterial">
            </div>
            <div class="col-md-12" style="margin-top: 10px">
                <label>Observação</label>
                <textarea type="text" class="form-control" name="observacaoMaterial" rows="2"></textarea>
            </div>
        </div>
    </x-modal-incluir>
    <x-modal-incluir id="modalIncluirTermo" labelId="modalIncluirTermoLabel"
        action="{{ url('/cadastro-inicial-material/incluir-termo/' . $idDocumento) }}" title="Inclusão de Nota Fiscal">
        <div class="row termo">
            <div class="col-md-6">
                <label>Empresa/Entidade</label>
                <select class="form-select  select2" id="empresaDocCompra"
                    style="border: 1px solid #999999; padding: 5px;" name="empresaDocCompra">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($buscaEmpresa as $buscaEmpresas)
                        <option value="{{ $buscaEmpresas->id }}">
                            {{ $buscaEmpresas->razaosocial }} - {{ $buscaEmpresas->nomefantasia }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-1">
                <label>Tipo da Nota Fiscal</label>
                <select class="form-control select2" id="tipoDocCompra"
                    name="tipoDocCompra">
                    <option value="">Selecione o tipo</option>
                    @foreach ($tiposDocumento as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ old('tipoDocCompra', $resultDocumento->tipoDocumento->id ?? '') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->sigla }} - {{ $tipo->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-1">
                <label>Número da Nota Fiscal</label>
                <input type="text" class="form-control" style="background-color: white; border-color: gray;"
                    value="{{ old('numeroDocCompra', $resultDocumento->numero ?? '') }}" id="numeroDocCompra"
                    name="numeroDocCompra">
            </div>
            <div class="col-md-6 mt-1">
                <label>Valor Total</label>
                <input type="text" class="form-control valor-monetario"
                    style="background-color: white; border-color: gray;"
                    value="{{ old('valorDocCompra', $resultDocumento->valor ?? '') }}" id="valorDocCompra"
                    name="valorDocCompra">
            </div>
            <!-- Arquivo da Proposta -->
            <div class="col-md-12 mt-1">
                <label>Arquivo do Termo de Doação</label>
                <input type="file" class="form-control" style="background-color: white; border-color: gray;"
                    id="arquivoDocCompra" name="arquivoDocCompra" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
            </div>
        </div>
    </x-modal-incluir>
    <x-modal-editar id="modalEditarMaterial" labelId="modalEditarMaterialLabel" title="Editar Material"
        action="{{ url('/cadastro-inicial-material/editar-material') }}">
        @method('PUT')
        <input type="hidden" name="edit-id" id="edit-id">
        <input type="hidden" name="documento-id-editar" id="documento-id-editar">
        <div class="row">
            <div class="col-md-6" style="margin-top: 10px">
                <label>Categoria do Material</label>
                <select class="form-select  select2" id="categoriaMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="categoriaMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($buscaCategoria as $buscaCategorias)
                        <option value="{{ $buscaCategorias->id }}">
                            {{ $buscaCategorias->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <label>Nome do Material</label>
                <select class="form-select select2" id="nomeMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="nomeMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Tipo do Material</label>
                <!-- Campo visível: apenas para mostrar o nome -->
                <input type="text" id="tipoMaterialNomeEditar" name="tipoMaterialNomeEditar" class="form-control"
                    disabled>
                <!-- Campo oculto: envia o ID no form -->
                <input type="hidden" id="tipoMaterialEditar" name="tipoMaterialEditar">
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Aplicação</label>
                <br>
                <input type="checkbox" id="checkAplicacaoEditar" name="checkAplicacaoEditar" disabled>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Embalagem</label>
                <select class="form-select select2" id="embalagemMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="embalagemMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Quantidade</label>
                <input type="number" class="form-control" id="quantidadeMaterialEditar" name="quantidadeMaterialEditar"
                    required>
            </div>
            <div class="col-md-4" style="margin-top: 10px">
                <label>Modelo</label>
                <input type="text" class="form-control" id="modeloMaterialEditar" name="modeloMaterialEditar">
            </div>
            <div class="col-md-2" style="margin-top: 10px">
                <label>Avariado</label>
                <br>
                <input type="checkbox" id="checkAvariadoEditar" name="checkAvariadoEditar">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Valor de Aquisição</label>
                <select class="form-select select2" id="valorAquisicaoMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="valorAquisicaoMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Valor de Venda</label>
                <select class="form-select select2" id="valorVendaMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="valorVendaMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Validade</label>
                <input type="date" class="form-control" id="dataValidadeMaterialEditar"
                    name="dataValidadeMaterialEditar">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Marca</label>
                <select class="form-select select2" id="marcaMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="marcaMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Tamanho</label>
                <select class="form-select select2" id="tamanhoMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="tamanhoMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Cor</label>
                <select class="form-select select2" id="corMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="corMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Fase Etária</label>
                <select class="form-select select2" id="faseEtariaMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="faseEtariaMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Sexo</label>
                <select class="form-select select2" id="sexoMaterialEditar"
                    style="border: 1px solid #999999; padding: 5px;" name="sexoMaterialEditar">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($buscaSexo as $buscaSexos)
                        <option value="{{ $buscaSexos->id }}">
                            {{ $buscaSexos->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Veículo</label>
                <br>
                <input type="checkbox" id="checkVeiculoEditar" name="checkVeiculoEditar" disabled>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Número de Série</label>
                <br>
                <input type="checkbox" id="checkNumSerieEditar" name="checkNumSerieEditar" disabled>
            </div>
            <div>
                <div id="containerNumerosSerieEditar" class="col-md" style="display: none; margin-top: 10px;">
                    <div id="inputsNumerosSerieEditar"></div>
                </div>
            </div>
            <div>
                <div id="containerVeiculoEditar" class="col-md" style="display: none; margin-top: 10px;">
                    <div id="inputsVeiculoEditar"></div>
                </div>
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Fabricação</label>
                <input type="date" class="form-control" id="dataFabricacaoMaterialEditar"
                    name="dataFabricacaoMaterialEditar">
            </div>
            <div class="col-md-3" style="margin-top: 10px">
                <label>Data de Fab. Modelo</label>
                <input type="date" class="form-control" id="dataFabricacaoModeloMaterialEditar"
                    name="dataFabricacaoModeloMaterialEditar">
            </div>
            <div class="col-md-12" style="margin-top: 10px">
                <label>Observação</label>
                <textarea type="text" class="form-control" id="observacaoMaterialEditar" name="observacaoMaterialEditar"
                    rows="2" maxlength="300"></textarea>
            </div>
        </div>
    </x-modal-editar>
    <x-modal-excluir id="modalExcluirMaterial" labelId="modalExcluirMaterialLabel"
        action="{{ url('/cadastro-inicial-material/deletar') }}" title="Excluir Material">
        <input type="hidden" name="delete-id" id="delete-id">
        <input type="hidden" name="documento-id-excluir" id="documento-id-excluir">
        <div class="row">
            <label>Deseja realmente <strong style="color: red">excluir</strong> o material <span
                    id="nome-material"></span>?</label>
        </div>
    </x-modal-excluir>
@endsection
