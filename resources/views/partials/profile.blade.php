<!DOCTYPE html>
<head>
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <title> "User profile" </title>
</head>
<div class="container">
    <h2>User Profile</h2>
    <br>
    <div class="row">
        <br>
        <div class="col">
            <?php if ($user->profile_picture_path == null) { ?>
            <img alt="User Without Picture"
                 src="{{ asset('../../images/person.png') }}"
                 id="profile-image1">
            <?php } else { ?>
            <img alt="User Picture"
                 src="{{ asset($user->profile_picture_path) }}"
                 id="profile-image">
            <?php } ?>
        </div>
        <div class="col">
            <h3><b><?php echo $user->name;?></b></h3>
            <?php if($user->id == $id_auth){ ?>
            <a href="/users/<?php echo $user->id?>/edit_profile" class="btn btn-primary a-btn-slide-text">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                <span><strong>Edit Profile</strong></span>
            </a>
            <?php } else {?>
            <button type="button" class="btn btn-primary a-btn-slide-text" data-toggle="modal" data-target=".bd-example-modal-sm2">
                <span><strong>Report user</strong></span>
            </button>
            <?php } ?>
            <hr>
            <br>
            <ul>
                <li><p><b>E-mail: </b><span class="fas fa-envelope" style="width:50px;"></span><?php echo $user->email;?></p></li>
                <?php if ($user->birthdate == null) { ?>
                <li><p><b>Date of birth: </b><span class="fas fa-birthday-cake" style="width:50px;"></span>dd.mm.yyyy</p></li>
                <?php } else { ?>
                <li><p><b>Date of birth: </b><span class="fas fa-birthday-cake" style="width:50px;"></span><?php echo date_format(new DateTime($user->birthdate), 'jS F Y') ?></p></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col"></div>
    </div>
    <?php if ($user->is_admin == false) { ?>
    <hr>
    <div class="row">
        <div class="col-sm-5 col-xs-6 tital "><h6><b>Number of warnings: </b></h6><h5><b><?php echo $user->nr_warnings;?></b></h5></div>
    </div>
    <?php } ?>
    <div class="modal fade bd-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content text-center">
                <h5 class="modal-title" id="exampleModalLabel">Tell us the reason</h5>
                <div class="modal-body">
                    <div class="list-group list-group-flush">
                        <form role="form" method="POST" action="/users/<?php echo $user->id ?>/report">
                            {{ csrf_field() }}
                            <input class="form-control" placeholder="Description" id="description" type="text" name="description">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
