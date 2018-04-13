@extends('layouts.app')

@section('content')
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="body_navbar_footer.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.html">I am In!</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="../events/events.html">EVENTS </a></li>
                    <li><a href="../createEvent/create_event.html">CREATE EVENT</a></li>
                    <li><a href="../faq/faq.html">FAQ</a></li>
                    <li><a href="../contact/contact.html">CONTACT US</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> AUTH <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">SIGN UP</a></li>
                            <li><a href="../user/sign_in.html">SIGN IN</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</head>

<body>

<div class="container">
    <div id="loginbox" style="margin-top:100px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
                <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a>
                </div>
            </div>

            <div style="padding-top:30px" class="panel-body">

                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                <form id="loginform" class="form-horizontal" role="form">

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username" value=""
                               placeholder="username or email">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password"
                               placeholder="password">
                    </div>


                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                            </label>
                        </div>
                    </div>


                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">
                            <a id="btn-login" href="profile.html" class="btn btn-success">Login </a>
                            <a class="btn  btn-social-icon btn-google">
                                <span class="fa fa-google"></span> Sign in with Google
                            </a>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                Don't have an account!
                                <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                    Sign Up Here
                                </a>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
</body>
<footer class="copyright">
    <div class="footer-copyright py-3 text-center">
        <div class="container">
            <hr>
            © 2018 I am In!
        </div>
    </div>
</footer>
</html>
@endsection
