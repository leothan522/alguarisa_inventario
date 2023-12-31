<div class="row" xmlns:wire="http://www.w3.org/1999/xhtml">

    <form class="row col-md-12" wire:submit.prevent="save">

        <div class="col-md-6">

            <div class="card card-outline card-navy">

                <div class="card-header">
                    <h5 class="card-title">Información</h5>
                    <div class="card-tools">
                        <span class="btn-tool"><i class="fas fa-book"></i></span>
                    </div>
                </div>

                <div class="card-body">


                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="nombre" placeholder="Nombre de la Empresa">
                            @error('nombre')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">RIF</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="rif" placeholder="RIF de la Empresa">
                            @error('rif')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Jefe</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="jefe" placeholder="Nombre del jefe de la Empresa">
                            @error('jefe')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Moneda Base</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <select class="custom-select" wire:model.defer="moneda">
                                <option value="">Seleccione</option>
                                <option value="Bolivares">Bolivares</option>
                                <option value="Dolares">Dolares</option>
                            </select>
                            @error('moneda')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Telefonos</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="telefonos" placeholder="Telefonos">
                            @error('telefonos')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="email" placeholder="Email">
                            @error('email')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Dirección</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-directions"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="direccion" placeholder="Dirección">
                            @error('direccion')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>


                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h5 class="card-title">Imagen</h5>
                    <div class="card-tools">
                        <span class="btn-tool"><i class="fas fa-image"></i></span>
                    </div>
                </div>
                <div class="card-body">


                    <div class="row justify-content-center attachment-block p-3">

                        <div class="d-none">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" wire:model="photo" class="custom-file-input" id="customFileLang"
                                           lang="es" accept="image/jpeg, image/png">
                                    <label class="custom-file-label text-sm" for="customFileLang" data-browse="Elegir">
                                        Seleccionar Imagen</label>
                                </div>
                                <input type="text" wire:model="img_borrar_principal">
                            </div>
                        </div>

                        <div class="col-md-6 mt-3 mb-3">
                            <div class="text-center" style="cursor:pointer;">
                                <img class="img-thumbnail"
                                     @if ($photo) src="{{ $photo->temporaryUrl() }}" @else src="{{ asset(verImagen($verImagen)) }}" @endif
                                     {{--width="101" height="100"--}}  alt="Logo Tienda" onclick="imgEmpresa()"/>
                                @if($verImagen)
                                    <button type="button" class="btn badge text-danger position-absolute float-right"
                                            wire:click="btnBorrarImagen">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            @error('photo')
                                <span class="text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>

            {{--@if ($photo)

                Logo Preview:

                <img src="{{ $photo->temporaryUrl() }}" class="img-fluid img-thumbnail rounded mx-auto d-block">
            @else
                @if($logo)
                    <img src="{{ asset(verImg($logo)) }}" class="img-fluid img-thumbnail rounded mx-auto d-block">
                @endif
            @endif--}}

            {{--<div wire:loading wire:target="photo">Uploading...</div>--}}

        </div>

        <div class="col-md-12">
            <div class="col-md-4 float-right">
                <button type="submit" class="btn btn-block btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>


    </form>
</div>
