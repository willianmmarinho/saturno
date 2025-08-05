@extends('layouts.app')

@section('title')
    Criar Documento
@endsection
@section('content')
    <br>
    <div class="container">
        <div class="card">
            <h5 class="card-header">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <span style="color: ">Criar Documento</span>
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <p class="card-text">
                <form action="{{ route('documento.store') }}">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <label for="iddatadocumento" class="form-label">Data Do Documento</label>
                            <input class="form-control" type="date" name="documento[dt_doc]" id="iddatadocumento"
                                required>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <label for="idtipoDocumento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" class="form-select" id="idtipoDocumento" name="documento[id_tp_doc]"
                                required>
                                <option value=""></option>
                                @foreach ($tipos_documentos as $tipo_documento)
                                    <option value="{{ $tipo_documento->id }}">{{ $tipo_documento->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <label for="idvalor" class="form-label">Valor Documento</label>
                            <input type="number"class="form-control" name="documento[valor]" id="idvalor" step="0.01"
                                required>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <label for="idempresa" class="form-label">Empresa</label>
                            <select class="form-select" id="idempresa" name="documento[id_empresa]" required>
                                <option value=""></option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razaosocial }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label for="idsetor" class="form-label">Setor</label>
                            <select class="form-select select2" id="idsetor" name="documento[id_setor]" required>
                                <option value=""></option>
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->nome }} - {{ $setor->sigla }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="idvalidadedocumento" class="form-label">Data de Validade de Documento</label>
                            <input type="date" name="documento[dt_validade]" id="idvalidadedocumento"
                                class="form-control" required>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="idendarquivo" class="form-label">Endereço do Arquivo</label>
                                <input type="file" name="documento[end_arquivo]" id="idendarquivo"class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-md-3 col-sm-12">
                            <a href="{{ route('documento.index') }}" class="btn btn-outline-danger"
                                style="width: 100%">Cancelar

                            </a>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button type="submit" class="btn btn-outline-success" style="width: 100%">Enviar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
