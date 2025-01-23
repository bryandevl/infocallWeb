<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/js/alert.js') }}"></script>
<script type="text/javascript" src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('plugins/validator/validator.js')}}"></script>
<script src="{{ asset('plugins/jconfirm/jquery-confirm.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/master.js') }}"></script>
@php
      $id = str_replace(".", "_", \Route::currentRouteName());
@endphp
<script type="text/javascript">
     $("#menOptID_{{ $id }}").addClass('active');
     Master.validateMinOldPassword();
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
@include('adminlte::layouts.loading')
@yield('javascript')

@yield('jquery')