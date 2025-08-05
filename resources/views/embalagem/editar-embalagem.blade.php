@extends('layouts.app')

@section('title')
    Editar Embalagens
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
                                Editar Embalagens
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5>Identificação do Material</h5>
                        <div style="display: flex; gap: 20px; align-items: flex-end;">
                            <div class="col-md-3"> Nome do Material
                                <input type="text" class="form-control" disabled value="{{ $itemMaterial->nome }}">
                            </div>
                            <div class="col-md-3"> Categoria do Material
                                <input type="text" class="form-control" disabled
                                    value="{{ $itemMaterial->tipoCategoriaMt->nome }}">
                            </div>
                            <div class="col-md-3"> Tipo do Material
                                <input type="text" class="form-control" disabled
                                    value="{{ $itemMaterial->tipoMaterial->nome }}">
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                    style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-left:5px"
                                    data-bs-target="#modalIncluirEmbalagem" style="font-size: 1rem; color:#303030"
                                    title="Incluir Embalagem">
                                    Novo+
                                </a>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row" style="margin-left:5px">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Embalagem</th>
                                        <th>QTD. Unidade Medida</th>
                                        <th>Unidade de Medida</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $results)
                                        <tr>
                                            <td>{{ $results->unidadeMedida2->nome ?? 'Não Possui' }}</td>
                                            <td>{{ $results->qtde_n1 }}</td>
                                            <td>{{ $results->unidadeMedida->nome ?? 'N/A' }}</td>
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
                                                    title="Editar" data-nome-id="{{ $results->id_un_med_n2 }}"
                                                    data-qtde="{{ $results->qtde_n1 }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-warning"
                                                    data-bs-toggle="modal" data-bs-target="#modalInativarEmbalagem"
                                                    style="font-size: 1rem; color:#303030" data-id="{{ $results->id }}"
                                                    title="Ativar/Inativar" data-ativo="{{ $results->ativo }}"
                                                    data-nome="{{ $results->unidadeMedida2->nome ?? 'N/A' }}"
                                                    data-qtde="{{ $results->qtde_n1 }}">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal" data-bs-target="#modalExcluirEmbalagem"
                                                    style="font-size: 1rem; color:#303030" data-id="{{ $results->id }}"
                                                    title="Excluir"
                                                    data-nome="{{ $results->unidadeMedida2->nome ?? 'N/A' }}"
                                                    data-qtde="{{ $results->qtde_n1 }}">
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
            </div>
        </div>
    </div>
    <br>
    <div class="row d-flex justify-content-around">
        <div class="col-4">
            <a href="{{ route('embalagem.index') }}">
                <button class="btn btn-primary" style="width: 100%">Retornar </button>
            </a>
        </div>
    </div>

    <x-modal-editar id="modalInativarEmbalagem" labelId="modalInativarEmbalagemLabel" title="Inativar Embalagem">
        <input type="hidden" name="id" id="inativar-id">
        <p id="modal-inativar-texto">
            <!-- Este conteúdo será substituído dinamicamente via JS -->
        </p>
    </x-modal-editar>
    <x-modal-Excluir id="modalExcluirEmbalagem" labelId="modalExcluirEmbalagemLabel" title="Excluir Embalagem">
        @method('DELETE')
        <input type="hidden" name="id" id="excluir-id">
        <p>
            <!-- Modal body -->
            Deseja realmente excluir a embalagem: <strong id="excluir-nome" style="color: red"></strong>. Com a quantidade
            <strong id="excluir-qtde" style="color: red"></strong>?
        </p>
    </x-modal-Excluir>
    <x-modal-incluir id="modalIncluirEmbalagem" labelId="modalIncluirEmbalagemLabel"
        action="{{ url('/gerenciar-embalagem/inserir/' . $itemMaterial->id) }}" title="Incluir Embalagem">
        <div class="row">
            {{-- <div class="col-md-5">QTD. na Embalagem nível 3
                <input name="qtdEmb3" id="qtdEmb3" type="number" class="form-control" style="margin-bottom: 10px;">
            </div>
            <div class="col-md-5">Embalagem de nível 3
                <select class="form-select  select2" id="embalagem3" style="border: 1px solid #999999; padding: 5px;"
                    name="embalagem3">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">QTD. na Embalagem niível 2
                <input name="qtdEmb2" id="qtdEmb2" type="number" class="form-control" style="margin-bottom: 10px;">
            </div>
            <div class="col-md-5">Embalagem de nível 2
                <select class="form-select  select2" id="embalagem2" style="border: 1px solid #999999; padding: 5px;"
                    name="embalagem2">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
            <div class="col-md-5">Embalagem
                <select class="form-select  select2" id="embalagem1" style="border: 1px solid #999999; padding: 5px;"
                    name="embalagem1">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">QTD. na Embalagem
                <input name="qtdEmb1" id="qtdEmb1" type="number" class="form-control" style="margin-bottom: 10px;"
                    value="1" disabled>
            </div>
            <div class="col-md-5">Unidade de Medida
                <input name="unidadeMedida" id="unidadeMedida" type="text" class="form-control" disabled
                    value="{{ $itemMaterial->unidadeMedida->nome }}">
            </div>
            <div class="col-md-5">QTD. da Unidade de Medida
                <input name="qtdUM" id="qtdUM" type="number" class="form-control">
            </div>
        </div>
    </x-modal-incluir>
    <x-modal-editar id="modalEditarEmbalagem" labelId="modalEditarEmbalagemLabel" title="Editar Embalagem">
        @method('PUT') {{-- para usar o método HTTP PUT --}}
        <input type="hidden" id="edit-id" name="id">
        <div class="row">
            {{-- <div class="col-md-5">QTD. na Embalagem nível 3
                <input name="qtdEmb3" id="qtdEmb3" type="number" class="form-control" style="margin-bottom: 10px;">
            </div>
            <div class="col-md-5">Embalagem de nível 3
                <select class="form-select  select2" id="embalagem3" style="border: 1px solid #999999; padding: 5px;"
                    name="embalagem3">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">QTD. na Embalagem niível 2
                <input name="qtdEmb2" id="qtdEmb2" type="number" class="form-control" style="margin-bottom: 10px;">
            </div>
            <div class="col-md-5">Embalagem de nível 2
                <select class="form-select  select2" id="embalagem2" style="border: 1px solid #999999; padding: 5px;"
                    name="embalagem2">
                    <option value="" disabled selected>Selecione...
                    </option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
            <div class="col-md-5">Embalagem
                <select class="form-select  select2" id="editEmbalagem1" style="border: 1px solid #999999; padding: 5px;"
                    name="editEmbalagem1">
                    <option value="" disabled selected></option>
                    @foreach ($embalagem as $embalagens)
                        <option value="{{ $embalagens->id }}">{{ $embalagens->sigla }} - {{ $embalagens->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">QTD. na Embalagem
                <input name="editQtdEmb1" id="editQtdEmb1" type="number" class="form-control"
                    style="margin-bottom: 10px;" value="1" disabled>
            </div>
            <div class="col-md-5">Unidade de Medida
                <input name="editUnidadeMedida" id="editUnidadeMedida" type="text" class="form-control" disabled
                    value="{{ $itemMaterial->unidadeMedida->nome }}">
            </div>
            <div class="col-md-5">QTD. da Unidade de Medida
                <input name="editQtdUM" id="editQtdUM" type="number" class="form-control">
            </div>
        </div>
    </x-modal-editar>

    <script>
        const modalInativar = document.getElementById('modalInativarEmbalagem');
        modalInativar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const qtde = button.getAttribute('data-qtde');
            const ativo = button.getAttribute('data-ativo');

            modalInativar.querySelector('#inativar-id').value = id;
            modalInativar.querySelector('form').action = `/gerenciar-embalagem/inativar/${id}`;

            const modalLabel = modalInativar.querySelector('#modalInativarEmbalagemLabel');
            const texto = modalInativar.querySelector('#modal-inativar-texto');

            if (ativo == '1') {
                modalLabel.textContent = 'Inativar Embalagem';
                texto.innerHTML =
                    `Deseja realmente <strong style="color:red">INATIVAR</strong> a embalagem: <strong style="color:red">${nome}</strong> com a quantidade <strong style="color:red">${qtde}</strong>?`;
            } else {
                modalLabel.textContent = 'Ativar Embalagem';
                texto.innerHTML =
                    `Deseja realmente <strong style="color:green">ATIVAR</strong> a embalagem: <strong style="color:green">${nome}</strong> com a quantidade <strong style="color:green">${qtde}</strong>?`;
            }
        });
    </script>
    <script>
        const modalExcluir = document.getElementById('modalExcluirEmbalagem');
        modalExcluir.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const qtde = button.getAttribute('data-qtde');

            modalExcluir.querySelector('#excluir-id').value = id;
            modalExcluir.querySelector('#excluir-nome').textContent = nome;
            modalExcluir.querySelector('#excluir-qtde').textContent = qtde;

            const form = modalExcluir.querySelector('form');
            form.action = `/gerenciar-embalagem/excluir/${id}`;
        });
    </script>
    <script>
        const modalEditar = document.getElementById('modalEditarEmbalagem');
        modalEditar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome-id');
            const qtde = button.getAttribute('data-qtde');

            modalEditar.querySelector('#edit-id').value = id;
            modalEditar.querySelector('#editEmbalagem1').value = nome;
            $('#editEmbalagem1').val(nome).trigger('change');
            modalEditar.querySelector('#editQtdUM').value = qtde;

            const form = modalEditar.querySelector('form');
            form.action = `/gerenciar-embalagem/atualizar/${id}`;
        });
    </script>
@endsection
