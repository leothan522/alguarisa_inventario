<div class="container-fluid sticky-top" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="info-box shadow">
        {{--<span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>--}}

        <div class="info-box-content">
            <span class="info-box-text"><i class="fas fa-boxes"></i> {{ $empresa->nombre }}</span>
            <span class="info-box-number">
                <button type="button" wire:click="actualizar" class="btn btn-default btn-xs float-right"
                        id="header_btn_actualizar" {{--style="margin-right: 5px;"--}}>
                    <i class="fas fa-sync"></i> Actualizar
                </button>
            </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>

{{-- VISTAS STOCK --}}
<div class="row justify-content-around">
    @include('dashboard.stock.show_stock')
</div>
