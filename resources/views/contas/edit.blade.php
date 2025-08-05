@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <form action="{{ route('conta-contabil.update', ['id' => $contaContabil->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card" style="border-color: #355089;">
                <div class="card-header">
                    <h5 style="color: #355089;">Editar Conta Contábil</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">

                    <fieldset class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="idcatalogocontabil" class="form-label">Tipo Catálogo:</label>
                                <select class="form-select" name="id_tipo_catalogo" id="idcatalogocontabil" required>
                                    @foreach ($catalogo_conta_contabil as $conta_catalogo)
                                        <option value="{{ $conta_catalogo->id }}"
                                            {{ $conta_catalogo->id == $contaContabil->id_tipo_catalogo ? 'selected' : '' }}>
                                            {{ $conta_catalogo->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="iddescricao" class="form-label">Descrição:</label>
                                <input type="text" name="descricao" id="iddescricao" class="form-control"
                                    placeholder="Descrição Conta Contábil" value="{{ $contaContabil->descricao }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="idnaturezacontabil" class="form-label">Natureza:</label>
                                <select name="id_tipo_natureza_conta_contabil" id="idnaturezacontabil" class="form-select"
                                    required>
                                    @foreach ($natureza_conta_contabil as $natureza_contabil)
                                        <option value="{{ $natureza_contabil->id }}"
                                            {{ $natureza_contabil->id == $contaContabil->id_tipo_natureza_conta_contabil ? 'selected' : '' }}>
                                            {{ $natureza_contabil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="idgrupocontabil" class="form-label">Grupo:</label>
                                <select name="id_tipo_grupo_conta_contabil" id="idgrupocontabil" class="form-select"
                                    required>
                                    @foreach ($grupo_conta_contabil as $grupo_contabil)
                                        <option value="{{ $grupo_contabil->id }}"
                                            {{ $grupo_contabil->id == $contaContabil->id_tipo_grupo_conta_contabil ? 'selected' : '' }}>
                                            {{ $grupo_contabil->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="idgrau" class="form-label">Grau:</label>
                                <input type="text" name="grau" id="idgrau" class="form-control"
                                    value="{{ $contaContabil->grau }}" readonly>
                            </div>
                        </div>
                    </fieldset>
                    <h4>Níveis</h4>
                    <div id="dynamic-fields" class="row">
                        @for ($i = 1; $i <= $contaContabil->grau; $i++)
                            <div class="col-md-2 col-sm-12 form-group">
                                <label for="select-{{ $i }}">Selecione um número:</label>
                                <div class="input-group">
                                    <select name="nivel_{{ $i }}" id="select-{{ $i }}"
                                        class="form-control dynamic-select" required>
                                        <option value="">Selecione</option>
                                        @for ($j = 1; $j <= 99; $j++)
                                            <option value="{{ $j }}"
                                                {{ $contaContabil->{'nivel_' . $i} == $j ? 'selected' : '' }}>
                                                {{ $j }}</option>
                                        @endfor
                                    </select>
                                    @if ($i > 1)
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary remove-field">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>

                    <br>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-3">
                            <a href="{{ url()->previous() }}" class="btn btn-danger w-100">Cancelar</a>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
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
            var selectCount = parseInt($('#idgrau').val()) || 1; // Inicia com os selects existentes

            // Função para adicionar um novo select
            function addNewSelect(index) {
                var newSelect = `
        <div class="col-md-2 col-sm-12 form-group" id="select-group-${index}">
            <label for="select-${index}">Selecione um número:</label>
            <div class="input-group">
                <select name="nivel_${index}" id="select-${index}" class="form-control dynamic-select" required>
                    <option value="">Selecione</option>
                    @for ($j = 1; $j <= 99; $j++)
                        <option value="{{ $j }}">{{ $j }}</option>
                    @endfor
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-secondary remove-field">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>`;
                $('#dynamic-fields').append(newSelect);
            }

            // Detecta mudança nos selects e adiciona novos
            $(document).on('change', '.dynamic-select', function() {
                if ($(this).val() && selectCount < 6) {
                    selectCount++;
                    $('#idgrau').val(selectCount);
                    addNewSelect(selectCount);
                }
            });

            // Remove o campo ao clicar no botão de exclusão
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
