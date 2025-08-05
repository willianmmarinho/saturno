@extends('layouts.app')

@section('title')
    Gerenciar Aquisição de Serviços
@endsection
@section('content')
    <form method="GET" action="/gerenciar-aquisicao-servicos">{{-- Formulario de pesquisa --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Gerenciar Aquisição de Serviços
                                </h5>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="ROW" style="margin-left:5px">
                                <div style="display: flex; gap: 20px; align-items: flex-end;">
                                    <div class="col-md-2 col-sm-12">Classe do Serviço
                                        <br>
                                        <select class="js-example-responsive form-select select2"
                                            style="border: 1px solid #999999; padding: 5px;" id="classeServico"
                                            name="classe">
                                            <option value=""></option>
                                            @foreach ($classeAquisicao as $classeAquisicaos)
                                                <option value="{{ $classeAquisicaos->id }}" {{ old('classe') }}>
                                                    {{ $classeAquisicaos->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Tipo de Serviço
                                        <br>
                                        <select class="js-example-responsive form-select select2"
                                            style="border: 1px solid #999999;" id="servicos" name="servicos"
                                            value="{{ old('servicos') }}" disabled>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Setor
                                        <select class="form-select select2" style="border: 1px solid #999999;" name="setor" id="setor">
                                            <option value="">Todos</option>
                                            @foreach ($todosSetor as $todosSetors)
                                                <option value="{{ $todosSetors->id }}"
                                                    {{ old('setor') == $todosSetors->id ? 'selected' : '' }}>
                                                    {{ $todosSetors->nome }} - {{ $todosSetors->sigla }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12">Status
                                        <select class="form-select" style="border: 1px solid #999999;" name="status_servico"
                                            value="" id="statusServico">
                                            <option value="">Todos</option>
                                            @foreach ($status as $statuss)
                                                <option value="{{ $statuss->id }}"
                                                    {{ old('status_servicos') == $statuss->id ? 'selected' : '' }}>
                                                    {{ $statuss->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light btn-sm "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px;"{{-- Botao submit do formulario de pesquisa --}}
                                            type="submit">Pesquisar
                                        </button>
                                        <a href="/gerenciar-aquisicao-servicos" type="button" class="btn btn-light btn-sm"
                                            style="box-shadow: 1px 2px 5px #000000; font-size: 1rem"
                                            value="">Limpar</a>
                                        <a href="/incluir-aquisicao-servicos" class="btn btn-success"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-left:5px">
                                            Novo+
                                        </a>
                                    </div>
                                </div>
                                <div class="ROW justify-content-start">
                                    <div class="col-12" style="margin-top:10px;">
                                        <a href="" class="btn btn-primary"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px"
                                            data-bs-toggle="modal" data-bs-target="#modalAprovarLote">
                                            Aprovar em Lote
                                        </a>
                                        <a href="" class="btn btn-success"
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px"
                                            data-bs-toggle="modal" data-bs-target="#modalHomologarLote">
                                            Homologar em Lote
                                        </a>
                                        <a href="{{ route('pagamento.index') }}" class="btn btn-warning "
                                            style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-right:5px">
                                            Pagamento
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            {{-- @foreach ($aquisicao as $aquisicaos)
                                @if (in_array($aquisicaos->id_setor, ['1', '2', '5', $setor])) --}}
                                    <table {{-- Inicio da tabela de informacoes --}}
                                        class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                        id="tabela-servicos" style="width: 100%">
                                        <thead style="text-align: center;">{{-- inicio header tabela --}}
                                            <tr style="background-color: #d6e3ff; font-size:15px; color:#000;"
                                                class="align-middle">
                                                <th>
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center;">
                                                        <input type="checkbox" id="selectAll"
                                                            onclick="toggleCheckboxes(this)" aria-label="Selecionar todos"
                                                            style="border: 1px solid #000">
                                                    </div>
                                                </th>
                                                <th>NÚMERO</th>
                                                <th>DATA</th>
                                                <th>TIPO SERVIÇO</th>
                                                <th>SETOR</th>
                                                <th>PRIORIDADE</th>
                                                <th>STATUS</th>
                                                <th>POSSUI MATERIAL?</th>
                                                <th>AÇÕES</th>
                                            </tr>
                                        </thead>{{-- Fim do header da tabela --}}
                                        <tbody style="font-size: 15px; color:#000000; text-align: center;">
                                            {{-- Inicio body tabela --}}
                                            @foreach ($aquisicao as $aquisicaos)
                                                <tr>
                                                    <td>
                                                        <div
                                                            style="display: flex; justify-content: center; align-items: center;">
                                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                                id="checkboxNoLabel" value="{{ $aquisicaos->id }}"
                                                                aria-label="..." style="border: 1px solid #000">
                                                        </div>
                                                    </td>
                                                    <td>{{ $aquisicaos->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($aquisicaos->data)->format('d/m/Y') }}</td>
                                                    <td>{{ $aquisicaos->CatalogoServico->descricao }}</td>
                                                    <td>{{ $aquisicaos->setor->nome }} - {{ $aquisicaos->setor->sigla }}</td>
                                                    <td>{{ $aquisicaos->prioridade }}</td>
                                                    <td>{{ $aquisicaos->tipoStatus->nome }}</td>
                                                    <td>Sim</td>
                                                    <td>
                                                        <a href="{{ route('visualizar.aquisicao.servicos', ['id' => $aquisicaos->id]) }}"
                                                            class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                            style="font-size: 1rem; color:#303030" data-placement="top"
                                                            title="Visualizar">
                                                            <i class="bi bi-search"></i>
                                                        </a>
                                                        <a href="/aditivo-aquisicao-servicos/{{ $aquisicaos->id }}"
                                                            class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                            style="font-size: 1rem; color:#303030" data-placement="top"
                                                            title="Aditivo">
                                                            <i class="bi bi-plus-square"></i>
                                                        </a>
                                                        @if (in_array($aquisicaos->tipoStatus->id, ['3', '2']))
                                                            <a href="/aprovar-aquisicao-servicos/{{ $aquisicaos->id }}"
                                                                class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                                style="font-size: 1rem; color:#303030" data-placement="top"
                                                                title="Aprovar">
                                                                <i class="bi bi-check-lg"></i>
                                                            </a>
                                                        @endif
                                                        @if ($aquisicaos->tipoStatus->id == '3')
                                                            <a href="/homologar-aquisicao-servicos/{{ $aquisicaos->id }}"
                                                                class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                                style="font-size: 1rem; color:#303030"
                                                                data-placement="top" title="Homologar">
                                                                <i class="bi bi-clipboard-check"></i>
                                                            </a>
                                                        @endif
                                                        @if ($aquisicaos->tipoStatus->id == '1')
                                                            <a href="/editar-aquisicao-servicos/{{ $aquisicaos->id }}"
                                                                class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                                style="font-size: 1rem; color:#303030"
                                                                data-placement="top" title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a href="/enviar-aquisicao-servicos/{{ $aquisicaos->id }}"
                                                                class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                                style="font-size: 1rem; color:#303030"
                                                                data-placement="top" title="Enviar">
                                                                <i class="bi bi-cart-check"></i>
                                                            </a>
                                                        @endif
                                                        @if (isset($aquisicaos->aut_usu_pres, $aquisicaos->aut_usu_adm))
                                                            <a href="" class="btn btn-sm btn-outline-info"
                                                                data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                                data-placement="top" title="Aceite">
                                                                <i class="bi bi-hand-thumbs-up"></i>
                                                            </a>
                                                        @endif
                                                        @if ($aquisicaos->tipoStatus->id == '1')
                                                            <a href="" class="btn btn-sm btn-outline-danger"
                                                                data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                                data-placement="top" title="Excluir">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- Fim body da tabela --}}
                                    </table>
                                {{-- @endif
                            @endforeach --}}
                        </div>
                        <div style="margin-right: 10px; margin-left: 10px">
                            {{ $aquisicao->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>{{-- Final Formulario de pesquisa --}}

    <!-- Modal Aprovar em Lote -->
    <div class="modal fade" id="modalAprovarLote" tabindex="-1" aria-labelledby="modalAprovarLoteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ url('/aprovar-em-lote') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#DC4C64;">
                        <h5 class="modal-title" id="modalAprovarLoteLabel">Confirmar Aprovação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-content-aprovar">
                        <!-- O conteúdo dinâmico será inserido aqui -->
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIM da Modal Aprovar em Lote -->
    <!-- Modal Homologar em Lote -->
    <div class="modal fade" id="modalHomologarLote" tabindex="-1" aria-labelledby="modalHomologarLoteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="form-horizontal" method="POST" action="{{ url('/homologar-em-lote') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#DC4C64;">
                        <h5 class="modal-title" id="modalHomologarLoteLabel">Confirmar Homologação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-content-homologar">
                        <!-- O conteúdo dinâmico será inserido aqui -->
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIM da Modal Homologar em Lote -->
    <script>
        $(document).ready(function() {
            function populateServicos(selectElement, classeServicoValue) {
                $.ajax({
                    type: "GET",
                    url: "/retorna-nome-servicos/" + classeServicoValue,
                    dataType: "json",
                    success: function(response) {
                        selectElement.empty();
                        selectElement.append(
                            '<option value="">Selecione um serviço</option>'
                        );
                        $.each(response, function(index, item) {
                            selectElement.append(
                                '<option value="' +
                                item.id +
                                '">' +
                                item.descricao +
                                "</option>"
                            );
                        });
                        selectElement.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        console.error("Ocorreu um erro:", error);
                        console.log(xhr.responseText);
                    },
                });
            }

            $("#classeServico").change(function() {
                var classeServicoValue = $(this).val();
                var servicosSelect = $("#servicos");

                if (!classeServicoValue) {
                    servicosSelect
                        .empty()
                        .append('<option value="">Selecione um serviço</option>');
                    servicosSelect.prop("disabled", true);
                    return;
                }

                populateServicos(servicosSelect, classeServicoValue);
            });

            $("#add-proposta").click(function() {
                var newProposta = $("#template-proposta-comercial").html();
                $("#form-propostas-comerciais").append(newProposta);
            });

            $(document).on("click", ".remove-proposta", function() {
                $(this).closest(".proposta-comercial").remove();
            });
        });
    </script>
    <script>
        // Função para selecionar ou desmarcar todos os checkboxes
        function toggleCheckboxes(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Função para gerar conteúdo dinâmico nos modais
        function generateModalContent(selectedCheckboxes, modalContentId) {
            selectedCheckboxes.each(function() {
                const id = $(this).val();
                const newContent = `
                    <div class="row mb-3" data-id="${id}">
                        <div class="d-flex col-md-12">
                            <div class="col-md-4" style="margin-right: 5px">
                                <label for="prioridade-${id}" class="form-label">Prioridade da solicitação ${id}:</label>
                                <select name="prioridade[${id}]" id="prioridade-${id}" class="form-select select2">
                                    @for ($i = 1; $i <= 100; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="setor-${id}" class="form-label">Setor responsável:</label>
                                <select name="setor[${id}]" id="setor-${id}" class="form-select select2">
                                    @foreach ($todosSetor as $setor)
                                        <option value="{{ $setor->id }}">{{ $setor->nome }} - {{ $setor->sigla }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                `;
                $(modalContentId).append(newContent);
            });
        }

        $(document).ready(function() {
            // Inicializa o Select2 dentro dos modais
            $('#modalAprovarLote, #modalHomologarLote').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $(this)
                });
            });

            // Configuração do modal de Aprovar em Lote
            $('#modalAprovarLote').on('show.bs.modal', function() {
                $('#modal-body-content-aprovar').empty();
                const selectedCheckboxes = $('.item-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Por favor, selecione pelo menos uma solicitação.');
                    $('#modalAprovarLote').modal('hide');
                    return;
                }
                generateModalContent(selectedCheckboxes, '#modal-body-content-aprovar');
            });

            // Configuração do modal de Homologar em Lote
            $('#modalHomologarLote').on('show.bs.modal', function() {
                $('#modal-body-content-homologar').empty();
                const selectedCheckboxes = $('.item-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Por favor, selecione pelo menos uma solicitação.');
                    $('#modalHomologarLote').modal('hide');
                    return;
                }
                generateModalContent(selectedCheckboxes, '#modal-body-content-homologar');
            });

            // Recarrega a página ao cancelar no modal
            $('.btn-danger[data-bs-dismiss="modal"]').on('click', function() {
                location.reload();
            });
        });
    </script>
    <style>
        .card-body {
            overflow-x: hidden;
        }
    </style>
@endsection
