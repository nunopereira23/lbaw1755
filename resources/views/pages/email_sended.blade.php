@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/email.css') }}" rel="stylesheet">
    <div class="container">
        <div class="jumbotron">
            <h5>
                <div class="text-center"><b>Email has been successfully sent.</b></div>
                <div class="text-center">You will receive confirmation code which you need to use for password reset.</div>
            </h5>
        </div>
    </div>
    <div class="container">
        <form class="needs-validation" role="form" method="POST" action="{{ route('confirmNewPassword') }}">
            {{ csrf_field() }}
            <input type="hidden" name="email" value="<?php echo $email ?>">

            <label for="title"><b>Confirmation code: </b></label>
            <input class="form-control" placeholder="Type a code you received" id="email" type="text" name="code" required>

            <label for="password"><b>Password</b></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Type a new password" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif

            <label for="password"><b>Password confirmation</b></label>
            <input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="Confirm a new password" required>

            <div class="clearfix">
                <button type="submit" class="btn signupbtn">Submit</button>
            </div>
        </form>
    </div>
@endsection