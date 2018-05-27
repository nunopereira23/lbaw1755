<link href="{{ asset('css/events.css') }}" rel="stylesheet">
<div class="container">
    <h3>All public events</h3>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="container">
                    <form method="get" action={{ route('search_events') }}>
                        {{ csrf_field() }}
                        <div class="row">
                            <h5>Title</h5>
                            <input type="text" class="form-control" placeholder="Title" name="title" id="title">
                        </div>
                        <br/>
                        <div class="row">
                            <h5>Event start between: </h5>
                        </div>
                        <div class="row">
                            <input type="date" class="form-control" id="dateFrom" placeholder="From" name="startFrom">
                            <br>
                            <input type="date" class="form-control" id="dateTo" placeholder="To" name="startTo">
                        </div>
                        <br/>
                        <div class="row">
                            <h5>Location:</h5>
                        </div>
                        <div class="row">
                            <input type="text" class="form-control" id="location" placeholder="Location" name="location">
                        </div>
                        <br/>
                        <div class="row">
                            <h5>Event type:</h5>
                        </div>
                        <div class="row">
                            <select class="form-control" name="type" id="type">
                                <option value="All">All types</option>
                                <option value="Trip">Trip</option>
                                <option value="Party">Party</option>
                                <option value="Sport">Sport</option>
                                <option value="Education">Education</option>
                                <option value="Culture">Culture</option>
                                <option value="Birthday">Birthday</option>
                            </select>
                        </div>
                        <br/>
                        <div class="row">
                            <h5>Order by:</h5>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <select class="form-control" name="order">
                                    <option value="title"><p>Title</p></option>
                                    <option value="event_start"><p>Date</p></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <select class="form-control" name="orderDirection">
                                    <option value="desc"><p>Descending</p></option>
                                    <option value="asc"><p>Ascending</p></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary btn-block"> Filter</button>
                        </div>
                    </form>
                    <p></p>
                    <div class="row">
                        <input id="submit" type="button" class="btn btn-default btn-block" value="Clear">
                    </div>
                </div>
            </div>
            <?php $events?>
            <div class="col align-content-center">
                <?php for ($i = 0; $i < $count; $i++) :
                if (($i % 4) == 0)  { ?>
                <?php $event = $events[$i]; ?>
                <div class="card">
                    <img src="{{ asset($event->getPicture()) }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="event/<?php echo $events[$i]->id ?>"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6><?php echo date_format(new DateTime($event->event_start), 'g:ia jS F Y') ?></h6>
                        <h6><?php echo $events[$i]->gps ?></h6>
                    </div>
                </div>
                <br>
                <?php } endfor ?>
            </div>
            <div class="col align-content-center">
                <?php if ($count == 0) { ?>
                <div class="row">
                    <h5> There are no events. </h5>
                </div>
                <?php } ?>
                <?php for ($i = 0; $i < $count; $i++) :
                if (($i % 4) == 1)  { ?>
                <?php $event = $events[$i]; ?>
                <div class="card">
                    <img src="{{ asset($event->getPicture()) }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="event/<?php echo $events[$i]->id ?>"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6><?php echo date_format(new DateTime($event->event_start), 'g:ia jS F Y') ?></h6>
                        <h6><?php echo $events[$i]->gps ?></h6>
                    </div>
                </div>
                <br>
                <?php } endfor ?>
            </div>
            <div class="col align-content-center">
                <?php for ($i = 0; $i < $count; $i++) :
                if (($i % 4) == 2)  { ?>
                <?php $event = $events[$i]; ?>
                <div class="card">
                    <img src="{{ asset($event->getPicture()) }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="event/<?php echo $events[$i]->id ?>"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6><?php echo date_format(new DateTime($event->event_start), 'g:ia jS F Y') ?></h6>
                        <h6><?php echo $events[$i]->gps ?></h6>
                    </div>
                </div>
                <br>
                <?php } endfor ?>
            </div>
            <div class="col align-content-center">
                <?php for ($i = 0; $i < $count; $i++) :
                if (($i % 4) == 3)  { ?>
                <?php $event = $events[$i]; ?>
                <div class="card">
                    <img src="{{ asset($event->getPicture()) }}" style="width:100%" class="card-img-top">
                    <div class="card-block">
                        <h4><a href="event/<?php echo $events[$i]->id ?>"> <?php echo $events[$i]->title ?> </a></h4>
                        <h6><?php echo date_format(new DateTime($event->event_start), 'g:ia jS F Y') ?></h6>
                        <h6><?php echo $events[$i]->gps ?></h6>
                    </div>
                </div>
                <br>
                <?php } endfor ?>
                <br>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('submit').addEventListener('click', function () {
        clear();
    });

    function clear() {
        document.getElementById('title').value = "";
        document.getElementById('dateFrom').value = "";
        document.getElementById('dateTo').value = "";
        document.getElementById('location').value = "";
        document.getElementById('type').value = "All";
    }
</script>