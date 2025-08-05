@extends('layouts.app')

@section('title')
    Aditivo da Solicitação de Serviços
@endsection
@section('content')
    <form method="POST" action="/validaAditivo-aquisicao-servicos" enctype="multipart/form-data">{{-- Formulario de Inserção --}}
        @csrf
        <input type="hidden" name="solicitacao_id" value="{{ $aquisicao->id }}">
        <input type="hidden" name="setor_id" value="{{ $aquisicao->setor->id }}">
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Aditivo da Solicitação de Serviços
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
                                    <input class="form-control" style="text-align: center;" type="text" name="idSetor" disabled
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
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->prioridade }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Setor Responsável por Acompanhar</label>
                                    <br>
                                    <input class="form-control" style="text-align: center;" type="text" disabled
                                        value="{{ $aquisicao->respSetor->nome ?? '' }} - {{ $aquisicao->respSetor->sigla ?? '' }}">
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
                            <div class="card proposta-comercial" style="border-color: #355089; margin-top: 20px;">
                                <div class="card-header">
                                    <div style="display: flex; gap: 20px; align-items: flex-end;">
                                        <h5 style="color: #355089">Aditivo de Contrato</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class=" form-group row" style="margin-left:5px">
                                        <div class="col-md-4 mb-3">
                                            <label for="numero">Número da Proposta</label>
                                            <input type="text" class="form-control" name="numeroAditivo"
                                                placeholder="Digite o Número da proposta" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="razaoSocial">Nome Empresa</label>
                                            <select class="form-select" style="border: 1px solid #999999; padding: 5px;"
                                                name="razaoSocialAditivo" required>
                                                <option></option>
                                                @foreach ($buscaEmpresa as $buscaEmpresas)
                                                    <option value="{{ $buscaEmpresas->id }}">
                                                        {{ $buscaEmpresas->razaosocial }} -
                                                        {{ $buscaEmpresas->nomefantasia }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="valor">Valor</label>
                                            <input type="number" class="form-control" name="valorAditivo"
                                                placeholder="Digite o valor da proposta" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="dt_inicial">Data da Proposta</label>
                                            <input type="date" class="form-control" name="dt_inicialAditivo"
                                                placeholder="Digite a data da proposta" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="dt_final">Data Limite</label>
                                            <input type="date" class="form-control" name="dt_finalAditivo"
                                                placeholder="Digite a data final do prazo da proposta" min="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="arquivo">Arquivo da Proposta</label>
                                            <input type="file" class="form-control" name="arquivoAditivo"
                                                placeholder="Insira o arquivo da proposta" required>
                                        </div>
                                        <div class="form-check col-md-4 mb-3">
                                            <label for="garantiaBotao">Possui garantia?</label>
                                            <input type="checkbox" style="border: 1px solid #999999; padding: 5px;"
                                                class="form-check-input" id="garantiaBotao" name="garantiaBotaoAditivo"
                                                @if (old('garantiaBotao')) checked @endif>
                                        </div>
                                        <div id="tempoGarantia" class="col-md-4 mb-3" style="display: none;">
                                            <label for="tempoGarantiaInput">Tempo de Garantia (em dias)</label>
                                            <input type="number" class="form-control" id="tempoGarantiaInput"
                                                name="tempoGarantiaAditivo" placeholder="Digite o tempo de garantia">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const garantiaCheckbox = document.getElementById('garantiaBotao');
            const tempoGarantiaDiv = document.getElementById('tempoGarantia');

            // Função para alternar visibilidade
            function toggleGarantiaField() {
                if (garantiaCheckbox.checked) {
                    tempoGarantiaDiv.style.display = 'block';
                } else {
                    tempoGarantiaDiv.style.display = 'none';
                }
            }

            // Evento de mudança no checkbox
            garantiaCheckbox.addEventListener('change', toggleGarantiaField);

            // Inicializar visibilidade com base no estado inicial
            toggleGarantiaField();
        });
    </script>
@endsection
