@extends('layouts.app')

@section('title')
    Gerenciar Documentos
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Gerenciar Documentos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-sm-12">Numero
                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="11"
                            type="text" id="1" name="cpf" value=>
                    </div>
                    <div class="col-md-2 col-sm-12">Data Do Documento
                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="9"
                            type="date" id="2" name="idt" value="">
                    </div>
                    <div class="col-md-2 col-sm-12">Data De Validade
                        <input class="form-control" style="border: 1px solid #999999; padding: 5px;" maxlength="9"
                            type="date" id="2" name="idt" value="">
                    </div>
                    <div class="col-md-2 col-sm-12">Tipo Documento
                        <select class="form-select custom-select" style="border: 1px solid #999999; padding: 5px;"
                            id="4" name="status" type="number">
                          
                        </select>
                    </div>
                    <div class="col" style="margin-top: 20px">
                        <a href="" class="btn btn-light btn-sm"
                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="button"
                            value="">
                            Limpar
                        </a>
                        <input class="btn btn-light btn-sm"
                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit"
                            value="Pesquisar">
                        <a href="{{ route('documento.create') }}" class="btn btn-success btn-sm" type="button"
                            name="6" value="Novo Cadastro +"
                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;">Incluir Novo Documento
                        </a>
                    </div>
                </div>
                <hr>

                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Data do Documento</th>
                            <th>Valor</th>
                            <th>Tipo de Documento</th>
                            <th>Empresa</th>
                            <th>Setor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemplo de dados; devem ser populados dinamicamente -->
                        @foreach ($lista_de_documentos as $documento)
                            <tr>
                                <td>{{ $documento->numero }}</td>
                                <td>{{ \Carbon\Carbon::parse($documento->dt_doc)->format('d-m-Y') }}</td>
                                <td>{{ $documento->dt_doc }}</td>
                                <td>R$ {{ number_format($documento->valor, 2, ',', '.') }}</td>
                                <td>{{ $documento->empresa->razaosocial ?? 'N/A' }}</td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
