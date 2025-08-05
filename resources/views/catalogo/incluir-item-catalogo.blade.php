@extends('layouts.app')

@section('title')
    Incluir item no catálogo
@endsection

@section('headerCss')
    <link href="{{ URL::asset('/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Incluir Tipo Material
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <h5>Incluir Material</h5>
                        <hr>
                        <!-- <p class="card-title-desc">Here are examples of <code class="highlighter-rouge">.form-control</code> applied to each textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code class="highlighter-rouge">type</code>.</p>-->
                        <form class="form-horizontal mt-4" method="POST" action="/cad-item-material/inserir">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="nome_item" class="col-sm-2 col-form-label">Nome Item*</label>
                                    <div class="col-md-10">
                                        <input class="form-control" required="required" type="text" id="nome_item"
                                            name="nome_item">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="categoria_item" class="col-sm-2 col-form-label">Categoria*</label>
                                    <div class="col-md-10">
                                        <select class="form-control select2" id="categoria_item" name="categoria_item"
                                            required="required">
                                            <option value="">Selecione</option>
                                            @foreach ($resultCategoria as $resultCategorias)
                                                <option value="{{ $resultCategorias->id }}">{{ $resultCategorias->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="val_minimo" class="col-sm-2 col-form-label">Valor Minimo*</label>
                                    <div class="col-md-4">
                                        <input class="form-control" value="0.00" type="numeric" id="val_minimo"
                                            name="val_minimo" required="required"
                                            onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                    <label for="val_medio" class="col-sm-2 col-form-label">Valor Médio*</label>
                                    <div class="col-md-4">
                                        <input class="form-control" value="0.00" type="numeric" id="val_medio"
                                            name="val_medio" required="required"
                                            onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="val_maximo" class="col-sm-2 col-form-label">Valor Máximo*</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="numeric" value="0.00" id="val_maximo"
                                            name="val_maximo" required="required"
                                            onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                    <label for="val_marca" class="col-sm-2 col-form-label">Valor Marca*</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="numeric" value="0.00" id="val_marca"
                                            name="val_marca" required="required"
                                            onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="val_etiqueta" class="col-sm-2 col-form-label">Valor Etiqueta*</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="numeric" value="0.00" id="val_etiqueta"
                                            name="val_etiqueta" required="required"
                                            onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                    <label for="tipoMaterial" class="col-sm-2 col-form-label">Tipo do Material</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2" id="tp_material" name="tp_material"
                                            required="required">
                                            <option value="">Selecione</option>
                                            @foreach ($tipoMaterial as $tipoMaterials)
                                                <option value="{{ $tipoMaterials->id }}">{{ $tipoMaterials->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tp_unidade_medida" class="col-sm-2 col-form-label">Unidade de
                                        Medida*</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2" id="tp_unidade_medida"
                                            name="tp_unidade_medida" required="required">
                                            @foreach ($unidadeMedida as $unidadeMedidas)
                                                <option value="{{ $unidadeMedidas->id }}">{{ $unidadeMedidas->sigla }} -
                                                    {{ $unidadeMedidas->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="ativo" class="col-sm-2 col-form-label">Ativo</label>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="ativo" name="ativo" checked="checked">
                                    </div>
                                </div>
                            </div>
                            <br>
                             <div class="card" style="border-color: #355089;">
                                <div class="card-header">
                                    <div class="ROW">
                                        <h5 class="col-12" style="color: #355089">
                                            Impostos de Produtos</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="card-body">
                                    <div style="display: flex; gap: 20px; align-items: flex-end;">
                                        <div class="col-md-2 col-sm-12">CFOP
                                            <br>
                                            <select class="form-select select2"
                                                style="border: 1px solid #999999; padding: 5px;" id="idCfop"
                                                name="idCfop" required>
                                                <option></option>
                                                @foreach ($cfop as $buscaCfop)
                                                    <option value="{{ $buscaCfop->cfop }}">
                                                        {{ $buscaCfop->cfop }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">CEST
                                            <br>
                                            <select class="form-select select2"
                                                style="border: 1px solid #999999; padding: 5px;" id="idCest"
                                                name="idCest" required>
                                                <option></option>
                                                @foreach ($cest as $buscaCest)
                                                    <option value="{{ $buscaCest->codigo }}">
                                                        {{ $buscaCest->codigo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12">NCM
                                            <br>
                                            <select class="form-select select2"
                                                style="border: 1px solid #999999; padding: 5px;" id="idNcm"
                                                name="idNcm" required>
                                                <option></option>
                                                @foreach ($ncm as $buscaNcm)
                                                    <option value="{{ $buscaNcm->ncm_codigo }}">
                                                        {{ $buscaNcm->ncm_codigo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12" style="display: flex; flex-direction: column;">
                                            Código do Benefício Fiscal
                                            <br>
                                            <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                type="text" id="idCBenef" name="cBenef"
                                                placeholder="Digite o código do benefício fiscal">
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Abas -->
                                    <ul class="nav nav-tabs" id="taxTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="icms-tab" data-bs-toggle="tab"
                                                href="#icms" role="tab" aria-controls="icms"
                                                aria-selected="true">ICMS</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="icmsst-tab" data-bs-toggle="tab" href="#icmsst"
                                                role="tab" aria-controls="icmsst" aria-selected="false">ICMS ST</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="fcp-tab" data-bs-toggle="tab" href="#fcp"
                                                role="tab" aria-controls="fcp" aria-selected="false">FCP</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pis-tab" data-bs-toggle="tab" href="#pis"
                                                role="tab" aria-controls="pis" aria-selected="false">PIS</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="cofins-tab" data-bs-toggle="tab" href="#cofins"
                                                role="tab" aria-controls="cofins" aria-selected="false">COFINS</a>
                                        </li>
                                    </ul>

                                    <!-- Conteúdo das Abas -->
                                    <div class="tab-content mt-3" id="taxTabsContent">
                                        <div class="tab-pane fade show active" id="icms" role="tabpanel"
                                            aria-labelledby="icms-tab">
                                            <!-- Campos de ICMS -->
                                            <div class="form-group row">
                                                <h5 style="color: #355089; margin-top: 15px">Origem e Tributação ICMS</h5>
                                                <br>
                                                <div class="col-md-9 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Origem da Mercadoria
                                                    <br>
                                                    <select class="form-select select2"
                                                        style="border: 1px solid #999999; padding: 5px;" id="idOrigem"
                                                        name="idOrigem" required>
                                                        @foreach ($origem_icms as $buscaOrigem)
                                                            <option value="{{ $buscaOrigem->id }}">
                                                                {{ $buscaOrigem->id }} - {{ $buscaOrigem->tipo }} -
                                                                {{ $buscaOrigem->descricao }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-9 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Código da Situação Simples Nacional (CSOSN)
                                                    <br>
                                                    <select class="form-select select2"
                                                        style="border: 1px solid #999999; padding: 5px;" id="idCsosn"
                                                        name="idCsosn" required>
                                                        @foreach ($csosn_icms as $buscaCsosn)
                                                            <option value="{{ $buscaCsosn->id }}">
                                                                {{ $buscaCsosn->id }} - {{ $buscaCsosn->nm_icms }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Modelo Base de Calculo ICMS
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Código da Situação Tributária (CST)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12"
                                                        style="display: flex; flex-direction: column; padding: 5px;">
                                                        Aliquota ICMS
                                                        <br>
                                                        <input
                                                            style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                            type="text" id="idCBenef" name="cBenef"
                                                            placeholder="Digite o código do benefício fiscal">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12"
                                                        style="display: flex; flex-direction: column; padding: 5px;">
                                                        Redução BC ICMS (%)
                                                        <br>
                                                        <input
                                                            style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                            type="text" id="idCBenef" name="cBenef"
                                                            placeholder="Digite o código do benefício fiscal">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12"
                                                        style="display: flex; flex-direction: column; padding: 5px;">
                                                        Alíquota ICMS Diferimento
                                                        <br>
                                                        <input
                                                            style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                            type="text" id="idCBenef" name="cBenef"
                                                            placeholder="Digite o código do benefício fiscal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="icmsst" role="tabpanel"
                                            aria-labelledby="icmsst-tab">
                                            <!-- Campos de ICMS ST -->
                                            <div class="form-group row">
                                                <h5 style="color: #355089; margin-top: 15px;">ICMS Substituição Tributária
                                                </h5>
                                                <br>
                                                <div class="col-md-5 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Modelo de Base de Cálculo do ICMS ST
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Redução BC ICMS ST (%)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Valor Unitário ICMS Substituto
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <h5 style="color: #355089; margin-top: 25px;">ICMS Substituição tributária
                                                    Retido</h5>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Aliquota ICMS Consumidor Final
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    BC ICMS ST Unitário Retido <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="fcp" role="tabpanel"
                                            aria-labelledby="fcp-tab">
                                            <!-- Campos de FCP -->
                                            <div class="form-group row">
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Alíquota FCP (%)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Alíquota FCP ST Retido
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    BC FCP ST Unitário Retido
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pis" role="tabpanel"
                                            aria-labelledby="pis-tab">
                                            <!-- Campos de PIS -->
                                            <div class="form-group row">
                                                <div class="col-md-10 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Código da Situação Tributária (CST)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-3 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Tipo da Tributação PIS
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Alíquota PIS (%)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="cofins" role="tabpanel"
                                            aria-labelledby="cofins-tab">
                                            <!-- Campos de Cofins -->
                                            <div class="form-group row">
                                                <div class="col-md-10 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Código da Situação Tributária (CST)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-3 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Tipo da Tributação COFINS
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                                <div class="col-md-2 col-sm-12"
                                                    style="display: flex; flex-direction: column; padding: 5px;">
                                                    Alíquota COFINS (%)
                                                    <br>
                                                    <input style="border: 1px solid #c9c6c6; padding: 6px; flex-grow: 1;"
                                                        type="text" id="idCBenef" name="cBenef"
                                                        placeholder="Digite o código do benefício fiscal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="botões">
                                <a href="javascript:history.back()"
                                    class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
                                <button type="submit" value="Confirmar"
                                    class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
