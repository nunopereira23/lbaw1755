@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <form id="loginform" class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="container">
            <h2>Log In</h2>
            <p>Please fill in this form to log in.</p>
            <hr>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="login-username" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <label for="password"><b>Password</b></label>
            <input type="password" class="form-control" name="password" id="login-password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif

            <div class="clearfix">
                <button type="submit" class="btn signupbtn">Log In</button>
            </div>
            <hr/>
            <p>Forgot password? <a href="{{ route('showEmailForm') }}">Reset Password</a></p>
            Don't have an account?
            <a href="{{ route('register') }}">Sign Up Here</a>
            Login with google?
            <a href="{{ url('/login/google') }}">Sign In With Google Here </a>
        </div>
    </form>
@endsection
