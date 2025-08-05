@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card shadow rounded-3">
            <div class="card-header bg-primary text-white">
                <strong>Conferir Material</strong>
            </div>
            <div class="card-body">
                @csrf
                <form action="{{ route('movimentacao-fisica.homologar') }}">
                    <div class="row mb-3">
                        <label for="id_setor" class="form-label">Setor: </label>
                        <div class="col-md-4">
                            <select name="setor" id="id_setor"
                                class="form-select @error('setor') is-invalid @enderror select2" required>
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->sigla }} - {{ $setor->nome }}</option>
                                @endforeach
                            </select>
                            @error('setor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="container-fluid">
                        <div class="table-responsive" id="div_tabela">
                            <table class="table table-bordered table-hover align-middle shadow-sm">
                                <thead class="table-primary text-center text-dark">
                                    <tr>
                                        <th scope="col" style="inline-size: 80%;">Material</th>
                                        <th scope="col" style="inline-size: 20%;">Presente?</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @forelse ($materiais_enviados as $material)
                                        <tr class="text-center">
                                            <td class="text-start">
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
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="materiais[]"
                                                        value="{{ $material->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Nenhum material enviado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-sm-12 col-md-3">
                            <a class="btn btn-danger" href="{{ route('movimentacao-fisica.index') }}">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-3" id="div_btn">
                            <button class="btn btn-success" type="submit">
                                Confirmar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#div_tabela, #div_btn').hide();
            $('#id_setor').change(function(e) {
                $('#div_tabela, #div_btn').show();


            });
        });
    </script>
@endsection
