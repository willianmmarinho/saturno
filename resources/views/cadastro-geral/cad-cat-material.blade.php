@extends('layouts.app')

@section('title')
    Cadastro categoria
@endsection

@section('content')
    <form method="GET" action="/cad-cat-material">{{-- Formulario de pesquisa --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Cadastrar Categoria
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="/catalogo-empresa">{{-- Formulario de Inserção --}}
                                @csrf
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-2 col-sm-12">Categoria
                                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                            maxlength="50" type="text" id="" name="razaoSocial" value="">
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light btn-sm "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px;"{{-- Botao submit do formulario de pesquisa --}}
                                            type="submit">Pesquisar
                                        </button>
                                        <a href="/cad-cat-material" type="button" class="btn btn-light btn-sm"
                                            style="box-shadow: 1px 2px 5px #000000; font-size: 1rem"
                                            value="">Limpar</a>
                                        <a href='/cad-cat-material/incluir' class="btn btn-success"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-left:5px">
                                            Novo+
                                        </a>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <hr>
                            <table {{-- Inicio da tabela de informacoes --}}
                                class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                id="tabela-materiais" style="width: 100%">
                                <thead style="text-align: center;">{{-- inicio header tabela --}}
                                    <tr style="background-color: #d6e3ff; font-size:15px; color:#000;" class="align-middle">
                                        <th>ID</th>
                                        <th>TIPO</th>
                                        <th>AÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 15px; color:#000000; text-align: center;">
                                    @foreach ($result as $results)
                                        <tr>
                                            <td>{{ $results->id }}</td>
                                            <td>{{ $results->nome }}</td>
                                            <td>
                                                <a href="/cad-cat-material/alterar/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/cad-cat-material/excluir/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-danger" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-right: 10px; margin-left: 10px">
                            {{ $result->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('cadastro-geral/popUp-alterar')
    @endsection

    @section('footerScript')
        <!-- Required datatable js -->
        <script src="{{ URL::asset('/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ URL::asset('/js/pages/datatables.init.js') }}"></script>
        <script src="{{ URL::asset('/js/pages/cad-tipo-material.init.js') }}"></script>
    @endsection
