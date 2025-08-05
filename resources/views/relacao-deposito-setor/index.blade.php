@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <br>
    <div class="container">
        <div class="card shadow-sm">
            <h5 class="card-header text-primary">Gerenciar Relação Depósito/Setor</h5>
            <div class="card-body">
                <form>
                    <div class="row g-3 align-items-end mb-3">
                        <div class="col-12 col-md-4">
                            <label for="id_setor_id" class="form-label">Setor</label>
                            <select class="form-select select2 w-100" name="setor_id" id="id_setor_id">
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->nome }} - {{ $setor->sigla }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="id_deposito_id" class="form-label">Depósito</label>
                            <select class="form-select select2 w-100" name="deposito_id" id="id_deposito_id">
                                @foreach ($depositos as $deposito)
                                    <option value="{{ $deposito->id }}">{{ $deposito->nome }} - {{ $deposito->sigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-3 d-grid">
                            <label class="form-label invisible">Novo</label>
                            <a href="{{ route('relacao-deposito-setor.create') }}" class="btn btn-success w-100">
                                Novo
                            </a>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                        <thead class="text-dark text-center">
                            <tr>
                                <th scope="col">Depósito</th>
                                <th scope="col">Setor Responsável</th>
                                <th scope="col">Data Início Responsabilidade</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($relacoes_deposito_setor as $relacao)
                                <tr>
                                    <td>{{ $relacao->Deposito->nome }}</td>
                                    <td>{{ $relacao->Setor->nome }}</td>
                                    <td>{{ $relacao->dt_inicio ? Carbon::parse($relacao->dt_inicio)->format('d/m/Y') : '--' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('relacao-deposito-setor.show', $relacao->id) }}"
                                            class="btn btn-outline-primary btn-sm me-1" title="Visualizar">
                                            <i class="bi bi-search"></i>
                                        </a>
                                        <a href="{{ route('relacao-deposito-setor.edit', $relacao->id) }}"
                                            class="btn btn-outline-warning btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
