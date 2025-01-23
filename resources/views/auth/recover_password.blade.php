@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <p class="login-box-msg">
            {{trans('auth.recover_password.title_recover_password')}}
        </p>
        <form action="/recuperar-contrasena" method="post">
            @csrf
            @php
                $errorMsg = "";
                $successMsg = "";
            @endphp
            @if (isset($errors))
                @if ($errors->has("recover_error"))
                @php
                    $errorMsg = $errors->first("recover_error");
                @endphp
                <div class="input-group mb-12">
                    <b class="error-msg">{{$errorMsg}}</b>
                </div>
                @endif
                @if ($errors->has("messageSuccess"))
                    @php
                        $successMsg = $errors->first("messageSuccess");
                    @endphp
                    <div class="input-group mb-12">
                        <b class="alert alert-success">{{$successMsg}}</b>
                    </div>
                @endif
            @endif
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="{{trans('auth.form.user_name')}}" required name="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">{{trans('auth.recover_password.send_link')}}</button>
                </div>
              <!-- /.col -->
            </div>
        </form>
    </div>
</div>
@endsection
