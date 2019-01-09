@extends('layouts.app')
@section('content')
    <div class="login-box" style="margin-top: 25px;margin-bottom:0px">
        <div class="login-logo">
            <a href="{{route('register')}}"><b>Register </b>me now</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Register a new membership</p>

            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                @csrf

                <div class="form-group has-feedback">
                    <input id="name" type="text" placeholder="Full name"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                           value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input id="email" type="email" placeholder="Email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input id="password" type="password" placeholder="Password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input id="password-confirm" type="password" placeholder="Retype password" class="form-control"
                           name="password_confirmation"
                           required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>


                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign
                    up using
                    Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign
                    up using
                    Google+</a>
            </div>
            <a href="{{route('login')}}" class="text-center">I already have a membership</a>
        </div>
        <br>
    </div>
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
