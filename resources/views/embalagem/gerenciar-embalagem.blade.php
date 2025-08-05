@extends('layouts.app')

@section('title')
    Gerenciar Embalagens
@endsection

@section('content')
    <div class="container-fluid"> {{-- Container completo da página  --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="row">
                            <h5 class="col-12" style="color: #355089">
                                Gerenciar Embalagens
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="GET" action="{{ route('embalagem.index') }}">
                            @csrf
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                <div class="col-md-2 col-sm-12">Categoria do Material
                                    <br>
                                    <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                        id="categoria" name="categoria">
                                        <option value=""></option>
                                        @foreach ($categoria as $categorias)
                                            <option value="{{ $categorias->id }}" {{ old('categoria') }}>
                                                {{ $categorias->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">Nome Item Material
                                    <select class="form-select select2" style="border: 1px solid #999999; padding: 5px;"
                                        id="nomeMaterial" name="nomeMaterial">
                                        <option value=""></option>
                                        @foreach ($nomeMaterial as $nomeMaterials)
                                            <option value="{{ $nomeMaterials->id }}" {{ old('nomeMaterial') }}>
                                                {{ $nomeMaterials->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    Status
                                    <select class="form-control select2" id="status" name="status">
                                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Todos
                                        </option>
                                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo
                                        </option>
                                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>
                                            Inativo</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-light btn-sm "
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px;"{{-- Botao submit do formulario de pesquisa --}}
                                        type="submit">Pesquisar
                                    </button>
                                    <a href="/gerenciar-embalagem" type="button" class="btn btn-light btn-sm"
                                        style="box-shadow: 1px 2px 5px #000000; font-size: 1rem" value="">Limpar</a>
                                </div>
                            </div>
                        </form>
                        <br>
                        <hr>
                        <div class="row" style="margin-left:5px">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Item Material</th>
                                        <th>Unidade de Medida</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($result as $results)
                                        <tr>
                                            <td>{{ $results->id ?? 'N/A' }}</td>
                                            <td>{{ $results->nome ?? 'N/A' }}</td>
                                            <td>{{ $results->unidadeMedida->sigla ?? '' }} -
                                                {{ $results->unidadeMedida->nome ?? '' }}</td>
                                            <td>
                                                @if ($results->ativo == 1)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-danger">Inativo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/gerenciar-embalagem/alterar/{{ $results->id }}"
                                                    class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Editar Embalagens">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endForeach
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
    {{-- Botões Confirmar e Cancelar --}}
    <div class="botões">
        <a href="/gerenciar-cadastro-inicial" class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
        <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
        </button>
    </div>
@endsection
