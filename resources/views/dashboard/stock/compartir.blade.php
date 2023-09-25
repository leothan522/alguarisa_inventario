@extends('layouts.adminlte')

@section('title')
    Android VIEW
@endsection

@section('content')

 @livewire('dashboard.compartir-component', ['empresa_id' => $empresa_id])

@endsection

@section('css')
    {{--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
@endsection

@section('js')
    {{--<script src="../../dist/js/adminlte.min.js"></script>--}}
@endsection
