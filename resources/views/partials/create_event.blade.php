<!DOCTYPE html>
<link href="{{ asset('css/create_event.css') }}" rel="stylesheet">

<div class="container mb-5">
    <div class="py-3 text-center">
        <h3>Create event</h3>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <form class="needs-validation" novalidate="" role="form" method="POST" action="{{ route('create_event') }}" onsubmit="return(validate());">
                <fieldset>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-8 mb-3 md-10">
                            <label for="title">Title*</label>
                            <input class="form-control" placeholder="Name of the event" id="title" type="text" name="title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3.5 mb-5 pl-3">
                            <label for="date_start">Start Date</label>
                            <div class="input-group">
                                <input class="form-control" id="date_start" type="date" name="date_start" value="2018-09-01">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_start">Time</label>
                            <div class="input-group">
                                <input class="form-control" id="time_start" type="time" name="time_start">
                            </div>
                        </div>
                        <div class="col-2.5 pl-5">
                            <label for="date_end">End Date</label>
                            <div class="input-group">
                                <input class="form-control" id="date_end" type="date" name="date_end" value="2018-09-02">
                            </div>
                        </div>
                        <div class="col-1.5 pl-4">
                            <label for="time_end">Time</label>
                            <div class="input-group">
                                <input class="form-control" id="time_end" type="time" name="time_end">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_type">Type</label>
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
                        <div class="col-6">
                            <button type="button" class="btn btn-primary m-2 float-right" data-toggle="modal" data-target=".bd-example-modal-sm2">
                                Share with...
                            </button>
                            <div class="modal fade bd-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content text-center">
                                        <h3 class="modal-title" id="exampleModalLabel">Share with...</h3>
                                        <div class="modal-body">
                                            <div class="list-group list-group-flush">
                                                <a class="list-group-item list-group-item-action">
                                                    <div class="custom-control custom-checkbox m-0" style="height:20px">
                                                        <input type="checkbox" class="custom-control-input " id="customCheck1">
                                                        <img class="img-responsive" style=" height: 100%;" src="../../images/profile.png">
                                                        <label class="custom-control-label" for="customCheck1">John Smith</label>
                                                    </div>
                                                </a>
                                                <a class="list-group-item list-group-item-action">
                                                    <div class="custom-control custom-checkbox m-0" style="height:20px">
                                                        <input type="checkbox" class="custom-control-input " id="customCheck2">
                                                        <img class="img-responsive" style=" height: 100%;" src="../../images/profile.png">
                                                        <label class="custom-control-label" for="customCheck2">John Doe</label>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Send</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h5> Event description</h5>
                        <textarea class="form-control" rows="5" placeholder="Write a description..." name="event_description" id="event_description"></textarea>
                    </div>
                    <hr class="mb-4">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Submit">
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