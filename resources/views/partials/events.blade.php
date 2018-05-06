<link href="{{ asset('css/events.css') }}" rel="stylesheet">

<div class="container">
    <h5>All public events</h5>
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
            <?php for ($i=0; $i < $count; $i++) :
                if (($i % 4) == 0)  { ?>
                <div class="card">
                    <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="../event"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6 class="text-muted"> <?php echo $events[$i]->event_start ?> </h6>
                        <h5> Porto's Airport </h5>
                    </div>
                </div>
                <br>
            <?php } endfor ?>
            </div>
            <div class="col-sm align-content-center">
            <?php for ($i=0; $i < $count; $i++) :
            if (($i % 4) == 1)  { ?>
                <div class="card">
                    <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="../event"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6 class="text-muted"> <?php echo $events[$i]->event_start ?> </h6>
                        <h5> Porto's Airport </h5>
                    </div>
                </div>
                <br>
            <?php } endfor ?>
            </div>
            <div class="col-sm align-content-center">
            <?php for ($i=0; $i < $count; $i++) :
            if (($i % 4) == 2)  { ?>
                <div class="card">
                    <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="../event"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6 class="text-muted"> <?php echo $events[$i]->event_start ?> </h6>
                        <h5> Porto's Airport </h5>
                    </div>
                </div>
                <br>
            <?php } endfor ?>
            </div>
            <div class="col-sm align-content-center">
                <?php for ($i=0; $i < $count; $i++) :
                if (($i % 4) == 3)  { ?>
                <div class="card">
                    <img src="{{ asset('../images/myevent.jpg') }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="../event"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6 class="text-muted"> <?php echo $events[$i]->event_start ?> </h6>
                        <h5> Porto's Airport </h5>
                    </div>
                </div>
                <br>
                <?php } endfor ?>
            <br>
        </div>
    </div>
</div>