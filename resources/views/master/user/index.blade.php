@extends('vendor.adminlte.layouts.master')

@section('contentheader_title')
    <i class="fa fa-cog"></i> Accesos
@endsection
@section('contentheader_description')
    Usuarios
@endsection
@section('htmlheader_title')
    Accesos | Usuarios
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Accesos</a></li>
        <li class="active">Usuarios</li>
    </ol>
@endsection

@section('jquery')
@php
    $jsVersion = config("crreportes.assets.js");
    $userJs = asset("js/master/user.js?v={$jsVersion}");
@endphp
<script type="text/javascript" src="{{ $userJs }}"></script>
<script type="text/javascript">
    
    tbl_data = User.list();
</script>
@endsection

@section("title_view_master_template")
Listado de Usuarios
@endsection
@push("grid_columns_master")
<tr>
    <th>Nombres y Apellidos</th>
    <th style="width: 100px;">Email</th>
    <th>Rol</th>
    <th>F.Registro</th>
    <th>#Intentos</th>
    <th>Estado</th>
    <th style="width: 70px;">[]</th>
</tr>
@endpush

@push("modals_master")
@include("master.user.mdlStore")
@endpush
