@extends('layouts.app')
@section('content')
    <script>
        function preventBack() {
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
            };
        }

        setTimeout("preventBack()", 0);

        window.onbeforeunload = function() {
            preventBack();
        };
    </script>
    <div class="row justify-content-center" style="margin-top: 10% !important">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <form method="POST" action="bypassauth">
                            {{ csrf_field() }}
                            <h1>
                                <div class="login-logo" style="align:center">
                                    <a href="#">
                                        <img src="{{ url('/images/kingranch_logo.png') }}" height="50" width="300"
                                            style="margin-left:25%">
                                    </a>
                                </div>
                            </h1>
                            <p class="text-muted">{{ trans('global.login') }}</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input name="email" type="text" class="form-control"
                                    placeholder="{{ trans('global.login_email') }}">

                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input name="password" type="password" class="form-control"
                                    placeholder="{{ trans('global.login_password') }}">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="submit" class="btn btn-primary px-4" value='{{ trans('global.login') }}'>
                                    <label class="ml-2">
                                        <input name="remember" type="checkbox" /> {{ trans('global.remember_me') }}
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        {{ trans('global.forgot_password') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
