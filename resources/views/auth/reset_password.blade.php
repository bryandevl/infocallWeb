@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">
            {{trans('auth.reset_password.title_reset_password')}}
        </p>
        @php
            $explode = explode("/", \Request::path());
            $tokenUrl = isset($explode[1])? $explode[1] : "";
        @endphp
        <form method="POST" action="/resetear-contrasena">
            @csrf
            <input type="hidden" name="token" value="{{ $tokenUrl}}">
            @error('form')
                <span class="invalid-feedback" role="alert" style="display: block;">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group row">
                <label for="email" class="col-md-12 col-form-label text-md-left">{{trans('auth.form.user_name')}}</label>
                <div class="col-md-12">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ \Request()->email }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-12 col-form-label text-md-left">{{trans('auth.form.new_password')}}</label>
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-12 col-form-label text-md-left">{{trans('auth.form.confirm_password')}}</label>

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12 offset-md-3">
                    <button type="submit" class="btn btn-primary">
                        {{trans('auth.reset_password.title_button')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
