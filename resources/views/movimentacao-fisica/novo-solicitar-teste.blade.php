@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card shadow rounded-3">
            <div class="card-header bg-primary text-white">
                <strong>Conferir Material</strong>
            </div>
            <div class="card-body">
                <h4 class="fw-bold text-primary mb-4">Como deseja Incluir o Material?</h4>
                <hr>

                <!-- Radio Buttons -->
                <div class="row mb-4 text-center">
                    <div class="col-md-6 d-flex justify-content-center">
                        <div class="form-check me-4">
                            <input class="form-check-input inputradio" type="radio" name="radioDefault" id="radioDefault1"
                                value="1" checked>
                            <label class="form-check-label" for="radioDefault1">Por Material</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input inputradio" type="radio" name="radioDefault" id="radioDefault2"
                                value="2">
                            <label class="form-check-label" for="radioDefault2">Por Documento</label>
                        </div>
                    </div>
                </div>

                <!-- Por Material -->
                <div class="row align-items-end mb-3" id="pormaterial">
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex align-items-center">
                            <input type="checkbox" id="afirma_por_data_material" name="afirma_por_data_material"
                                class="form-check-input me-2">
                            <label class="form-check-label" for="afirma_por_data_material">Filtrar por data</label>
                        </div>
                    </div>

                    <!-- Campo Data -->
                    <div id="id_deseja_por_data_cadastro_material" class="mb-4" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="data" class="form-label">Data Início</label>
                                <input type="date" class="form-control" id="id_data_inicio_por_material">
                            </div>
                            <div class="col-md-6">
                                <label for="data" class="form-label">Data Fim</label>
                                <input type="date" class="form-control" id="id_data_fim_por_material">
                            </div>
                        </div>
                    </div>

                    <!-- Select Material -->
                    <div class="col-md-8">
                        <label for="material" class="form-label">Selecione o Material</label>
                        <select class="form-select select2" id="id_material" name="material">
                            @foreach ($cadastro_inicial as $material)
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
                    <div class="col-md-4 mt-3 mt-md-0">
                        <button class="btn btn-success w-100" id="botao_por_material">Adicionar</button>
                    </div>
                </div>

                <!-- Por Documento -->
                <div id="pordocumento" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <p>Por Documento</p>
                            {{-- <label for="documento" class="form-label">Selecione o Documento</label>
                            <select class="form-select" id="id_documento" name="documento">
                              @foreach ($cadastro_inicial as $material)
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
                            </select> --}}
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="text-primary">Materiais Selecionados:</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover align-middle shadow-sm" id="tabela_materiais">
                        <thead class="table-primary text-center text-dark">
                            <tr>
                                <th scope="col" style="width: 80%;">Material</th>
                                <th scope="col" style="width: 20%;">Remover</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider" id="body-table">
                            {{-- Linhas adicionadas via JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function verificarCampos() {
            return $('#id_data_inicio_por_material').val() && $('#id_data_fim_por_material').val();
        }

        function materiais() {
            $.ajax({
                type: "GET",
                url: "/retorna-materiais",
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    // Aqui você pode processar os materiais conforme necessário
                },
                error: function() {
                    console.error('Erro ao carregar materiais.');
                }
            });
        }

        $(document).ready(function() {
            // Alternância entre os tipos de inclusão
            $('.inputradio').change(function() {
                if ($(this).val() == "1") {
                    $('#pormaterial').show();
                    $('#pordocumento').hide();
                } else {
                    $('#pormaterial').hide();
                    $('#pordocumento').show();
                }
            });

            // Checkbox: Filtrar por data
            $('#afirma_por_data_material').change(function() {
                if ($(this).is(':checked')) {
                    $('#id_deseja_por_data_cadastro_material').show();
                    $('#id_material').attr('disabled', true);
                } else {
                    $('#id_deseja_por_data_cadastro_material').hide();
                    $('#id_material').attr('disabled', false);
                }
            });

            // Alterações nos campos de data
            $('#id_data_fim_por_material, #id_data_inicio_por_material').on('change', function() {
                event.preventDefault();
                if (verificarCampos()) {

                    const dataInicio = $('#id_data_inicio_por_material').val();
                    const dataFim = $('#id_data_fim_por_material').val();

                    $.ajax({
                        type: "GET",
                        url: `/retorna-materiais-por-data-cadastro/${dataInicio}/${dataFim}`,
                        dataType: "json",
                        success: function(response) {


                            $('#id_material').empty();
                            $.each(response, function(indexInArray, material) {

                                var nome = '';
                                if (material.categoria_material) {
                                    nome += material.categoria_material.nome + ' - ';
                                    // console.log(nome);

                                }
                                if (material.item_catalogo_material) {
                                    nome += material.item_catalogo_material.nome +
                                        ' - ';
                                }
                                if (material.marca) {
                                    nome += material.marca.nome +
                                        ' - ';
                                }
                                if (material.cor) {
                                    nome += material.cor.nome +
                                        ' - ';
                                }
                                if (material.tamanho) {
                                    nome += material.tamanho.nome +
                                        ' - ';
                                }
                                if (material.fase_etaria) {
                                    nome += material.fase_etaria.nome +
                                        ' - ';
                                }
                                if (material.tipo_sexo) {
                                    nome += material.tipo_sexo.nome + '-';
                                }
                                console.log(nome);
                                $('#id_material').append(
                                    `<option value="${material.id}">${nome}</option>`
                                );

                            });
                            $('#id_material').attr('disabled', false);

                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao buscar materiais por data:', error);
                        }
                    });
                } else {
                    console.log('Campos de data não preenchidos corretamente.');
                }
            });

            // Botão "Adicionar"
            $('#botao_por_material').click(function() {
                const materialId = $('#id_material').val();

                // Verifica se já foi adicionado
                if ($(`#linha-material-${materialId}`).length > 0) {
                    alert('Este material já foi adicionado.');
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "/ajax-por-material/" + materialId,
                    dataType: "JSON",
                    success: function(material) {
                        let partesNome = [];

                        if (material.categoria_material) partesNome.push(material
                            .categoria_material.nome);
                        if (material.item_catalogo_material) partesNome.push(material
                            .item_catalogo_material.nome);
                        if (material.marca) partesNome.push(material.marca.nome);
                        if (material.cor) partesNome.push(material.cor.nome);
                        if (material.tamanho) partesNome.push(material.tamanho.nome);
                        if (material.fase_etaria) partesNome.push(material.fase_etaria.nome);
                        if (material.tipo_sexo) partesNome.push(material.tipo_sexo.nome);

                        const nome = partesNome.join(' - ');

                        // Cria linha na tabela com input hidden
                        const linha = `
                <tr id="linha-material-${materialId}">
                    <td>
                        ${nome}
                        <input type="hidden" name="materiais[]" value="${materialId}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-remover-material" data-id="${materialId}">
                            Remover
                        </button>
                    </td>
                </tr>
            `;

                        $('#body-table').append(linha);
                    },
                    error: function() {
                        alert('Erro ao buscar informações do material.');
                    }
                });
            });
            // Remover material da tabela
            $(document).on('click', '.btn-remover-material', function() {
                const id = $(this).data('id');
                $(`#linha-material-${id}`).remove();
            });

        });
    </script>
@endsection
