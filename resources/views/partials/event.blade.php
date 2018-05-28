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
                                <input id="address" type="hidden" value="<?php echo $event->gps ?>">
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
                            <button type="submit" class="btn btn-danger btn-sm btn-xs">Yes</button>
                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <div class="modal fade" id="addPollModal" role="dialog">
            <?php if ($status != ''){ ?>
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header" style="font-size:15px;">
                        <p>Please add your question!</p>

                    </div>
                    <div class="modal-footer">
                        <br method="post" style="margin:0" action="/event/<?php echo $event->id ?>">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="AddPoll">
                        <input type="hidden" name="event_id" value=<?php echo $event->id ?>>


                        <div class="poll-question">
                            <textarea style="resize:horizontal;" class="form-control bg-light modal-tittle" minlength="1" maxlength="80" rows="1" id="pollQuestion" placeholder=""></textarea>
                        </div>


                        <button type="submit" id="submitPoll" class="btn btn-danger btn-sm btn-xs">Submit</button>
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>

                        <div class="alert alert-success" id="newPollSuccess" style="display:none;">
                            Poll added sucessfuly.
                        </div>
                        <div class="alert alert-danger" id="newPollFailure" style="display:none;">
                            Poll failed.
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
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

        <div class="row pbpb-5 mt-2">
            <?php if ($status != ''){ ?>
            <div class="new_comment col-md-6 mb-5 mt-3" id="new_comment">
                <div class="form-group">
                    <h5>New comment:</h5>
                    <textarea style="resize:none;" class="form-control bg-light" minlength="1" maxlength="150" rows="5" id="commentContent" placeholder=""></textarea>
                    <button type="button" class="btn btn-sm m-2 mr-2" data-toggle="modal" data-target=".bd-example-modal-sm4">Add photo</button>
                    <button type="button" class="btn  btn-sm m-2 mr-2" data-toggle="modal" data-target="#addPollModal">Add Poll</button>
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

            </br><hr>

            <!-- Polls -->
                <div class="polls-div col-md-6 mb-5 mt-3">
                    <h5 class="mb-2 ">Polls(<?php echo count(json_decode($polls)); ?>)</h5>

                    <?php foreach($polls as $poll){ ?>
                    <div name="polls[]"  class="poll-content  rounded bg-light border">
                        <div class="poll-id" id=<?php echo $poll->id ?>>
                            <p><?php echo $poll->question ?>
                                <br>
                                <?php if ($status != ''){ ?>
                                <button type="button" id="answerPoll" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#answerPoll">Answer</button>
                                <?php } ?>
                                <?php if (($status == 'Owner' )||($user_id == $poll->id_user)){ ?>
                                <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1" data-toggle="modal" data-target="#deletePoll">Delete</button>
                                <?php } ?>
                                <br>
                            </p>
                        </div>
                        <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                        <br>
                        <br>
                    </div>
                    <?php } ?>
                </div>



            <div class="comments col-md-6 pull-right mt-3" id="comments">
                <h5 class="mb-2 ">Comments(<?php echo count(json_decode($comments))+count(json_decode($replies)); ?>)</h5>
                <div class="comment mb-2 ml-2 row">
                    <?php foreach($comments as $comment){ ?>
                    <div name="comments[]"  class="comment-content col-sm-11 p-2 mb-1 rounded bg-light border">
                        <div class="comment-body" id=<?php echo $comment->id ?>>
                            <p><?php echo $comment->comment_content ?>
                                <br>
                                <?php if ($status != ''){ ?>
                                <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#replyCommentModal">Reply</button>
                                <?php } ?>
                                <?php if (($status == 'Owner' )||($user_id == $comment->user_id)){ ?>
                                <?php if ($comment->comment_content != ' Comment deleted' ){ ?><!-- White space is intentional-->
                                <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1" data-toggle="modal" data-target="#deleteCommentModal">Delete</button>
                                <?php } ?>
                                <?php } ?>
                                <br>
                            </p>
                        </div>
                        <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                        <p class="text-right">
                            <?php if ($comment->comment_content != ' Comment deleted' ){ ?>
                            <a href="../users/<?php echo $comment->user_id ?>/profile"><?php echo $comment->name ?></a>
                            <?php } else { ?>
                            User
                        <?php }?>

                        <div class="mb-1 text-muted text-right"><?php echo $comment->date;  echo " | Nr: "?><span id="comment_id"> <?php echo $comment->id." " ?></span></div>
                    </div>

                    <?php foreach($replies as $reply){ ?>
                    <?php if($reply->replyto == $comment->id ){?>
                    <div name="replies[]"  class="comment-content col-sm-11 p-2 mb-1 ml-1" >
                        <div class="comment-content col-sm-11 p-2 rounded bg-light border">
                            <div class="comment-body" id=<?php echo $comment->id ?>><!-- so the reply is made to the aprent comment -->
                                <p><?php echo $reply->comment_content ?>
                                    <br>
                                    <?php if ($status != ''){ ?>
                                    <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#replyCommentModal">Reply</button>
                                    <?php } ?>
                                    <?php if (($status == 'Owner' )||($user_id == $reply->user_id)) { ?>
                                    <?php if ($reply->comment_content != ' Comment deleted' ){ ?><!-- White space is intentional-->
                                    <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1" data-toggle="modal" data-target="#deleteCommentModal">Delete</button>
                                    <?php } ?>
                                    <?php } ?>
                                    <br>
                                </p>
                            </div>
                            <img class="img-fluid rounded-circle float-right" src="../../images/profile.png" height="25px" width="25px">
                            <p class="text-right">
                                <?php if ($reply->comment_content != ' Comment deleted' ){ ?>
                                <a href="../users/<?php echo $reply->user_id ?>/profile"><?php echo $reply->name ?></a>
                                <?php } else { ?>
                                User
                                <?php }?>
                            </p>
                            <div class="mb-1 text-muted text-right"><?php echo $reply->date;  echo " | Nr: "?><span id="comment_id"> <?php echo $reply->id." " ?></span></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </div>





                <!-- Modal -->
                <div class="modal" id="replyCommentModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <p hidden id="replyButtonId"></p>
                            <div class="modal-header">
                                <h5 class="modal-title">Reply</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <textarea class="form-control" rows="6" maxlength="100" id="new_reply"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="submitCommentReply" class="btn btn-primary">Send</button>
                                <button type="button" id="closeCommentReply" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>












                <div class="modal fade" id="deleteCommentModal" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <p hidden id="deleteCommentId"></p>
                        <div class="modal-header" style="font-size:15px;">
                            <button type="button" class="close" data-dismiss="modal" style="margin-right:2px;">&times;</button>
                            <p class="modal-title">Are you sure you want to delete this comment?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitCommentDelete" class="btn btn-danger btn-sm btn-xs">Yes</button>
                            <button type="button" id="closeCommentDelete" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
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
</div>



<meta name="csrf-token" content="{{ csrf_token() }}" />

<script type="text/javascript">
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
    $(document).on( "click", "#submitPoll", function( ) {
        var pollQuestion = $("#pollQuestion").val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                type : 'SubmitPoll',
                event_id: <?php echo $event->id ?>,
                question: pollQuestion,
            },
            dataType: 'JSON',
            success: function (data) {
                $("#submitPoll").attr("disabled",true);
                setTimeout(function(){
                    $("#submitPoll").attr("disabled",false);
                }, 1500);
                if (data == "newPoll"){
                    $("#newPollSuccess").show();
                    setTimeout(function(){
                        $("#newPollSuccess").fadeOut(500);
                    }, 1000);
                }else{
                    $("#newPollFailure").show();
                    setTimeout(function(){
                        $("#newPollFailure").fadeOut(500);
                    }, 1000);
                }
            }
        });
    });
    $(document).ready(function(){
        var i = 0;
        var j = 0;
        if ($('div[name="comments[]"]').length > 1) {
            $('div[name="comments[]"]').each(function() {
                if (i > 0)
                    $(this).hide();
                i++
            });
            $('div[name="replies[]"]').each(function() {
                if (j > 0)
                    $(this).hide();
                j++
            });
            if (i > 0 )
            {
                $("#comments").append('<button id="moreComments" type="button" class="btn btn-primary ml-2 mr-2" style="width:98%;height:35px;">Load more comments</button>');
            }
        }
    });
    $(document).on( "click", "#moreComments", function( ) {
        var i = 0;
        var j = 0;
        $('div[name="comments[]"]').each(function() {
            if (i > 0)
                $(this).fadeIn(250);
            i++
        });
        $('div[name="replies[]"]').each(function() {
            if (j > 0)
                $(this).fadeIn(250);
            j++
        });
        $("#moreComments").hide();
    });
    /*Fill the toreply field*/
    $(document).on( "click", "#replyButton", function( ) {
        $("#replyButtonId").text($(this).closest("div").attr("id"));
    });
    $(document).on( "click", "#submitCommentReply", function( ) {
        var commentContent = $("#new_reply").val();
        var replyto = $("#replyButtonId").text();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                type : 'SubmitComment',
                event_id: <?php echo $event->id ?>,
                comment_content: commentContent,
                replyto:replyto },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentReply").click();
                $("#new_reply").val('');
                $("#comments").load(location.href+" #comments>*","");
            }
        });
    });
    /*Fill the toreply field*/
    $(document).on( "click", "#deleteButton", function( ) {
        $("#deleteCommentId").text($(this).parent().parent().parent().find('span').text());
    });
    $(document).on( "click", "#submitCommentDelete", function( ) {
        var comment_id = $("#deleteCommentId").text();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                type : 'DeleteComment',
                event_id: <?php echo $event->id ?>,
                comment_id:comment_id },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentDelete").click();
                $("#comments").load(location.href+" #comments>*","");
            }
        });
    });
    $(document).on( "click", "#replyButton", function( ) {
        $("#replyButtonId").text($(this).closest("div").attr("id"));
    });
    $(document).on( "click", "#submitCommentReply", function( ) {
        var commentContent = $("#new_reply").val();
        var replyto = $("#replyButtonId").text();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                type : 'SubmitComment',
                event_id: <?php echo $event->id ?>,
                comment_content: commentContent,
                replyto:replyto },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentReply").click();
                $("#new_reply").val('');
                $("#comments").load(location.href+" #comments>*","");
            }
        });
    });
</script>
<script>
    function myMap() {
        var mapCanvas = document.getElementById("map");
        var mapOptions = {
            center: new google.maps.LatLng(41.15, -8.63), zoom: 15
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results) {
            if (results[0]) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(11);
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            }
        })
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7TfDZysirAi-y1lFLtQQHxP_4Zs2-nrw&callback=myMap"></script>