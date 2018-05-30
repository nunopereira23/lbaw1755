<!DOCTYPE html>
<head>
    <link href="{{ asset('css/event.css') }}" rel="stylesheet">
    <title> "Event" </title>
</head>
<?php use Illuminate\Support\Facades\Auth;?>
<div class="container mt-3">
    <div class="col-md-12">
        <div class="row">
            <div class="card col-12">
                <?php if ($event_pictures->count() != 0) { ?>
                <?php if ($event_pictures->count() == 1) { ?>
                <img class="img-fluid event_picture" src="{{ asset($event_pictures[0]->path_value) }}" alt="Event picture">
                <?php } else { ?>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $count = 0;
                        foreach ($event_pictures as $picture) : {
                        $count++; ?>
                        <?php if ($count == 1) { ?>
                        <div class="carousel-item active">
                            <img class="d-block img-fluid event_picture" src="{{ asset($picture->path_value) }}" alt="Event picture">
                        </div>
                        <?php } else { ?>
                        <div class="carousel-item">
                            <img class="d-block img-fluid event_picture" src="{{ asset($picture->path_value) }}" alt="Event picture">
                        </div>
                        <?php } ?>
                        <?php } endforeach ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <img class="img-fluid event_picture" src="{{ asset('images/concert.jpeg') }}" alt="Event default picture">
                <?php }  ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="card-title mb-1 pb-1 font-weight-bold"><?php echo $event->title ?></h4>
                            <hr>
                            <h6><b>Visibility: </b></h6><h6><?php echo $event->event_visibility ?></h6>
                            <h6><b>Date and time: </b></h6><h6><?php echo date_format(new DateTime($event->event_start), 'g:ia \o\n l jS F Y') ?></h6>
                            <h6><b>Type: </b></h6><h6><?php echo $event->event_type ?></h6>
                            <h6><b>Description: </b></h6>
                            <p class="card-text"><?php echo $event->description ?></p>
                            <hr>
                            <div id="floating-panel">
                                <input id="address" type="hidden" value="<?php echo $event->gps ?>">
                            </div>
                            <div class="container-fluid  mb-2">
                                <div id="map" class="map rounded" style="width:100%"></div>
                            </div>
                        </div>
                        <div id="userActions" class="col-md-2">
                            <?php if ($status != 'Owner'){ ?>
                            <?php if ($status != ('')){ ?>
                              <?php if(($status != 'Going') && ($status != 'Ignoring')){ ?>
                              <button type="submit" id="acceptEvent" class="btn btn-primary m-2" style="width:100%">Accept</button>
                              <?php }else if ($status == 'Going'){ ?>
                              <button type="submit" id="acceptEvent" class="btn btn-success m-2" style="width:100%">Going</button>
                              <?php } ?>

                            <?php if(($status != 'Ignoring') && ($status != 'Going')){ ?>
                            <button type="submit" id="ignoreEvent" class="btn btn-secondary m-2" style="width:100%">Ignore</button>
                            <?php }else if ($status == 'Ignoring'){ ?>
                            <button type="submit" id="ignoreEvent" class="btn btn-danger m-2" style="width:100%">Ignoring</button>
                            <?php } ?>
                            <?php } ?>
                            <?php } else{ ?>
                            <form action="/event/<?php echo $event->id ?>/edit_event" style="margin:0">
                                <button type="submit" class="btn btn-primary m-2" style="width:100%">Edit event</button>
                            </form>
                            <button type="button" class="btn btn-danger m-2" data-toggle="modal" data-target="#cancelEventModal" style="width:100%;">Cancel Event</button>
                            <button type="button" class="btn btn-danger m-2" data-toggle="modal" data-target="#cancelInviteModal" style="width:100%;">Cancel Invite</button>
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
        <div id="eventModals">
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

            <div class="modal fade" id="cancelInviteModal" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content text-center">
                        <h5 class="modal-title">Cancel invite</h5>
                        <div class="modal-body">
                            <div class="list-group list-group-flush">
                                <a class="list-group-item list-group-item-action">
                                    <?php foreach ($invited_going as $user) {?>
                                    <div class="custom-control custom-checkbox mb-1" style="height:30px;">
                                        <input type="checkbox" class="custom-control-input" name="toCancel[]" id="customCheck<?php echo $user->id ?>" value=<?php echo $user->id ?>>
                                        <?php if ($user->profile_picture_path == null) { ?>
                                        <img class="rounded-circle float-right" src="{{ asset('../../images/person.png') }}" alt="User without picture" height="25px" width="25px">
                                        <?php } else { ?>
                                        <img class="rounded-circle float-right" src="{{ asset($user->profile_picture_path) }}" alt="User profile picture" height="25px" width="25px">
                                        <?php } ?>
                                        <label class="custom-control-label" for="customCheck<?php echo $user->id ?>" style='font-size:14px;'><?php echo $user->name ?></label>
                                    </div>
                                    <?php }?>
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="cancelInvite" class="btn btn-primary btn-xs">Send</button>
                            <button type="button" id="closeCancelInvite" class="btn btn-secondary btn-xs" data-dismiss="modal">Close</button>
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
                        <div class="modal-body" id="goingBody">
                            <div class="list-group list-group-flush">
                                <?php foreach ($going as $user) {?>
                                <a class="list-group-item list-group-item-action" href="../users/<?php echo $user->id ?>/profile" style="height:50px">
                                    <?php if ($user->profile_picture_path == null) { ?>
                                    <img class="rounded-circle float-right" src="{{ asset('../../images/person.png') }}" alt="User without picture" height="25px" width="25px">
                                    <?php } else { ?>
                                    <img class="rounded-circle float-right" src="{{ asset($user->profile_picture_path) }}" alt="User profile picture" height="25px" width="25px">
                                    <?php } ?>
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
                                        <?php if ($user->profile_picture_path == null) { ?>
                                        <img class="rounded-circle float-right" src="{{ asset('../../images/person.png') }}" alt="User without picture" height="25px" width="25px">
                                        <?php } else { ?>
                                        <img class="rounded-circle float-right" src="{{ asset($user->profile_picture_path) }}" alt="User profile picture" height="25px" width="25px">
                                        <?php } ?>
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
        </div>

        <div class="row pb-5 mt-2">
            <?php if ($status != ''){ ?>
            <div class="new_comment col-md-6 mb-5 mt-3" id="new_comment">
                <div class="form-group">
                    <h5><b>New comment:</b></h5>
                    <textarea style="resize:none;" class="form-control bg-light" minlength="1" maxlength="150" rows="5" id="commentContent" placeholder=""></textarea>
                    <button type="button" class="btn btn-sm m-2 mr-2">Add poll</button>
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
            <br>
            <hr>

            <div class="comments col-md-6 pull-right mt-3" id="comments">
                <h5 class="mb-2 "><b>Comments(<?php echo count(json_decode($comments)) + count(json_decode($replies)); ?>)</b></h5>
                <div class="comment mb-2 ml-2 row">
                    <?php foreach($comments as $comment){ ?>
                    <div name="comments[]" class="comment-content col-sm-11 p-2 mb-1 rounded bg-light border">
                        <div class="comment-body" id=<?php echo $comment->id ?>>
                            <p><span id="commentContent"><?php echo $comment->comment_content ?></span>
                                <br>
                                <?php if ($status != ''){ ?>
                                <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#replyCommentModal">Reply</button>
                                <?php } ?>
                                <?php if (($status == 'Owner') || (Auth::id() != null && Auth::id() == $comment->user_id)){ ?>
                                <?php if ($comment->comment_content != ' Comment deleted' ){ ?><!-- White space is intentional-->
                                <button type="button" id="updateButton" class="btn btn-primary btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#updateCommentModal">Update</button>
                                <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#deleteCommentModal">&#10060;</button>
                                <?php } ?>
                                <?php } elseif (Auth::user() != null && Auth::user()->is_admin == true && $comment->comment_content != ' Comment deleted') {?>
                                <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#deleteCommentModal">&#10060;</button>
                                <?php } ?>
                                <br>
                            </p>
                        </div>
                        <p class="text-right">
                        <?php if ($comment->comment_content != ' Comment deleted' ){ ?>
                            <?php if ($comment->profile_picture_path == null) { ?>
                            <img class="rounded-circle float-right" src="{{ asset('../../images/person.png') }}" alt="User without picture" height="25px" width="25px">
                            <?php } else { ?>
                            <img class="rounded-circle float-right" src="{{ asset($comment->profile_picture_path) }}" alt="User profile picture" height="25px" width="25px">
                            <?php } ?>
                            <a href="../users/<?php echo $comment->user_id ?>/profile"><?php echo $comment->name ?></a>
                            <?php } else { ?>
                            User
                            <?php }?>
                        </p>
                        <div class="mb-1 text-muted text-right"><?php echo $comment->date;  echo " | Nr: "?><span id="comment_id"> <?php echo $comment->id . " " ?></span></div>
                    </div>

                    <?php foreach($replies as $reply){ ?>
                    <?php if($reply->replyto == $comment->id ){?>
                    <div name="replies[]" class="comment-content col-sm-11 p-2 mb-1 ml-1">
                        <div class="comment-content col-sm-11 p-2 rounded bg-light border">
                            <div class="comment-body" id=<?php echo $comment->id ?>><!-- so the reply is made to the aprent comment -->
                                <p><span id="commentContent"><?php echo $reply->comment_content ?></span>
                                    <br>
                                    <?php if ($status != ''){ ?>
                                    <button type="button" id="replyButton" class="btn btn-sm float-left mt-5" data-toggle="modal" data-target="#replyCommentModal">&#8618;</button>
                                    <?php } ?>
                                    <?php if (($status == 'Owner') || (Auth::id() != null && Auth::id() == $reply->user_id)) { ?>
                                    <?php if ($reply->comment_content != ' Comment deleted' ){ ?><!-- White space is intentional-->
                                    <button type="button" id="updateButton" class="btn btn-primary btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#updateCommentModal">&#9997;</button>
                                    <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#deleteCommentModal">&#10060;</button>
                                    <?php } ?>
                                    <?php }  elseif (Auth::user() != null && Auth::user()->is_admin == true && $reply->comment_content != ' Comment deleted') {?>
                                    <button type="button" id="deleteButton" class="btn btn-danger btn-sm float-left mt-5 ml-1 text-center" data-toggle="modal" data-target="#deleteCommentModal">&#10060;</button>
                                    <?php } ?>
                                    <br>
                                </p>
                            </div>
                            <p class="text-right">
                            <?php if ($reply->comment_content != ' Comment deleted' ){ ?>
                                <?php if ($reply->profile_picture_path == null) { ?>
                                <img class="rounded-circle float-right" src="{{ asset('../../images/person.png') }}" alt="User without picture" height="25px" width="25px">
                                <?php } else { ?>
                                <img class="rounded-circle float-right" src="{{ asset($comment->profile_picture_path) }}" alt="User profile picture" height="25px" width="25px">
                                <?php } ?>
                                <a href="../users/<?php echo $reply->user_id ?>/profile"><?php echo $reply->name ?></a>
                                <?php } else { ?>
                                User
                                <?php }?>
                            </p>
                            <div class="mb-1 text-muted text-right"><?php echo $reply->date;  echo " | Nr: "?><span id="comment_id"> <?php echo $reply->id . " " ?></span></div>
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

            <div class="modal" id="updateCommentModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <p hidden id="updateCommentId"></p>
                        <div class="modal-header">
                            <h5 class="modal-title">Update comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea class="form-control" rows="6" maxlength="100" id="update_reply"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="updateComment" class="btn btn-primary">Send</button>
                            <button type="button" id="closeCommentUpdate" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

        <div class="modal fade bd-example-modal-sm4" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <input type="file" single>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Add</button>
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

<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script type="text/javascript">

    $(document).on("click", "#acceptEvent", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'AcceptEvent',
                event_id: <?php echo $event->id ?> },
            dataType: 'JSON',
            success: function (data) {

                //if((data == "AcceptSuccess") || (data == "UnacceptSuccess"))
                $("#userActions").load(location.href + " #userActions>*", "");
                $("#goingBody").load(location.href + " #goingBody>*", "");

                //alert(data);
            }
        });
    });

    $(document).on("click", "#ignoreEvent", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'IgnoreEvent',
                event_id: <?php echo $event->id ?> },
            dataType: 'JSON',
            success: function (data) {
                //if((data == "AcceptSuccess") || (data == "UnacceptSuccess"))
                $("#userActions").load(location.href + " #userActions>*", "");
                //alert(data);
            }
        });
    });

    $(document).on("click", "#shareEvent", function () {

        var invited = [];
        $('input[name="invited[]"]:checked').each(function () {
            invited.push(this.value);
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'ShareEvent',
                event_id: <?php echo $event->id ?>,
                invited: invited
            },
            dataType: 'JSON',
            success: function (data) {
                var inviteStatus = data;
                $("#shareEventModal").load(location.href + " #shareEventModal>*", "");
                $("#closeShareEvent").click();
                $("#modalInviteBody").empty();
                if (data == "Invited") {
                    $("#modalInviteBody").append("User(s) invited successfuly.");
                } else if (data == "noInvite") {
                    $("#modalInviteBody").append("No one invited.");
                }
                $("#inviteSuccess").modal('toggle');
                $("#cancelInviteModal").load(location.href + " #cancelInviteModal>*", "");
            }
        });
    });


    $(document).on("click", "#submitComment", function () {

        var commentContent = $("#commentContent").val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'SubmitComment',
                event_id: <?php echo $event->id ?>,
                comment_content: commentContent,
                replyto: 0
            },
            dataType: 'JSON',
            success: function (data) {

                $("#submitComment").attr("disabled", true);
                setTimeout(function () {
                    $("#submitComment").attr("disabled", false);
                }, 1500);

                if (data == "newComment") {
                    $("#newCommentSuccess").show();
                    setTimeout(function () {
                        $("#newCommentSuccess").fadeOut(500);
                    }, 1000);
                } else {
                    $("#newCommentFailure").show();
                    setTimeout(function () {
                        $("#newCommentfailure").fadeOut(500);
                    }, 1000);

                }

                $("#comments").load(location.href + " #comments>*", "");
                $("#commentContent").val('');

            }
        });
    });

    $(document).ready(function () {
        $("#comments").load(location.href + " #comments>*", "");
        $("#commentContent").val('');
    });
    $(document).ready(function () {

        var i = 0;
        var j = 0;
        if ($('div[name="comments[]"]').length > 1) {
            $('div[name="comments[]"]').each(function () {
                if (i > 0)
                    $(this).hide();

                i++
            });

            $('div[name="replies[]"]').each(function () {
                if (j > 0)
                    $(this).hide();

                j++
            });


            if (i > 0) {
                $("#comments").append('<button id="moreComments" type="button" class="btn btn-primary ml-2 mr-2" style="width:98%;height:35px;">Load more comments</button>');

            }
        } else {

        }

    });

    $(document).on("click", "#moreComments", function () {
        var i = 0;
        var j = 0;
        $('div[name="comments[]"]').each(function () {
            if (i > 0)
                $(this).fadeIn(250);

            i++
        });

        $('div[name="replies[]"]').each(function () {
            if (j > 0)
                $(this).fadeIn(250);

            j++
        });

        $("#moreComments").hide();


    });

    /*Fill the toreply field*/
    $(document).on("click", "#replyButton", function () {
        $("#replyButtonId").text($(this).closest("div").attr("id"));
    });


    $(document).on("click", "#submitCommentReply", function () {

        var commentContent = $("#new_reply").val();
        var replyto = $("#replyButtonId").text();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'SubmitComment',
                event_id: <?php echo $event->id ?>,
                comment_content: commentContent,
                replyto: replyto
            },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentReply").click();
                $("#new_reply").val('');
                $("#comments").load(location.href + " #comments>*", "");

            }
        });
    });


    /*Fill the toreply field*/
    $(document).on("click", "#updateButton", function () {
        $("#updateCommentId").text($(this).parent().parent().parent().find('span#comment_id').text());
        $("#update_reply").text($(this).siblings('#commentContent').text());
    });

    $(document).on("click", "#updateComment", function () {


        var comment_id = $("#updateCommentId").text();
        var comment_content = $("#update_reply").val();


        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'UpdateComment',
                event_id: <?php echo $event->id ?>,
                comment_id: comment_id,
                comment_content: comment_content
            },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentUpdate").click();
                $("#comments").load(location.href + " #comments>*", "");
                $("#updateCommentModal").load(location.href + " #updateCommentModal>*", "");
                $("#modalInviteBody").empty();
                if (data == "noUpdate") {
                    $("#modalInviteBody").append("No update(s) made.");
                } else if (data == "commentUpdated") {
                    $("#modalInviteBody").append("Comment updated sucessfuly.");
                }
                $("#inviteSuccess").modal('toggle');
            }
        });
    });

    /*Fill the toreply field*/
    $(document).on("click", "#deleteButton", function () {
        $("#deleteCommentId").text($(this).parent().parent().parent().find('span#comment_id').text());
    });


    $(document).on("click", "#submitCommentDelete", function () {


        var comment_id = $("#deleteCommentId").text();


        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'DeleteComment',
                event_id: <?php echo $event->id ?>,
                comment_id: comment_id
            },
            dataType: 'JSON',
            success: function (data) {
                $("#closeCommentDelete").click();
                $("#comments").load(location.href + " #comments>*", "");

            }
        });
    });


    $(document).on("click", "#cancelInvite", function () {

        var toCancel = [];
        $('input[name="toCancel[]"]:checked').each(function () {
            toCancel.push(this.value);
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/event/<?php echo $event->id ?>',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                type: 'CancelInvite',
                event_id: <?php echo $event->id ?>,
                toCancel: toCancel
            },
            dataType: 'JSON',
            success: function (data) {
                var inviteStatus = data;
                $("#cancelInviteModal").load(location.href + " #cancelInviteModal>*", "");
                $("#closeCancelInvite").click();
                $("#modalInviteBody").empty();
                if (data == "inviteCanceled") {
                    $("#modalInviteBody").append("User(s) invites canceled.");
                } else if (data == "noCancel") {
                    $("#modalInviteBody").append("No invites were canceled.");
                }
                $("#inviteSuccess").modal('toggle');
                $("#shareEventModal").load(location.href + " #shareEventModal>*", "");

            }
        });
    });

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
