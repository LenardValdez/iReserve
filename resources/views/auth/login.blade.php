@extends('layouts.login')

@section('scripts')
    <script src="js/adminlte_js/jquery.min.js"></script>
    <script src="js/adminlte_js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();   
    });
    </script>
@endsection

@section('content')
    <div class="login-logo">
        <a href={{ URL::route('Dashboard') }}><img src="img/iacademy_shield.png" style="width: 150px; padding-bottom: 10px;" alt="iACADEMY"><br>iReserve</a>
    </div>
        <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in using your iACADEMY email</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required autofocus>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>

            <div class="text-center">
            @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            </div>

            <div class="row">
            <div class="col-xs-6 pull-left">
                    <small id="loginError" class="text-danger"></small>
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