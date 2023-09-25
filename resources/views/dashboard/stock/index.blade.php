@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-boxes"></i> Stock</h1>
            </div>
            <div class="col-sm-6">
                {{--<ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Articulos con existencia</li>
                </ol>--}}
                <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1" onclick="activarBoton('content_btn_ajustes', 'header_btn_ajustes')" id="header_btn_ajustes"
                        {{--wire:click="verAjustes" @if($view == "ajustes" || !comprobarPermisos('ajustes.index')) disabled @endif--}}>
                    <i class="fas fa-list"></i> Ajustes
                </button>
                <button type="button" class="btn btn-default btn-sm float-right ml-1 mr-1 disabled" onclick="activarBoton('content_btn_existencias', 'header_btn_existencias')" id="header_btn_existencias"
                       {{-- wire:click="verAjustes" @if($view == "stock") disabled @endif--}}>
                    <i class="fas fa-boxes"></i> Inventario
                </button>
                <button type="button" wire:click="show" class="btn btn-default btn-sm float-right ml-1 mr-1" onclick="activarBoton('content_btn_actualizar', 'header_btn_actualizar')" id="header_btn_actualizar" {{--style="margin-right: 5px;"--}}>
                    <i class="fas fa-sync"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.stock-component')
@endsection

@section('right-sidebar')
    @include('dashboard.stock.right-sidebar')
@endsection

@section('footer')
    @include('dashboard.footer')
@endsection

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        function search(){
            let input = $("#navbarSearch");
            let keyword  = input.val();
            if (keyword.length > 0){
                input.blur();
                //alert('Falta vincular con el componente Livewire');
                $('.cargar_buscar').removeClass('d-none');
                Livewire.emit('buscar', keyword);
            }
            return false;
        }

        function verAlmacenes() {
            Livewire.emit('limpiarAlmacenes');
        }

        function verTiposAjuste() {
            Livewire.emit('limpiarTiposAjuste');
        }

        function verSegmentos() {
            Livewire.emit('limpiarSegmentos');
        }

        function cambiarEmpresa()
        {
            Livewire.emit('changeEmpresa');
        }

        function compartirQr() {
            Livewire.emit('compartirQr');
        }

        Livewire.on('verspinnerOculto', valor => {
            $('.cargar_buscar').removeClass('d-none');
        });

        $('#reportes_articulos').select2({
            theme: 'bootstrap4',
        });

        function activarBoton(content, header) {
            $('#' + content).click();
            if (header !== 'header_btn_actualizar'){
                $('#header_btn_ajustes').removeClass('disabled');
                $('#header_btn_existencias').removeClass('disabled');
                $('#' + header).addClass('disabled');
            }
        }

        console.log('Hi!');
    </script>
@endsection
