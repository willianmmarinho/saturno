@extends('layouts.app')

@section('title')
    Editar de Empresa
@endsection
@section('content')
    <form method="POST" action="/atualizar-empresa">{{-- Formulario de Inserção --}}
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
                                        value="{{ $buscaEmpresa->razaosocial }}" required>
                                </div>
                                <!-- Campo Nome Fantasia -->
                                <div class="col-md-3 col-sm-12">Nome Fantasia
                                    <input type="text" class="form-control" id="nomeFantasiaId" name="nomeFantasia"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->nomefantasia }}" required>
                                </div>
                                <!-- Campo CNPJ/CPF -->
                                <div class="col-md-3 col-sm-12">CNPJ - CPF
                                    <input type="text" class="form-control" id="cnpjId" name="cnpj"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->cnpj_cpf }}" required>
                                    @if ($errors->has('cnpj'))
                                        <span class="text-danger">{{ $errors->first('cnpj') }}</span>
                                    @endif
                                </div>
                                <!-- Campo País -->
                                <div class="col-md-3 col-sm-12">País
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        id="paisId" name="pais">
                                        <option value=""></option>
                                        @foreach ($tipoPais as $tipoPaiss)
                                            <option value="{{ $tipoPaiss->id }}"
                                                @if (old('pais', $buscaEmpresa->tipoPais->id) == $tipoPaiss->id) selected @endif>
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
                                        value="{{ $buscaEmpresa->inscestadual }}" required>
                                </div>
                                <!-- Campo Inscrição Municipal -->
                                <div class="col-md-3 col-sm-12">Inscrição Municipal
                                    <input type="text" class="form-control" id="inscricaoMunicipalId"
                                        name="inscricaoMunicipal"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->inscmunicipal }}">
                                </div>
                                <!-- Campo Telefone -->
                                <div class="col-md-3 col-sm-12">Telefone
                                    <input type="text" class="form-control" id="inscricaoTelefoneId"
                                        name="inscricaoTelefone"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->telefone }}">
                                    @if ($errors->has('inscricaoTelefone'))
                                        <span class="text-danger">Por favor, insira um Telefone válido.</span>
                                    @endif
                                </div>
                                <!-- Campo Email -->
                                <div class="col-md-3 col-sm-12">Email
                                    <input type="text" class="form-control" id="inscricaoEmailId" name="inscricaoEmail"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->email }}">
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
                                    <input type="text" class="form-control" id="cepId" name="cep"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->cep }}" required>
                                    @if ($errors->has('inscricaoCep'))
                                        <span class="text-danger">{{ $errors->first('inscricaoCep') }}</span>
                                    @endif
                                </div>
                                <!-- Campo UF -->
                                <div class="col-md-1 col-sm-12">UF
                                    <select class="form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        id="tp_uf" name="tp_uf">
                                        <option value=""></option>
                                        @foreach ($tiposUf as $ModelTipoUf)
                                            <option value="{{ $ModelTipoUf->id }}"
                                                @if (old('tp_uf', $buscaEmpresa->ModelTipoUf->id) == $ModelTipoUf->id) selected @endif>
                                                {{ $ModelTipoUf->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Campo Cidade -->
                                <div class="col-md-4 col-sm-12">Cidade
                                    <br>
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        id="cidade" name="cidade">
                                        <option value=""></option>
                                        @foreach ($tipoCidade as $tipoCidades)
                                            <option value="{{ $tipoCidades->id_cidade }}"
                                                @if (old('cidade', $buscaEmpresa->tipoCidade->id_cidade) == $tipoCidades->id_cidade) selected @endif>
                                                {{ $tipoCidades->descricao }}
                                            </option>
                                        @endforeach
                                        <!-- As cidades serão carregadas via AJAX -->
                                    </select>
                                </div>
                                <!-- Campo Logradouro -->
                                <div class="col-md-4 col-sm-12">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro"
                                        name="logradouro"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->logradouro }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Campo Número -->
                                <div class="col-md-2 col-sm-12">Número
                                    <input type="text" class="form-control" id="inscricaoNumeroId"
                                        name="inscricaoNumero"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->numero }}" required>
                                </div>
                                <!-- Campo Bairro -->
                                <div class="col-md-3 col-sm-12">Bairro
                                    <input type="text" class="form-control" id="bairro"
                                        name="bairro"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->bairro }}" required>
                                </div>
                                <!-- Campo Complemento -->
                                <div class="col-md-7 col-sm-12">Complemento
                                    <input type="text" class="form-control" id="inscricaoComplementoId"
                                        name="inscricaoComplemento"
                                        style="border: 1px solid #999999; padding: 5px; background-color: white"
                                        value="{{ $buscaEmpresa->complemento }}" required>
                                </div>
                            </div>
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="{{ $buscaEmpresa->id }}">
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
@endsection
