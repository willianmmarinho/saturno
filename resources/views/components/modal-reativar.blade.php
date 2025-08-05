@props([
    'id' => 'modalInativar',
    'labelId' => 'modalInativarLabel',
    'action' => '#',
    'title' => 'Defina um Título',
])

<!-- Modal de Inativação -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $labelId }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="{{ $action }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0d6efd; color: white;">
                    <h5 class="modal-title" id="{{ $labelId }}">
                        {{ $title }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modal-body-content-{{ $id }}">
                    {{ $slot }}
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Inativar</button>
                </div>
            </div>
        </form>
    </div>
</div>
