{{--<button type="button" class="btn btn-primary btn-sm btn-block m-1"
        data-toggle="modal" data-target="#modal-user-permisos"
    --}}{{--onclick="verRoles({{ $parametro->id }})" id="set_rol_id_{{ $parametro->id }}"--}}{{-->
    Categorias
</button>--}}

<div wire:ignore.self class="modal fade" id="modal-parroquias" xmlns:wire="http://www.w3.org/1999/xhtml">
    <form {{--wire:submit.prevent="store"--}} xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-navy">
                <h4 class="modal-title">Crear Parroquias</h4>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">Municipio{{--<i class="fas fa-code"></i>--}}</span>
                            </div>
                            <select class="custom-select">
                                <option value="">Seleccione</option>
                            </select>
                            @error('nombre')
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
                                <span class="input-group-text text-bold">nombre{{--<i class="fas fa-code"></i>--}}</span>
                            </div>
                            <input type="text" class="form-control" {{--wire:model.defer="nombre"--}} name="nombre" placeholder="[string]">
                            @error('nombre')
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
                            <input type="text" class="form-control" {{--wire:model.defer="nombre"--}} name="nombre" placeholder="[string]">
                            @error('nombre')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="submit" {{--wire:click="limpiar()"--}} class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <button type="button" {{--wire:click="limpiar()"--}} class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

            {!! verSpinner() !!}

        </div>
    </div>
    </form>
</div>
