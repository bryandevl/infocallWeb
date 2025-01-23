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
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.dataTables.min.js') }}"></script>
    <script type="text/babel" src="{{asset('/js/scoring/historic/ScoringHistoricComponent.js')}}"></script>
@endpush

@section('jquery')
    <script type="text/javascript">
        $('#men-scoring, #men-scoring-historic').addClass('active');
    </script>
@endsection

@section('main-content')
    <div id="scoring_historic_component"></div>
@endsection
