@extends('layouts.app')

@section('title')
    Aprovar Solicitação de Material
@endsection

@section('content')
    <form method="POST" action="/aprovar-store-proposta-material/{{ $idSolicitacao }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="activeButton" id="activeButton"
            value="{{ $solicitacao->tipo_sol_material == 1 ? 'empresa' : 'material' }}">
        <div class="container-fluid">
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="col-12" style="color: #355089">
                                    Aprovar Solicitação de Material
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Identificação da Solicitação</h5>
                            <hr>
                            <div class="row">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-3 col-sm-12">
                                        <label>Nome do Solicitante</label>
                                        <br>
                                        <input type="text" class="form-control"
                                            value="{{ $solicitacao->modelPessoa->nome_completo ?? 'Não especificado' }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label>Setor Solicitante</label>
                                        <br>
                                        <input type="text" class="form-control"
                                            value=" {{ $solicitacao->setor->sigla ?? 'Não especificado' }} - {{ $solicitacao->setor->nome ?? 'Não especificado' }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Prioridade</label>
                                        <br>
                                        <select id="cargoSelect" class="form-select status select2 pesquisa-select"
                                            style="" name="prioridade" required>
                                            @foreach ($numeros as $number)
                                                <option value="{{ $number }}">{{ $number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Setor Responsável por Acompanhar</label>
                                        <br>
                                        <select id="idSetorResponsavel" class="form-select status select2 pesquisa-select"
                                            style="" name="setorResponsavel" required>
                                            <option></option>
                                            @foreach ($todosSetor as $setor)
                                                <option value="{{ $setor->id }}"
                                                    {{ $setor->id == $solicitacao->id_resp_mt ? 'selected' : '' }}>
                                                    {{ $setor->nome }} - {{ $setor->sigla }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Motivo</label>
                                    <br>
                                    <input type="text" class="form-control"
                                        value="{{ $solicitacao->motivo ?? 'Não especificado' }}" disabled>
                                </div>
                            </div>
                            <br>
                            <h5>Tipo de Solicitação</h5>
                            <hr>
                            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                <!-- Botões Por Material e Por Empresa no centro -->
                                <div style="flex-grow: 1; display: flex; justify-content: center;">
                                    <div class="btn-group" role="group" aria-label="Tipo de Solicitação">
                                        <button type="button" class="btn btn-primary" id="btnPorMaterial"
                                            aria-selected="true" name="botaoPorMaterial" disabled>
                                            Por Material
                                        </button>
                                        <button type="button" class="btn btn-secondary" id="btnPorEmpresa"
                                            aria-selected="false" name="botaoPorEmpresa" disabled>
                                            Por Empresa
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                {{-- card por material --}}
                                <div class="col-12 mt-3" id="listaMateriais" style="display: none;">
                                    @foreach ($materiais as $index => $material)
                                        <div class="card" id="card-material" style="margin-bottom: 10px">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <div class="row material-item flex-grow-1">
                                                    <div class="col-md-4">
                                                        <label>Categoria do Material</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoCategoria->nome }}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Nome do Material</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoItemCatalogoMaterial->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Unid. Medida</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoUnidadeMedida->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>Quantidade</label>
                                                        <input type="text" class="form-control"
                                                            name="quantidadePorMaterial1[{{ $index }}]"
                                                            value="{{ $material->quantidade ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <!-- Botões de Minimizar e Fechar -->
                                                <div class="card-actions position-absolute" style="top: 5px; right: 5px;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary toggle-card-content"
                                                        data-bs-toggle="tooltip" title="Minimizar/Maximizar">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger open-delete-modal"
                                                        data-bs-toggle="modal" data-bs-target="#modalExcluirMaterial"
                                                        data-material-id="{{ $material->id }}"
                                                        data-material-name="{{ $material->nome }}" data-bs-toggle="tooltip"
                                                        title="Excluir">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body d-none">
                                                <div class="row material-item">
                                                    <div class="col-md">
                                                        <label>Marca</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoMarca->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Tamanho</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoTamanho->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Cor</label>
                                                        <input type="text" class="form-control"
                                                            value=" {{ $material->tipoCor->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Fase Etária</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoFaseEtaria->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Sexo</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $material->tipoSexo->nome ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                {{-- Contador --}}
                                                @php
                                                    $requiredMaterialsProposals = 3;
                                                    $counterMaterials = 1;
                                                    $actualMaterialsProposals = count($material->documentoMaterial);
                                                    $missingMaterialsProposals = max(
                                                        0,
                                                        $requiredMaterialsProposals - $actualMaterialsProposals,
                                                    );
                                                @endphp
                                                {{-- Propostas Preenchidas por material (3) --}}
                                                @if ($material->documentoMaterial->isNotEmpty())
                                                    @foreach ($material->documentoMaterial as $documentoMaterials)
                                                        <input type="hidden" name="numMat[]"
                                                            value="{{ $material->id }}">
                                                        <div class="card mt-3">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">
                                                                    @if ($counterMaterials == 1)
                                                                        Proposta Preferida
                                                                    @else
                                                                        {{ $counterMaterials }}ª Proposta
                                                                    @endif
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- Número da Proposta -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Número da Proposta Principal
                                                                            @else
                                                                                Número da {{ $counterMaterials }}ª Proposta
                                                                            @endif
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="numero1[]"
                                                                            placeholder="Digite o Número da proposta"
                                                                            value="{{ $documentoMaterials->numero }}"
                                                                            data-index="{{ $index }}" disabled>
                                                                    </div>
                                                                    <!-- Nome da Empresa -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Nome da Empresa Principal
                                                                            @else
                                                                                Nome da {{ $counterMaterials }}ª Empresa
                                                                            @endif
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $documentoMaterials->empresa->razaosocial ?? 'Não especificado' }} - {{ $documentoMaterials->empresa->nomefantasia ?? 'Não especificado' }}"
                                                                            disabled>
                                                                    </div>
                                                                    <!-- Valor -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Valor da Proposta Principal
                                                                            @else
                                                                                Valor da {{ $counterMaterials }}ª Proposta
                                                                            @endif
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control valor valor-proposta"
                                                                            data-index="{{ $index }}"
                                                                            name="valor1[]"
                                                                            value="{{ $documentoMaterials->valor }}"
                                                                            placeholder="Digite o valor da proposta"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <!-- Data da Criação da Proposta -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Data da Criação da
                                                                                Proposta Principal
                                                                            @else
                                                                                Data da Criação da {{ $counterMaterials }}ª
                                                                                Proposta
                                                                            @endif
                                                                        </label>
                                                                        <input type="date" class="form-control"
                                                                            name="dt_inicial1[]"
                                                                            data-index="{{ $index }}"
                                                                            value="{{ $documentoMaterials->dt_doc }}"
                                                                            placeholder="Digite a data da proposta"
                                                                            disabled>
                                                                    </div>

                                                                    <!-- Data Limite da Proposta -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Data Limite da Proposta Principal
                                                                            @else
                                                                                Data Limite da {{ $counterMaterials }}ª
                                                                                Proposta
                                                                            @endif
                                                                        </label>
                                                                        <input type="date" class="form-control"
                                                                            name="dt_final1[]"
                                                                            data-index="{{ $index }}"
                                                                            value="{{ $documentoMaterials->dt_validade }}"
                                                                            placeholder="Digite a data final do prazo da proposta"
                                                                            disabled>
                                                                    </div>

                                                                    <!-- Arquivo atual da Proposta -->
                                                                    <div class="col-md-4 mb-3 row">
                                                                        <label for="arquivo">Arquivo Salvo</label>
                                                                        @if ($documentoMaterials->end_arquivo)
                                                                            <a href="{{ Storage::url($documentoMaterials->end_arquivo) }}"
                                                                                target="_blank" class="btn btn-primary">
                                                                                Ver Arquivo
                                                                            </a>
                                                                        @else
                                                                            <a class="btn btn-secondary" disabled>Nenhum
                                                                                arquivo
                                                                                disponível.</a>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <!-- Tempo de Garantia -->
                                                                    <div id="tempoGarantia" class="col-md-4 mb-3">
                                                                        <label>Tempo de Garantia (em
                                                                            dias)</label>
                                                                        <input type="number" class="form-control"
                                                                            value="{{ $documentoMaterials->tempo_garantia_dias }}"
                                                                            id="tempoGarantiaInput"
                                                                            name="tempoGarantia1[]"
                                                                            data-index="{{ $index }}"
                                                                            placeholder="Digite o tempo de garantia"
                                                                            disabled>
                                                                    </div>

                                                                    <!-- Link da Proposta -->
                                                                    <div class="col-md-4 mb-3">
                                                                        <label>
                                                                            @if ($counterMaterials == 1)
                                                                                Link da Proposta Principal
                                                                            @else
                                                                                Link da {{ $counterMaterials }}ª
                                                                                Proposta
                                                                            @endif
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $documentoMaterials->link_proposta }}"
                                                                            id="linkProposta1" name="linkProposta1[]"
                                                                            data-index="{{ $index }}"
                                                                            placeholder="Link da Proposta" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $counterMaterials++; @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12 mt-3" id="listaEmpresa" style="display: block;">
                                    {{-- Contador --}}
                                    @php
                                        $requiredProposals = 3;
                                        $actualProposals = count($documentos);
                                        $missingProposals = $requiredProposals - $actualProposals;
                                        $counter = 1;
                                    @endphp
                                    {{-- Propostas Preenchidas por empresa (3) --}}
                                    @foreach ($documentos as $documento)
                                        {{-- card proposta por empresa --}}
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                {{-- Nome da Proposta --}}
                                                <h5 class="card-title mb-0">
                                                    @if ($counter == 1)
                                                        Proposta Preferida
                                                    @else
                                                        Proposta {{ $counter }}
                                                    @endif
                                                </h5>
                                                <!-- Botões de Minimizar -->
                                                <div class="card-actions position-absolute" style="top: 5px; right: 5px;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary toggle-card-content"
                                                        data-bs-toggle="tooltip" title="Minimizar/Maximizar">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body d-none">
                                                <div class="row">
                                                    <!-- Número da Proposta -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Número da Proposta Principal
                                                            @else
                                                                Número da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            name="numeroPorEmpresa[{{ $counter }}]"
                                                            placeholder="Digite o Número da proposta"
                                                            value="{{ $documento->numero }}" disabled>
                                                    </div>
                                                    <!-- Nome da Empresa -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Nome da Empresa Principal
                                                            @else
                                                                Nome da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $documento->empresa->razaosocial ?? 'Não especificado' }} - {{ $documento->empresa->nomefantasia ?? 'Não especificado' }}"
                                                            disabled>
                                                    </div>
                                                    <!-- Valor -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Valor Total da Proposta Principal
                                                            @else
                                                                Valor Total da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control valor valor-proposta"
                                                            name="valorPorEmpresa[{{ $counter }}]"
                                                            placeholder="Digite o valor da proposta"
                                                            value="{{ $documento->valor }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Data da Criação da Proposta -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Data da Criação da
                                                                Proposta Principal
                                                            @else
                                                                Data da Criação da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="date" class="form-control"
                                                            name="dt_inicialPorEmpresa[{{ $counter }}]"
                                                            placeholder="Digite a data da proposta"
                                                            value="{{ $documento->dt_doc }}" disabled>
                                                    </div>

                                                    <!-- Data Limite da Proposta -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Data Limite da Proposta Principal
                                                            @else
                                                                Data Limite da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="date" class="form-control"
                                                            name="dt_finalPorEmpresa[{{ $counter }}]"
                                                            placeholder="Digite a data final do prazo da proposta"
                                                            value="{{ $documento->dt_validade }}" disabled>
                                                    </div>

                                                    <!-- Arquivo atual da Proposta -->
                                                    <div class="col-md-4 mb-3 row">
                                                        <label for="arquivo">Arquivo Salvo</label>
                                                        @if ($documento->end_arquivo)
                                                            <a href="{{ Storage::url($documento->end_arquivo) }}"
                                                                target="_blank" class="btn btn-primary">
                                                                Ver Arquivo
                                                            </a>
                                                        @else
                                                            <a class="btn btn-secondary" disabled>Nenhum arquivo
                                                                disponível.</a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Tempo de Garantia -->
                                                    <div id="tempoGarantia" class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Tempo de Garantia (em
                                                                dias) da Proposta Principal
                                                            @else
                                                                Tempo de Garantia (em
                                                                dias) da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="number" class="form-control"
                                                            id="tempoGarantiaInput"
                                                            name="tempoGarantiaPorEmpresa[{{ $counter }}]"
                                                            data-index="{{ $index }}"
                                                            placeholder="Digite o tempo de garantia"
                                                            value="{{ $documento->tempo_garantia_dias }}" disabled>
                                                    </div>

                                                    <!-- Link da Proposta -->
                                                    <div class="col-md-4 mb-3">
                                                        <label>
                                                            @if ($counter == 1)
                                                                Link da Proposta Principal
                                                            @else
                                                                Link da Proposta {{ $counter }}
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control" id="linkProposta1"
                                                            name="linkPropostaPorEmpresa[{{ $counter }}]"
                                                            placeholder="Link da Proposta"
                                                            data-index="{{ $index }}"
                                                            value="{{ $documento->link_proposta }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $counter++; @endphp
                                    @endforeach
                                    <br>
                                    {{-- Nomes em cima da tabela --}}
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{-- <label>Categoria do Material</label> --}}
                                            <h5>Materiais</h5>
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <label>Nome do Material</label> --}}
                                        </div>
                                        <div class="col-md-2">
                                            {{-- <label>Unidade de Medida</label> --}}
                                        </div>
                                        <div class="col-md-1">
                                            {{-- <label>Quantidade</label> --}}
                                        </div>
                                        <div class="col-md-1">
                                            <label>1ª Empresa</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label>2ª Empresa</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label>3ª Empresa</label>
                                        </div>
                                    </div>
                                    {{-- card por empresa --}}
                                    @foreach ($materiais as $index => $material)
                                        <div class="card" id="card-material" style="margin-bottom: 10px">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <div class="row material-item flex-grow-1">
                                                    <div class="col-md-2">
                                                        <label>Categoria do Material</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoCategoria->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Nome do Material</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $material->tipoItemCatalogoMaterial->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Unid. Medida</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoUnidadeMedida->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>Quantidade</label>
                                                        <input type="text" class="form-control"
                                                            name="quantidadePorEmpresa[{{ $index }}]"
                                                            data-index="{{ $index }}"
                                                            value="{{ $material->quantidade ?? 'Não especificado' }}" disabled>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>Valor Unitário</label>
                                                        <input type="text" class="form-control valor valor-proposta"
                                                            name="valorUnitarioEmpresa1[{{ $index }}]"
                                                            placeholder="Digite o valor da proposta"
                                                            data-index="{{ $index }}"
                                                            value="{{ $material->valor1 }}" disabled>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>Valor Unitário</label>
                                                        <input type="text" class="form-control valor valor-proposta"
                                                            name="valorUnitarioEmpresa2[{{ $index }}]"
                                                            placeholder="Digite o valor da proposta"
                                                            data-index="{{ $index }}"
                                                            value="{{ $material->valor2 }}" disabled>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>Valor Unitário</label>
                                                        <input type="text" class="form-control valor valor-proposta"
                                                            name="valorUnitarioEmpresa3[{{ $index }}]"
                                                            placeholder="Digite o valor da proposta"
                                                            data-index="{{ $index }}"
                                                            value="{{ $material->valor3 }}" disabled>
                                                    </div>
                                                </div>
                                                <!-- Botões de Minimizar e Fechar -->
                                                <div class="card-actions position-absolute" style="top: 5px; right: 5px;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary toggle-card-content"
                                                        data-bs-toggle="tooltip" title="Minimizar/Maximizar">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger open-delete-modal"
                                                        data-bs-toggle="modal" data-bs-target="#modalExcluirMaterial"
                                                        data-material-id="{{ $material->id }}"
                                                        data-material-name="{{ $material->nome }}"
                                                        data-bs-toggle="tooltip" title="Excluir">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body d-none">
                                                <div class="row material-item">
                                                    <div class="col-md">
                                                        <label>Marca</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoMarca->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Tamanho</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoTamanho->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Cor</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoCor->nome ?? 'Não especificado' }}" disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Fase Etária</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoFaseEtaria->nome ?? 'Não especificado' }}"
                                                                disabled>
                                                    </div>
                                                    <div class="col-md">
                                                        <label>Sexo</label>
                                                            <input type="text" class="form-control" value="{{ $material->tipoSexo->nome ?? 'Não especificado' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <br>
                            <hr>
                            <h5>Decisão</h5>

                            <input type="hidden" name="solicitacao_id" value="{{ $solicitacao->id }}">

                            <div class="d-flex gap-5 align-items-end">
                                <div class="form-check">
                                    <input type="radio" name="status" id="radioDevolver" value="1">
                                    <label for="radioDevolver">Devolver</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="status" id="radioAprovar" value="3" checked>
                                    <label for="radioAprovar">Aprovar</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="status" id="radioCancelar" value="7">
                                    <label for="radioCancelar">Cancelar</label>
                                </div>
                            </div>
                            <div class=" col-12">Motivo
                                <br>
                                <textarea class="form-control" style="border: 1px solid #999999;" id="idMotivo" rows="4"
                                    name="motivoRejeicao" value="" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Botões Confirmar e Cancelar --}}
        <div class="botões">
            <a href="/gerenciar-aquisicao-material" class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>
    {{-- Style do Select2 --}}
    <style>
        .select2-container--bootstrap-5 .select2-selection {
            background-color: white !important;
            border-color: gray !important;
        }
    </style>
        {{-- Script dos botao de aprovar --}}
    <script>
        $(document).ready(function() {

            // Seletores dos inputs de radio
            const radioAprovar = $('#radioAprovar');
            const radioDevolver = $('#radioDevolver');
            const radioCancelar = $('#radioCancelar');
            const motivoField = $('#idMotivo');
            const setorRespField = $('#idSetorResponsavel');

            // Função para habilitar/desabilitar o campo de motivo
            function toggleMotivoField() {
                if (radioAprovar.is(':checked')) {
                    motivoField.prop('disabled', true).removeAttr('required');
                } else {
                    motivoField.prop('disabled', false).attr('required', true);
                    setorRespField.prop('disabled', true).removeAttr('required');
                }
            }

            // Atribuir a função aos eventos de clique nos radios
            radioAprovar.on('change', toggleMotivoField);
            radioDevolver.on('change', toggleMotivoField);
            radioCancelar.on('change', toggleMotivoField);

            // Inicializar com o estado correto
            toggleMotivoField();
        });
    </script>
    {{-- Script dos botao de alternar e adicionar --}}
    <script>
        // Selecione todos os campos com a classe 'proposta'
        document.querySelectorAll('.valor-proposta').forEach(function(input) {
            input.addEventListener('input', function(event) {
                let value = event.target.value.replace(/\D/g, ''); // Remove tudo o que não for número
                if (value) {
                    value = (parseInt(value) / 100).toFixed(2); // Converte para valor decimal
                    value = value.replace('.', ','); // Substitui ponto por vírgula
                    event.target.value = 'R$ ' + value; // Adiciona o "R$" antes do valor
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.valor-proposta').forEach(function(input) {
                let value = input.value.replace(/\D/g, ''); // Remove tudo o que não for número
                if (value) {
                    value = (parseInt(value) / 100).toFixed(2).replace('.',
                        ','); // Converte para valor decimal
                    input.value = 'R$ ' + value;
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Captura os elementos do DOM
            const btnPorEmpresa = document.getElementById('btnPorEmpresa');
            const btnPorMaterial = document.getElementById('btnPorMaterial');
            const listaEmpresa = document.getElementById('listaEmpresa');
            const listaMateriais = document.getElementById('listaMateriais');
            const inputActiveButton = document.getElementById('activeButton');

            let materialAdicionado = false;

            // Obtém o estado salvo ou define 'empresa' como padrão
            let activeButton = document.getElementById('activeButton').value || localStorage.getItem(
                'activeButton') || 'empresa';
            inputActiveButton.value = activeButton;

            function toggleList(type) {
                activeButton = type;
                inputActiveButton.value = type;
                localStorage.setItem('activeButton', type);

                if (type === 'empresa') {
                    btnPorEmpresa.classList.add('btn-success');
                    btnPorEmpresa.classList.remove('btn-secondary');
                    btnPorMaterial.classList.add('btn-secondary');
                    btnPorMaterial.classList.remove('btn-success');

                    btnPorEmpresa.setAttribute('aria-selected', 'true');
                    btnPorMaterial.setAttribute('aria-selected', 'false');

                    listaMateriais.style.display = 'none';
                    listaEmpresa.style.display = 'block';

                    toggleRequired(listaMateriais, false);
                    toggleRequired(listaEmpresa, true);
                } else if (type === 'material') {
                    btnPorMaterial.classList.add('btn-success');
                    btnPorMaterial.classList.remove('btn-secondary');
                    btnPorEmpresa.classList.add('btn-secondary');
                    btnPorEmpresa.classList.remove('btn-success');

                    btnPorMaterial.setAttribute('aria-selected', 'true');
                    btnPorEmpresa.setAttribute('aria-selected', 'false');

                    listaMateriais.style.display = 'block';
                    listaEmpresa.style.display = 'none';

                    toggleRequired(listaMateriais, true);
                    toggleRequired(listaEmpresa, false);

                    if (!materialAdicionado) {
                        addMaterial();
                        materialAdicionado = true;
                    }
                }
            }

            function toggleRequired(container, isRequired) {
                const inputs = container.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    if (input.type !== 'file') {
                        if (isRequired) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    }
                });
            }

            function addMaterial() {
                console.log("Material adicionado dinamicamente.");
            }

            // Inicializa a interface com o estado salvo
            toggleList(activeButton);

            // Adiciona eventos aos botões
            btnPorEmpresa.addEventListener('click', () => toggleList('empresa'));
            btnPorMaterial.addEventListener('click', () => toggleList('material'));
        });


        // Minimizar Card
        document.querySelectorAll('.toggle-card-content').forEach(button => {
            button.addEventListener('click', function() {
                const cardBody = this.closest('.card').querySelector('.card-body');
                cardBody.classList.toggle('d-none');

                // Alterna o ícone entre '-' e '+'
                const icon = this.querySelector('i');
                if (cardBody.classList.contains('d-none')) {
                    icon.classList.remove('bi-dash');
                    icon.classList.add('bi-plus');
                } else {
                    icon.classList.remove('bi-plus');
                    icon.classList.add('bi-dash');
                }
            });
        });

        //Fechar Card
        document.querySelectorAll('.open-delete-modal').forEach(button => {
            button.addEventListener('click', function() {
                const materialId = this.getAttribute('data-material-id');
                const materialName = this.getAttribute('data-material-name');
                const modalBody = document.getElementById('modal-body-content-excluir-material');

                // Define o conteúdo dinâmico
                modalBody.innerHTML = `
            <p>Tem certeza de que deseja excluir o material <strong>${materialName}</strong>?</p>
            <input type="hidden" name="material_id" value="${materialId}">
        `;
            });
        });
    </script>

@endsection
