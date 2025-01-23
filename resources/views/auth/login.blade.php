@extends('layouts.auth')

@push('js')
<script type="text/javascript">
    var keyCaptcha = '{{env("APP_SYSTEM","")}}_reCaptchaV3Available';
    var reCaptchaV3Available = localStorage.getItem(keyCaptcha);
    if (reCaptchaV3Available !="null" && reCaptchaV3Available !=null) {
        let obj = JSON.parse(reCaptchaV3Available);
        if (obj.available) {
            $("#recaptcha-block").css("display", "none");
            $("form").append("<input type='hidden' name='remember_recaptcha' value='1'/>");
        }
    }

    $('#formLogin').submit(function(event) {
        event.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute("{{env('RECAPTCHA_V3_KEY_PUBLIC', '')}}", {action: 'login'}).then(function(token) {
                $('#formLogin').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('#formLogin').prepend('<input type="hidden" name="action" value="login">');
                $('#formLogin').unbind('submit').submit();
            });;
        });
        return false;
    });
</script>
@endpush
@push('head')
<script src="https://www.google.com/recaptcha/api.js?render={{env('RECAPTCHA_V3_KEY_PUBLIC', '')}}"></script>
@endpush
@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{trans('auth.login.title_login')}}</p>
        <form method="post" id="formLogin" action="/login">
            @csrf
            @error("form")
            <div class="alert alert-success" role="alert">
                {{$message}}
            </div>
            @enderror
            @php
                $errorMsg = "";
            @endphp
            @if (isset($errors))
                @if ($errors->has("recaptcha"))
                @php
                    $errorMsg = $errors->first("recaptcha");
                @endphp
                @endif
                @if ($errors->has("credentials"))
                @php
                    $errorMsg = $errors->first("credentials");
                @endphp
                @endif
                @if ($errors->has("catch"))
                @php
                    $errorMsg = $errors->first("catch");
                @endphp
                @endif
                <div class="input-group mb-12">
                    <b class="error-msg">{{$errorMsg}}</b>
                </div>
            @endif
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="{{trans('auth.form.user_name')}}" required name="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Contraseña" required name="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            {{-- <div class="input-group mb-3" id="recaptcha-block">
                <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_V3_KEY_PUBLIC', '')}}"></div>
            </div> --}}
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember_token">
                        <label for="remember">
                            {{trans('auth.login.remember_me')}}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{trans('auth.login.signin')}}</button>
                </div>
              <!-- /.col -->
            </div>
        </form>
      <!--<div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>-->
      <!-- /.social-auth-links -->

        <p class="mb-1">
            <a href="/recuperar-contrasena">{{trans('auth.login.recover_password')}}</a>
        </p>
        <!--<p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
        </p>-->
    </div>
    <!-- /.login-card-body -->
</div>
@endsection
