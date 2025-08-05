@extends('layouts.app')

@section('title')
    Gerenciar unidade medida
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
                                Cadastro de Unidade de Medida
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('unidade-medida.index') }}">
                            @csrf
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                <div class="col-md-2 col-sm-12">Nome da Unidade de Medida
                                    <br>
                                    <input class="form-control" type="text" id="nomeUM" name="nomeUM"
                                        value="{{ request('nomeUM') }}">
                                </div>
                                <div class="col-md-2 col-sm-12">Sigla da Unidade de Medida
                                    <input class="form-control" type="text" id="siglaUM" name="siglaUM"
                                        value="{{ request('siglaUM') }}">
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
                                    <a href="/unidade-medida" type="button" class="btn btn-light btn-sm"
                                        style="box-shadow: 1px 2px 5px #000000; font-size: 1rem" value="">Limpar</a>
                                </div>
                            </div>
                        </form>
                        <br>
                        <hr>
                        <form class="form-horizontal" method="POST" action="/unidade-medida/inserir">
                            @csrf
                            <div class="row" style="margin-left:5px">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-3 col-sm-12">
                                        Nova Unidade
                                        <input class="form-control" type="text" id="unidade_med" name="unidade_med"
                                            required>
                                    </div>
                                    <div class="col-md-1 col-sm-12">
                                        Sigla
                                        <input class="form-control" type="text" id="sigla" name="sigla" required>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <button type="submit" class="btn btn-success">CADASTRAR</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <h5>Lista de Unidade de Medida</h5>
                        <div class="row">
                            <div class="col-12">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Unidade de Medida</th>
                                            <th>Sigla</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($result as $results)
                                            <tr>
                                                <td>{{ $results->id }}</td>
                                                <td>{{ $results->nome }}</td>
                                                <td>{{ $results->sigla }}</td>
                                                <td>
                                                    @if ($results->ativo == 1)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarEmbalagem"
                                                        style="font-size: 1rem; color:#303030" data-id="{{ $results->id }}"
                                                        title="Editar" data-nome="{{ $results->nome }}"
                                                        data-sigla="{{ $results->sigla }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal" data-bs-target="#modalInativarEmbalagem"
                                                        style="font-size: 1rem; color:#303030"
                                                        data-id="{{ $results->id }}" title="Ativar/Inativar"
                                                        data-nome="{{ $results->nome }}"
                                                        data-ativo="{{ $results->ativo }}"
                                                        data-sigla="{{ $results->sigla }}">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#modalExcluirEmbalagem"
                                                        style="font-size: 1rem; color:#303030"
                                                        data-id="{{ $results->id }}" title="Excluir"
                                                        data-nome="{{ $results->nome }}"
                                                        data-sigla="{{ $results->sigla }}">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endForeach
                                    </tbody>
                                </table>
                            </div>
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

    <x-modal-editar id="modalEditarEmbalagem" labelId="modalEditarEmbalagemLabel" title="Editar Unidade de Medida">
        @method('PUT') {{-- para usar o método HTTP PUT --}}
        <input type="hidden" id="edit-id" name="id">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                Nome da Unidade de Medida
                <input class="form-control" type="text" id="edit-nome" name="unidade_med" required>
            </div>
            <div class="col-md-2 col-sm-12">
                Sigla
                <input class="form-control" type="text" id="edit-sigla" name="sigla" required>
            </div>
        </div>
    </x-modal-editar>
    <x-modal-editar id="modalInativarEmbalagem" labelId="modalInativarEmbalagemLabel" title="Inativar Unidade de Medida">
        <input type="hidden" name="id" id="inativar-id">
        <p id="modal-inativar-um-texto">
            <!-- Conteúdo dinâmico via JS -->
        </p>
    </x-modal-editar>
    <x-modal-excluir id="modalExcluirEmbalagem" labelId="modalExcluirEmbalagemLabel" title="Excluir Unidade de Medida">
        <input type="hidden" name="id" id="excluir-id">
        <p>
            Deseja realmente excluir a unidade de medida: <strong id="excluir-nome" style="color: red"></strong>. Com a
            sigla: <strong id="excluir-sigla" style="color: red"></strong>?
        </p>
    </x-modal-excluir>
    <script>
        const modalEditar = document.getElementById('modalEditarEmbalagem');
        modalEditar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const sigla = button.getAttribute('data-sigla');

            modalEditar.querySelector('#edit-id').value = id;
            modalEditar.querySelector('#edit-nome').value = nome;
            modalEditar.querySelector('#edit-sigla').value = sigla;

            const form = modalEditar.querySelector('form');
            form.action = `/unidade-medida/alterar/${id}`;
        });
    </script>
    <script>
        const modalInativar = document.getElementById('modalInativarEmbalagem');
        modalInativar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const sigla = button.getAttribute('data-sigla');
            const ativo = button.getAttribute('data-ativo');

            modalInativar.querySelector('#inativar-id').value = id;
            modalInativar.querySelector('form').action = `/unidade-medida/inativar/${id}`;

            const label = modalInativar.querySelector('#modalInativarEmbalagemLabel');
            const texto = modalInativar.querySelector('#modal-inativar-um-texto');

            if (ativo == '1') {
                label.textContent = 'Inativar Unidade de Medida';
                texto.innerHTML =
                    `Deseja realmente <strong style="color:red">INATIVAR</strong> a unidade de medida: <strong style="color:red">${nome}</strong> com a sigla <strong style="color:red">${sigla}</strong>?`;
            } else {
                label.textContent = 'Ativar Unidade de Medida';
                texto.innerHTML =
                    `Deseja realmente <strong style="color:green">ATIVAR</strong> a unidade de medida: <strong style="color:green">${nome}</strong> com a sigla <strong style="color:green">${sigla}</strong>?`;
            }
        });
    </script>
    <script>
        const modalExcluir = document.getElementById('modalExcluirEmbalagem');
        modalExcluir.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const sigla = button.getAttribute('data-sigla');

            modalExcluir.querySelector('#excluir-id').value = id;
            modalExcluir.querySelector('#excluir-nome').textContent = nome;
            modalExcluir.querySelector('#excluir-sigla').textContent = sigla;

            const form = modalExcluir.querySelector('form');
            form.action = `/unidade-medida/excluir/${id}`;
        });
    </script>
@endsection
