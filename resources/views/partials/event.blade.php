<link href="{{ asset('css/event.css') }}" rel="stylesheet">

<div class="container mt-3">
    <div class="col-md-12">
        <div class="row">
            <div class="card col-12">
                <div class="card-top mt-3 rounded event_img" style="background-image: url({{ asset('images/concert.jpeg') }});"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="card-title mb-1 pb-1 font-weight-bold"><?php echo $event->title ?></h4>
                            <div class="text-muted"><?php echo $event->event_start ?> - <?php echo $event->event_type ?></div>
                            <div id="floating-panel">
                                <input id="latlng" type="hidden" value="<?php echo $event->gps ?>">
                                <input id="submit" type="button" value="Get event adress">
                            </div>
                            <p class="card-text"><?php echo $event->description ?></p>
                            <div class="container-fluid  mb-2">
                                <div id="map" class="map rounded" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <?php if ($status != ('')){
                            echo '->user: ' . $status . "\n" . '->event: ' . $event->event_visibility;
                            if ($status != 'Owner'){ ?>
                            <form method="post" style="margin:0" action="/event/<?php echo $event->id ?>">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="AcceptEvent">
                                <input type="hidden" name="event_id" value=<?php echo $event->id ?>>
                                <?php if(($status != 'Going') && ($status != 'Ignoring')){ ?>
                                <button type="submit" class="btn btn-primary m-2" style="width:100%">Accept</button>
                                <?php }else if ($status == 'Going'){ ?>
                                <button type="submit" class="btn btn-success m-2" style="width:100%">Going</button>
                                <?php } ?>
                            </form>
                            <form method="post" style="margin:0" action="/event/<?php echo $event->id ?>">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="IgnoreEvent">
                                <input type="hidden" name="event_id" value=<?php echo $event->id ?>>
                                <?php if(($status != 'Ignoring') && ($status != 'Going')){ ?>
                                <button type="submit" class="btn btn-secondary m-2" style="width:100%">Ignore</button>
                                <?php }else if ($status == 'Ignoring'){ ?>
                                <button type="submit" class="btn btn-danger m-2" style="width:100%">Ignoring</button>
                                <?php } ?>
                            </form>

                            <?php } else{ ?>
                            <form action="/event/<?php echo $event->id ?>/edit_event">
                                <button type="submit" class="btn btn-primary m-2" style="width:100%">Edit event</button>
                            </form>
                            <button type="button" class="btn btn-danger m-2" data-toggle="modal" data-target="#cancelEventModal" style="font-size:11px;width:100%;">Cancel Event</button>
                            <?php } ?>
                            <?php } ?>
                            <button type="button" class="btn m-2 dropdown-toggle" style="width:100%" data-toggle="modal" data-target=".goingModal">
                                <?php echo count($going); ?> are in!
                            </button>
                            <?php if ($status != ('')){ ?>
                            <button type="button" class="btn m-2 dropdown-toggle" data-toggle="modal" style="width:100%" data-target=".shareModal">
                                Share
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancelEventModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="font-size:15px;">
                        <button type="button" class="close" data-dismiss="modal" style="margin-right:2px;">&times;</button>
                        <p class="modal-title">Are you sure you want to cancel this event?</p>
                    </div>
                    <div class="modal-footer">
                        <form method="post" style="margin:0" action="/event/<?php echo $event->id ?>">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="CancelEvent">
                            <input type="hidden" name="event_id" value=<?php echo $event->id ?>>
                            <button type="submit" class="btn btn-danger btn-xs">Yes</button>
                            <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade goingModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-center">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="exampleModalLabel">Currently Accepted</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group list-group-flush">
                            <?php foreach ($going as $user) {?>
                            <a class="list-group-item list-group-item-action" href="../users/<?php echo $user->id ?>/profile" style="height:50px">
                                <img class="img-responsive pull-right" style=" height: 100%;" src="../../images/profile.png">
                                <?php echo $user->name; ?>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade shareModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-center">
                    <h5 class="modal-title">Share with...</h5>
                    <form method="post" style="margin:0" action="/event/<?php echo $event->id ?>">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="ShareEvent">
                        <input type="hidden" name="event_id" value=<?php echo $event->id ?>>

                        <div class="modal-body">
                            <div class="list-group list-group-flush">
                                <a class="list-group-item list-group-item-action">
                                    <?php foreach ($canBeInvited as $user) {?>
                                    <div class="custom-control custom-checkbox mb-1" style="height:30px;">
                                        <input type="checkbox" class="custom-control-input" name="invited[]" id="customCheck<?php echo $user->id ?>" value=<?php echo $user->id ?>>
                                        <img class="img-responsive" style=" height: 100%;float:left;" src="../../images/profile.png">
                                        <label class="custom-control-label" for="customCheck<?php echo $user->id ?>" style='font-size:14px;'><?php echo $user->name ?></label>
                                    </div>
                                    <?php }?>
                                </a>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-xs">Send</button>
                            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row pb-5 mt-2">
            <div class="comments col-md-6" id="comments">
                <h5 class="mb-2">Comments</h5>
                <div class="comment mb-2 ml-2 row">
                    <div class="comment-content col-sm-10 p-2 rounded bg-light border">
                        <div class="comment-body">
                            <p>This is a comment. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea commodo consequat.
                                <br>
                                <button type="button" class="btn btn-sm float-left" data-toggle="modal" data-target="#bd-example-modal3">Reply</button>
                                <br>
                            </p>
                        </div>
                        <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                        <h5 class="text-right"><a href="../profile">John Doe</a></h5>
                        <div class="mb-1 text-muted text-right">Today, 2:38 PM</div>
                    </div>
                    <div class="comment-reply col-md-11 col-sm-10 offset-sm-2 mt-2" style="width:90%">
                        <div class="row">
                            <div class="comment-content col-sm-10 p-2 rounded bg-light border">
                                <div class="comment-body">
                                    <p>This is a comment reply. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        <br>
                                        <button type="button" class="btn btn-sm float-left" data-toggle="modal" data-target="#bd-example-modal3">Reply</button>
                                        <br>
                                    </p>
                                </div>
                                <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="20px" width="20px">
                                <h6 class="text-right"><a href="../profile">John Doe</a></h6>
                                <div class="mb-1 text-muted text-right">Today, 4:41 PM</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="bd-example-modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Reply</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="new_comment"></label><textarea class="form-control" rows="5" id="new_comment"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Send</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new_comment col-md-6" id="new_comment">
                <div class="form-group">
                    <h5>New comment:</h5>
                    <textarea class="form-control bg-light" rows="5" id="new_comment" placeholder=""></textarea>
                    <button type="button" class="btn btn-sm m-2 mr-2" data-toggle="modal" data-target=".bd-example-modal-sm4">Add photo</button>
                    <button type="button" class="btn m-2">Add poll</button>
                    <input type="submit" class="btn float-right mt-2" value="Submit">
                </div>
            </div>
            <div class="modal fade bd-example-modal-sm4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content text-center">
                        <div class="modal-body">
                            <input type="file" single>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <label hidden id="triggerModal">
        <?php echo $modal;?>
    </label>

    <div class="modal fade" id="inviteSuccess" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body" style="font-size:15px;">
                    <?php if ($modal == 'Invite'){ ?>
                    <p class="modal-title">User(s) invited successfuly.</p>
                    <?php } elseif ($modal == 'noInvite') { ?>
                    <p class="modal-title">No users were invited.</p>
                    <?php } ?>
                    <br>
                    <button type="button" class="btn btn-primary btn-xs mb-0" data-dismiss="modal" style="height:25px;float:right;font-size:11px;">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        var labelText = $('#triggerModal').text().trim();

        if (labelText != "noModal") {
            $(document).ready(function () {
                $('#inviteSuccess').modal('show');
            });
        }
    </script>

    <script>
        function myMap() {
            var mapCanvas = document.getElementById("map");
            var mapOptions = {
                center: new google.maps.LatLng(<?php echo $event->gps ?>), zoom: 15
            };
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;

            document.getElementById('submit').addEventListener('click', function () {
                geocodeLatLng(geocoder, map, infowindow);
            });
        }

        function geocodeLatLng(geocoder, map, infowindow) {
            var input = document.getElementById('latlng').value;
            var latlngStr = input.split(',', 2);
            var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
            geocoder.geocode({'location': latlng}, function (results, status) {
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
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7TfDZysirAi-y1lFLtQQHxP_4Zs2-nrw&callback=myMap"></script>
</div>
