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
    <script !src="">
        function cerrarInventarios() {
            $('.cerra_inventarios').click();
        }

        function verAjuste(id) {
            Livewire.emit('verAjuste', id);
            $('#btn_ver_modal_ajuste').click();
        }

        function verDetalle(municipio, censo, deudaAnterior, despacho, deudaTotal) {
            Livewire.emit('detalleCuota', municipio, censo, deudaAnterior, despacho, deudaTotal);
            $('#btn_ver_modal_cuota').click();
        }

        console.log('hi!');
    </script>
@endsection
