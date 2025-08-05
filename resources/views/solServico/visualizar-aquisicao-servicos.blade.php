@extends('layouts.app')

@section('head')
    <title>Visualizar Solicitação de Serviço</title>
@endsection

@section('content')
    @csrf
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h5 class="col-12" style="color: #355089">
                                    Visualizar Solicitação de Serviços
                                </h5>
                            </div>
                            <div class="col">
                                <a href="javascript:history.back()">
                                    <button type="button" class="btn btn-danger btn-sm float-end remove-proposta">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <fieldset class="rounded p-4 position-relative"
                            style="margin-bottom: 20px; border: 1px #8f8181 solid">
                            <legend class="w-auto"
                                style="font-size: .9rem; padding: 0 10px; position: absolute; top: -12px; left: 20px; background: white; color: red">
                                Identificação do Serviço</legend>
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Id da Solicitação:
                                    </legend>
                                    {{ $solicitacao->id }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Prioridade:
                                    </legend>
                                    {{ $solicitacao->prioridade }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Status da Solicitação:
                                    </legend>
                                    {{ $solicitacao->tipoStatus->nome }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Motivo:
                                    </legend>
                                    {{ $solicitacao->motivo }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data de Criação:
                                    </legend>
                                    {{ $solicitacao->data }}
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Classe de Serviço:
                                    </legend>
                                    {{ $solicitacao->tipoClasse->descricao }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Tipo de Serviço:
                                    </legend>
                                    {{ $solicitacao->catalogoServico->descricao }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Setor Solicitante:
                                    </legend>
                                    {{ $solicitacao->setor->nome }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Setor Responsável por Acompanhar:
                                    </legend>
                                    {{ $solicitacao->respSetor->nome ?? '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Motivo da Recusa:
                                    </legend>
                                    {{ $solicitacao->motivo_recusa }}
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="rounded p-4 position-relative"
                            style="margin-bottom: 20px; border: 1px #8f8181 solid">
                            <legend class="w-auto"
                                style="font-size: .9rem; padding: 0 10px; position: absolute; top: -12px; left: 20px; background: white; color: red">
                                Nível de Autorização</legend>
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Autorização da Diretoria Responsável:
                                    </legend>
                                    {{ $solicitacao->aut_usu_dir ?? '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Autorização da DAF:
                                    </legend>
                                    {{ $solicitacao->aut_usu_daf ?? '-' }}
                                </div>

                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Autorização da DIADM:
                                    </legend>
                                    {{ $solicitacao->aut_usu_adm ?? '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Autorização da DIFIN:
                                    </legend>
                                    {{ $solicitacao->aut_usu_fin ?? '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Autorização do Presidente:
                                    </legend>
                                    {{ $solicitacao->aut_usu_pres ?? '-' }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data Autorização Diretoria:
                                    </legend>
                                    {{ $solicitacao->dt_usu_dir ? \Carbon\Carbon::parse($solicitacao->dt_usu_dir)->format('d/m/Y') : '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data Autorização DAF:
                                    </legend>
                                    {{ $solicitacao->dt_usu_daf ? \Carbon\Carbon::parse($solicitacao->dt_usu_daf)->format('d/m/Y') : '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data Autorização ADM:
                                    </legend>
                                    {{ $solicitacao->dt_usu_adm ? \Carbon\Carbon::parse($solicitacao->dt_usu_adm)->format('d/m/Y') : '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data Autorização DIFIN:
                                    </legend>
                                    {{ $solicitacao->dt_usu_fin ? \Carbon\Carbon::parse($solicitacao->dt_usu_fin)->format('d/m/Y') : '-' }}
                                </div>
                                <div class="col">
                                    <legend class="schedule-border"
                                        style="font-size: small; width:inherit; font-weight: bold;">
                                        Data Autorização Presidente:
                                    </legend>
                                    {{ $solicitacao->dt_usu_pres ? \Carbon\Carbon::parse($solicitacao->dt_usu_pres)->format('d/m/Y') : '-' }}
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="rounded p-4 position-relative" style="border: 1px #8f8181 solid">
                            <legend class="w-auto"
                                style="font-size: .9rem; padding: 0 10px; position: absolute; top: -12px; left: 20px; background: white; color: red">
                                Documentos Relacionados
                            </legend>
                            @foreach ($documentos as $doc)
                                <div class="row" style="margin-bottom: 20px">
                                    <div class="col">
                                        <legend class="schedule-border" style="font-size: small; font-weight: bold;">
                                            Documento ID:
                                        </legend>
                                        {{ $doc->id }}
                                    </div>
                                    <div class="col">
                                        <legend class="schedule-border" style="font-size: small; font-weight: bold;">
                                            Empresa:
                                        </legend>
                                        {{ $doc->id_empresa }}
                                    </div>
                                    <div class="col">
                                        <legend class="schedule-border" style="font-size: small; font-weight: bold;">
                                            Valor:
                                        </legend>
                                        {{ $doc->valor }}
                                    </div>
                                    <div class="col">
                                        <legend class="schedule-border" style="font-size: small; font-weight: bold;">
                                            Data de Validade:
                                        </legend>
                                        {{ $doc->dt_validade }}
                                    </div>
                                    <div class="col">
                                        <legend class="schedule-border" style="font-size: small; font-weight: bold;">
                                            Arquivo:
                                        </legend>
                                        @if (isset($doc->arquivo_url))
                                            <a href="{{ $doc->arquivo_url }}" target="_blank">Ver Arquivo</a>
                                        @else
                                            Não disponível
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <br>
    <div class="row d-flex justify-content-around">
        <div class="col" style="margin-left: 10px">
            <a href="javascript:history.back()">
                <button class="btn btn-danger col-md-1 col-2">Fechar</button>
            </a>
        </div>
    </div>
    <br>
    <button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <style>
        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }
    </style>
    <script>
        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
@endsection
