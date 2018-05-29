<!DOCTYPE html>
<head>
    <link href="{{ asset('css/create_event.css') }}" rel="stylesheet">
    <title> "Create event" </title>
</head>
<div class="container">
    <div class="py-3 text-center">
        <h1>Create event</h1>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation"  method="POST" action="{{ route('create_event') }}" onsubmit="return(validate());" enctype="multipart/form-data">
                <fieldset>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-8 mb-3 md-10">
                            <label for="title"><b>Title (required)</b></label>
                            <input class="form-control" placeholder="Name of the event" id="title" type="text" name="title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3.5 mb-5 pl-3">
                            <label for="date_start"><b>Start Date</b></label>
                            <div class="input-group">
                                <input class="form-control" id="date_start" type="date" name="date_start" value="2018-06-06">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_start"><b>Time</b></label>
                            <div class="input-group">
                                <input class="form-control" id="time_start" type="time" name="time_start">
                            </div>
                        </div>
                        <div class="col-2.5 pl-5">
                            <label for="date_end"><b>End Date</b></label>
                            <div class="input-group">
                                <input class="form-control" id="date_end" type="date" name="date_end" value="2018-07-07">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_end"><b>Time</b></label>
                            <div class="input-group">
                                <input class="form-control" id="time_end" type="time" name="time_end">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_type"><b>Type</b></label>
                            <select class="custom-select d-block w-100" id="event_type" name="event_type">
                                <option value="Trip" selected="selected">Trip</option>
                                <option value="Party">Party</option>
                                <option value="Sport">Sport</option>
                                <option value="Education">Education</option>
                                <option value="Culture">Culture</option>
                                <option value="Birthday">Birthday</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fileToUpload"><b>Event photo</b></label>
                            <input type="file" class="form-control" name="images[]" multiple>
                        </div>
                    </div>
                    <hr class="mb-1">
                    <label><b>Location</b></label>
                    <input class="form-control" id="gps" placeholder="Address of the event" type="text" name="gps">
                    <br/>
                    <input id="submit" type="button" class="btn btn-primary" value="Show on map">
                    <hr class="mb-4">
                    <div id="map" class="map rounded mt-1"></div>
                    <hr class="mb-4">
                    <fieldset>
                        <legend><h5><b>Event privacy</b></h5></legend>
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
                    </fieldset>
                    <h5><b>Event description</b></h5>
                    <textarea class="form-control" rows="5" placeholder="Write a description..." name="event_description" id="event_description"></textarea>
                    <hr class="mb-4">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Create">
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function validate() {
        var username = document.getElementById("title").value;

        if (username.length <= 0) {
            alert("Please enter the name of the event.");
            return false;
        }
    }

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
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(11);
                    var marker = new google.maps.Marker({
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