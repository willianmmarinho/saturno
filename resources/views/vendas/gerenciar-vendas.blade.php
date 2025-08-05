@extends('layouts.master')

@section('title') Gerenciar Vendas @endsection

@section('content')

<div clas="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container"  style="background-color: #fff">
                <form action="{{route('vendas.index')}}" class="form-horizontal mt-4" method="GET" >
                    @csrf
                <div class="row align-items-center">
                    <div class="col">Início
                        <input type="date" name="data_inicio" value="{{$data_inicio}}">
                    </div>
                    <div class="col">Fim
                        <input type="date" name="data_fim"  value="{{$data_fim}}">
                    </div>
                    <div class="col-2">Situação:
                        <select class="form-control"id="sit" name="situacao" ><option></option>
                        @Foreach($resultSitVenda as $resultSitVendas)
                            <option value="{{$resultSitVendas->id}}" {{$resultSitVendas->id == $situacao ? 'selected' : ''}}>{{$resultSitVendas->nome}}</option>
                        @endForeach
                        </select>
                    </div>
                    <div class="col-4">Nome do cliente:
                        <input class="form-control" type="text" name="cliente" id="cliente" value="{{$cliente}}"/>
                    </div>
                    <div class="col-3">ID venda:
                        <input class="form-control" type="numeric" name="id_venda" id="id_venda" value=""/>
                    </div>
                </div>
                <br>
                <div class="row" style="text-align: right;">
                    <div class="col">
                        <input class="btn btn-light" type="submit" style="box-shadow: 1px 2px 5px #000000;  margin:5px;" value="Pesquisar">
                        <a href="/gerenciar-vendas"><input class="btn btn-light" style="box-shadow: 1px 2px 5px #000000; margin:5px;" type="button" value="Limpar"></a>
                </form>
                        <a href="/registrar-venda"><input class="btn btn-success" style="font-weight:bold; font-size:15px; box-shadow: 1px 2px 5px #000000; margin:5px;" type="button" value="Nova venda +"></a>
                    </div>
                </div>
            </div>
            <hr>

        <div class="row">
            <div class="col-12">
                    <h4 class="card-title" style="color:red; text-align: left;">Listar as vendas</h4>Quantidade filtrada: {{$contar}}
                        <table id="datatable" class="table-resposive-sm table-bordered table-striped table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style='text-align:center;vertical-align:middle'>
                                <tr style="text-align:center; background-color:#c6e6ce">
                                    <th>ID</th>
                                    <th>DATA</th>
                                    <th>CLIENTE</th>
                                    <th>VENDEDOR</th>
                                    <th>VALOR</th>
                                    <th>SITUAÇÃO</th>
                                    <th class="col-3">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody style='text-align:center;vertical-align:middle'>
                            @foreach($result as $results)
                                <tr>
                                    <td>{{$results->id}}</td>
                                    <td>{{ date( 'd/m/Y' , strtotime($results->data))}}</td>
                                    <td>{{$results->nome_cliente}}</td>
                                    <td>{{$results->nome_usuario}}</td>
                                    <td>{{number_format($results->valor,2,',','.')}}</td>
                                    <td>{{$results->sit_venda}}</td>
                                    <td>
                                        @if ($results->id_tp_situacao_venda == 4)
                                        <a href="/registrar-venda-editar/{{$results->id}}"><input class="btn btn-warning btn-sm" type="button" style="font-size:11px;" value="Alterar" disabled="">
                                        </a>
                                        <a href="/gerenciar-vendas/excluir/{{$results->id}}"><input class="btn btn-danger btn-sm" type="button" style="font-size:11px;" value="Excluir" data-toggle="modal" data-target="#modalExemplo" disabled="">
                                        </a>
                                        <a>
                                            <a href="/gerenciar-pagamentos/{{$results->id}}"><input class="btn btn-success btn-sm" type="button" style="font-size:11px;" value="Pagar" disabled="">
                                        </a>
                                        <a href="/demonstrativo/{{$results->id}}"  type="button" style="font-size:11px;" class="btn btn-info btn-sm">Recibo</a>
                                        @else
                                        <a href="/registrar-venda-editar/{{$results->id}}"><input class="btn btn-warning btn-sm" type="button" style="font-size:11px;" value="Alterar">
                                        </a>
                                        <a href="/gerenciar-vendas/excluir/{{$results->id}}"><input class="btn btn-danger btn-sm" type="button" style="font-size:11px;" value="Excluir" data-toggle="modal" data-target="#modalExemplo">
                                        </a>
                                        <a>
                                            <a href="/gerenciar-pagamentos/{{$results->id}}"><input class="btn btn-success btn-sm" type="button" style="font-size:11px;" value="Pagar">
                                        </a>
                                        <a href="/demonstrativo/{{$results->id}}"  type="button" style="font-size:11px;" class="btn btn-info btn-sm">Recibo</a>
                                        @endif

                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="d-flex justify-content-center">
                    {{$result->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- end col -->
<!--
    **********************************************************************************************************************************
    * MODAL
    **********************************************************************************************************************************
   
    <div class="modal" id="modalExemplo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Excluir venda</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>A venda foi excluida com sucesso.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div> -->
@endsection
@section('footerScript')

            <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
            <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>
            <!-- Datatable init js -->
            <script src="{{ URL::asset('/js/pages/datatables.init.js')}}"></script>
            <script src="{{ URL::asset('/libs/select2/select2.min.js')}}"></script>
            <script src="{{ URL::asset('/js/pages/form-advanced.init.js')}}"></script>
            
@endsection
