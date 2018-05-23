<link href="{{ asset('css/create_event.css') }}" rel="stylesheet">

<div class="container">
    <div class="py-3 text-center">
        <h1>Edit event</h1>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation" role="form" method="POST" action="{{ route('edit_event', [$event]) }}" onsubmit="return(validate());" enctype="multipart/form-data">
                <fieldset>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-8 mb-3 md-10">
                            <label for="title"><b>Title (required)</b></label>
                            <input class="form-control" placeholder="Name of the event" id="title" type="text" name="title" value="<?php echo $event->title ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3.5 mb-5 pl-3">
                            <label for="date_start"><b>Start Date</b></label>
                            <div class="input-group">
                                <input class="form-control" id="date_start" type="date" name="date_start" value="<?php echo date_format(new DateTime($event->event_start), 'Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_start"><b>Time</b></label>
                            <div class="input-group">
                                <input class="form-control" id="time_start" type="time" name="time_start" value="<?php echo date_format(new DateTime($event->event_end), 'h:i')?>">
                            </div>
                        </div>
                        <div class="col-2.5 pl-5">
                            <label for="date_end"><b>End Date</b></label>
                            <div class="input-group">
                                <input class="form-control" id="date_end" type="date" name="date_end" value="<?php echo date_format(new DateTime($event->event_end), 'Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_end"><b>Time</b></label>
                            <div class="input-group">
                                <input class="form-control" id="time_end" type="time" name="time_end" value="<?php echo date_format(new DateTime($event->event_start), 'h:i')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_type"><b>Type</b></label>
                            <select class="custom-select d-block w-100" id="event_type" name="event_type">
                                <option value="Trip" <?php echo($event->event_type == "Trip" ? 'selected' : ''); ?>>Trip</option>
                                <option value="Sport" <?php echo($event->event_type == "Sport" ? 'selected' : ''); ?>>Sport</option>
                                <option value="Party" <?php echo($event->event_type == "Party" ? 'selected' : ''); ?>>Party</option>
                                <option value="Culture" <?php echo($event->event_type == "Culture" ? 'selected' : ''); ?>>Culture</option>
                                <option value="Education" <?php echo($event->event_type == "Education" ? 'selected' : ''); ?>>Education</option>
                                <option value="Birthday" <?php echo($event->event_type == "Birthday" ? 'selected' : ''); ?>>Birthday</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fileToUpload"><b>Event photo</b></label>
                            <input type="file" class="form-control" name="images[]" multiple>
                        </div>
                    </div>
                    <hr class="mb-1">
                    <label><b>Location</b></label>
                    <input class="form-control" placeholder="Address of the event" id="gps" type="text" name="gps" value="<?php echo $event->gps ?>">
                    <br/>
                    <input id="submit" type="button" class="btn btn-primary" value="Show on map">
                    <hr class="mb-4">
                    <div id="map" class="map rounded mt-1"></div>
                    <hr class="mb-4">
                    <h5 class="mb-3"><b>Event privacy</b></h5>
                    <div class="row">
                        <div class="col-6 d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="event_visibility"
                                       name="event_visibility"
                                       value="Private"
                                       class="custom-control-input"
                                       type="radio"
                                <?php echo($event->event_visibility == "Private" ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="invite">Invite only</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="public"
                                       name="event_visibility"
                                       value="Public"
                                       class="custom-control-input"
                                       checked type="radio"
                                <?php echo($event->event_visibility == "Public" ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="public">Public</label>
                            </div>
                        </div>
                    </div>
                    <h5><b>Event description</b></h5>
                    <textarea class="form-control" rows="5" placeholder="Write a description..." name="event_description" id="event_description"><?php echo $event->description ?></textarea>
                    <hr class="mb-4">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Edit" name="submitted">
                    <input type="submit" class="btn btn-danger btn-lg btn-block" value="Cancel" name="submitted">
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function validate() {
        var username = document.getElementById("title").value;
        var location = document.getElementById("gps").value;

        if (username.length <= 0) {
            alert("Please enter the name of the event.");
            return false;
        }
        if (location.length <= 0) {
            alert("Please enter the location of the event.");
            return false;
        }
    }

    function myMap() {
        var mapCanvas = document.getElementById("map");
        var mapOptions = {
            center: new google.maps.LatLng(41.15, -8.63), zoom: 15
        };
        var marker;
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;

        var address = document.getElementById('gps').value;
        geocoder.geocode({'address': address}, function (results) {
            if (results[0]) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(11);
                marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            }
        });

        document.getElementById('submit').addEventListener('click', function () {
            geocodeLatLng(geocoder, map, infowindow, marker);
        });
    }

    function geocodeLatLng(geocoder, map, infowindow, marker) {
        marker.setMap(null);
        var address = document.getElementById('gps').value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(11);
                    marker = new google.maps.Marker({
                        position: results[0].geometry.location,
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
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7TfDZysirAi-y1lFLtQQHxP_4Zs2-nrw&callback=myMap"></script>