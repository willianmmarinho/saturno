@extends('layouts.app')

@section('title')
    Aprovar Solicitação de Serviços
@endsection
@section('content')
    <form method="POST" action="/validaAprovacao-aquisicao-servicos">{{-- Formulario de Inserção --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Aprovar Solicitação de Serviços
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Identificação do Solicitante</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Número da Proposta</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->id }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Data da Criação</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="date" format="d-m-Y"
                                        disabled value="{{ $aquisicao->data }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Setor</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->setor->nome }}">
                                </div>
                            </div>
                            <br>
                            <hr>
                            <h5>Identificação do Serviço</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Classe</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->tipoClasse->descricao }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Tipo</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->catalogoServico->descricao }}">
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
                                <div class="col-md-4">
                                    <label>Setor Responsável por Acompanhar</label>
                                    <br>
                                    <select id="idSetorResponsavel" class="form-select status select2 pesquisa-select"
                                        style="" name="setorResponsavel" required>
                                        <option></option>
                                        @foreach ($todosSetor as $setor)
                                            <option value="{{ $setor->id }}"
                                                {{ $setor->id == $aquisicao->id_resp_sv ? 'selected' : '' }}>
                                                {{ $setor->nome }} - {{ $setor->sigla }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" col-12">Motivo
                                <br>
                                <textarea class="form-control" style="border: 1px solid #999999; padding: 5px;" id="idmotivo" rows="4"
                                    value="" disabled>{{ $aquisicao->motivo }}</textarea>
                            </div>
                            <br>
                            <hr>
                            <h5>Propostas Comerciais</h5>
                            <div class="ROW" style="margin-left:5px">
                                @foreach ($empresas as $index => $empresa)
                                    <div style="display: flex; gap: 20px; align-items: flex-end;">
                                        <div class="col-md-3">{{ $contadorEmpresa }}º Empresa
                                            <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                                type="text" name="empresas[{{ $index }}][id_empresa]"
                                                value="{{ $empresa->id_empresa }}" readonly>
                                        </div>
                                        @php
                                            $contadorEmpresa++;
                                        @endphp
                                        <div class="col-md-3">Valor Orçado
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    style="border: 1px solid #999999; padding: 5px;">R$</span>
                                                <input type="text" class="form-control"
                                                    name="empresas[{{ $index }}][valor]"
                                                    style="border: 1px solid #999999; padding: 5px;"
                                                    value="{{ $empresa->valor }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">Data Limite do Orçamento
                                            <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                                type="date" name="empresas[{{ $index }}][dt_validade]"
                                                value="{{ $empresa->dt_validade }}" readonly>
                                        </div>
                                        <div class="col-md-3 row">
                                            <label for="arquivo">Arquivo da Proposta</label>
                                            @if ($empresa->arquivo_url)
                                                <a href="{{ $empresa->arquivo_url }}" target="_blank"
                                                    class="btn btn-primary">
                                                    Ver Arquivo
                                                </a>
                                            @else
                                                <a class="btn btn-secondary" disabled>Nenhum arquivo
                                                    disponível.</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <hr>
                            <h5>Decisão</h5>

                            <input type="hidden" name="solicitacao_id" value="{{ $aquisicao->id }}">

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
                                    name="motivoRejeicao" value="" required>{{ $aquisicao->motivo_recusa }}</textarea>
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
    </form>{{-- Final Formulario de Inserção --}}
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
@endsection
