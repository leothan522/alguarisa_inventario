@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Pagna de Prueba')

@section('content_header')
    {{--<h1>Pagina de Prueba</h1>--}}
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-boxes"></i> Pagina de Prueba</h1>
        </div>
        <div class="col-sm-6">
            {{--<ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Articulos con existencia</li>
            </ol>--}}
            <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1"
                    onclick="showRow('button_ajustes')" id="button_ajustes"
                {{--wire:click="verAjustes" @if($view == "ajustes" || !comprobarPermisos('ajustes.index')) disabled @endif--}}>
                <i class="fas fa-list"></i> Ajustes
            </button>
            <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1"
                    onclick="showRow('button_stock')" id="button_stock" disabled
                {{-- wire:click="verAjustes" @if($view == "stock") disabled @endif--}}>
                <i class="fas fa-boxes"></i> Inventario
            </button>
            <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1"
                    onclick="" id="button_actualizar">
                <i class="fas fa-sync"></i> Actualizar
            </button>
        </div>
    </div>
@stop

@section('content')
    {{--<p>Welcome to this beautiful admin panel.</p>--}}
    @livewire('dashboard.mount-empresas-component')
    <div class="{{--d-none--}}" id="row_button_ajustes">
        @livewire('dashboard.ajustes-component')
    </div>
    <div class="row">
        @livewire('dashboard.tipos-ajustes-component')
        @livewire('dashboard.almacenes-component')
        @livewire('dashboard.segmentos-component')
        @livewire('dashboard.cuotas-component')
        @livewire('dashboard.reportes-component')
    </div>

@stop

@section('right-sidebar')
    @include('dashboard._componentes.right-sidebar')
@endsection

@section('footer')
    @include('dashboard.footer')
@stop

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        function showRow(row) {
            $('#button_ajustes').prop("disabled",false);
            $('#button_stock').prop("disabled",false);
            $('#row_' + row).removeClass('d-none');
            $('#' + row).prop("disabled",true);
        }

        $(document).ready(function () {
            $('.cargar_buscar').removeClass('d-none');
            Livewire.dispatch('updatedEmpresaID');
        });

        function verSpinnerOculto() {
            $('.cargar_buscar').removeClass('d-none');
        }

        function verTiposAjuste() {
            Livewire.dispatch('limpiarTiposAjuste');
        }

        function verAlmacenes() {
            Livewire.dispatch('limpiarAlmacenes');
        }

        function verSegmentos() {
            Livewire.dispatch('limpiarSegmentos');
        }

        function verCuotas() {
            Livewire.dispatch('limpiarCuota');
        }

        function select_2(id, data)
        {
            let html = '<div class="input-group-prepend">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-code"></i>' +
                '</span>' +
                '</div> ' +
                '<select id="'+ id +'"></select>';
            $('#div_' + id).html(html);

            $('#'  + id).select2({
                dropdownParent: $('#modal-cuotas'),
                theme: 'bootstrap4',
                data: data,
                placeholder: 'Seleccione',
                /*allowClear: true*/
            });
            $('#'  + id).val(null).trigger('change');
            $('#'  + id).on('change', function() {
                var val = $(this).val();
                Livewire.dispatch('cuotaSeleccionada', { codigo: val });
            });
        }

        Livewire.on('selectCuotasCodigo', ({ codigos }) => {
            select_2('select_cuotas_codigo', codigos);
        });

        Livewire.on('setCuotaSelect', ({ codigo }) => {
            $('#select_cuotas_codigo').val(codigo).trigger('change');
        });


        function buscar(){
            let input = $("#navbarSearch");
            let keyword  = input.val();
            if (keyword.length > 0){
                input.blur();
                alert('Falta vincular con el componente Livewire');
                //Livewire.dispatch('buscar', { keyword: keyword });
            }
            return false;
        }

        console.log('Hi!');
    </script>
@stop
