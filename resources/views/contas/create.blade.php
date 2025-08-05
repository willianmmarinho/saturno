@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <form action="{{ route('conta-contabil.store') }}" method="POST">
            @csrf
            <div class="card shadow" style="border-color: #355089;">
                <div class="card-header">
                    <h5 style="color: #355089;">Inserir Conta Contábil</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                    <fieldset class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="idcatalogocontabil" class="form-label">Tipo Catálogo:</label>
                                <select class="form-select" name="id_tipo_catalogo" id="idcatalogocontabil" required>
                                    @foreach ($catalogo_conta_contabil as $conta_contabil)
                                        <option value="{{ $conta_contabil->id }}">{{ $conta_contabil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="iddescricao" class="form-label">Descrição:</label>
                                <input type="text" name="descricao" id="iddescricao" class="form-control"
                                    placeholder="Descrição Conta Contábil" required>
                            </div>
                            <div class="col-md-2">
                                <label for="idnaturezacontabil" class="form-label">Natureza:</label>
                                <select name="id_tipo_natureza_conta_contabil" id="idnaturezacontabil" class="form-select"
                                    required>
                                    @foreach ($natureza_conta_contabil as $natureza_contabil)
                                        <option value="{{ $natureza_contabil->id }}">{{ $natureza_contabil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="idgrupocontabil" class="form-label">Grupo:</label>
                                <select name="id_tipo_grupo_conta_contabil" id="idgrupocontabil" class="form-select"
                                    required>
                                    @foreach ($grupo_conta_contabil as $grupo_contabil)
                                        <option value="{{ $grupo_contabil->id }}">{{ $grupo_contabil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="idgrau" class="form-label">Grau:</label>
                                <input type="text" name="grau" id="idgrau" class="form-control" value="1"
                                    readonly>
                            </div>
                        </div>
                    </fieldset>
                    <h4>Niveis</h4>
                    <div id="dynamic-fields" class="row">
                        <div class="col-md-2 col-sm-12 form-group">
                            <label for="select-0">Selecione um número:</label>
                            <div class="input-group">
                                <select id="select-0" class="form-control dynamic-select" name="nivel_1" required>
                                    <option value="">Selecione</option>
                                    @for ($i = 1; $i <= 99; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary remove-field" disabled>
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row g-3 justify-content-center">
                        <div class="col-md-3">
                            <a href="{{ url()->previous() }}" class="btn btn-danger w-100">Cancelar</a>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Enviar</button>
                        </div>
                    </div>
                    </p>
                </div>
                <br>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script>
        $(document).ready(function() {
            var selectCount = 1; // Inicia com 1


            $(document).on('change', '.dynamic-select', function() {
                $('#idgrau').val(selectCount);
                var selectedValue = $(this).val();
                if (selectedValue && selectCount < 6) {
                    selectCount++;
                    var newSelect = `
                                    <div class="col-md-2 col-sm-12 form-group">
                                        <label for="select-${selectCount}">Selecione um número:</label>
                                        <div class="input-group">
                                            <select name="nivel_${selectCount}" id="select-${selectCount}" class="form-control dynamic-select" required>
                                                <option value="">Selecione</option>
                                                @for ($i = 1; $i <= 99; $i++)
    <option value="{{ $i }}">{{ $i }}</option>
    @endfor
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-secondary remove-field">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                    $('#dynamic-fields').append(newSelect);
                }
            });

            $(document).on('click', '.remove-field', function() {
                $(this).closest('.col-md-2').remove();
                if (selectCount > 1) {
                    selectCount--;
                }
                $('#idgrau').val(selectCount);
            });
        });
    </script>
@endsection
