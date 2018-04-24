<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ asset('../css/homepage.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<div id="myCarousel" class="carousel slide" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="{{ asset('../images/picarra2.jpg') }}" style="width:100%" class="img-responsive" no-repeat center center fixed>
            <div class="container">
                <div class="caraous-title">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <span >THIS WEEK </span>
                            <h1>Diogo Piçarra Concert</h1>
                            <a class="btn btn-lg btn-primary site-btn" href="#">Find out more about this event</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="item">
            <img src="../../images/book_stack.jpg" style="width:100%" class="img-responsive" no-repeat center center fixed>
            <div class="container">
                <div class="caraous-title">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <span>THIS WEEK</span>
                            <h1>Book Presentation</h1>
                            <a class="btn btn-lg btn-primary site-btn" href="#">Find out more about this event</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Controls -->

    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>

</div>



<div class="footer-area">
    <div class="footer">
        <div class="row">
            <div class="col-md-4 footer-one">
                <a href="../about"> ABOUT </a>
            </div>
            <div class="col-md-4 footer-two">
                <a href="../faq"> FAQ </a>
            </div>
            <div class="col-md-4 footer-three">
                <a href="../contact"> CONTACT US </a>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="col-sm-12 text-center ">
                <div class="copyright-text">
                    <p>© 2018 I am In!</p>
                </div>
            </div> <!-- End Col -->
        </div>
    </div>
</div>

</body>
</html>
