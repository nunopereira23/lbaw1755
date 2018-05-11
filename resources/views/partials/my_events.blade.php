<!DOCTYPE html>
<html lang="en">
<title> My events </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../myEvents/my_events.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap-grid.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body>
<?php if ($past) { ?>
<h3> MY EVENTS </h3>
<?php } else { ?>
<h3> MY PAST EVENTS </h3>
<?php }?>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="container">
                <div class="row">
                    <form  id="search-form" method="get" action="/api/users/<?php echo $user->id ?>/my_events">
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
                            <h5>Location:</h5>
                        </div>
                        <div class="row">
                            <input type="text" class="form-control" id="location" placeholder="Location" name="location">
                        </div>
                        <br>
                        <div class="row">
                            <h5>Event type:</h5>
                        </div>
                        <div class="row">
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
                        <div class="row">
                            <h5>My state:</h5>
                        </div>
                        <div class="row">
                            <select class="form-control" name="state">
                                    <option value="All">All states</option>
                                    <option value="Created">Created by me</option>
                                    <option value="Going">Going</option>
                                    <option value="Ignoring">Ignoring</option>
                                    <option value="Invited">Invited</option>
                            </select>
                        </div>
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
                            <div class="form-group">
                                <select class="form-control" name="orderDirection">
                                    <option value="desc"><p>Descending</p></option>
                                    <option value="asc"><p>Ascending</p></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary btn-block"> Filter </button>
                        </div>
                    </form>
                    <div class="row">
                        <button class="btn btn-default btn-block" onclick="clear()"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm align-content-center">
            <span id="created"> Created by me </span>
            <hr>
            <?php foreach ($events as $event) :
                if ($event->pivot->event_user_state == 'Owner') {?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4> <a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?> </h6>
                    <h5> Location </h5>
                </div>
            </div>
            <?php } else {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } endforeach ?>
            <?php if (!($events)) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>
        <div class="col-sm justify-content-center">
            <span id="going"> Going</span>
            <hr>
            <?php foreach ($events as $event) :
                if ($event->pivot->event_user_state == 'Going') {?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4> <a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?> </h6>
                    <h5>Location </h5>
                </div>
            </div>
            <?php } else {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } endforeach ?>
            <?php if (!($events)) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>

        <br>
        <div class="col-sm justify-content-center">
            <span id="ignoring"> Ignoring </span>
            <hr>
            <?php foreach ($events as $event) :
            if ($event->pivot->event_user_state == 'Ignoring') {?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4> <a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?></h6>
                    <h5>Location </h5>
                </div>
            </div>
            <?php } else {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } endforeach ?>
            <?php if (!($events)) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>
        <br>
        <div class="col-sm justify-content-center">
            <span id="invited"> Invited to </span>
            <hr>
            <?php foreach ($events as $event) :
                if ($event->pivot->event_user_state == 'Invited') {?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4> <a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?></h6>
                    <h5>Location </h5>
                    <h5>Invited by <a href="../user/profile.html"> joao95 </a> </h5>
                    <br>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            React <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="my_events.html"> Accept </a></li>
                            <li><a href="my_events.html"> Ignore </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } else {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } endforeach ?>
            <?php if (!($events)) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>
    </div>
</div>
</body>
<footer class="past">
        <div class="container">
            <ul class="list-inline">
                <?php if ($past) { ?>
                <li class="list-inline-item"> <a  href="/users/<?php echo $user->id ?>/past_events"> MY PAST EVENTS </a></li>
                    <?php } else { ?>
                    <li class="list-inline-item"> <a  href="/users/<?php echo $user->id ?>/my_events"> MY EVENTS </a></li>
                    <?php }?>
            </ul>
        </div>
</footer>

</html>

<script>

    function clear() {
        document.getElementById('title').value = "";
        document.getElementById('dateFrom').value = "";
        document.getElementById('dateTo').value = "";
        document.getElementById('location').value = "";
        document.getElementById('type').value = "All";
    }

</script>