@extends('layouts.app')

@section('title')
    Catálogo de Empresas
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
                                Catálogo de Empresas
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="/catalogo-empresa">{{-- Formulario de Inserção --}}
                            @csrf
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                <div class="col-md-2 col-sm-12">Razão Social
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                        maxlength="50" type="text" id="" name="razaoSocial" value="">
                                </div>
                                <div class="col-md-2 col-sm-12">Nome Fantasia
                                    <input class="form-control" style="border: 1px solid #999999; padding: 5px;"
                                        maxlength="50" type="text" id="" name="nomeFantasia" value="">
                                </div>
                                <div class="col" style="margin-top: 20px">
                                    <input class="btn btn-light btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit"
                                        value="Pesquisar">
                                    <a href="/catalogo-empresa" class="btn btn-light btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="button"
                                        value="">
                                        Limpar
                                    </a>
                                    <a href="/incluir-empresa">
                                        <input class="btn btn-success btn-sm" type="button" name="novo" value="Novo+"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;">
                                    </a>
                                </div>
                            </div>
                        </form>{{-- Final Formulario de Inserção --}}
                        <br>
                        <hr>
                        <table {{-- Inicio da tabela de informacoes --}}
                            class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                            <thead style="text-align: center; ">{{-- inicio header tabela --}}
                                <tr style="background-color: #d6e3ff; color:#000;" class="align-middle">
                                    <th>RAZÃO SOCIAL</th>
                                    <th>NOME FANTASIA</th>
                                    <th>CNPJ-CPF</th>
                                    <th>UF</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>{{-- Fim do header da tabela --}}
                            <tbody style="color:#000000; text-align: center;">{{-- Inicio body tabela --}}
                                @foreach ($empresa as $empresas)
                                    <tr>
                                        <td>{{ $empresas->razaosocial }}</td>
                                        <td>{{ $empresas->nomefantasia }}</td>
                                        <td>{{ $empresas->cnpj_cpf }}</td>
                                        <td>{{ $empresas->ModelTipoUf->extenso }}</td>
                                        <td>
                                            <a href="/editar-empresa/{{ $empresas->id }}"
                                                class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                style="font-size: 1rem; color:#303030" data-placement="top" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#A{{ $empresas->id }}" class="btn btn-outline-danger btn-sm"
                                                data-bs-placement="top" title="Excluir"><i class="bi bi-trash"
                                                    style="font-size: 1rem; color:#303030;"></i></button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="A{{ $empresas->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ url('/deletar-empresa/' . $empresas->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color:#DC4C64;">
                                                                <h5 class="modal-title" id="exampleModalLabel"
                                                                    style=" color:rgb(255, 255, 255)">Excluir Empresa
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" style="text-align: center">
                                                                Você realmente deseja excluir <br><span
                                                                    style="color:#DC4C64; font-weight: bold">{{ $empresas->nomefantasia }}</span>
                                                                ?

                                                            </div>
                                                            <div class="modal-footer mt-2">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Confirmar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--Fim Modal-->
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
@endsection
