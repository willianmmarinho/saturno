@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Gerenciar Depósitos</h5>
            </div>
            <div class="card-body">

                {{-- 1. Botões de ação e filtro --}}
                <div class="row mb-3 align-items-center">
                    {{-- Novo Depósito --}}


                    {{-- Formulário de Filtro --}}
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('deposito.index') }}" class="row g-2">
                            <div class="col-sm-3">
                                <label for="idnome">Nome:</label>
                                <input type="text" name="nome" value="{{ request('nome') }}" class="form-control"
                                    placeholder="Pesquisar Nome" id="idnome">
                            </div>
                            <div class="col-sm-2">
                                <label for="idsigla">Sigla</label>
                                <input type="text" name="sigla" value="{{ request('sigla') }}" class="form-control"
                                    placeholder="Pesquisar Sigla" id="idsigla">
                            </div>
                            <div class="col-sm-2">
                                <label for="idstatus">Tipo de Depósito</label>
                                <select name="ativo" class="form-select" id="idstatus">
                                    <option value="">-- Todos --</option>
                                    <option value="1" {{ request('ativo') === '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ request('ativo') === '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                            <div class="col-sm-2">

                                <button type="submit" class="btn btn-primary" style="width: 100%">Filtrar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('deposito.create') }}" class="btn btn-success w-100">
                                    Novo
                                </a>
                            </div>
                        </form>
                        {{-- Botão limpar filtros --}}
                        <div class="mt-2">
                            <a href="{{ route('deposito.index') }}" class="btn btn-secondary btn-sm">
                                Limpar Filtros
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. Tabela --}}
                <div class="table-responsive">
                    @if ($depositos->isEmpty())
                        <div class="alert alert-info">
                            Nenhum depósito encontrado com os filtros informados.
                        </div>
                    @else
                        <table
                            class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                            <thead class="text-center" style="background-color: #d6e3ff; color:#000;">
                                <tr>
                                    <th>Nome</th>
                                    <th>Sigla</th>
                                    <th>Sala</th>
                                    <th>Tipo de Depósito</th>
                                    <th>Ativo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depositos as $d)
                                    <tr>
                                        <td>{{ $d->nome }}</td>
                                        <td>{{ $d->sigla }}</td>
                                        <td>{{ optional($d->sala)->nome }}</td>
                                        <td>{{ optional($d->tipoDeposito)->nome }}</td>
                                        <td>{{ $d->ativo ? 'Sim' : 'Não' }}</td>
                                        <td class="text-center">

                                            {{-- Visualizar --}}
                                            <a href="{{ route('deposito.show', $d->id) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-search"></i>
                                            </a>

                                            @if ($d->ativo)
                                                {{-- Editar --}}
                                                <a href="{{ route('deposito.edit', $d->id) }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                {{-- Excluir --}}
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalExcluir{{ $d->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <x-modal-excluir :id="'modalExcluir' . $d->id" :labelId="'modalExcluirLabel' . $d->id" :action="route('deposito.delete', $d->id)"
                                                    title="Excluir Depósito: {{ $d->nome }}">
                                                    @method('DELETE')
                                                    <p>Deseja mesmo excluir o depósito
                                                        <strong>{{ $d->nome }}</strong>?
                                                    </p>
                                                </x-modal-excluir>
                                            @else
                                                {{-- Reativar --}}
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalReativar{{ $d->id }}">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                                <x-modal-reativar :id="'modalReativar' . $d->id" :labelId="'modalReativarLabel' . $d->id" :action="route('deposito.reativar', $d->id)"
                                                    title="Reativar Depósito: {{ $d->nome }}">
                                                    <p>Deseja mesmo reativar o depósito
                                                        <strong>{{ $d->nome }}</strong>?
                                                    </p>
                                                </x-modal-reativar>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- 3. Paginação --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $depositos->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
