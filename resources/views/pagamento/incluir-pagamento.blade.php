@extends('layouts.app')

@section('title')
    Gerenciar Pagamentos
@endsection
@section('content')
    <form method="GET" action="">{{-- Formulario de pesquisa --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="col-12" style="color: #355089">
                                    Compra de Material
                                </h5>
                            </div>
                        </div>
                        <br>
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
                                        <label>Selecione seu Setor</label>
                                        <br>
                                        <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                            id="idSetor" name="idSetorSolicitacao" required>
                                            <option value="{{ $solicitacao->setor->id ?? '' }}" selected>
                                                {{ $solicitacao->setor->sigla ?? 'Não especificado' }} -
                                                {{ $solicitacao->setor->nome ?? 'Não especificado' }}</option>
                                            @foreach ($buscaSetor as $buscaSetors)
                                                <option value="{{ $buscaSetors->id }}">
                                                    {{ $buscaSetors->sigla }} - {{ $buscaSetors->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label>Selecione o Depósito de Entrada</label>
                                        <br>
                                        <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                            id="idDeposito" name="idDepositoSolicitacao" required data-placeholder="Selecione um depósito">
                                            <option value="" selected></option>
                                            @foreach ($buscaDeposito as $buscaDepositos)
                                                <option value="{{ $buscaDepositos->id }}">
                                                    {{ $buscaDepositos->sigla }} - {{ $buscaDepositos->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Motivo</label>
                                    <br>
                                    <input type="text" class="form-control" name="motivoSolicitacao"
                                        placeholder="Digite o motivo da solicitação"
                                        style="background-color: white; border-color: gray;"
                                        value="{{ $solicitacao->motivo ?? '' }}" required>
                                </div>
                            </div>
                            <br>
                            <div class="row" style="margin-left:5px">
                            <table {{-- Inicio da tabela de informacoes --}}
                                class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                id="tabela-materiais" style="width: 100%">
                                <thead style="text-align: center;">{{-- inicio header tabela --}}
                                    <tr style="background-color: #d6e3ff; font-size:15px; color:#000;" class="align-middle">
                                        <th>ID</th>
                                        <th>TIPO DÍVIDA</th>
                                        <th>FORMA PAGAMENTO</th>
                                        <th>QTD. PARCELAS</th>
                                        <th>CREDOR</th>
                                        <th>DATA FINAL</th>
                                        <th>PERENE</th>
                                        <th>PRIORIDADE</th>
                                        <th>DOCUMENTO</th>
                                        <th>STATUS</th>
                                        <th>AÇÕES</th>
                                    </tr>
                                </thead>{{-- Fim do header da tabela --}}
                                <tbody style="font-size: 15px; color:#000000; text-align: center;">
                                    {{-- Inicio body tabela --}}
                                    @foreach ($result as $results)
                                        <tr>
                                            <td> {{ $results->id }} </td>
                                            <td>Material/Serviço</td>
                                            <td>A Vista</td>
                                            <td>03/07</td>
                                            <td>SIM</td>
                                            <td>01/01/2019</td>
                                            <td>NÃO</td>
                                            <td>-</td>
                                            <td>NÃO POSSUI</td>
                                            <td>-</td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Visualizar">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/gerenciar-pagamento/pagar/{{ $results->id }}" class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Pagar">
                                                    <i class="bi bi-currency-dollar"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Aditivo">
                                                    <i class="bi bi-bookmark-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- Fim body da tabela --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
