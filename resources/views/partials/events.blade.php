<!DOCTYPE html>
<html lang="en">
<title> Public events </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="{{ asset('../css/events.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap-grid.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>

<!--
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">I am In!</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="../events">EVENTS </a></li>
                <li><a href="../create_event">CREATE EVENT</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> AUTH <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../sign_up"> Sign Up </a></li>
                        <li><a href="../sign_in"> Sign In </a></li>
                    </ul>
                </li>
            </ul>
        </div>
</nav>
-->

<h3> All public events </h3>
<br>
<div class="container">
    <div class="row">

        <div class="col-sm">
            <div class="container">
                <div class="row">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by title" name="search">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <h5>Select the date period:</h5>
                </div>
                <div class="row">
                    <input type="date" class="form-control" id="dateFrom" placeholder="From">
                    <br>
                    <input type="date" class="form-control" id="dateTo" placeholder="To">
                </div>
                <div class="row">
                    <h5>Max km from my location:</h5>
                </div>
                <div class="row">
                    <input type="number" class="form-control" id="km" placeholder="Km">
                </div>

                <br>
                <div class="row">
                    <div class="form-group">
                        <select class="form-control">
                            <option><p>Type of event</p></option>
                            <option><p>Music</p></option>
                            <option><p>Historical</p></option>
                            <option><p>Trip</p></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <select class="form-control">
                            <option><p>Order by</p></option>
                            <option><p>Date</p></option>
                            <option><p>Alphabetical</p></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <select class="form-control">
                            <option><p>Order direction </p></option>
                            <option><p>Highest first</p></option>
                            <option><p>Lowest first</p></option>
                        </select>
                    </div>
                </div>

                <br>
                <div class="row">
                    <button type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span> Filter</button>
                    <button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                </div>
            </div>
        </div>

        <div class="col-sm align-content-center">

            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>

        </div>
        <div class="col-sm align-content-center">
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>

        </div>
        <div class="col-sm align-content-center">
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>

        </div>
        <div class="col-sm align-content-center">
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>
            <div class="card">
                <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top" no-repeat center center fixed>
                <div class="card-block">
                    <h4> <a href="../event"> Trip to Lisbon </a></h4>
                    <h6 class="text-muted"> 23 Mar 2018 at 9.30 AM </h6>
                    <h5> Porto's Airport </h5>
                </div>
            </div>
            <br>

        </div>
        <br>
    </div>
</div>
</body>
<footer class="past">
    <div class="footer-copyright py-3 text-center">

        <div class="container">
            <hr>
            <ul class="list-inline">
                <li class="list-inline-item"> <a href="../my_events"> MY PAST EVENTS </a></li>
            </ul>
        </div>
        <div class="footer-copyright py-3 text-center">
            <div class="container-fluid">
                © 2018 I am In!
            </div>
        </div>

    </div>
</footer>

</html>