<div class="modal fade" id="{{ $id ?? 'modalEditar' }}" tabindex="-1"
    aria-labelledby="{{ $labelId ?? 'modalEditarLabel' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" method="POST" action="{{ $action ?? '#' }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightyellow;">
                    <h5 class="modal-title" id="{{ $labelId ?? 'modalEditarLabel' }}">
                        {{ $title ?? 'Defina um Título' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="{{ $bodyId ?? 'modal-body-content-editar' }}">
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

{{-- <!-- Modal Editar -->
<x-modal-editar id="modalEditar" labelId="modalEditarLabel"
        action="" title="Escreva um título">
        <div class="row">
            <!-- Modal body -->
        </div>
    </x-modal-editar>
--}}
