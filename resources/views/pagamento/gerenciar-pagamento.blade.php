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
                                    Gerenciar Compras/Pagamentos
                                </h5>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="row" style="margin-left:5px">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-2 col-sm-12">Tipo Dívida
                                        <br>
                                        <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                            id="categoriaServico" name="categoria">
                                            <option value="">Selecione...</option>
                                            <option value="">Material</option>
                                            <option value="">Serviço</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Forma Pagamento
                                        <br>
                                        <select class="form-select select2" style="border: 1px solid #999999;"
                                            id="materiais" name="materiais">
                                            <option value="">Selecione...</option>
                                            <option value="">A Vista</option>
                                            <option value="">Parcelado</option>
                                            <option value="">A Prazo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Data Final
                                        <input type="date" class="form-control"
                                            style="border: 1px solid #999999; padding: 5px;" name="data_final"
                                            id="dataFinal">
                                    </div>
                                    <div class="col-md-2 col-sm-12">Status
                                        <select class="form-select" style="border: 1px solid #999999;"
                                            name="status_material" value="" id="statusMaterial">
                                            <option value="">Todos</option>

                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light btn-sm "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px; padding: 5px;"{{-- Botao submit do formulario de pesquisa --}}
                                            type="submit">Pesquisar
                                        </button>
                                        <a href="" type="button" class="btn btn-light btn-sm"
                                            style="box-shadow: 1px 2px 5px #000000; font-size: 1rem; padding: 5px; margin-right: 5px;"
                                            value="">Limpar
                                        </a>
                                        <a href="{{ route('contrato.index') }}" class="btn btn-primary"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px">
                                            Contratos
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <table {{-- Inicio da tabela de informacoes --}}
                                class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                id="tabela-materiais" class="display" style="width: 100%">
                                <thead style="text-align: center;">{{-- inicio header tabela --}}
                                    <tr style="background-color: #d6e3ff; font-size:15px; color:#000;" class="align-middle">
                                        <th>ID</th>
                                        <th>TIPO DÍVIDA</th>
                                        {{-- VAI VIRAR HINT
                                        <th>FORMA PAGAMENTO</th>
                                        <th>QTD. PARCELAS</th> --}}
                                        <th>CREDOR</th>
                                        <th>DATA FINAL</th>
                                        <th>PERENE</th>
                                        <th>VALOR</th>
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
                                            {{-- VAI VIRAR HINT
                                            <td>A Vista</td>
                                            <td>03/07</td> --}}
                                            <td>SIM</td>
                                            <td>01/01/2019</td>
                                            <td>NÃO</td>
                                            <td>R$100,00</td>
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
                                                <a href="/gerenciar-pagamento/pagar/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Pagar">
                                                    <i class="bi bi-currency-dollar"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Aditivo">
                                                    <i class="bi bi-bookmark-plus"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Contrato">
                                                    <i class="bi bi-paperclip"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-warning"
                                                    data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                    data-placement="top" title="Protelar">
                                                    <i class="bi bi-alarm"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-outline-danger" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Devolver">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- Fim body da tabela --}}
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
    </form>
@endsection
