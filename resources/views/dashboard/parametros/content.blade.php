<div class="row justify-content-center">

    <div class="col-md-4 col-lg-3">
        @include('dashboard.parametros.form')
    </div>

    <div class="col-md-8 col-lg-9">
        @include('dashboard.parametros.table')
    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <label>Parametros Manuales</label>
        <ul>
            <li>numRowsPaginate[null|numero]</li>
            <li>size_codigo[tamaño|null]</li>
            <li>proximo_codigo_ajutes[empresas_id|numero]</li>
            <li>editable_fecha_ajutes[empresas_id|1/0]</li>
            <li>editable_codigo_ajutes[empresas_id|1/0]</li>
            {{--<li>iva</li>
            <li>telefono_soporte</li>
            <li>codigo_pedido</li>--}}
        </ul>
    </div>
</div>
