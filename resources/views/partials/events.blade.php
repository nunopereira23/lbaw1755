<link href="{{ asset('css/events.css') }}" rel="stylesheet">

<div class="container">
    <h5>All public events</h5>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="container">
                    <form method="get" action={{ route('search_events') }}>
                        {{ csrf_field() }}
                        <div class="row">
                            <input type="text" class="form-control" placeholder="Title" name="title">
                        </div>
                    <div class="row">
                        <h5>Select the date period:</h5>
                    </div>
                    <div class="row">
                        <input type="date" class="form-control" id="dateFrom" placeholder="From" name="startFrom">
                        <br>
                        <input type="date" class="form-control" id="dateTo" placeholder="To" name="startTo">
                    </div>
                    <div class="row">
                        <h5>Max km from my location:</h5>
                    </div>
                    <div class="row">
                        <input type="number" class="form-control" id="km" placeholder="Km" name="km">
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <select class="form-control" name="type">
                                <option value="All">All types</option>
                                <option value="Trip">Trip</option>
                                <option value="Party">Party</option>
                                <option value="Sport">Sport</option>
                                <option value="Education">Education</option>
                                <option value="Culture">Culture</option>
                                <option value="Birthday">Birthday</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <select class="form-control" name="order">
                                <option value="title"><p>Title</p></option>
                                <option value="event_start"><p>Date</p></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="orderDirection">
                                <option value="desc"><p>Descending</p></option>
                                <option value="asc"><p>Ascending</p></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-block"> Filter </button>
                        <button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                    </div>
                    </form>
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
</div>