//SELECT2
$(document).ready(function () {
    //Importa o select2 com tema do Bootstrap para a classe "select2"
    $(".select2").select2({
        theme: "bootstrap-5",
    });
});

//SELECT2 Dentro do modal
$(document).ready(function () {
    // Inicializa o Select2 em qualquer modal que contenha .select2
    $(document).on('shown.bs.modal', '.modal', function () {
        $('.select2', this).select2({
            theme: "bootstrap-5",
            dropdownParent: $(this),
        });

        // Para o select2 específico com tags: true
        const $valorSelect = $('#valorAquisicaoMaterial, #valorVendaMaterial, #valorAquisicaoMaterialEditar, #valorVendaMaterialEditar', this);
        $valorSelect.select2({
            theme: "bootstrap-5",
            dropdownParent: $(this),
            tags: true,
            placeholder: "Selecione ou digite um valor",
            allowClear: true,
            createTag: function (params) {
                const term = params.term.trim();
                if (!/^\d+(\.\d{1,2})?$/.test(term)) {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            }
        });
    });

    // Recarrega a página ao clicar em qualquer botão .btn-danger com data-bs-dismiss="modal"
    $(document).on('click', '[data-bs-dismiss="modal"]', function () {
        location.reload();
    });
});

//preencher select da modal incluir Itens Material
$(document).ready(function () {
    // Função genérica para carregar opções via AJAX com async/await
    async function carregarOpcoes(url, targetSelect, placeholder = "Selecione...") {
        const select = $(targetSelect);
        if (select.length === 0) return;

        select.prop('disabled', true);
        select.html(`<option selected>Carregando...</option>`);

        try {
            const response = await fetch(url);
            const data = await response.json();

            select.empty();

            if (data.length > 0) {
                select.append(`<option value="" disabled selected>${placeholder}</option>`);
                data.forEach((item) => {
                    select.append(`<option value="${item.id}">${item.nome}</option>`);
                });
            } else {
                select.append(`<option value="" selected>Não Possui</option>`);
            }
        } catch (error) {
            console.error("Erro ao carregar opções:", error);
            select.html(`<option value="">Erro ao carregar</option>`);
        } finally {
            select.prop('disabled', false);
        }
    }

    // Flag do checkbox "Avariado"
    let avariadoAtivo = false;

    // Atualiza apenas o valor de venda ao marcar/desmarcar "Avariado"
    $('#checkAvariado').on('change', function () {
        avariadoAtivo = $(this).is(':checked');

        const nomeId = $('#nomeMaterial').val();
        if (nomeId) {
            const valorVendaUrl = avariadoAtivo
                ? `/valorVendaAvariado/${nomeId}`
                : `/valorVenda/${nomeId}`;

            carregarOpcoes(valorVendaUrl, '#valorVendaMaterial');
        }
    });

    // Quando categoria é selecionada
    $('#categoriaMaterial').on('change', function () {
        const categoriaId = this.value;
        if (!categoriaId) return;

        const filtrosCategoria = {
            [`/nome/${categoriaId}`]: '#nomeMaterial',
            [`/marcas/${categoriaId}`]: '#marcaMaterial',
            [`/tamanhos/${categoriaId}`]: '#tamanhoMaterial',
            [`/cores/${categoriaId}`]: '#corMaterial',
            [`/fases/${categoriaId}`]: '#faseEtariaMaterial',
        };

        for (const [url, selector] of Object.entries(filtrosCategoria)) {
            carregarOpcoes(url, selector);
        }
    });

    // Quando nome do material é selecionado
    $('#nomeMaterial').on('change', async function () {
        const nomeId = this.value;
        if (!nomeId) return;

        await carregarOpcoes(`/embalagem/${nomeId}`, '#embalagemMaterial');
        await carregarOpcoes(`/valorAquisicao/${nomeId}`, '#valorAquisicaoMaterial');

        const valorVendaUrl = avariadoAtivo
            ? `/valorVendaAvariado/${nomeId}`
            : `/valorVenda/${nomeId}`;
        await carregarOpcoes(valorVendaUrl, '#valorVendaMaterial');

        // Carrega o tipo do material e preenche os campos ocultos
        try {
            const response = await fetch(`/tipo/${nomeId}`);
            const data = await response.json();

            $('#tipoMaterialNome').val(data.nome || '');
            $('#tipoMaterial').val(data.id || '');

            if (data.id == 2) {
                $('#checkAplicacao').prop('disabled', false);
                $('#checkNumSerie').prop('disabled', true).prop('checked', false);
                $('#checkVeiculo').prop('disabled', true).prop('checked', false);
            } else {
                $('#checkAplicacao').prop('disabled', true).prop('checked', false);
                $('#checkNumSerie').prop('disabled', false);
                $('#checkVeiculo').prop('disabled', false);
            }
        } catch (error) {
            console.error('Erro ao buscar tipo do material:', error);
            $('#tipoMaterialNome').val('');
            $('#tipoMaterial').val('');
        }
    });

    $('#quantidadeMaterial').on('input', function () {
        const quantidade = parseInt($(this).val());
        const tipoMaterial = parseInt($('#tipoMaterial').val());
        const checkNumSerie = $('#checkNumSerie').is(':checked');
        const checkVeiculo = $('#checkVeiculo').is(':checked');

        const container = $('#containerNumerosSerie');
        const inputs = $('#inputsNumerosSerie');
        const container2 = $('#containerVeiculo');
        const inputs2 = $('#inputsVeiculo');

        inputs.empty();
        inputs2.empty();


        if (tipoMaterial === 1 && checkNumSerie && quantidade > 0) {
            container.show();
            for (let i = 0; i < quantidade; i++) {
                inputs.append(`
                <input type="text" name="numerosSerie[]" class="form-control mt-2 mb-2" placeholder="Número de série ${i + 1}" required />
            `);
            }
        } else if (tipoMaterial === 1 && checkVeiculo && quantidade > 0) {
            container2.show();
            for (let i = 0; i < quantidade; i++) {
                inputs2.append(`
                <div class="form-group"></div>
                    <label>Dados do ${i + 1}º Veiculo:</label>
                    <input type="text" name="numerosPlacas[]" class="form-control mb-2" placeholder="Número da Placa ${i + 1}" required />
                    <input type="text" name="numerosRenavam[]" class="form-control mb-2" placeholder="Número do Renavam ${i + 1}" required />
                    <input type="text" name="numerosChassis[]" class="form-control mb-2" placeholder="Número do Chassi ${i + 1}" required />
                </div>`);
            }
        } else {
            container.hide();
        }
    });

    $('#checkVeiculo').on('change', function () {
        const checkVeiculo = $(this).is(':checked');
        const tipoMaterial = parseInt($('#tipoMaterial').val());

        if (checkVeiculo) {
            $('#checkNumSerie').prop('disabled', true).prop('checked', false);
        } else {
            if (tipoMaterial !== 2) {
                $('#checkNumSerie').prop('disabled', false);
            }
        }

        $('#quantidadeMaterial').trigger('input');
    });


    // Reage a mudanças no checkbox também
    $('#checkNumSerie').on('change', function () {
        $('#quantidadeMaterial').trigger('input');
    });
});

//preencher select da modal editar Itens Material
$(document).ready(function () {
    function carregarOpcoes(url, selector, valorSelecionado = null, callback = null) {
        return new Promise((resolve, reject) => {
            const select = $(selector);
            select.prop('disabled', true);
            select.empty();
            select.append('<option value="">Carregando...</option>'); // Mostra "Carregando..."

            $.get(url, function (data) {
                select.empty(); // Limpa o "Carregando..."
                select.append('<option value="">Selecione...</option>');

                data.forEach(item => {
                    const selected = item.id == valorSelecionado ? 'selected' : '';
                    select.append(`<option value="${item.id}" ${selected}>${item.nome}</option>`);
                });

                if (valorSelecionado) {
                    select.val(valorSelecionado).trigger('change');
                }

                select.prop('disabled', false);

                if (typeof callback === 'function') {
                    callback();
                }

                resolve(); // Finaliza a promise
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Erro ao carregar ${url}:`, textStatus, errorThrown);
                select.empty();
                select.append('<option value="">Erro ao carregar</option>'); // Opcional: mensagem de erro visível
                reject(errorThrown);
            });
        });
    }

    let valoresSelecionados = {};
    let valoresNomeSelecionados = {};
    let btnEditarAtual = null;

    $('#categoriaMaterialEditar').on('change', function () {
        const categoriaId = this.value;
        if (!categoriaId) return;

        const filtrosCategoria = {
            [`/nome/${categoriaId}`]: { selector: '#nomeMaterialEditar', valor: valoresSelecionados.nome },
            [`/marcas/${categoriaId}`]: { selector: '#marcaMaterialEditar', valor: valoresSelecionados.marca },
            [`/tamanhos/${categoriaId}`]: { selector: '#tamanhoMaterialEditar', valor: valoresSelecionados.tamanho },
            [`/cores/${categoriaId}`]: { selector: '#corMaterialEditar', valor: valoresSelecionados.cor },
            [`/fases/${categoriaId}`]: { selector: '#faseEtariaMaterialEditar', valor: valoresSelecionados.fase_etaria },
        };

        Promise.all(
            Object.entries(filtrosCategoria).map(([url, obj]) =>
                carregarOpcoes(url, obj.selector, obj.valor)
            )
        );
    });

    $('#nomeMaterialEditar').on('change', async function () {
        const nomeId = this.value;
        if (!nomeId) return;

        const filtrosNome = {
            [`/embalagem/${nomeId}`]: { selector: '#embalagemMaterialEditar', valor: valoresNomeSelecionados.embalagem },
            [`/valorAquisicao/${nomeId}`]: { selector: '#valorAquisicaoMaterialEditar', valor: valoresNomeSelecionados.valor_aquisicao },
        };

        const isAvariado = $('#checkAvariadoEditar').is(':checked');
        const urlVenda = isAvariado ? `/valorVendaAvariado/${nomeId}` : `/valorVenda/${nomeId}`;

        filtrosNome[urlVenda] = {
            selector: '#valorVendaMaterialEditar',
            valor: valoresNomeSelecionados.valor_venda
        };

        try {
            const response = await fetch(`/tipo/${nomeId}`);
            const data = await response.json();

            $('#tipoMaterialNomeEditar').val(data.nome || '');
            $('#tipoMaterialEditar').val(data.id || '');

            if (data.id == 2) {
                $('#checkAplicacaoEditar').prop('disabled', false);
                $('#checkNumSerieEditar').prop('disabled', true).prop('checked', false);
                $('#checkVeiculoEditar').prop('disabled', true).prop('checked', false);

                $('#placaEditar').val(btnEditarAtual?.data('veiculo_placas'));
                $('#renavamEditar').val(btnEditarAtual?.data('veiculo_renavam'));
                $('#chassiEditar').val(btnEditarAtual?.data('veiculo_chassis'));
            } else {
                $('#checkAplicacaoEditar').prop('disabled', true).prop('checked', false);
                $('#checkNumSerieEditar').prop('disabled', false);
                $('#checkVeiculoEditar').prop('disabled', false);
            }
        } catch (error) {
            console.error('Erro ao buscar tipo do material (editar):', error);
            $('#tipoMaterialNomeEditar').val('');
            $('#tipoMaterialEditar').val('');
        }

        await Promise.all(
            Object.entries(filtrosNome).map(([url, obj]) =>
                carregarOpcoes(url, obj.selector, obj.valor)
            )
        );

        $('#quantidadeMaterialEditar').trigger('input');
    });

    $('#checkAvariadoEditar').on('change', function () {
        const nomeId = $('#nomeMaterialEditar').val();
        if (!nomeId) return;

        const isAvariado = $(this).is(':checked');
        const urlVenda = isAvariado ? `/valorVendaAvariado/${nomeId}` : `/valorVenda/${nomeId}`;
        const valorVendaSelecionado = valoresNomeSelecionados.valor_venda;

        carregarOpcoes(urlVenda, '#valorVendaMaterialEditar', valorVendaSelecionado);
    });

    $('#quantidadeMaterialEditar').on('input', function () {
        const quantidade = parseInt($(this).val());
        const tipoMaterial = parseInt($('#tipoMaterialEditar').val());
        const checkNumSerie = $('#checkNumSerieEditar').is(':checked');
        const checkVeiculo = $('#checkVeiculoEditar').is(':checked');

        const container = $('#containerNumerosSerieEditar');
        const inputs = $('#inputsNumerosSerieEditar');
        const container2 = $('#containerVeiculoEditar');
        const inputs2 = $('#inputsVeiculoEditar');

        inputs.empty();
        inputs2.empty();

        container.hide();
        container2.hide();

        if (tipoMaterial === 1 && checkNumSerie && quantidade > 0) {
            container.show();
            const num_serie = String(btnEditarAtual?.data('num_serie') || '').split(',');

            for (let i = 0; i < quantidade; i++) {
                inputs.append(`
                    <label>Dados do ${i + 1}º Número de Série:</label>
                    <input type="text" name="numerosSerieEditar[]" class="form-control mt-2 mb-2" placeholder="Número de série ${i + 1}" value="${num_serie[i] || ''}" required />
                `);
            }
        } else if (tipoMaterial === 1 && checkVeiculo && quantidade > 0) {
            container2.show();

            const placas = String(btnEditarAtual?.data('veiculo_placas') || '').split(',');
            const renavams = String(btnEditarAtual?.data('veiculo_renavam') || '').split(',');
            const chassises = String(btnEditarAtual?.data('veiculo_chassis') || '').split(',');

            console.log('Placas:', placas);
            console.log('Renavams:', renavams);
            console.log('Chassis:', chassises);

            for (let i = 0; i < quantidade; i++) {
                inputs2.append(`
                    <div class="form-group">
                        <label>Dados do ${i + 1}º Veículo:</label>
                        <input type="text" name="numerosPlacasEditar[]" class="form-control mb-2" placeholder="Placa ${i + 1}" value="${placas[i] || ''}" required />
                        <input type="text" name="numerosRenavamEditar[]" class="form-control mb-2" placeholder="Renavam ${i + 1}" value="${renavams[i] || ''}" required />
                        <input type="text" name="numerosChassisEditar[]" class="form-control mb-2" placeholder="Chassi ${i + 1}" value="${chassises[i] || ''}" required />
                    </div>
                `);
            }
        }
    });

    $('#checkVeiculoEditar').on('change', function () {
        const checkVeiculo = $(this).is(':checked');
        const tipoMaterial = parseInt($('#tipoMaterialEditar').val());

        if (checkVeiculo) {
            $('#checkNumSerieEditar').prop('disabled', true).prop('checked', false);
        } else if (tipoMaterial !== 2) {
            $('#checkNumSerieEditar').prop('disabled', false);
        }

        $('#quantidadeMaterialEditar').trigger('input');
    });

    $('#checkNumSerieEditar').on('change', function () {
        const checkNumSerie = $(this).is(':checked');
        const tipoMaterial = parseInt($('#tipoMaterialEditar').val());

        if (checkNumSerie) {
            $('#checkVeiculoEditar').prop('disabled', true).prop('checked', false);
        } else if (tipoMaterial !== 2) {
            $('#checkVeiculoEditar').prop('disabled', false);
        }

        $('#quantidadeMaterialEditar').trigger('input');
    });

    $('.btn-editar-material').on('click', function () {
        const btn = $(this);
        btnEditarAtual = btn;

        valoresSelecionados = {
            nome: btn.data('nome') || '',
            marca: btn.data('marca') || '',
            tamanho: btn.data('tamanho') || '',
            cor: btn.data('cor') || '',
            fase_etaria: btn.data('fase_etaria') || ''
        };

        valoresNomeSelecionados = {
            embalagem: btn.data('embalagem') || '',
            valor_aquisicao: btn.data('valor_aquisicao') || '',
            tipoId: btn.data('tipoid') || '',
            tipo: btn.data('tipo') || '',
            valor_venda: btn.data('valor_venda') || ''
        };

        $('#edit-id').val(btn.data('id') || '');
        $('#documento-id-editar').val(btn.data('documento-id') || '');
        $('#checkVeiculoEditar').prop('checked', !!btn.data('veiculo_placas')).trigger('change');
        $('#checkNumSerieEditar').prop('checked', !!btn.data('num_serie')).trigger('change');
        $('#categoriaMaterialEditar').val(btn.data('categoria')).trigger('change');
        $('#checkAplicacaoEditar').prop('checked', btn.data('aplicacao') == 1);
        $('#quantidadeMaterialEditar').val(btn.data('quantidade') || '');
        $('#modeloMaterialEditar').val(btn.data('modelo') || '');
        $('#checkAvariadoEditar').prop('checked', btn.data('avariado') == 1);
        $('#dataValidadeMaterialEditar').val(btn.data('data_validade') || '');
        $('#dataFabricacaoMaterialEditar').val(btn.data('data_fabricacao') || '');
        $('#dataFabricacaoModeloMaterialEditar').val(btn.data('data_fabricacao_modelo') || '');
        $('#observacaoMaterialEditar').val(btn.data('observacao') || '');
        $('#sexoMaterialEditar').val(btn.data('sexo')).trigger('change');

        $('#quantidadeMaterialEditar').trigger('input');
    });
});

//Modal Excluir Material
document.addEventListener('DOMContentLoaded', function () {
    const excluirLinks = document.querySelectorAll('.excluirSolicitacao');

    excluirLinks.forEach(link => {
        link.addEventListener('click', function () {

            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            const documentoId = this.getAttribute('data-documento-id');

            document.getElementById('delete-id').value = id;
            document.getElementById('nome-material').textContent = nome;
            document.getElementById('documento-id-excluir').value = documentoId;
        });
    });
});

// Selecione todos os campos com a classe 'proposta'
document.querySelectorAll('.valor-monetario').forEach(function (input) {
    input.addEventListener('input', function (event) {
        let value = event.target.value.replace(/\D/g, ''); // Remove tudo o que não for número
        if (value) {
            value = (parseInt(value) / 100).toFixed(2); // Converte para valor decimal
            value = value.replace('.', ','); // Substitui ponto por vírgula
            event.target.value = 'R$ ' + value; // Adiciona o "R$" antes do valor
        }
    });
});
