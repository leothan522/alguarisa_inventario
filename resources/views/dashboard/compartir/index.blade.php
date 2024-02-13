@extends('layouts.adminlte')

@section('title')
    Alguarisa | Inventario
@endsection

@section('content')

 @livewire('dashboard.compartir-component', ['empresa_id' => $empresa_id])

@endsection

@section('css')
    {{--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
@endsection

@section('js')
    {{--<script src="../../dist/js/adminlte.min.js"></script>--}}
    <script>
        function cerrarInventarios() {
            $('.cerra_inventarios').click();
        }

        function verAjuste(id) {
            Livewire.dispatch('verAjuste', { detalles_id: id });
            $('#btn_ver_modal_ajuste').click();
        }

        function verDetalle(municipio, censo, deudaAnterior, despacho, deudaTotal) {
            Livewire.dispatch('detalleCuota', { municipio: municipio, censo: censo, deudaAnterior: deudaAnterior, despacho: despacho, deudaTotal: deudaTotal });
            $('#btn_ver_modal_cuota').click();
        }

        console.log('hi!');
    </script>
@endsection
