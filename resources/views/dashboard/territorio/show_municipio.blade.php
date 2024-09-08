<div wire:ignore.self class="modal fade" id="modal-show-municipio" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content {{--fondo--}}">
            <div class="modal-header bg-navy">
                <h4 class="modal-title">
                    Ver Municipio
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="col-12">
                    <!-- Widget: user widget style 2 -->
                    <div class="card card-widget widget-user-2">
                        <div class="card-footer p-0">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <span class="nav-link">
                                        Nombre <span class="float-right text-bold text-uppercase">{{ $municipioNombre }}</span>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <span class="nav-link">
                                        Abreviatura <span class="float-right text-bold text-uppercase">{{ $municipioAbreviatura }}</span>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <span class="nav-link">
                                        Asignación <span class="float-right text-bold">{{ formatoMillares($municipioFamilias, 0) }}</span>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <span class="nav-link">
                                        Parroquias <span class="float-right text-bold">{{ $municipioParroquias }}</span>
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <span class="nav-link">
                                        Estatus <span class="float-right text-bold">{{ $municipioEstatus }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_modal_show_minicipio">
                    Cerrar
                </button>
                <button type="button" class="btn btn-danger btn-sm" wire:click="destroyMunicipio('{{ $municipioRowquid }}')"
                        @if(!comprobarPermisos('municipios.destroy')) disabled @endif >
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-municipios"
                        data-dismiss="modal"
                        wire:click="editMunicipio('{{ $municipioRowquid }}')"
                        @if(!comprobarPermisos('municipios.edit')) disabled @endif >
                    <i class="fas fa-edit"></i> Editar
                </button>
            </div>
            {!! verSpinner() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

