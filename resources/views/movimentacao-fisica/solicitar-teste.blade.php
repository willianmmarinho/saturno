@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card shadow rounded-3">
            <div class="card-header bg-primary text-white">
                <strong>Solicitar Teste de Material</strong>
            </div>
            <div class="card-body">

                <form action="{{ route('movimentacao-fisica.solicitar-teste.confere') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="materiais" class="form-label">Selecione os Materiais</label>
                        <select name="materiais1[]" class="form-select select2" multiple="multiple">
                            @foreach ($cadastro_inicial->unique('id') as $material)
                                <option value="{{ $material->id }}">
                                    {{ implode(
                                        ' - ',
                                        array_filter([
                                            $material->CategoriaMaterial?->nome,
                                            $material->ItemCatalogoMaterial?->nome,
                                            $material->Marca?->nome,
                                            $material->Cor?->nome,
                                            $material->Tamanho?->nome,
                                            $material->FaseEtaria?->nome,
                                            $material->TipoSexo?->nome,
                                        ]),
                                    ) }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Solicitar Teste</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Estilo Select2 + tema Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    {{-- jQuery + Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
