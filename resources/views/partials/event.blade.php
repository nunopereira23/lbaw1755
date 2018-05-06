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
                        <div id="userActions" class="col-md-2">
                            <?php if ($status != ('')){
                            echo '->user: ' . $status . "\n" . '->event: ' . $event->event_visibility;
                            if ($status != 'Owner'){ ?>
                              <?php if(($status != 'Going')&&($status != 'Ignoring')){ ?>
                                <button type="submit" id="acceptEvent" class="btn btn-primary m-2" style="width:100%">Accept</button>
                              <?php }else if ($status == 'Going'){ ?>
                              <button type="submit" id="acceptEvent" class="btn btn-success m-2" style="width:100%">Going</button>
                              <?php } ?>

                                <?php if(($status != 'Ignoring')&&($status != 'Going')){ ?>
                                <button type="submit" id="ignoreEvent" class="btn btn-secondary m-2" style="width:100%">Ignore</button>
                              <?php }else if ($status == 'Ignoring'){ ?>
                                  <button type="submit" id="ignoreEvent" class="btn btn-danger m-2" style="width:100%">Ignoring</button>
                              <?php } ?>

                            <?php } else{ ?>
                            <form action="/event/<?php echo $event->id ?>/edit_event" style="margin:0">
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
        <div class="modal fade shareModal" id="shareEventModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-center">
                    <h5 class="modal-title">Share with...</h5>

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
                        <button type="submit" id="shareEvent" class="btn btn-primary btn-xs">Send</button>
                        <button type="button" id="closeShareEvent" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="row pb-5 mt-2">
          <?php if ($status != ''){ ?>
            <div class="new_comment col-md-6 mb-5 mt-3" id="new_comment">
                <div class="form-group">
                    <h5>New comment:</h5>
                    <textarea style="resize:none;" class="form-control bg-light" minlength="1" maxlength="150" rows="5" id="commentContent" placeholder=""></textarea>
                    <button type="button" class="btn btn-sm m-2 mr-2" data-toggle="modal" data-target=".bd-example-modal-sm4">Add photo</button>
                    <button type="button" class="btn m-2">Add poll</button>
                    <input type="submit" id="submitComment" class="btn float-right mt-2 mb-5" value="Submit">
                    <div class="alert alert-success" id="newCommentSuccess" style="display:none;">
                      Comment added sucessfuly.
                    </div>
                    <div class="alert alert-danger" id="newCommentFailure" style="display:none;">
                      Comment failed.
                    </div>
                </div>
            </div>
          <?php } ?>
          </br>

            <div class="comments col-md-6 pull-right mt-3" id="comments">
                <h5 class="mb-2 ">Comments(<?php echo count(json_decode($comments)); ?>)</h5>
                <div class="comment mb-2 ml-2 row">
                  <?php foreach($comments as $comment){ ?>
                    <div name="comments[]" id=<?php echo $comment->id ?> class="comment-content col-sm-11 p-2 mb-1 rounded bg-light border">
                        <div class="comment-body">
                            <p><?php echo $comment->comment_content ?>
                                <br>
                                <?php if ($status != ''){ ?>
                                  <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#bd-example-modal3">Reply</button>
                                <?php } ?>
                                <br>
                            </p>
                        </div>
                        <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                        <p class="text-right"><a href="../users/<?php echo $comment->user_id ?>/profile"><?php echo $comment->name ?></a></p>
                        <div class="mb-1 text-muted text-right"><?php echo $comment->date ?></div>
                    </div>
                    <!-- <div class="comment-reply col-md-11 col-sm-10 mb-3 mt-2" style="width:90%">
                        <div class="row">
                            <div class="comment-content col-sm-11 p-2 rounded bg-light border">
                              <div class="comment-body">
                                  <p>This is a comment. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                      laboris nisi ut aliquip ex ea commodo consequat.
                                      <br>
                                      <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#bd-example-modal3">Reply</button>
                                      <br>
                                  </p>
                              </div>
                              <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                              <p class="text-right"><a href="../profile">John Doe</a></p>
                              <div class="mb-1 text-muted text-right">Today, 2:38 PM</div>
                            </div>
                        </div>
                    </div> -->

                  <?php } ?>
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
                                    <label for="new_comment"></label><textarea class="form-control" rows="6" maxlength="100" id="new_comment"></textarea>
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



    <div class="modal fade" id="inviteSuccess" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body" style="font-size:15px;">
                <p class="modal-title" id="modalInviteBody"></p>
                <br>
                <button type="button" class="btn btn-primary btn-xs mb-0" data-dismiss="modal" style="height:25px;float:right;font-size:11px;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>

      $(document).on( "click", "#acceptEvent", function( ) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                  type : 'AcceptEvent',
                  event_id: <?php echo $event->id ?> },
            dataType: 'JSON',
            success: function (data) {
              //if((data == "AcceptSuccess") || (data == "UnacceptSuccess"))
                $("#userActions").load(location.href+" #userActions>*","");
                //alert(data);
            }
        });
      });

      $(document).on( "click", "#ignoreEvent", function( ) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                  type : 'IgnoreEvent',
                  event_id: <?php echo $event->id ?> },
            dataType: 'JSON',
            success: function (data) {
              //if((data == "AcceptSuccess") || (data == "UnacceptSuccess"))
                $("#userActions").load(location.href+" #userActions>*","");
                //alert(data);
            }
        });
      });

      $(document).on( "click", "#shareEvent", function( ) {

        var invited = [];
        $('input[name="invited[]"]:checked').each(function () {
            invited.push(this.value);
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                  type : 'ShareEvent',
                  event_id: <?php echo $event->id ?>,
                  invited: invited},
            dataType: 'JSON',
            success: function (data) {
              var inviteStatus = data;
              $("#shareEventModal").load(location.href+" #shareEventModal>*","");
              $("#closeShareEvent").click();
              $("#modalInviteBody").empty();
              if(data == "Invited")
              {
                $("#modalInviteBody").append("User(s) invited successfuly.");
              }else if (data == "noInvite") {
                $("#modalInviteBody").append("No one invited.");
              }
                $("#inviteSuccess").modal('toggle');
            }
        });
      });


      $(document).on( "click", "#submitComment", function( ) {

        var commentContent = $("#commentContent").val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                  type : 'SubmitComment',
                  event_id: <?php echo $event->id ?>,
                  comment_content: commentContent,
                  replyto:0 },
            dataType: 'JSON',
            success: function (data) {

              $("#submitComment").attr("disabled",true);
              setTimeout(function(){
                  $("#submitComment").attr("disabled",false);
              }, 1500);

              if (data == "newComment"){
                $("#newCommentSuccess").show();
                setTimeout(function(){
                    $("#newCommentSuccess").fadeOut(500);
                }, 1000);
              }else{
                $("#newCommentFailure").show();
                setTimeout(function(){
                    $("#newCommentfailure").fadeOut(500);
                }, 1000);

              }

              $("#comments").load(location.href+" #comments>*","");
              $("#commentContent").val('');

            }
        });
      });


      $(document).ready(function(){

        var i = 0;
        if ($('div[name="comments[]"]').length > 1) {
          $('div[name="comments[]"]').each(function() {
              if (i > 0)
                $(this).hide();

                i++
          });

          if (i > 0 )
          {
            $("#comments").append('<button id="moreComments" type="button" class="btn btn-primary ml-2 mr-2" style="width:98%;height:35px;">Load more comments</button>');

          }
        }

      });

      $(document).on( "click", "#moreComments", function( ) {
        var i = 0;
        $('div[name="comments[]"]').each(function() {
            if (i > 0)
              $(this).fadeIn(250);

              i++
        });
        $("#moreComments").hide();


      });



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
