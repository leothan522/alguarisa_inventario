<button type="button" class="btn btn-primary btn-sm btn-block m-1 d-none"
        data-toggle="modal" data-target="#modal-compartir-ver-ajuste" id="btn_ver_modal_ajuste">
    ver Ajuste
</button>

<div wire:ignore.self class="modal fade" id="modal-compartir-ver-ajuste" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">{{--<i class="fas fa-store-alt"></i>--}} {{ $modalEmpresa->nombre ?? '' }}</h5>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">

                {{--<h3 class="profile-username text-center text-uppercase">Almacen Principal</h3>--}}
                <p class="text-navy text-bold text-center text-uppercase m-3 pt-3">
                    {{ $getDetalles->almacen->nombre ?? '' }}
                </p>
                <ul class="list-group list-group-unbordered">
                    {{--<li class="dropdown-divider ml-3 mr-3"></li>--}}
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Articulo</b>
                            <a class="text-uppercase text-navy">{{ $getDetalles->articulo->descripcion ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Segmento</b>
                            <a class="text-uppercase text-navy">
                                @if($getDetalles)
                                    @if($getDetalles->ajustes->segmentos->tipo)
                                        {{ $getDetalles->ajustes->municipios->mini ?? '' }}
                                    @else
                                        {{ $getDetalles->ajustes->segmentos->descripcion ?? '' }}
                                    @endif
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Cantidad</b>
                            <a class="text-nowrap text-navy">
                                @if($getDetalles)
                                    @if($getDetalles->tipo->tipo == 1)
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                        </small>
                                    @else
                                        <small class="text-danger mr-1">
                                            <i class="fas fa-arrow-down"></i>
                                        </small>
                                    @endif
                                    {{ formatoMillares($getDetalles->cantidad, 0) }}
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Nro. Ajuste</b>
                            <a class="text-uppercase text-navy">{{ $getDetalles->ajustes->codigo ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Fecha</b>
                            <a class="text-navy">
                                @if($getDetalles)
                                    {{ diaEspanol($getDetalles->ajustes->fecha) }}, {{ verFecha($getDetalles->ajustes->fecha, 'd/m/Y h:i a') }}
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item {{--d-flex--}} justify-content-between align-items-center">
                            <b class="text-uppercase">Descripción</b><br>
                            <a class="text-uppercase text-navy">{{ $getDetalles->ajustes->descripcion ?? '' }}</a>
                        </li>

                    </div>
                    <!--/.direct-chat-messages-->
                </ul>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" {{--wire:click="limpiar()"--}} class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
