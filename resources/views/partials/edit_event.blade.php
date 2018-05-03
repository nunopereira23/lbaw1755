<link href="{{ asset('css/create_event.css') }}" rel="stylesheet">

<div class="container mb-5">
    <div class="py-3 text-center">
        <h3>Edit event</h3>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation" novalidate="" role="form" method="POST" action="/event/<?php echo $event->title ?>/edit_event">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-8 mb-3 md-10">
                        <label for="title">Title</label>
                        <input class="form-control" placeholder="Name of the event" id="title" type="text" name="title" value="<?php echo $event->title ?>">
                        <div class="invalid-feedback">
                            An event name is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3.5 mb-5 pl-3">
                        <label for="date">Start Date</label>
                        <div class="input-group">
                            <input class="form-control" id="date" type="date" name="date_start">
                        </div>
                    </div>
                    <div class="col-1.5 pl-4">
                        <label for="time">Time</label>
                        <div class="input-group">
                            <input class="form-control" id="time" type="time" name="time_start">
                        </div>
                    </div>
                    <div class="col-2.5 pl-5">
                        <label for="date">End Date</label>
                        <div class="input-group">
                            <input class="form-control" id="date" type="date" name="date_end">
                        </div>
                    </div>
                    <div class="col-1.5 pl-4">
                        <label for="time">Time</label>
                        <div class="input-group">
                            <input class="form-control" id="time" type="time" name="time_end">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="event_type">Type</label>
                        <select class="custom-select d-block w-100" id="event_type" name="event_type">
                            <option value="" selected="selected">Choose...</option>
                            <option value="Trip">Trip</option>
                            <option value="Party">Party</option>
                            <option value="Sport">Sport</option>
                            <option value="Education">Education</option>
                            <option value="Culture">Culture</option>
                            <option value="Birthday">Birthday</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="state">Event photo</label>
                        <input class="form-control" type="file">
                    </div>
                </div>
                <hr class="mb-1">
                <label>Location</label>
                <input class="form-control" placeholder="Address of the event" id="gps" type="text" name="gps">
                <input id="submit" type="button" class="btn btn-primary" value="Show on map">
                <div id="map" class="map rounded mt-1"></div>
                <hr class="mb-4">
                <h5 class="mb-3">Event privacy</h5>
                <div class="row">
                    <div class="col-6 d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="event_visibility" name="event_visibility" value="Private" class="custom-control-input" checked="checked" type="radio">
                            <label class="custom-control-label" for="invite">Invite only</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="public" name="event_visibility" value="Public" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="public">Public</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr class="mb-4">
                    <h5>Event description</h5>
                    <textarea class="form-control" rows="5" placeholder="Write a description..." name="event_description" id="event_description"><?php echo $event->description ?></textarea>
                </div>
                <hr class="mb-4">
                <a href="/event/<?php echo $event->id ?>">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Save changes</button>
                </a>
            </form>
        </div>
    </div>
</div>

<script>
    function myMap() {
        var mapCanvas = document.getElementById("map");
        var mapOptions = {
            center: new google.maps.LatLng(41.15, -8.63), zoom: 15
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;

        document.getElementById('submit').addEventListener('click', function () {
            geocodeLatLng(geocoder, map, infowindow);
        });
    }

    function geocodeLatLng(geocoder, map, infowindow) {
        var address = document.getElementById('gps').value;
        geocoder.geocode({'location': address}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setZoom(11);
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map
                    });
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
        $.ajax({
                url: "http://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
                type: "POST",
                success: function (res) {
                    var lat = res.results[0].geometry.location.lat;
                    var lng = res.results[0].geometry.location.lng;
                    var gps = lat + ',' + lng;
                    window.location.href = window.location.href + '?gps=' + gps;
                }
            }
        )
    };


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7TfDZysirAi-y1lFLtQQHxP_4Zs2-nrw&callback=myMap"></script>