@extends('layouts.app')
@section('content')
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar Relação Depósito/Setor
            </div>
            <div class="card-body">
                <form action="{{ route('relacao-deposito-setor.update', ['id' => $relacao->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="id_deposito_id">Depósito</label>
                            <input type="hidden" name="deposito_id" value="{{ $relacao->id_deposito }}">
                            <select class="form-select" id="id_deposito_id" disabled>
                                @foreach ($depositos as $deposito)
                                    <option value="{{ $deposito->id }}"
                                        {{ $deposito->id == $relacao->id_deposito ? 'selected' : '' }}>
                                        {{ $deposito->nome }} - {{ $deposito->sigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="id_setor_id">Setor</label>
                            <select class="form-select select2" name="setor_id" id="id_setor_id">
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}"
                                        {{ $setor->id == $relacao->id_setor ? 'selected' : '' }}>
                                        {{ $setor->nome }} - {{ $setor->sigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-4">
                            <button class="btn btn-primary w-100" type="submit">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
