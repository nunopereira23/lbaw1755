<link href="{{ asset('css/my_events.css') }}" rel="stylesheet">
<div class="container">
    <?php if ($past) { ?>
    <h3> MY EVENTS </h3>
    <?php } else { ?>
    <h3> MY PAST EVENTS </h3>
    <?php }?>
    <br/>
    <div class="row">
        <div class="col">
            <div class="container">
                <form id="search-form" method="get" action="/api/users/<?php echo $user->id ?>/my_events">
                    {{ csrf_field() }}
                    <div class="row">
                        <h5>Select title</h5>
                        <input type="text" class="form-control" placeholder="Title" name="title" id="title">
                    </div>
                    <br/>
                    <div class="row">
                        <h5>Select the date period:</h5>
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
                        <div class="form-group">
                            <select class="form-control" name="orderDirection">
                                <option value="desc"><p>Descending</p></option>
                                <option value="asc"><p>Ascending</p></option>
                            </select>
                        </div>
                    </div>
                    <br>
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

        <div class="col align-content-center">
            <span id="created"><h4>Created by me</h4></span>
            <hr>
            <?php
            $count = 0;
            foreach ($events as $event) :
            if ($event->pivot->event_user_state == 'Owner') {
            $count++;?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4><a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?> </h6>
                </div>
            </div>
            <br/>
            <?php } endforeach ?>
            <?php if ($count = 0) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>
        <div class="col justify-content-center">
            <span id="going"><h4> Going</h4></span>
            <hr>
            <?php
            $count = 0;
            foreach ($events as $event) :
            if ($event->pivot->event_user_state == 'Going') {
            $count++;?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4><a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?> </h6>
                </div>
            </div>
            <?php } endforeach ?>
            <?php if ($count == 0) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>

        <br>
        <div class="col justify-content-center">
            <span id="ignoring"><h4>Ignoring</h4></span>
            <hr>
            <?php
            $count = 0;
            foreach ($events as $event) :
            if ($event->pivot->event_user_state == 'Ignoring') {
            $count++;?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4><a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?></h6>
                </div>
            </div>
            <?php } endforeach ?>
            <?php if ($count == 0) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
        </div>
        <br>
        <div class="col justify-content-center">
            <span id="invited"><h4>Invited to</h4></span>
            <hr>
            <?php
            $count = 0;
            foreach ($events as $event) :
            if ($event->pivot->event_user_state == 'Invited') {
            $count++;?>
            <div class="card">
                <img class="card-img-top" src="../../images/myevent.jpg" alt="Card image cap">
                <div class="card-block">
                    <h4><a href="/event/<?php echo $event->id ?>"> <?php echo $event->title ?> </a></h4>
                    <h6 class="text-muted"> <?php echo $event->event_start ?></h6>
                    <h5>Location </h5>
                    <h5>Invited by <a href="../user/profile.html"> joao95 </a></h5>
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
            <?php } endforeach ?>
            <?php if ($count == 0) {?>
            <div>
                <p> <?php echo 'OOOPS, this category is empty :/'?> </p>
            </div>
            <?php } ?>
            <hr>
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