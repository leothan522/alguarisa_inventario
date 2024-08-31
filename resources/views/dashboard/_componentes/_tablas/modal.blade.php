<div wire:ignore.self class="modal fade" id="modal-tipos" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row col-md-10">

                    <div class="col-md-6">
                        <h4 class="modal-title">
                            Tipos
                        </h4>
                    </div>

                    <div class="col-md-6 justify-content-end">
                        <form wire:submit="buscar">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar" wire:model="keyword" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <button type="button" wire:click="limpiarTipos" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <div class="col-md-6 @if(!$form) d-none @endif ">
                        @include('dashboard.bienes.tipos.form')
                    </div>
                    <div class="col-12 @if(!$table) d-none @endif ">
                        @include('dashboard.bienes.tipos.table')
                    </div>
                </div>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" wire:click="limpiarTipos" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
