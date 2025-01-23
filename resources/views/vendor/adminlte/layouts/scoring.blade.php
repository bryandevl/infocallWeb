@extends('adminlte::page')
@section('javascript')
<script src="{{ asset('/plugins/react/react.production.min.js') }}" crossorigin></script>
<script src="{{ asset('/plugins/react/react-dom.production.min.js') }}" crossorigin></script>
<script src="{{ asset('/plugins/react/babel.min.js') }}"></script>
<script>
	const crScoringEndpoint = "{{ config('crreportes.endpoint.scoring') }}";
</script>
@stack("scoring_javascript")
@endsection