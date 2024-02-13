@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Territorio')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-globe-americas"></i> Territorio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Municipios Registrados</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.territorio-component')
@endsection

@section('right-sidebar')
    @include('dashboard.territorio.right-sidebar')
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

        function nuevoMunicipio() {
            Livewire.dispatch('limpiarMunicipios');
        }

        function nuevaParroquia() {
            Livewire.dispatch('limpiarParroquias');
        }

        Livewire.on('cerrarModal', ({ selector }) => {
            $('#' + selector).click();
        });

        function select_2(data) {

            let html = '<div class="input-group-prepend">' +
                '<span class="input-group-text text-bold">Municipio</span>' +
                '</div>' +
                '<select id="parroquias_select_municipios"></select>';
            $('#parroquias_div_select').html(html);

            $('#parroquias_select_municipios')
                .select2({
                    theme: 'bootstrap4',
                    data: data,
                    placeholder: 'Seleccione',
                    allowClear: true
                })
                .val(null)
                .trigger('change');

            $('#parroquias_select_municipios').on('change', function () {
                let val = $(this).val();
                Livewire.dispatch('municipioSeleccionado', { municipio: val });
            });
        }

        Livewire.on('selectMunicipios', ({ municipios }) => {
            select_2(municipios);
        });

        Livewire.on('editSelectMunicipio', ({ municipio }) =>{
            $('#parroquias_select_municipios')
                .val(municipio)
                .trigger('change');
        });

        console.log('Hi!');
    </script>
@endsection
