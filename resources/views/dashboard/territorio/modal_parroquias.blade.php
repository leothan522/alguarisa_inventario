{{-- modal --}}
<div wire:ignore.self class="modal fade" id="modal-parroquias" xmlns:wire="http://www.w3.org/1999/xhtml">
    <form wire:submit="saveParroquia" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h4 class="modal-title">@if($viewParroquia == "create") Crear @else Editar @endif Parroquia</h4>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">

                        <div wire:ignore>
                            <div class="input-group mb-3" id="parroquias_div_select"></div>
                        </div>
                        @error('parroquiaMunicipio')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">nombre{{--<i class="fas fa-code"></i>--}}</span>
                            </div>
                            <input type="text" class="form-control" wire:model="parroquiaNombre" placeholder="[string]">
                            @error('parroquiaNombre')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">Abreviatura{{--<i class="fas fa-code"></i>--}}</span>
                            </div>
                            <input type="text" class="form-control" wire:model="parroquiaAbreviatura" placeholder="[string]">
                            @error('parroquiaAbreviatura')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">Asignación{{--<i class="fas fa-code"></i>--}}</span>
                            </div>
                            <input type="text" class="form-control" wire:model="parroquiaFamilias" placeholder="[int]">
                            @error('parroquiaFamilias')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                            @error('parroquiaMax')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar @if($viewParroquia != "create") Cambios @endif
                </button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="parroquia_btn_cerrar">{{ __('Close') }}</button>
            </div>

            {!! verSpinner() !!}

        </div>
    </div>
    </form>
</div>
