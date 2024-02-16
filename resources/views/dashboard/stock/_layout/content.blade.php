<div class="row justify-content-around @if($viewMovimientos) d-none @endif">
    @include('dashboard.stock._layout.show')
    @include('dashboard.stock._layout.modal')
</div>
<div class="row justify-content-center @if(!$viewMovimientos) d-none @endif">
    @include('dashboard.stock._layout.show_movimientos')
</div>
