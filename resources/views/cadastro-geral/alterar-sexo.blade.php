<form class="form-horizontal mt-4" method="POST" action="cad-sexo/atualizar/{{$resultSexo[0]->id}}">
@csrf
@method('PUT')
    <div class="form-group">
        <div class="row">
            <label for="sexo" class="col-sm-2 col-form-label">Novo Sexo</label>
            <div class="col-sm-6">
                <input class="form-control" value="{{$resultSexo[0]->nome}}" type="text" value="" id="sexo" name="sexo" required oninvalid="this.setCustomValidity('Campo requerido')">
            </div>
        </div>

        <div class="row mt-3">
            <label for="siglaSexo" class="col-sm-2 col-form-label">Sigla</label>
            <div class="col-sm-6">
                <input class="form-control" value="{{$resultSexo[0]->sigla}}" type="text" maxlength="1" value="" id="siglaSexo" name="siglaSexo" required oninvalid="this.setCustomValidity('Campo requerido')">
            </div>
        </div>

        <div class="row">
            <div class="col-6 mt-3" style="text-align: right;">
                <button type="submit" class="btn btn-success">Alterar</button>
            </div>
        </div>
    </div>
</form>
