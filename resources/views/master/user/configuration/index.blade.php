@extends('vendor.adminlte.layouts.master')

@section('contentheader_title')
    <i class="fa fa-cog"></i> Accesos
@endsection
@section('contentheader_description')
    Configuración de Usuarios
@endsection
@section('htmlheader_title')
    Accesos | Configuración de Usuarios
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Accesos</a></li>
        <li class="active">Configuración de Usuarios</li>
    </ol>
@endsection

@section('jquery')
@php
    $jsVersion = config("crreportes.assets.js");
    $configurationUserJs = asset("js/configuration/configurationUser.js?v={$jsVersion}");
@endphp
<script type="text/javascript" src="{{ $configurationUserJs }}"></script>
<script type="text/javascript">
    $("#btnAdd").remove()
    tbl_data = ConfigUser.list();
</script>
@endsection

@section("title_view_master_template")
Listado de Configuración de Usuarios
@endsection
@push("grid_columns_master")
<tr>
    <th>Nombre</th>
    <th style="width: 100px;">Key</th>
    <th style="width: 70px;">Valor</th>
    <th style="width: 100px;">F.Registro</th>
    <th style="width: 70px;">Estado</th>
    <th style="width: 50px;">[]</th>
</tr>
@endpush

@push("modals_master")
@include("master.user.configuration.mdlStore")
@endpush
