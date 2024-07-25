{{-- Modal --}}
<div wire:ignore.self class="modal fade" id="modal-municipios" xmlns:wire="http://www.w3.org/1999/xhtml">
    <form wire:submit="saveMunicipio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-navy">
                    <h4 class="modal-title">@if($viewMunicipio == 'create')
                            Crear
                        @else
                            Editar
                        @endif Municipio</h4>
                    <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">Nombre</span>
                            </div>
                            <input type="text" class="form-control" wire:model="municipioNombre" placeholder="[string]">
                            @error('municipioNombre')
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
                            <input type="text" class="form-control" wire:model="municipioAbreviatura" placeholder="[string]">
                            @error('municipioAbreviatura')
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
                            <input type="text" class="form-control" wire:model="municipioFamilias" placeholder="[int]">
                            @error('municipioFamilias')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn @if($viewMunicipio != 'create') btn-primary @else btn-success @endif ">
                        <i class="fas fa-save"></i>
                        Guardar
                        @if($viewMunicipio != 'create')
                            Cambios
                        @endif
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="municipio_btn_cerrar">{{ __('Close') }}</button>
                </div>

                {!! verSpinner() !!}

            </div>
        </div>
    </form>
</div>
