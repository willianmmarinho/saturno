@extends('layouts.app')
@section('content')
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Incluir Relação Depósito/Setor
            </div>
            <div class="card-body">

                <p class="card-text">
                <form action="{{ route('relacao-deposito-setor.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="id_deposito_id">Depósito</label>
                            <select class="form-select select2" name="deposito_id" id="id_deposito_id">
                                @foreach ($depositos as $deposito)
                                    <option value="{{ $deposito->id }}">{{ $deposito->nome }} - {{ $deposito->sigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="id_setor_id">Setor</label>
                            <select class="form-select select2" name="setor_id" id="id_setor_id">
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->nome }} - {{ $setor->sigla }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <button class="btn btn-primary" style="width: 100%" type="submit">Adicionar</button>
                        </div>
                    </div>
                </form>
                </p>
            </div>
        </div>
    </div>
@endsection
