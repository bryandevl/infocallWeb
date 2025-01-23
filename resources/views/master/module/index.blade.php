@extends('vendor.adminlte.layouts.master')

@section('contentheader_title')
    <i class="fa fa-cog"></i> Accesos
@endsection
@section('contentheader_description')
    Módulos y SubMódulos
@endsection
@section('htmlheader_title')
    Accesos | Módulos y SubMódulos
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Accesos</a></li>
        <li class="active">Módulos y SubMódulos</li>
    </ol>
@endsection
@section('jquery')
@php
    $jsVersion = config("crreportes.assets.js");
    $moduleJs = asset("js/master/module.js?v={$jsVersion}");
@endphp
<script type="text/javascript">
    var viewTabModule = true;
    var tbModulesColumns = [
        { data: 'name'},
        { data: 'class_icon'},
        { data: 'url'},
        { data: 'num_childs'},
        { data: 'visible'},
        { data: 'order'},
        { data: 'created_at'},
        { data: 'status'},
        { data: 'id'},
    ];
    var fnRowCallbackTbModules = function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        let htmlIcon = "<i class='"+aData['class_icon']+"'>";
            htmlIcon+= "</i>";
        $(nRow).find("td:eq(1)").html(htmlIcon);
        $(nRow).find('td:eq(7)').html(statusLabelOnGrid(aData["status"]));
        $(nRow).find("td:eq(4)").html(isVisible(aData["visible"]));
        let btn = htmlMasterButton(aData);
        $(nRow).find("td:eq(8)").html(btn);
    };

    var tbModulesChildsColumns = [
        { data: 'name'},
        { data: 'moduleParent', "searchable": false},
        { data: 'visible'},
        { data: 'order'},
        { data: 'created_at'},
        { data: 'status'},
        { data: 'id'},
    ];
    var fnRowCallbackTbModulesChilds = function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        $(nRow).find("td:eq(2)").html(isVisible(aData["visible"]));
        $(nRow).find('td:eq(5)').html(statusLabelOnGrid(aData["status"]));
        let btn = htmlMasterButton(aData);
        $(nRow).find("td:eq(6)").html(btn);
    };

    var tbModules = $("#tbModules").DataTable();
    var tbModulesChilds = $("#tbModulesChilds").DataTable();
</script>
<script type="text/javascript" src="{{ $moduleJs }}"></script>
<script type="text/javascript">
    tbModules = Module.list(tbModulesColumns, fnRowCallbackTbModules, false, "#tbModules");
    $("a[href='#tab-modules-childs']").on("click", function() {
        tbModulesChilds = Module.list(tbModulesChildsColumns, fnRowCallbackTbModulesChilds, true, "#tbModulesChilds");
        viewTabModule = false;
    });
    $("a[href='#tab-modules']").on("click", function() {
        tbModules = Module.list(tbModulesColumns, fnRowCallbackTbModules, false, "#tbModules");
        viewTabModule = true;
    });
    $("#tableResponsive").css("display", "none");
</script>
@endsection
@section("title_view_master_template")
Listado de Módulos y SubMódulos
@endsection

@push("modals_master")
@include("master.module.mdlStore")
@endpush

@section("custom_master_section")
<div class="box-body box-primary">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab-modules" id="nav-tab-info">Módulos</a>
        </li>
        <li>
            <a data-toggle="tab" href="#tab-modules-childs">SubMódulos</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-modules" class="tab-pane fade in active">
            @include("master.module.partials.tbModules")
        </div>
        <div id="tab-modules-childs" class="tab-pane fade">
            @include("master.module.partials.tbModulesChilds")
        </div>
    </div>
</div>
@endsection

@push("custom_css")
<style type="text/css">
    .divHidden {
        pointer-events: none;
    
        /* for "disabled" effect */
        opacity: 0.5;
        background: #CCC;
    }
</style>
@endpush