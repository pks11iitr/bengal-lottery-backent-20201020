@extends('layouts.my-app')

@section('form')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @if ($errors->any())
            {{ implode(' ', $errors->all()) }}
        @endif
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="email" class="form-control" placeholder="Username" name="email" value="{{ old('email') }}" required  autofocus id="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-8">--}}
{{--                    <div class="icheck-primary">--}}
{{--                        <input type="checkbox" id="remember">--}}
{{--                        <label for="remember">--}}
{{--                            Remember Me--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Forgot Password</a>
                </p>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center mb-3">
            {{--                <p>- OR -</p>--}}
            {{--                <a href="#" class="btn btn-block btn-primary">--}}
            {{--                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
            {{--                </a>--}}
            {{--                <a href="#" class="btn btn-block btn-danger">--}}
            {{--                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
            {{--                </a>--}}
        </div>
        <!-- /.social-auth-links -->

{{--        <p class="mb-0">--}}
{{--            Dont Have An Account?<a href="{{ route('register') }}" class="text-center"> Register Now</a>--}}
{{--        </p>--}}
    </div>
    <!-- /.login-card-body -->
</div>

@endsection
