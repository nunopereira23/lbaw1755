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
<div id="signupbox" style="display:none; margin-top:50px"
     class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Sign Up</div>
            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#"
                                                                                       onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign
                    In</a></div>
        </div>
        <div class="panel-body">
            <form id="signupform" class="form-horizontal" role="form">

                <div id="signupalert" style="display:none" class="alert alert-danger">
                    <p>Error:</p>
                    <span></span>
                </div>

                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                    </div>
                </div>


                <div class="form-group">
                    <label for="phonenumber" class="col-md-3 control-label">Phone Number</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phonenumber" placeholder="Phone Number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">New Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="new_passwd" placeholder="New Password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Confirm Your Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="conf_passwd" placeholder="Confirmation">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3 control-label">
                        <label for="birth">
                            Birth Date
                        </label>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-xs-3 col-md-3">
                            <select class="form-control">
                                <option value="Month">Month</option>
                            </select>
                        </div>
                        <div class="col-xs-3 col-md-3">
                            <select class="form-control">
                                <option value="Day">Day</option>
                            </select>
                        </div>
                        <div class="col-xs-3 col-md-3">
                            <select class="form-control">
                                <option value="Year">Year</option>
                            </select>
                        </div>
                    </div>
                </div>


                <label class="radio-inline">
                    <input type="radio" name="sex" id="inlineCheckbox1" value="male"/>
                    Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" id="inlineCheckbox2" value="female"/>
                    Female
                </label>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3 control-label">
                            <label for="input-group">Upload Profile Picture</label>
                        </div>

                        <div class="col col-md-8 upload-box">
                            <div class="input-group upload">

                        <span class="input-group-btn">
                            <button id="fake-file-button-browse" type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-file"></span>
                            </button>
                        </span>

                                <input type="file" id="files-input-upload" style="display:none">
                                <input type="text" id="fake-file-input-name" disabled="disabled"
                                       placeholder="File not selected"
                                       class="form-control">
                                <span class="input-group-btn">
                            <button type="button" class="btn btn-default" disabled="disabled"
                                    id="fake-file-button-upload">
                                <span class="glyphicon glyphicon-upload"></span>
                            </button>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-3 col-md-9">
                        <button id="btn-signup" type="button" class="btn btn-info"><i
                                    class="icon-hand-right"></i>
                            &nbsp Sign Up
                        </button>
                        <span style="margin-left:8px;">or</span>
                        <a class="btn  btn-social-icon btn-google">
                            <span class="fa fa-google"></span> Sign in with Google
                        </a>
                    </div>
                </div>


            </form>
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