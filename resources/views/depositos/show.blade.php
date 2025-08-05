@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Detalhes do Depósito
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    @method('PUT') <!-- O método PUT será ignorado, pois estamos apenas exibindo -->

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="id_nome" class="form-label">Nome do Depósito</label>
                            <input type="text" name="nome" id="id_nome" class="form-control"
                                value="{{ $deposito->nome }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_sigla" class="form-label">Sigla</label>
                            <input type="text" name="sigla" id="id_sigla" class="form-control"
                                value="{{ $deposito->sigla }}" disabled>
                        </div>

                        <div class="col-md-3">
                            <label for="id_tipo_deposito" class="form-label">Tipo de Depósito</label>
                            <select name="tipo_deposito" id="id_tipo_deposito" class="form-select" disabled>
                                @foreach ($tipo_deposito as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ $deposito->id_tp_deposito == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="id_sala" class="form-label">Sala</label>
                            <select name="sala" id="id_sala" class="form-select" disabled>
                                @foreach ($sala as $s)
                                    <option value="{{ $s->id }}"
                                        {{ $deposito->id_sala == $s->id ? 'selected' : '' }}>
                                        {{ $s->nome }} - {{ $s->numero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <label for="id_comprimento" class="form-label">Comprimento (m)</label>
                            <input type="number" name="comprimento" id="id_comprimento" step="0.01" min="0"
                                class="form-control" value="{{ $deposito->comprimento }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_largura" class="form-label">Largura (m)</label>
                            <input type="number" name="largura" id="id_largura" step="0.01" min="0"
                                class="form-control" value="{{ $deposito->largura }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_altura" class="form-label">Altura (m)</label>
                            <input type="number" name="altura" id="id_altura" step="0.01" min="0"
                                class="form-control" value="{{ $deposito->altura }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_largura_porta" class="form-label">Largura Porta (m)</label>
                            <input type="number" name="largura_porta" id="id_largura_porta" step="0.01" min="0"
                                class="form-control" value="{{ $deposito->largura_porta }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_altura_porta" class="form-label">Altura Porta (m)</label>
                            <input type="number" name="altura_porta" id="id_altura_porta" step="0.01" min="0"
                                class="form-control" value="{{ $deposito->altura_porta }}" disabled>
                        </div>

                        <div class="col-md-2">
                            <label for="id_capacidade" class="form-label">Capacidade (m³)</label>
                            <input type="number" id="id_capacidade" class="form-control"
                                value="{{ $deposito->capacidade_volume }}" disabled>
                        </div>
                    </div>

                    <div class="row g-3 justify-content-around">
                        <div class="col-md-3">
                            <a href="{{ route('deposito.index') }}" class="btn btn-danger w-100">Voltar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
