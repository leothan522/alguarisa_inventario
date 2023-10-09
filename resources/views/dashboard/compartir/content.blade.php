<div class="container-fluid sticky-top" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="info-box shadow">
        @if($empresa->imagen)
            <img class="info-box-icon" src="{{ verImagen($empresa->imagen) }}" alt="Logo">
        @else
            <span class="info-box-icon bg-success"><i class="fas fa-store-alt"></i></span>
        @endif
        <div class="info-box-content">
            <span class="info-box-text text-uppercase">{{--<i class="fas fa-store-alt"></i>--}} {{ $empresa->nombre }}</span>
            <span class="info-box-number">
                <button type="button" wire:click="actualizar" class="btn btn-default btn-xs float-right"
                        id="header_btn_actualizar" {{--style="margin-right: 5px;"--}}>
                    <i class="fas fa-sync"></i> Actualizar
                </button>
                <button type="button" wire:click="verCuota" class="btn btn-default btn-xs float-right mr-3"
                        {{--id="header_btn_actualizar"--}} {{--style="margin-right: 5px;"--}}>
                    <i class="fas fa-list"></i> Ver Cuota
                </button>
            </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>

{{-- VISTAS STOCK --}}
<div class="row justify-content-around @if($viewMovimientos || $viewCuota) d-none @endif">
    @include('dashboard.stock.show_stock')
</div>
<div class="row justify-content-center @if(!$viewMovimientos || $viewCuota) d-none @endif">
    @include('dashboard.stock.show_movimientos')
</div>
@include('dashboard.compartir.modal_ver_ajuste')

<div class="row justify-content-center @if(!$viewCuota) d-none @endif">
    @include('dashboard.compartir.show_cuota')
</div>

