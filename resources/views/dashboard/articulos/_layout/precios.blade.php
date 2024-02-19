<div wire:ignore.self class="modal fade" id="modal-sm-articulos-precios" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">


            <div class="modal-header bg-navy">
                <h4 class="modal-title">Precios</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive p-0" style="height: 40vh;">

                    <table class="table table-sm table-head-fixed table-hover text-nowrap">
                        <thead>
                        <tr class="text-navy">
                            <th style="width: 10%">Unidad</th>
                            <th style="width: 10%">Moneda</th>
                            <th>Precio</th>
                            <th style="width: 5%">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listarPrecios->isNotEmpty())
                            @foreach($listarPrecios as $precio)
                                <tr>
                                    <td>{{ $precio->unidad->codigo }}</td>
                                    <td>{{ $precio->moneda }}</td>
                                    <td>{{ formatoMillares($precio->precio, 2) }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm text-danger m-0" wire:click="edit({{ $precio->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm text-danger m-0" wire:click="destroy({{ $precio->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-danger">
                                    Sin registros guardados.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>


                </div>

                <form wire:submit="save" class="p-0">
                    <table class="table table-sm">
                        <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="custom-select custom-select-sm" wire:model="unidades_id">
                                            <option value="">Seleccione</option>
                                            @foreach($listarUnidades as $unidad)
                                                @if($unidad->ver)
                                                    <option value="{{ $unidad->id }}">{{ $unidad->codigo }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error("unidades_id")
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="custom-select custom-select-sm" wire:model="moneda">
                                            <option value="">Seleccione</option>
                                            <option value="Bolivares">Bolivares</option>
                                            <option value="Dolares">Dolares</option>
                                        </select>
                                    </div>
                                    @error("moneda")
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" wire:model="precio" placeholder="precio">
                                    </div>
                                    @error("precio")
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </td>
                            <td style="width: 5%;">
                                <button type="submit" class="btn btn-success  btn-sm"
                                        @if(!comprobarPermisos('precios.unidades')) disabled @endif >
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>



            </div>

            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
            </div>

            {!! verSpinner() !!}

            <div class="overlay-wrapper d-none cargar_precio">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
