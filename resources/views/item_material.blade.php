@extends('layouts.master')

@section('title') Gerar código @endsection

@section('content')

    <div>
        <a href="/gerenciar-cadastro-inicial">
            <input class="btn btn-danger" type="button" value="Cancelar">
        </a>
        <a href="">
            <input class="btn btn-success" onclick="cont();" type="button" value="Imprimir">
        </a>
    </div>
        <script>
            function cont(){
               var conteudo = document.getElementById('print').innerHTML;
               tela_impressao = window.open('about:blank');
               tela_impressao.document.write(conteudo);
               tela_impressao.window.print();
               tela_impressao.window.close();
            }
        </script>
    <div id='print' class='conteudo'>
        @foreach($itens as $p)
        <div class="Col" style="font-size: 14px; color:#000; text-align: center;font-weight:bold;">
            {!! DNS1D::getBarcodeSVG($p->id, 'C128', 2, 40)!!}
            {{$p->nomei}}-{{$p->nomem}}-{{$p->observacao}}<br>
            {{number_format($p->valor_venda, 2,',','.')}}
        </div>
        @endforeach
    </div>
@endsection


