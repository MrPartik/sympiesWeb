@extends('layouts.app')
@section('content')
    <div class="login-box" style="margin-top: 25px;margin-bottom:0px">
        <div class="login-logo">
            <a href="{{route('login')}}"><b>Log in </b>me now</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
                <div class="form-group has-feedback">
                    <input id="email" type="email" placeholder="Email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input id="password" type="password" placeholder="Password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           required>

                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>


                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"
                                       name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
                @if ($errors->has('email'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $errors->first('email') }} </div>
                    </span>
                @endif

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>
                        Sign
                        in using
                        Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i>
                        Sign
                        in using
                        Google+</a>
                </div>
                <!-- /.social-auth-links -->
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a><br>
                <a href="{{route('register')}}" class="text-center">Register a new membership</a>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
@section('extrajs')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endsection