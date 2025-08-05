@extends('layouts.app')

@section('title')
    Gerenciar item
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
                                Gerenciar Item no Catálogo
                            </h5>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="ROW" style="margin-left:5px">
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                <a href="/item-catalogo-incluir" class="btn btn-success"
                                    style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-left:5px">
                                    Novo+
                                </a>
                            </div>
                            <br>
                            <hr>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOME</th>
                                        <th>CATEGORIA</th>
                                        <th>VALOR MÍNIMO</th>
                                        <th>VALOR MÉDIO</th>
                                        <th>VALOR MÁXIMO</th>
                                        <th>VALOR MARCA</th>
                                        <th>VALOR ETIQUETA</th>
                                        <th>ITEM COMPOSIÇÃO</th>
                                        <th>ATIVO</th>
                                        <th>AÇÕES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($result as $results)
                                        <tr>
                                            <td>{{ $results->id }}</td>
                                            <td>{{ $results->nome }}</td>
                                            <td>{{ $results->nome_categoria }}</td>
                                            <td>{{ number_format($results->valor_minimo, 2, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($results->valor_medio, 2, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($results->valor_maximo, 2, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($results->valor_marca, 2, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($results->valor_etiqueta, 2, ',', '.') }}
                                            </td>
                                            <td>{{ $results->composicao ? 'sim' : 'não' }}</td>
                                            <td>{{ $results->ativo ? 'sim' : 'não' }}</td>
                                            <td>
                                                <a href="/item-catalogo/alterar/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/item-catalogo/excluir/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-danger" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Aditivo">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="margin-right: 10px; margin-left: 10px">
                        {{ $result->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('footerScript')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ URL::asset('/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/js/pages/form-advanced.init.js') }}"></script>
@endsection
