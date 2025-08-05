@extends('layouts.app')

@section('title')
    Incluir de Categoria
@endsection
@section('content')
    <form class="form-horizontal mt-4" method="POST" action="/cad-cat-material/inserir">
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Inserir Categoria do Material
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="categoria" class=" col-form-label">Nome da Categoria</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" value=""
                                            name="categoria" id="categoria" required
                                            oninvalid="this.setCustomValidity('Campo requerido')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="botões">
            <a href="/cad-cat-material" type="button" value=""
                class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
            <button type="submit" value="Confirmar" class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
            </button>
        </div>
    </form>
@endsection
