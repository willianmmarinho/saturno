@extends('layouts.app')

@section('title')
    Incluir de Empresa
@endsection
@section('content')
    <form method="POST" action="/salvar-empresa">{{-- Formulario de Inserção --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Catálogo de Empresas
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Identificação da Empresa</h5>
                            <div class="row">
                                <!-- Campo Nome da Empresa(Razão social) -->
                                <div class="col-md-3 col-sm-12">Razão Social
                                    <input type="text" class="form-control" id="razaoSocialId" name="razaoSocial"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('razaoSocial') }}" required>
                                </div>
                                <!-- Campo Nome Fantasia -->
                                <div class="col-md-3 col-sm-12">Nome Fantasia
                                    <input type="text" class="form-control" id="nomeFantasiaId" name="nomeFantasia"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('nomeFantasia') }}" required>
                                </div>
                                <!-- Campo CNPJ/CPF -->
                                <div class="col-md-3 col-sm-12">CNPJ - CPF
                                    <input type="number" class="form-control" id="cnpjId" name="cnpj"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('cnpj') }}" required>
                                    @if ($errors->has('cnpj'))
                                        <span class="text-danger">{{ $errors->first('cnpj') }}</span>
                                    @endif
                                </div>
                                <!-- Campo País -->
                                <div class="col-md-3 col-sm-12">País
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white" required
                                        id="paisId" name="pais">
                                        <option value=""></option>
                                        @foreach ($tipoPais as $tipoPaiss)
                                            <option @if (old('pais') == $tipoPaiss->id) {{ 'selected="selected"' }} @endif
                                                value="{{ $tipoPaiss->id }}">
                                                {{ $tipoPaiss->descricao }}
                                            </option>
                                        @endforeach
                                        <!-- As cidades serão carregadas via AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Campo Inscrição Estadual -->
                                <div class="col-md-3 col-sm-12">Inscrição Estadual
                                    <input type="text" class="form-control" id="inscricaoEstadualId"
                                        name="inscricaoEstadual"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoEstadual') }}" required>
                                </div>
                                <!-- Campo Inscrição Municipal -->
                                <div class="col-md-3 col-sm-12">Inscrição Municipal
                                    <input type="text" class="form-control" id="inscricaoMunicipalId"
                                        name="inscricaoMunicipal"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoMunicipal') }}">
                                </div>
                                <!-- Campo Telefone -->
                                <div class="col-md-3 col-sm-12">
                                    Telefone
                                    <input type="text" class="form-control" id="inscricaoTelefoneId"
                                        name="inscricaoTelefone"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoTelefone') }}" placeholder="Ex.: (99) 99999-9999">
                                    @if ($errors->has('inscricaoTelefone'))
                                        <span class="text-danger">Por favor, insira um Telefone válido.</span>
                                    @endif
                                </div>
                                <!-- Campo Email -->
                                <div class="col-md-3 col-sm-12">Email
                                    <input type="text" class="form-control" id="inscricaoEmailId" name="inscricaoEmail"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoEmail') }}">
                                    @if ($errors->has('inscricaoEmail'))
                                        <span class="text-danger">Por favor, insira um Email válido.</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <h5>Endereço da Empresa</h5>
                            <div class="row">
                                <!-- Campo CEP -->
                                <div class="col-md-3 col-sm-12">CEP
                                    <input type="text" class="form-control" id="isncricaoCepId" name="inscricaoCep"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoCep') }}" required>
                                    @if ($errors->has('inscricaoCep'))
                                        <span class="text-danger">{{ $errors->first('inscricaoCep') }}</span>
                                    @endif

                                </div>
                                <!-- Campo UF -->
                                <div class="col-md-1 col-sm-12">UF
                                    <select class="form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white" required
                                        id="tp_uf" name="tp_uf">
                                        <option value=""></option>
                                        @foreach ($tp_uf as $tp_ufs)
                                            <option value="{{ $tp_ufs->id }}">{{ $tp_ufs->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Campo Cidade -->
                                <div class="col-md-4 col-sm-12">Cidade
                                    <br>
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        id="cidade" name="cidade" value="{{ old('cidade') }}" disabled>
                                    </select>
                                </div>
                                <!-- Campo Logradouro -->
                                <div class="col-md-4 col-sm-12">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('logradouro') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Campo Número -->
                                <div class="col-md-2 col-sm-12">Número
                                    <input type="text" class="form-control" id="inscricaoNumeroId"
                                        name="inscricaoNumero"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoNumero') }}" required>
                                </div>
                                <!-- Campo Bairro -->
                                <div class="col-md-3 col-sm-12">Bairro
                                    <input type="text" class="form-control" id="bairro" name="bairro"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('bairro') }}" required>
                                </div>
                                <!-- Campo Complemento -->
                                <div class="col-md-7 col-sm-12">Complemento
                                    <input type="text" class="form-control" id="inscricaoComplementoId"
                                        name="inscricaoComplemento"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('inscricaoComplemento') }}" required>
                                </div>
                            </div>
                            <hr>
                            <h5>CNAE da Empresa</h5>
                            <div class="row">
                                <!-- Campo CNAE -->
                                <div class="col-md-3 col-sm-12">Número CNAE
                                    <input type="text" class="form-control" id="cnae" name="cnae[]"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ old('cnae') }}" required>
                                </div>
                                <!-- Container para os formulários de propostas comerciais -->
                                <div id="form-propostas-comerciais">
                                    <!-- Formulários de propostas comerciais serão adicionados aqui -->
                                </div>
                                <!-- Botão para adicionar nova proposta comercial -->
                                <div class="col-12 text-center mt-4">
                                    <button type="button" id="add-proposta" class="btn btn-success">Adicionar Proposta
                                        Comercial</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <div class="botões">
            <a href="/catalogo-empresa" type="button" value=""
                class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>{{-- Final Formulario de Inserção --}}

    <div id="template-numero-cnae" style="display: none;">
        <div class="template-numero-cnae" style="border-color: #355089; margin-top: 5px;">
            <div class="card-body">
                <div class=" form-group row" style="margin-left:5px">
                    <!-- Campo CNAE -->
                    <div class="col-md-3 col-sm-12">Número CNAE
                        <input type="text" class="form-control" id="cnae" name="cnae[]"
                            style="border: 1px solid #999999; background-color: white"
                            value="{{ old('cnae') }}">
                            <button type="button" class="btn btn-danger btn-sm float-end remove-proposta">
                                <i class="bi bi-x"></i>
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function populateCities(selectElement, stateValue) {
                $.ajax({
                    type: "get",
                    url: "/retorna-cidade-dados-residenciais/" + stateValue,
                    dataType: "json",
                    success: function(response) {
                        selectElement.empty();
                        $.each(response, function(indexInArray, item) {
                            selectElement.append(
                                '<option value="' +
                                item.id_cidade +
                                '">' +
                                item.descricao +
                                "</option>"
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                    },
                });
            }

            $("#tp_uf").change(function(e) {
                var stateValue = $(this).val();
                $("#cidade").removeAttr("disabled");
                populateCities($("#cidade"), stateValue);
            });

            $("#add-proposta").click(function() {
                var newProposta = $("#template-numero-cnae").html();
                $("#form-propostas-comerciais").append(newProposta);
            });

            $(document).on("click", ".remove-proposta", function() {
                $(this).closest(".proposta-comercial").remove();
            });
        });
    </script>
@endsection
