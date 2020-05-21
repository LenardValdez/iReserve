@extends('layouts.login')

@section('scripts')
    <script src="js/adminlte_js/jquery.min.js"></script>
    <script src="js/adminlte_js/bootstrap.min.js"></script>
    <script src="iCheck/icheck.min.js"></script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();   
        $('#remember').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
        });
    });
    </script>
@endsection

@section('content')
    <div class="login-logo">
        <a href={{ URL::route('Dashboard') }}><img src="img/iacademy_shield.png" style="width: 150px; padding-bottom: 10px;" alt="iACADEMY"><br>iReserve</a>
    </div>
        <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in using your iSIMS credentials</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>

            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autofocus>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>

            <div class="text-center text-danger">
            @if ($errors->has('email'))
                <span class="help-block" role="alert">
                    {{ $errors->first('email') }}
                </span>
            @endif

            @if ($errors->has('password'))
                <span class="help-block" role="alert">
                    {{ $errors->first('password') }}
                </span>
            @endif
            </div>

            <div class="row">
            <div class="col-xs-8 pull-left">
                <div class="checkbox icheck">
                    <label>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                </div>
                </div>
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                </div>
            </div>
        </form>

    <div class="login-box-body">
        <a href="#" class="pull-right" data-toggle="popover" data-content="Please visit the IT Department at the Mezzanine, iACADEMY Nexus.">Forgot your password?</a>
    </div>
@endsection