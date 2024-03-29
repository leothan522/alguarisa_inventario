@if($modulo_activo)

    <!-- Main content -->
    <div class="invoice p-3 mb-3" xmlns:wire="http://www.w3.org/1999/xhtml">

        <!-- title row -->
        <div class="row {{--@if($view != "ajustes") mb-3 @endif--}}{{--mb-3--}}">
            <div class="col-12">
                <h3>
                    <i class="fas fa-store-alt"></i> <span class="text-uppercase">{{ $empresa->nombre }}</span>
                    <small class="float-right">
                        <select class="custom-select" wire:model.live="empresa_id" onchange="cambiarEmpresa()">
                            @foreach($listarEmpresas as $empresa)
                                <option value="{{ $empresa['id'] }}">{{ $empresa['text'] }}</option>
                            @endforeach
                        </select>
                    </small>
                </h3>
            </div>
        </div>

        <!-- Button row -->
        <div class="row invoice-info d-none">
            <div class="col-12 mb-3">
                <span class="btn" style="cursor: default;">
                    @if($view != "stock")
                        Mostrando Ajustes
                    @else
                        Mostrando Existencias
                    @endif
                </span>
                @if(!empty($keywordStock) && $view == "stock")
                    <span class="btn">
                    Resultados de la Búsqueda { <b class="text-danger">{{ $keywordAjustes }}</b> }
                    </span>
                    <button class="btn btn-tool text-danger" wire:click="show"><i class="fas fa-times-circle"></i>
                    </button>
                @endif

                <!-- Right -->
                <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1" id="content_btn_ajustes"
                        wire:click="verAjustes"
                        @if($view == "ajustes" || !comprobarPermisos('ajustes.index')) disabled @endif>
                    <i class="fas fa-list"></i> Ajustes
                </button>
                <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1" id="content_btn_existencias"
                        wire:click="verAjustes" @if($view == "stock") disabled @endif>
                    <i class="fas fa-boxes"></i> Existencias
                </button>
                <button type="button" wire:click="show" class="btn btn-default btn-sm float-right ml-1 mr-1"
                        id="content_btn_actualizar" {{--style="margin-right: 5px;"--}}>
                    <i class="fas fa-sync"></i> Actualizar
                </button>
            </div>
        </div>
        <div {{--class="row"--}}>
            @include('dashboard.stock.modal_almacenes')
            @include('dashboard.stock.modal_tipos_ajuste')
            @include('dashboard.stock.modal_segmentos')
            @include('dashboard.stock.modal_reportes_stock')
            @include('dashboard.stock.modal_reportes_ajustes')
            @include('dashboard.stock.modal_compartir_qr')
            @include('dashboard.stock.modal_cuotas')
        </div>

        <div class="overlay-wrapper" wire:loading wire:target="empresa_id{{--, setEstatus, show, verAjustes--}}">
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="overlay-wrapper d-none cargar_buscar">
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

    </div>
    {{-- VISTAS STOCK --}}
    <div class="row justify-content-around @if($view != "stock" || $viewMovimientos) d-none @endif">
        @include('dashboard.stock.show_stock')
    </div>
    <div class="row justify-content-center @if($view != "stock" || !$viewMovimientos) d-none @endif">
        @include('dashboard.stock.show_movimientos')
    </div>

    {{-- VISTAS AJUSTES--}}
    <div class="row @if($view != "ajustes") d-none @endif">
        <div class="col-md-4">
            @include('dashboard.stock.table_ajustes')
        </div>
        <div class="col-md-8">
            @include('dashboard.stock.show_ajustes')
        </div>
    </div>

@else
    @if(!$modulo_empresa || !$modulo_articulo)
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            Para que este Modulo este <span class="text-bold text-navy">Activo</span>, es Necesario previmente crear una
            <span class="text-bold @if($modulo_empresa) text-success @else text-danger @endif">Empresa</span>,
            un <span
                class="text-bold @if($modulo_empresa) text-success @else text-danger @endif">Almacen</span>
            y Tener Al menos un <span class="text-bold @if($modulo_articulo) text-success @else text-danger @endif">Articulo</span>
            Registrado.
        </div>
    @else
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            El <span class="text-bold text-danger">Usuario</span> actual
            NO tiene acceso a ninguna empresa. Contacte con su <span class="text-bold text-navy">Administrador</span>.
        </div>
    @endif
@endif




