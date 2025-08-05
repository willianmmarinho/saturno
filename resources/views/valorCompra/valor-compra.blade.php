@extends('layouts.app')

@section('title')
    Valor de Compra
@endsection
@section('content')
    <form method="get" action="/valor-compra">{{-- Formulario de Inserção --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Valor de Compra </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Gerenciar Valor de Compra</h5>
                            <hr>
                             <!-- Campo Valor Máximo de compra -->
                             <div class="row mb-3 row">
                                <div class="col-md-4 col-sm-12">Valor Limite Máximo para Solicitação de <span class="text-danger">SERVIÇO</span> da DIADM
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="valorServDIADMId" name="valorServDIADM"
                                               style="border: 1px solid #999999; padding: 5px; background-color: white"
                                               value="{{ $valorServDIADM->valor }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">Valor Limite Máximo para Solicitação de <span class="text-danger">MATERIAL</span> da DIADM
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="valorMatDIADMId" name="valorMatDIADM"
                                               style="border: 1px solid #999999; padding: 5px; background-color: white"
                                               value="{{ $valorMatDIADM->valor }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 row">
                                <div class="col-md-4 col-sm-12">Valor Limite Máximo de Compra de <span class="text-danger">SERVIÇO</span> sem Necessidade de 3 Propostas
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="valorMaxId" name="valorMaxServ"
                                               style="border: 1px solid #999999; padding: 5px; background-color: white"
                                               value="{{ $valorMaxServ->valor }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">Valor Limite Máximo de Compra de <span class="text-danger">MATERIAL</span> sem Necessidade de 3 Propostas
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="valorMaxId" name="valorMaxMat"
                                               style="border: 1px solid #999999; padding: 5px; background-color: white"
                                               value="{{ $valorMaxMat->valor }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="botões">
            <a href="/valor-compra" type="button" value=""
                class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>
@endsection
