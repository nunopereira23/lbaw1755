<link href="{{ asset('css/homepage.css') }}" rel="stylesheet">

<div id="myCarousel" class="carousel slide" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="{{ asset('../images/picarra2.jpg') }}" style="width:100%" class="img-responsive">
            <div class="container">
                <div class="caraous-title">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <span>THIS WEEK </span>
                            <h1>Diogo Piçarra Concert</h1>
                            <a class="btn btn-lg btn-primary site-btn" href="#">Find out more about this event</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="{{ asset('../images/book_stack.jpg') }}" style="width:100%" class="img-responsive">
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
