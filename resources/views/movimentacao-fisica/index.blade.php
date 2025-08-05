@extends('layouts.app')
@section('content')
    <div class="container">
        <br>
        <div class="card">
            <h5 class="card-header">Gerenciar Movimentação Fisica</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12"></div>
                </div>
                <hr>

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <a href="{{ route('movimentacao-fisica.solicitar-teste') }}" class="btn btn-info" >Solicitar Teste</a>
                        </div>
                    </div>
                    <br>
                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
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
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
@endsection
