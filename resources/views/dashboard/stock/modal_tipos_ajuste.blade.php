<div wire:ignore.self class="modal fade" id="modal-tipos-ajuste" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Tipos de Ajuste
                        </h4>
                    </div>
                    <div class="col-md-5 justify-content-end">
                        <form wire:submit="buscarTiposAjuste">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar" wire:model="keywordTiposAjuste" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" wire:click="limpiarTiposAjuste" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        @include('dashboard.stock.card_form_tipos_ajuste')
                    </div>
                    <div class="col-md-8">
                        @include('dashboard.stock.card_table_tipos_ajuste')
                    </div>
                </div>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" wire:click="limpiarAlmacenes" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
