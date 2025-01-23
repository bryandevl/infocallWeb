@extends('vendor.adminlte.layouts.scoring')

@section('contentheader_title')
    <i class="fa fa-bar-chart-o"></i> Scoring
@endsection
@section('contentheader_description')
    Resumen
@endsection
@section('htmlheader_title')
    Scoring
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Scoring</li>
        <li class="active">Resumen</li>
    </ol>
@endsection

@push('scoring_javascript')
    @php
        $jsVersion = config("crreportes.assets.js");
        $buttonVicidialExporterComponentJs = asset("/js/scoring/components/ButtonVicidialExporterComponent.js?v={$jsVersion}");
        $messagesComponentJs = asset("/js/scoring/components/MessagesComponent.js?v={$jsVersion}");
        $scoringMatchDialTableComponentJs = asset("/js/scoring/match-dial/ScoringMatchDialTableComponent.js?v={$jsVersion}");
        $scoringMatchDialFilterComponentJs = asset("/js/scoring/match-dial/ScoringMatchDialFilterComponent.js?v={$jsVersion}");
        $scoringMatchDialComponentJs = asset("/js/scoring/match-dial/ScoringMatchDialComponent.js?v={$jsVersion}");
    @endphp
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.dataTables.min.js') }}"></script>
    <script type="text/babel" src="{{ $buttonVicidialExporterComponentJs }}"></script>
    <script type="text/babel" src="{{ $messagesComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringMatchDialTableComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringMatchDialFilterComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringMatchDialComponentJs }}"></script>
@endpush

@section('jquery')
    <script type="text/javascript">
        $('#men-scoring, #men-scoring-match').addClass('active');
    </script>
@endsection

@section('main-content')
    <div id="match_dial_scoring_component"></div>
@endsection
