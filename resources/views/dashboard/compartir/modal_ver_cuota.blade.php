<button type="button" class="btn btn-primary btn-sm btn-block m-1 d-none"
        data-toggle="modal" data-target="#modal-compartir-ver-cuota" id="btn_ver_modal_cuota">
    ver Ajuste
</button>

<div wire:ignore.self class="modal fade" id="modal-compartir-ver-cuota" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">{{--<i class="fas fa-store-alt"></i>--}} {{ $empresa->nombre ?? '' }}</h5>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">

                {{--<h3 class="profile-username text-center text-uppercase">Almacen Principal</h3>--}}
                <p class="text-navy text-bold text-center text-uppercase m-3 pt-3">
                    {{ $modalMunicipio ?? '' }}
                </p>
                <ul class="list-group list-group-unbordered">
                    {{--<li class="dropdown-divider ml-3 mr-3"></li>--}}
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Censo</b>
                            <a class="text-uppercase text-navy">{{ $modalCenso ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Deuda Anterior</b>
                            <a class="text-uppercase text-navy">{{ $modalDeudaAnterior ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Deuda Acumulada</b>
                            <a class="text-uppercase text-navy">{{ $modalDuedaAcumulada ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Cuota Actual</b>
                            <a class="text-uppercase text-navy">{{ $cuotaMes }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Envío</b>
                            <a class="text-nowrap text-navy">{{ $modalDespacho ?? '' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="text-uppercase">Deuda Total</b>
                            <a class="text-uppercase text-navy">{{ $modalDeudaTotal ?? '' }}</a>
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
