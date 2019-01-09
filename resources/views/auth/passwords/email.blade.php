@extends('layouts.app')

@section('content')
    <div class="login-box" style="margin-top: 25px;margin-bottom:0px">
        <div class="login-logo">
            <a href="{{route('login')}}">Resetting Password</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">We miss you!!!</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                @csrf

                <div class="form-group has-feedback">
                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
        <div class="row">
            <div class="col-xs-8">

            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block flat">
                    {{ __('Reset') }}
                </button>
            </div>
        </div>
        </form>
    </div>
    </div>
@endsection
