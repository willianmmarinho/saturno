<div class="modal fade" id="{{ $id ?? 'modalIncluir' }}" tabindex="-1"
    aria-labelledby="{{ $labelId ?? 'modalIncluirLabel' }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ $action ?? '#' }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightblue;">
                    <h5 class="modal-title" id="{{ $labelId ?? 'modalIncluirLabel' }}">
                        {{ $title ?? 'Defina um Título' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="{{ $bodyId ?? 'modal-body-content-incluir' }}">
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

{{-- <!-- Modal Incluir -->
<x-modal-incluir id="modalIncluir" labelId="modalIncluirLabel"
        action="" title="Escreva um título">
        <div class="row">
            <!-- Modal body -->
        </div>
    </x-modal-incluir>
--}}
