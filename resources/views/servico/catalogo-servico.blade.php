@extends('layouts.app')

@section('title')
    Catálogo de Serviços
@endsection
@section('content')
    <div class="container-fluid"> {{-- Container completo da página --}}
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Catálogo de Serviços
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="/catalogo-servico">{{-- Formulario de Inserção --}}
                            @csrf
                            <div style="display: flex; gap: 20px; align-items: flex-end;">
                                <div class="col-md-2 col-sm-12">Classe do Serviço
                                    <br>
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px;" id="classeServico" name="classe">
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
                                <div class="col-md-1 col-sm-12">Situação da Classe
                                    <br>
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px;" id="classeSituacao"
                                        name="classeSituacao">
                                        <option value="">Todos</option> <!-- Opção 'Todos' com valor vazio -->
                                        <option value="true">Ativo</option>
                                        <option value="false">Inativo</option>
                                    </select>
                                </div>
                                <div class="col-md-1 col-sm-12">Situação da Serviço
                                    <br>
                                    <select class="js-example-responsive form-select select2"
                                        style="border: 1px solid #999999; padding: 5px;" id="servSituacao"
                                        name="servSituacao">
                                        <option value="">Todos</option> <!-- Opção 'Todos' com valor vazio -->
                                        <option value="true">Ativo</option>
                                        <option value="false">Inativo</option>
                                    </select>
                                </div>
                                <div class="col" style="margin-top: 20px">
                                    <input class="btn btn-light btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="submit"
                                        value="Pesquisar">
                                    <a href="/catalogo-servico" class="btn btn-light btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;" type="button"
                                        value="">
                                        Limpar
                                    </a>
                                    <a href="/incluir-servico" class="btn btn-success btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;"
                                        type="button">
                                        Novo+
                                    </a>
                                    <a  class="btn btn-danger btn-sm"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin:5px;"
                                        data-bs-toggle="modal" data-bs-target="#modalExcluir">
                                        Excluir Classe
                                    </a>
                                </div>
                            </div>
                        </form>
                        {{-- Final Formulario de Inserção --}}
                        <!-- Modal Excluir Classe -->
                        <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="form-horizontal" method="POST" action="{{ url('/deletar-classe-servico') }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#DC4C64;">
                                            <h5 class="modal-title" id="modalExcluirLabel">Confirmar Exclusão/Inativação
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Selecione a classe a ser excluída/Inativada:
                                            <select name="classeExcluir" class="form-select select2">
                                                @foreach ($classeAquisicao as $classeAquisicaos)
                                                    <option value="{{ $classeAquisicaos->id }}">
                                                        {{ $classeAquisicaos->descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer mt-2">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FIM da Modal Excluir Classe -->
                        <br>
                        <hr>
                        <table {{-- Inicio da tabela de informacoes --}}
                            class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                            <thead style="text-align: center; ">{{-- inicio header tabela --}}
                                <tr style="background-color: #d6e3ff; color:#000;" class="align-middle">

                                    <th>CLASSE</th>
                                    <th>TIPO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>{{-- Fim do header da tabela --}}
                            <tbody style="color:#000000; text-align: center;">{{-- Inicio body tabela --}}
                                @foreach ($aquisicao as $aquisicaos)
                                    @if ($aquisicaos->tipoClasseSv)
                                        <tr>

                                            <td>{{ $aquisicaos->tipoClasseSv->descricao }}</td>
                                            <td>{{ $aquisicaos->descricao }}</td>
                                            <td>
                                                <a href="/editar-servico/{{ $aquisicaos->id }}"
                                                    class="btn btn-sm btn-outline-warning" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal" data-bs-target="#A{{ $aquisicaos->id }}"
                                                    class="btn btn-outline-danger btn-sm" data-bs-placement="top"
                                                    title="Excluir"><i class="bi bi-trash"
                                                        style="font-size: 1rem; color:#303030;"></i></button>

                                                <!-- Modal Excluir Tipo -->
                                                <div class="modal fade" id="A{{ $aquisicaos->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form class="form-horizontal" method="POST"
                                                            action="{{ url('/deletar-servico/' . $aquisicaos->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color:#DC4C64;">
                                                                    <h5 class="modal-title" id="exampleModalLabel"
                                                                        style=" color:rgb(255, 255, 255)">Excluir/Inativar
                                                                        Servico
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" style="text-align: center">
                                                                    Você realmente deseja Excluir/Inativar <br><span
                                                                        style="color:#DC4C64; font-weight: bold">{{ $aquisicaos->descricao }}</span>
                                                                    ?

                                                                </div>
                                                                <div class="modal-footer mt-2">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Confirmar</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!--Fim Modal-->
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            {{-- Fim body da tabela --}}
                        </table>
                    </div>
                    <div style="margin-right: 10px; margin-left: 10px">
                        {{ $aquisicao->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection
