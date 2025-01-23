@extends('vendor.adminlte.layouts.master')

@section('contentheader_title')
    <i class="fa fa-cog"></i> Accesos
@endsection
@section('contentheader_description')
    Roles
@endsection
@section('htmlheader_title')
    Accesos | Roles
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Accesos</a></li>
        <li class="active">Roles</li>
    </ol>
@endsection
@section('jquery')
@php
    $jsVersion = config("crreportes.assets.js");
    $roleJs = asset("js/master/role.js?v={$jsVersion}");
@endphp
<script type="text/javascript" src="{{ $roleJs }}"></script>
<script type="text/javascript">
    tbl_data = Role.list();
</script>
@endsection
@section("title_view_master_template")
Listado de Roles
@endsection

@push("grid_columns_master")
<tr>
    <th>Nombre</th>
    <th style="width: 100px;">Abreviatura</th>
    <th>F.Registro</th>
    <th>Estado</th>
    <th>[]</th>
</tr>
@endpush

@push("modals_master")
@include("master.role.mdlStore")
@endpush