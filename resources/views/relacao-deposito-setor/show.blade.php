@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header" style="color:blue">Gerenciar Relação Depósito/Setor</h5>
            <div class="card-body">
                <p class="card-text">
                <div class="row justify-content-beteween">
                    <div class="col-sm-12 col-md-3">
                    </div>
                    <div class="col-sm-12 col-md-3"></div>
                </div>
                <hr>
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead>
                        <tr style="background-color: #d6e3ff; font-size:14px; color:#000000">

                            <th scope="col">Setor Responsavel</th>
                            <th scope="col">Data Inicio Responsabilidade</th>
                            <th scope="col">Data Fim Responsabilidade</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relacoes as $relacao)
                            <tr>

                                <td>{{ $relacao->Setor->nome }}</td>
                                <td scope="col">
                                    {{ $relacao->dt_inicio ? Carbon::parse($relacao->dt_inicio)->format('d/m/Y') : '--' }}
                                </td>
                                <td scope="col">
                                    {{ $relacao->dt_fim ? Carbon::parse($relacao->dt_fim)->format('d/m/Y') : '--' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </p>
            </div>
        </div>
    </div>
@endsection
