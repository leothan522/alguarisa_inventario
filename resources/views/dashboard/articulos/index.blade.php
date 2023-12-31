@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-box"></i> Artículos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Artículos Registrados</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.articulos-component')
@endsection

@section('right-sidebar')
    @include('dashboard.articulos.right-sidebar')
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

        function verCategorias() {
                Livewire.emit('limpiarCategorias');
        }

        function verUnidades() {
            Livewire.emit('limpiarUnidades');
        }

        function verTributarios() {
            Livewire.emit('limpiarTributarios');
        }

        function verProcedencias() {
            Livewire.emit('limpiarProcedencias');
        }

        function verTipos() {
            Livewire.emit('limpiarTipos');
        }

        function imgCategoria() {
            let input = document.getElementById('customFileLangCategoria');
            input.click();
        }

        function select_2(id, data, opcion)
        {
            let html = '<div class="input-group-prepend">' +
                '<span class="input-group-text">' +
                '<i class="fas fa-object-ungroup"></i>' +
                '</span>' +
                '</div> ' +
                '<select id="'+ id +'"></select>';
            $('#div_' + id).html(html);

            $('#'  + id).select2({
                theme: 'bootstrap4',
                data: data,
                placeholder: 'Seleccione',
                /*allowClear: true*/
            });
            $('#'  + id).val(null).trigger('change');
            $('#'  + id).on('change', function() {
                var val = $(this).val();
                switch (opcion) {
                    case 0:
                        Livewire.emit('tipoSeleccionado', val);
                    break;
                    case 1:
                        Livewire.emit('categoriaSeleccionada', val);
                    break;
                    case 2:
                        Livewire.emit('procedenciaSeleccionada', val);
                    break;
                    case 3:
                        Livewire.emit('tributoSeleccionado', val);
                    break;
                    case 4:
                        Livewire.emit('unidadSeleccionada', val);
                    break;
                    case 5:
                        Livewire.emit('secundariaSeleccionada', val);
                    break;
                    case 6:
                        Livewire.emit('empresaSeleccionada', val);
                    break;
                }
            });
        }

        Livewire.on('setSelectFormArticulos', (tipos, categorias, procedencias, tributarios) => {
            select_2('select_articulos_tipos', tipos, 0);
            select_2('select_articulos_categorias', categorias, 1);
            select_2('select_articulos_procedencias', procedencias, 2);
            select_2('select_articulos_tributarios', tributarios, 3);
        });

        function selectEditar(id, valor)
        {
            $("#" + id).val(valor);
            $("#" + id).trigger('change');
        }

        Livewire.on('setSelectFormEditar', (tipos, categorias, procedencias, tributarios) => {
            selectEditar('select_articulos_tipos', tipos);
            selectEditar('select_articulos_categorias', categorias);
            selectEditar('select_articulos_procedencias', procedencias);
            selectEditar('select_articulos_tributarios', tributarios);
        });

        Livewire.on('setSelectFormUnidades', unidades =>{
            select_2('select_articulos_unidades', unidades, 4);
            select_2('select_unidades_artund', unidades, 5);
        });

        Livewire.on('setSelectFormEditUnd', unidades =>{
            $('#select_articulos_unidades').val(unidades);
            $('#select_articulos_unidades').trigger('change');
        });

        Livewire.on('setSelectFormEmpresas', empresas => {
            select_2('select_precios_empresas', empresas, 6)
        });

        Livewire.on('setSelectPrecioEmpresas', empresas => {
            $('#select_precios_empresas').val(empresas);
            $('#select_precios_empresas').trigger('change');
        });

        function imgPrincipal()
        {
            let input = document.getElementById('customFileLang');
            input.click();
        }

        function imgGaleria(i)
        {
            let input = document.getElementById('img_Galeria_' + i);
            input.click();
        }

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

        console.log('Hi!');
    </script>
@endsection
