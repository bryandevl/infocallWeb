@extends('adminlte::page')


@section('htmlheader_title')
Reportes CRDIAL
@endsection

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> Supervisores
@endsection

@section('contentheader_description')
    Reportes CRDIAL
@endsection

@section('contentheader_breadcrumb')
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Supervisores</li>
</ol>
@endsection

@section('main-content') {{-- Usa 'main-content' en lugar de 'content' --}}
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">REPORTES DE CRDIAL</h1>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">CORE 1</h3>
                </div>
                <div class="box-body">
                    <ul>
                        <li>Reporte Santander</li>
                        <li>Reporte BBVA</li>
                        <li>Reporte MAF</li>
                    </ul>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">CORE 2</h3>
                </div>
                <div class="box-body">
                    <ul>
                        <li>Reporte Santander</li>
                        <li>Reporte BBVA</li>
                        <li>Reporte MAF</li>
                    </ul>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">CORE 3</h3>
                </div>
                <div class="box-body">
                    <ul>
                        <li>Reporte Santander</li>
                        <li>Reporte BBVA</li>
                        <li>Reporte MAF</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
