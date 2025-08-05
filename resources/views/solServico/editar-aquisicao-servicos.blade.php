@extends('layouts.app')

@section('title')
    Editar Aquisição de Serviços
@endsection
@section('content')
    <form method="POST" action="/atualizar-aquisicao-servicos/{{ $solicitacao->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Editar Solicitação de Serviços
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Identificação do Serviço</h5>
                            <hr>
                            <div class="ROW" style="margin-left:5px">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-2 col-sm-12">
                                        <label>Número da Solicitação</label>
                                        <input class="form-control" type="text" value="{{ $solicitacao->id }}"
                                            id="iddt_inicio" name="numeroSolicitacao" required="required" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label>Data de Criação da Solicitação</label>
                                        <input class="form-control" type="text"
                                            value="{{ \Carbon\Carbon::parse($solicitacao->data)->format('d/m/Y') }}"
                                            id="iddt_inicio" name="dt_inicio" required="required" disabled>
                                    </div>
                                    <div class="col-md-3 col-sm-12">Setor
                                        <br>
                                        <select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                            id="idSetor" name="idSetor">
                                            <option></option>
                                            @foreach ($buscaSetor as $buscaSetors)
                                                <option value="{{ $buscaSetors->id }}"
                                                    {{ $solicitacao->id_setor == $buscaSetors->id ? 'selected' : '' }}>
                                                    {{ $buscaSetors->sigla }} - {{ $buscaSetors->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-2 col-sm-12">Classe do Serviço
                                        <br>
                                        <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                            id="classeServicoEditar" name="classeSvEditar" required>
                                            @foreach ($classeAquisicao as $classe)
                                                <option value="{{ $classe->id }}"
                                                    {{ $classe->id == $solicitacao->id_classe_sv ? 'selected' : '' }}>
                                                    {{ $classe->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Tipo de Serviço
                                        <br>
                                        <select class="js-example-responsive form-select select2"
                                            style="border: 1px solid #999999; padding: 5px;" id="servicos"
                                            name="tipoServicos" required>
                                            <option value="">Selecione um serviço</option>
                                            @foreach ($tiposServico as $tipoServico)
                                                <option value="{{ $tipoServico->id }}"
                                                    {{ $solicitacao->id_tp_sv == $tipoServico->id ? 'selected' : '' }}>
                                                    {{ $tipoServico->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">Motivo
                                    <br>
                                    <textarea class="form-control" style="border: 1px solid #999999; padding: 5px;" id="idmotivo" rows="4"
                                        name="motivo">{{ old('motivo', $solicitacao->motivo) }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="button" id="add-proposta" class="btn btn-success">Adicionar Proposta
                                    Comercial</button>
                            </div>

                            <div id="form-propostas-comerciais">
                                @foreach ($documentos as $documento)
                                    <input type="hidden" name="documento_id[]" value="{{ $documento->id }}">
                                    <div class="card proposta-comercial" style="border-color: #355089; margin-top: 20px;">
                                        <div class="card-header">
                                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                                <h5 style="color: #355089">Proposta Comercial</h5>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm float-end remove-proposta">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class=" form-group row" style="margin-left:5px">
                                                <div class="col-md-4 mb-3">
                                                    <label for="numero">Número da Proposta</label>
                                                    <input type="text" class="form-control" name="numeroOld[]"
                                                        placeholder="Digite o Número da proposta" required
                                                        value="{{ $documento->numero }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="razaoSocial">Nome da Empresa</label>
                                                    <select class="form-select select2"
                                                        style="border: 1px solid #999999; padding: 5px;"
                                                        name="razaoSocialOld[]" required>
                                                        @foreach ($buscaEmpresa as $buscaEmpresas)
                                                            <option value="{{ $buscaEmpresas->id }}"
                                                                {{ $buscaEmpresas->id == $documento->id_empresa ? 'selected' : '' }}>
                                                                {{ $buscaEmpresas->razaosocial }} -
                                                                {{ $buscaEmpresas->nomefantasia }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="valor">Valor</label>
                                                    <input type="text" class="form-control" name="valorOld[]"
                                                        placeholder="Digite o valor da proposta" required
                                                        value="{{ $documento->valor }}">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="dt_inicial">Data da Proposta</label>
                                                    <input type="date" class="form-control" name="dt_inicialOld[]"
                                                        placeholder="Digite a data da proposta"
                                                        value="{{ $documento->dt_doc }}" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="dt_final">Data Limite</label>
                                                    <input type="date" class="form-control" name="dt_finalOld[]"
                                                        value="{{ $documento->dt_validade }}"
                                                        placeholder="Digite a data final do prazo da proposta">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="arquivo">Novo Arquivo</label>
                                                    <input type="file" class="form-control" name="arquivoOld[]"
                                                        value="{{ $documento->end_arquivo }}"
                                                        placeholder="Insira o arquivo da proposta">
                                                </div>
                                                <div class="col-md-3 mb-3 row">
                                                    <label for="arquivo">Arquivo Atual</label>
                                                    @if ($documento->arquivo_url)
                                                        <a href="{{ $documento->arquivo_url }}" target="_blank"
                                                            class="btn btn-primary">
                                                            Ver Arquivo
                                                        </a>
                                                    @else
                                                        <a class="btn btn-secondary" disabled>Nenhum arquivo
                                                            disponível.</a>
                                                    @endif
                                                </div>
                                                <div class="form-check col-md-4 mb-3">
                                                    <label for="garantiaBotao">Possui garantia?</label>
                                                    <input type="checkbox"
                                                        style="border: 1px solid #999999; padding: 5px;"
                                                        class="form-check-input" id="garantiaBotao"
                                                        name="garantiaBotao[]"
                                                        @if (old('garantiaBotao')) checked @endif>
                                                </div>
                                                <div id="tempoGarantia" class="col-md-4 mb-3" style="display: none;">
                                                    <label for="tempoGarantiaInput">Tempo de Garantia (em dias)</label>
                                                    <input type="number" class="form-control" id="tempoGarantiaInput"
                                                        name="tempoGarantiaOld[]"
                                                        placeholder="Digite o tempo de garantia">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="botões">
            <a href="javascript:history.back()" type="button" value=""
                class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Função para popular serviços com base na classe de serviço
            function populateServicos(selectElement, classeServicoValue) {
                $.ajax({
                    type: "GET",
                    url: "/retorna-nome-servicos/" + classeServicoValue,
                    dataType: "json",
                    success: function(response) {
                        selectElement.empty();
                        selectElement.append('<option value="">Selecione um serviço</option>');
                        $.each(response, function(index, item) {
                            selectElement.append(
                                '<option value="' + item.id + '">' + item.descricao +
                                "</option>"
                            );
                        });
                        selectElement.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        console.error("Ocorreu um erro:", error);
                        console.log(xhr.responseText);
                    },
                });
            }

            // Atualiza os serviços ao alterar a classe de serviço
            $(document).on("change", "#classeServicoEditar", function() {
                const classeServicoValue = $(this).val();
                const servicosSelect = $("#servicos");

                if (!classeServicoValue) {
                    servicosSelect.empty().append('<option value="">Selecione um serviço</option>');
                    servicosSelect.prop("disabled", true);
                    return;
                }

                populateServicos(servicosSelect, classeServicoValue);
            });

            // Adiciona nova proposta comercial
            $("#add-proposta").click(function() {
                const newProposta = $("#template-proposta-comercial").html();
                $("#form-propostas-comerciais").append(newProposta);
            });

            // Remove proposta comercial
            $(document).on("click", ".remove-proposta", function() {
                $(this).closest(".proposta-comercial").remove();
            });

            // Alterna campo de tempo de garantia para formulários dinâmicos
            $(document).on("change", ".form-check-input[name='garantiaBotao[]']", function() {
                const garantiaCheckbox = $(this);
                const tempoGarantiaDiv = garantiaCheckbox
                    .closest(".form-group.row")
                    .find("#tempoGarantia");

                if (garantiaCheckbox.is(":checked")) {
                    tempoGarantiaDiv.show();
                } else {
                    tempoGarantiaDiv.hide();
                }
            });

            // Inicializa a visibilidade do campo de garantia com base no estado inicial
            $(".form-check-input[name='garantiaBotao[]']").each(function() {
                const garantiaCheckbox = $(this);
                const tempoGarantiaDiv = garantiaCheckbox
                    .closest(".form-group.row")
                    .find("#tempoGarantia");

                if (garantiaCheckbox.is(":checked")) {
                    tempoGarantiaDiv.show();
                } else {
                    tempoGarantiaDiv.hide();
                }
            });
        });
    </script>

    <!-- Template para adicionar nova proposta comercial dinamicamente -->
    <script type="text/template" id="template-proposta-comercial">
            <div class="card proposta-comercial" style="border-color: #355089; margin-top: 20px;">
                <div class="card-header">
                    <div style="display: flex; gap: 20px; align-items: flex-end;">
                        <h5 style="color: #355089">Proposta Comercial</h5>
                        <button type="button" class="btn btn-danger btn-sm float-end remove-proposta">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class=" form-group row" style="margin-left:5px">
                        <div class="col-md-4 mb-3">
                            <label for="numero">Número da Proposta</label>
                            <input type="text" class="form-control" name="numero[]" placeholder="Digite o Número da proposta"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="razaoSocial">Nome da Empresa</label>
                            <select class="form-select" style="border: 1px solid #999999; padding: 5px;" id=""
                            name="razaoSocial[]" required>
                            <option></option>
                                @foreach ($buscaEmpresa as $buscaEmpresas)
                                    <option value="{{ $buscaEmpresas->id }}">
                                        {{ $buscaEmpresas->razaosocial }} - {{ $buscaEmpresas->nomefantasia }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor">Valor</label>
                            <input type="text" class="form-control" name="valor[]" placeholder="Digite o valor da proposta"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dt_inicial">Data da Proposta</label>
                            <input type="date" class="form-control" name="dt_inicial[]"
                                placeholder="Digite a data da proposta" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dt_final">Data Limite</label>
                            <input type="date" class="form-control" name="dt_final[]"
                                placeholder="Digite a data final do prazo da proposta">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="arquivo">Arquivo da Proposta</label>
                            <input type="file" class="form-control" name="arquivo[]"
                                placeholder="Insira o arquivo da proposta" required>
                        </div>
                        <div class="form-check col-md-4 mb-3">
                            <label for="garantiaBotao">Possui garantia?</label>
                            <input type="checkbox" style="border: 1px solid #999999; padding: 5px;"
                                class="form-check-input" id="garantiaBotao" name="garantiaBotao[]"
                                @if (old('garantiaBotao')) checked @endif>
                        </div>
                        <div id="tempoGarantia" class="col-md-4 mb-3" style="display: none;">
                            <label for="tempoGarantiaInput">Tempo de Garantia (em dias)</label>
                            <input type="number" class="form-control" id="tempoGarantiaInput"
                                name="tempoGarantia[]" placeholder="Digite o tempo de garantia">
                        </div>
                    </div>
                </div>
            </div>
    </script>
    <!-- FIM Template para adicionar nova proposta comercial dinamicamente -->
    {{-- <!-- Template de formulário de material -->
    <div id="template-material-principal" style="display: none;">
        <div class="card material-principal" style="border-color: #355089; margin-top: 20px;">
            <div class="form-group row" style="margin-left: 5px; margin-top: 5px;">
                <div class="col-md-2">
                    <label>Quantidade de material</label>
                    <input type="text" class="form-control" name="quantidadeMaterialPrincipal[]"
                        placeholder="Digite o valor da proposta">
                </div>
                <div class="col-md-3">
                    <label>Nome do item material</label>
                    <input type="text" class="form-control" name="nomeMaterialPrincipal[]"
                        placeholder="Digite o valor da proposta">
                </div>
                <div class="col-md-4">
                    <label>Categoria do material</label>
                    <select class="form-select js-categoria-material" style="border: 1px solid #999999; padding: 3px;"
                        name="CategoriaMaterialPrincipal[]">
                        <option></option>
                        @foreach ($buscaCategoria as $buscaCategorias)
                            <option value="{{ $buscaCategorias->id }}">
                                {{ $buscaCategorias->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Valor do material</label>
                    <input type="number" class="form-control" name="valorMaterialPrincipal[]"
                        placeholder="Digite o valor da proposta" style="margin-bottom: 10px">
                </div>
                <div class="col-md-1" style="display: flex; align-items: center; margin-top: 10px;">
                    <button type="button" class="btn btn-danger btn-sm remove-material-principal">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM do Template de formulário de material --> --}}
@endsection
