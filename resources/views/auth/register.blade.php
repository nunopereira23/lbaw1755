@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <form id="signupform" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <div class="container">
            <h2>Sign Up</h2>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <label for="name"><b>Full name (required)</b></label>
            <input type="text" placeholder="Enter name and surname" name="name" id="name" required>
            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
            @endif

            <label for="email"><b>Email (required)</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <label for="password"><b>Password</b></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif

            <label for="password"><b>Password confirmation</b></label>
            <input type="password" name="password_confirmation" id="password-confirm" placeholder="Confirmation" required>

            <label for="file"><b>User photo</b>
                <input type="file" id="file" class="form-control" name="file">
            </label>

            <div class="clearfix">
                <button type="submit" class="btn signupbtn">Sign Up</button>
            </div>
            <hr/>
            Login with google?
            <a href="{{ url('/login/google') }}">Sign In With Google Here </a>
        </div>
    </form>
@endsection
