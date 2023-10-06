<button type="button" class="btn btn-primary btn-sm btn-block m-1 d-none"
        data-toggle="modal" data-target="#modal-compartir-ver-ajuste" id="btn_ver_modal_ajuste">
    ver Ajuste
</button>

<div wire:ignore.self class="modal fade" id="modal-compartir-ver-ajuste" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ver Ajuste</h4>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Muy Pronto...

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" {{--wire:click="limpiar()"--}} class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
