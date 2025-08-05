@extends('layouts.app')

@section('title')
    Incluir Serviços no Catálogo
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
                                Incluir Serviços no Catálogo
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/salvar-servico">{{-- Formulario de Inserção --}}
                            @csrf
                            <!-- Botão para alternar entre select e input -->
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-secondary" id="toggleButton"
                                    style="margin-bottom: 5px">Usar Classe Existente</button>
                            </div>
                            {{-- Selecione a classe de serviço ou crie uma nova --}}
                            <div class="form-group col-md-4" id="classeServicoContainer">
                                <label for="classe_servico">Classe de Serviço</label>
                                <select class="form-control select2" id="classe_servico" name="classe_servico">
                                    <option value="">Selecione uma Classe</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}">{{ $classe->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group d-none" id="novaClasseContainer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nova_classe_servico">Nova Classe de Serviço</label>
                                        <input type="text" class="form-control" id="nova_classe_servico"
                                            style="background-color: white" name="nova_classe_servico"
                                            placeholder="Digite a nova classe de serviço">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="sigla_classe_servico">Sigla da Nova Classe</label>
                                        <input type="text" class="form-control" id="sigla_classe_servico"
                                            style="background-color: white" name="sigla_classe_servico"
                                            placeholder="Digite a Sigla">
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- Adicionar tipos de serviço dinamicamente --}}
                            <div class="form-group col-md-4">
                                <label for="tipos_servico">Tipo de Serviço</label>
                                <div id="tipos_servico_container">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="tipos_servico[]"
                                            placeholder="Digite o tipo de serviço">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger remove-button" type="button">X</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success mt-2" id="addTipoServico">Adicionar Tipo de
                                    Serviço</button>
                            </div>
                            <div class="botões">
                                <a href="javascript:history.back()" type="button" value=""
                                    class="btn btn-danger col-md-3 col-2 mt-4 offset-md-2">Cancelar</a>
                                <button type="submit" value="Confirmar"
                                    class="btn btn-primary col-md-3 col-1 mt-4 offset-md-2">Confirmar
                                </button>
                            </div>
                        </form>{{-- Final Formulario de Inserção --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleButton');
            const classeServicoContainer = document.getElementById('classeServicoContainer');
            const novaClasseContainer = document.getElementById('novaClasseContainer');
            const classeServicoSelect = document.getElementById('classe_servico');
            const novaClasseInput = document.getElementById('nova_classe_servico');
            const siglaClasseInput = document.getElementById('sigla_classe_servico'); // Novo input para sigla

            toggleButton.addEventListener('click', function() {
                if (classeServicoContainer.classList.contains('d-none')) {
                    // Se o select de classe está oculto, mostrá-lo e esconder o campo de nova classe
                    classeServicoContainer.classList.remove('d-none');
                    novaClasseContainer.classList.add('d-none');
                    novaClasseInput.value = ''; // Limpa o input de nova classe
                    siglaClasseInput.value = ''; // Limpa o input da sigla
                    toggleButton.textContent = 'Usar Classe Existente';
                } else {
                    // Se o select de classe está visível, ocultá-lo e mostrar o campo de nova classe
                    classeServicoContainer.classList.add('d-none');
                    novaClasseContainer.classList.remove('d-none');
                    classeServicoSelect.value = ''; // Limpa o select de classe
                    toggleButton.textContent = 'Adicionar Nova Classe';
                }
            });

            // Código para adicionar e remover tipos de serviço dinamicamente
            const tiposServicoContainer = document.getElementById('tipos_servico_container');
            const addTipoServicoButton = document.getElementById('addTipoServico');

            addTipoServicoButton.addEventListener('click', function() {
                const newTipoServico = document.createElement('div');
                newTipoServico.classList.add('input-group', 'mb-3');
                newTipoServico.innerHTML = `
                <input type="text" class="form-control" name="tipos_servico[]" placeholder="Digite o tipo de serviço">
                <div class="input-group-append">
                    <button class="btn btn-danger remove-button" type="button">X</button>
                </div>
            `;
                tiposServicoContainer.appendChild(newTipoServico);
            });

            // Remover campo de tipo de serviço
            tiposServicoContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-button')) {
                    event.target.closest('.input-group').remove();
                }
            });
        });
    </script>
@endsection
