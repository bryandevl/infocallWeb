@extends('vendor.adminlte.layouts.scoring')

@section('contentheader_title')
    <i class="fa fa-bar-chart-o"></i> Scoring
@endsection
@section('contentheader_description')
    Historicos
@endsection
@section('htmlheader_title')
    Scoring
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li>Scoring</li>
        <li class="active">Historicos</li>
    </ol>
@endsection

@push('scoring_javascript')
    @php
        $jsVersion = config("crreportes.assets.js");
        $buttonDeleteFieldSettingComponentJs = asset("/js/scoring/components/ButtonDeleteFieldSettingComponent.js?v={$jsVersion}");
        $selectCampaignComponentJs = asset("/js/scoring/components/SelectCampaignComponent.js?v={$jsVersion}");
        $scoringPanelConfigComponentJs = asset("/js/scoring/fields-settings/ScoringPanelConfigComponent.js?v={$jsVersion}");
        $scoringSettingsTableComponentJs = asset("/js/scoring/fields-settings/ScoringSettingsTableComponent.js?v={$jsVersion}");
        $scoringFieldsSettingsComponentJs = asset("/js/scoring/fields-settings/ScoringFieldsSettingsComponent.js?v={$jsVersion}");
        $scoringGroupValuesComponentJs = asset("/js/scoring/fields-settings/ScoringGroupValuesComponent.js?v={$jsVersion}");
    @endphp
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.dataTables.min.js') }}"></script>
    <script type="text/babel" src="{{ $buttonDeleteFieldSettingComponentJs }}"></script>
    <script type="text/babel" src="{{ $selectCampaignComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringPanelConfigComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringSettingsTableComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringFieldsSettingsComponentJs }}"></script>
    <script type="text/babel" src="{{ $scoringGroupValuesComponentJs }}"></script>
@endpush

@section('jquery')
    <script type="text/javascript">
        //$('#men-scoring, #men-scoring-settings').addClass('active');
    </script>
@endsection

@section('main-content')
    <div id="fields_settings"></div>
@endsection
