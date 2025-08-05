<div class="modal fade" id="{{ $id ?? 'modalExcluir' }}" tabindex="-1" aria-labelledby="{{ $labelId ?? 'modalExcluirLabel' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" method="POST" action="{{ $action ?? '#' }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background-color:#DC4C64;">
                    <h5 class="modal-title" id="{{ $labelId ?? 'modalExcluirLabel' }}">
                        {{ $title ?? 'Defina um Título' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="{{ $bodyId ?? 'modal-body-content-excluir' }}">
                    {{ $slot }}
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- <!-- Modal Excluir -->
<x-modal-excluir id="modalExcluir" labelId="modalExcluirLabel"
        action="" title="Escreva um título">
        <div class="row">
            <!-- Modal body -->
        </div>
    </x-modal-excluir>
--}}
