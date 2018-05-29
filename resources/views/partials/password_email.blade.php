<!DOCTYPE html>
<head>
    <link href="{{ asset('css/email.css') }}" rel="stylesheet">
    <title> "Reset password" </title>
</head>
<div class="container">
    <form class="needs-validation" role="form" method="POST" action="{{ route('sendResetPasswordCode') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-5 mb-3 md-10">
                <label for="title"><b>Email: </b></label>
                <input class="form-control" placeholder="Type your email" id="email" type="text" name="email" required>
                <p></p>
                <input type="submit" class="btn btn-primary" value="Send to this email" name="submitted">
            </div>
        </div>
    </form>
</div>