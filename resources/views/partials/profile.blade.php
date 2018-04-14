<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
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
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Username <span
                        class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-item"><a href="../user/profile.html"> Profile </a>
						</li>
						<li class="dropdown-item"><a href="../myEvents/my_events.html"> My events </a>
						</li>
					</ul>
                </li>
            </ul>
        </div>
    </nav>

    <style>

        body {
            font-family: Arial, sans-serif;
            font-size: 17px;
            background-color: white;
            min-width: 100%;
            min-height: 100%;
            position: absolute;
            color: darkslategrey;
            padding-bottom: 60px;
        }
        .navbar {
            border-radius: unset;
            background-color: #2c3e50;
            border-bottom: #2c3e50;
            font-size: 16px;
            text-align: center;
        }

        .copyright {
            background-color: white;
            position: absolute;
            bottom: -5%;
            left: 0;
            width: 100%;
            height: 60px;
            color:  #2c3e50;
        }

        .panel {
            transform: translate(100px);
            margin-top: 40px;
            margin-right: 180px;
            padding-bottom: 50px;
        }

        a.btn:hover {
            -webkit-transform: scale(1.01);
            -moz-transform: scale(1.01);
            -o-transform: scale(1.01);
        }
        a.btn {
            -webkit-transform: scale(0.8);
            -moz-transform: scale(0.8);
            -o-transform: scale(0.8);
            -webkit-transition-duration: 0.5s;
            -moz-transition-duration: 0.5s;
            -o-transition-duration: 0.5s;
        }
        ul {
          list-style-type: none;
        }
        .panel-body{
            margin-top: 3%;
        }

    </style>

</head>
<body>

<div class="container">
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading"><h4>User Profile</h4></div>
            <div class="panel-body">
                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                    <img alt="User Pic"
                         src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
                         id="profile-image1" class="img-circle img-responsive">


                </div>
                <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                    <div class="container">
                        <h2><?php echo $user->name;?></h2>
                        <a href="edit_profile.html" class="btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span><strong>Edit Profile</strong></span>
                        </a>
                    </div>
                    <hr>
                    <ul class="container details">
                        <li><p><span class="fas fa-envelope" style="width:50px;"></span><?php echo $user->email;?></p></li>
                        <li><p><span class="fas fa-birthday-cake" style="width:50px;"></span><?php echo $user->birthdate;?></p></li>

                    </ul>
                    <hr>
                    <div class="col-sm-5 col-xs-6 tital ">Warning nr: <?php echo $user->nr_warnings;?></div>
                </div>
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
