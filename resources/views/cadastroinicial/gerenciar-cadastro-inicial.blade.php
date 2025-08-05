@extends('layouts.app')

@section('title')
    Gerenciar Cadastro Inicial
@endsection
@section('content')
    <form method="GET" action="/gerenciar-cadastro-inicial">{{-- Formulario de pesquisa --}}
        @csrf
        <div class="container-fluid"> {{-- Container completo da página  --}}
            <div class="justify-content-center">
                <div class="col-12">
                    <br>
                    <div class="card" style="border-color: #355089;">
                        <div class="card-header">
                            <div class="ROW">
                                <h5 class="col-12" style="color: #355089">
                                    Gerenciar Cadastro Inicial
                                </h5>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md d-flex">
                                    <button type="button" class="btn  btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#filtros"
                                        style="box-shadow: 1px 2px 5px #000000; background-color: rgb(231, 231, 69); margin-right: 2%">
                                        FILTRAR <i class="bi bi-funnel"></i>
                                    </button>
                                    <a class="btn btn-secondary" style="box-shadow: 1px 2px 5px #000000; margin-right: 2%" href="/gerenciar-cadastro-inicial">Limpar</a>
                                </div>
                                <div class="col-md d-flex justify-content-end">
                                    <a href="/salvar-termo-compra" class="btn btn-success"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; ">
                                        COMPRA DIRETA
                                    </a>
                                    <a href="/salvar-termo-doacao" class="btn btn-success"
                                        style="font-size: 1rem; box-shadow: 1px 2px 5px #000000; margin-left: 2%">
                                        DOAÇÃO
                                    </a>
                                </div>
                            </div>
                            <br>
                            <hr>
                            {{-- @foreach ($aquisicao as $aquisicaos)
                                @if (in_array($aquisicaos->id_setor, ['1', '2', '5', $setor])) --}}
                            <table {{-- Inicio da tabela de informacoes --}}
                                class= "table table-sm table-striped table-bordered border-secondary table-hover align-middle"
                                id="tabela-materiais" style="width: 100%">
                                <thead style="text-align: center;">{{-- inicio header tabela --}}
                                    <tr style="background-color: #d6e3ff; font-size:15px; color:#000;" class="align-middle">
                                        <th>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)"
                                                    aria-label="Selecionar todos" style="border: 1px solid #000">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>DATA</th>
                                        @if ($request->pesquisaDeposito)
                                            <th>DEPÓSITO</th>
                                        @endif
                                        @if ($request->pesquisaDestinacao)
                                            <th>DESTINAÇÃO</th>
                                        @endif
                                        <th>NR. DOC.</th>
                                        <th>CATEGORIA</th>
                                        @if ($request->pesquisaEmpresa)
                                            <th>EMPRESA</th>
                                        @endif
                                        <th>NOME</th>
                                        @if ($request->pesquisaDocumento)
                                            <th>TIPO DE DOCUMENTO</th>
                                        @endif
                                        @if ($request->pesquisaTipoMaterial)
                                            <th>TIPO DE MATERIAL</th>
                                        @endif
                                        @if ($request->pesquisaSolicitacao)
                                            <th>SOLICITAÇÃO</th>
                                        @endif
                                        <th>STATUS</th>
                                        <th>AÇÕES</th>
                                    </tr>
                                </thead>{{-- Fim do header da tabela --}}
                                <tbody style="font-size: 15px; color:#000000; text-align: center;">
                                    {{-- Inicio body tabela --}}
                                    @foreach ($CadastroInicial as $CadastroInicials)
                                        <tr>
                                            <td>
                                                <div style="display: flex; justify-content: center; align-items: center;">
                                                    <input class="form-check-input item-checkbox" type="checkbox"
                                                        id="checkboxNoLabel" value="{{ $CadastroInicials->id }}"
                                                        aria-label="..." style="border: 1px solid #000">
                                                </div>
                                            </td>
                                            <td>{{ $CadastroInicials->id ?? 'N/A' }}</td>
                                            <td>{{ $CadastroInicials->data_cadastro ? \Carbon\Carbon::parse($CadastroInicials->data_cadastro)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            @if ($request->pesquisaDeposito)
                                                <td>{{ $CadastroInicials->deposito->nome ?? 'N/A' }}</td>
                                            @endif
                                            @if ($request->pesquisaDestinacao)
                                                <td>{{ $CadastroInicials->destinacao->descricao ?? 'N/A' }}</td>
                                            @endif

                                            <td>{{ $CadastroInicials->DocOrigem->numero ?? 'N/A' }}</td>
                                            <td>{{ $CadastroInicials->CategoriaMaterial->nome ?? 'N/A' }}</td>

                                            @if ($request->pesquisaEmpresa)
                                                <td>{{ $CadastroInicials->docOrigem->empresa->razaosocial ?? 'N/A' }} -
                                                    {{ $CadastroInicials->docOrigem->empresa->nomefantasia ?? 'N/A' }}</td>
                                            @endif

                                            <td>{{ $CadastroInicials->ItemCatalogoMaterial->nome ?? 'N/A' }}</td>

                                            @if ($request->pesquisaDocumento)
                                                <td>{{ $CadastroInicials->docOrigem->tipoDocumento->descricao ?? 'N/A' }}
                                                </td>
                                            @endif
                                            @if ($request->pesquisaTipoMaterial)
                                                <td>{{ $CadastroInicials->TipoMaterial->nome ?? 'N/A' }}</td>
                                            @endif
                                            @if ($request->pesquisaSolicitacao)
                                                <td>{{ $CadastroInicials->id_sol_origem ?? 'N/A' }}</td>
                                            @endif

                                            <td>{{ $CadastroInicials->status->descricao ?? 'N/A' }}</td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Visualizar">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                                @php
                                                    $idTpDoc = $CadastroInicials->docOrigem->id_tp_doc ?? null;
                                                    $documentoOrigem = $CadastroInicials->documento_origem;

                                                    $rota = match (true) {
                                                        $idTpDoc === 16
                                                            => "/gerenciar-cadastro-inicial/doacao/{$documentoOrigem}",
                                                        in_array($idTpDoc, [1, 4, 6, 7, 8])
                                                            => "/gerenciar-cadastro-inicial/compra-direta/{$documentoOrigem}",
                                                        default => null,
                                                    };
                                                @endphp

                                                @if ($rota)
                                                    <a href="{{ $rota }}" class="btn btn-sm btn-outline-warning"
                                                        data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                        data-placement="top" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif
                                                {{-- @if (in_array($aquisicaos->tipoStatus->id, ['3', '2'])) --}}
                                                {{-- <a href="" class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Completar Cadastro">
                                                    <i class="bi bi-check-lg"></i>
                                                </a> --}}
                                                {{-- @endif --}}
                                                {{-- @if ($aquisicaos->tipoStatus->id == '3') --}}
                                                {{-- <a href="" class="btn btn-sm btn-outline-success" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Material Devolvido">
                                                    <i class="bi bi-clipboard-check"></i>
                                                </a> --}}
                                                {{-- @endif --}}
                                                {{-- @if ($aquisicaos->tipoStatus->id == '1') --}}
                                                {{-- <a href="" class="btn btn-sm btn-outline-primary" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Enviar Material">
                                                    <i class="bi bi-cart-check"></i>
                                                </a> --}}
                                                {{-- @endif --}}
                                                {{-- @if (isset($aquisicaos->aut_usu_pres, $aquisicaos->aut_usu_adm, $aquisicaos->aut_usu_daf)) --}}
                                                {{-- <a href="" class="btn btn-sm btn-outline-info" data-tt="tooltip"
                                                    style="font-size: 1rem; color:#303030" data-placement="top"
                                                    title="Solicitar Teste">
                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                </a> --}}
                                                {{-- @endif --}}
                                                {{-- @if ($aquisicaos->tipoStatus->id == '1') --}}
                                                <a class="btn btn-sm btn-outline-danger excluirSolicitacao"
                                                    data-tt="tooltip" style="font-size: 1rem; color:#303030"
                                                    data-placement="top" title="Excluir" data-bs-toggle="modal"
                                                    data-bs-target="#modalExcluirMaterial"
                                                    data-id="{{ $CadastroInicials->id }}"
                                                    data-documento-id="{{ $CadastroInicials->documento_origem }}"
                                                    data-nome='{{ $CadastroInicials->ItemCatalogoMaterial->nome ?? 'N/A' }}'>
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                                {{-- @endif --}}
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
                            {{ $CadastroInicial->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Filtros -->
        <div class="modal fade" id="filtros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:grey;color:white">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Filtrar Opções</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="row col-10">
                                <div class="col-md-6 col-sm-12 mb-2">Por Depósito
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaDeposito" id="idPesquisaDeposito">
                                        <option value="">Todos</option>
                                        @foreach ($deposito as $depositos)
                                            <option value="{{ $depositos->id }}"
                                                {{ old('pesquisaDeposito') == $depositos->id ? 'selected' : '' }}>
                                                {{ $depositos->sigla }} - {{ $depositos->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Período
                                    <div class="d-flex gap-2">
                                        <input type="date" class="form-control" name="pesquisaDataInicioPeriodo"
                                            id="idPesquisaDataInicioPeriodo"
                                            value="{{ request('pesquisaDataInicioPeriodo') }}"
                                            style="border: 1px solid #999999; background-color: #ffffff;">
                                        <input type="date" class="form-control" name="pesquisaDataFimPeriodo"
                                            id="idPesquisaDataFimPeriodo" value="{{ request('pesquisaDataFimPeriodo') }}"
                                            style="border: 1px solid #999999; background-color: #ffffff;">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Destinação
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaDestinacao" id="idPesquisaDestinacao">
                                        <option value="">Todos</option>
                                        @foreach ($destinacao as $destinacaos)
                                            <option value="{{ $destinacaos->id }}"
                                                {{ old('pesquisaDestinacao') == $destinacaos->id ? 'selected' : '' }}>
                                                {{ $destinacaos->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Categoria do Material
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaCategoriaMaterial" id="idPesquisaCategoriaMaterial">
                                        <option value="">Todos</option>
                                        @foreach ($categoriaMaterial as $categoriaMaterials)
                                            <option value="{{ $categoriaMaterials->id }}"
                                                {{ old('pesquisaCategoriaMaterial') == $categoriaMaterials->id ? 'selected' : '' }}>
                                                {{ $categoriaMaterials->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Empresa
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaEmpresa" id="idPesquisaEmpresa">
                                        <option value="">Todos</option>
                                        @foreach ($empresa as $empresas)
                                            <option value="{{ $empresas->id }}"
                                                {{ old('pesquisaEmpresa') == $empresas->id ? 'selected' : '' }}>
                                                {{ $empresas->razaosocial }} - {{ $empresas->nomefantasia }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Nome do Material
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaNomeMaterial" id="idPesquisaNomeMaterial">
                                        <option value="">Todos</option>
                                        @foreach ($nomeMaterial as $nomeMaterials)
                                            <option value="{{ $nomeMaterials->id }}"
                                                {{ old('pesquisaNomeMaterial') == $nomeMaterials->id ? 'selected' : '' }}>
                                                {{ $nomeMaterials->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Tipo de Documento
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaDocumento" id="idPesquisaDocumento">
                                        <option value="">Todos</option>
                                        @foreach ($tipoDocumento as $tipoDocumentos)
                                            <option value="{{ $tipoDocumentos->id }}"
                                                {{ old('pesquisaDocumento') == $tipoDocumentos->id ? 'selected' : '' }}>
                                                {{ $tipoDocumentos->sigla }} - {{ $tipoDocumentos->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Número de Documento
                                    <input type="text" class="form-control" name="pesquisaNumeroDocumento"
                                        id="idPesquisaNumeroDocumento" value="{{ old('pesquisaNumeroDocumento') }}"
                                        style="border: 1px solid #999999; background-color: #ffffff;">
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Tipo de Material
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaTipoMaterial" id="idPesquisaTipoMaterial">
                                        <option value="">Todos</option>
                                        @foreach ($tipoMaterial as $tipoMaterials)
                                            <option value="{{ $tipoMaterials->id }}"
                                                {{ old('pesquisaTipoMaterial') == $tipoMaterials->id ? 'selected' : '' }}>
                                                {{ $tipoMaterials->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Solicitação de Material
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaSolicitacao" id="idPesquisaSolicitacao">
                                        <option value="">Todos</option>
                                        @foreach ($solMat as $solMats)
                                            <option value="{{ $solMats->id }}"
                                                {{ old('pesquisaSolicitacao') == $solMats->id ? 'selected' : '' }}>
                                                {{ $solMats->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">Por Status
                                    <select class="form-select select2" style="border: 1px solid #999999;"
                                        name="pesquisaStatus" id="idPesquisaStatus">
                                        <option value="">Todos</option>
                                        @foreach ($status as $statuss)
                                            <option value="{{ $statuss->id }}"
                                                {{ old('pesquisaStatus') == $statuss->id ? 'selected' : '' }}>
                                                {{ $statuss->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <a class="btn btn-secondary" href="/gerenciar-cadastro-inicial">Limpar</a>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>{{-- Final Formulario de pesquisa --}}
    <x-modal-excluir id="modalExcluirMaterial" labelId="modalExcluirMaterialLabel"
        action="{{ url('/cadastro-inicial-material/deletar') }}" title="Excluir Material">
        <input type="hidden" name="delete-id" id="delete-id">
        <input type="hidden" name="documento-id-excluir" id="documento-id-excluir">
        <div class="row">
            <label>Deseja realmente <strong style="color: red">excluir</strong> o material <span
                    id="nome-material"></span>?</label>
        </div>
    </x-modal-excluir>
    @if (session('pdf_base64'))
        <iframe id="pdfFrame" style="display:none;"></iframe>

        <script>
            const base64PDF = "{{ session('pdf_base64') }}";
            const pdfFrame = document.getElementById("pdfFrame");

            // Cria o blob do PDF
            const byteCharacters = atob(base64PDF);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], {
                type: 'application/pdf'
            });
            const blobUrl = URL.createObjectURL(blob);

            // Coloca o PDF no iframe e imprime
            pdfFrame.src = blobUrl;
            pdfFrame.onload = function() {
                pdfFrame.contentWindow.focus();
                pdfFrame.contentWindow.print();
            };
        </script>
    @endif
    <script>
        // Função para selecionar ou desmarcar todos os checkboxes
        function toggleCheckboxes(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        $(document).ready(function() {
            // Inicializa o Select2 dentro dos modais
            $('#filtros').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $(this)
                });
            });

            // Recarrega a página ao cancelar no modal
            $('.btn-danger[data-bs-dismiss="modal"]').on('click', function() {
                location.reload();
            });
        });
    </script>
@endsection
