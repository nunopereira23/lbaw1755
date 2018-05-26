<link href="{{ asset('css/profile.css') }}" rel="stylesheet">

<div class="container">
    <h2>Edit User Profile</h2>
    <br>
    <div class="row">
        <div class="col">
            <?php if ($user->profile_picture_path == null) { ?>
            <img alt="User Without Pic"
                 src="{{ asset('../../images/person.png') }}"
                 id="profile-image1">
            <?php } else { ?>
            <img alt="User Pic"
                 src="{{ asset($user->profile_picture_path) }}"
                 id="profile-image1">
            <?php } ?>
        </div>
        <div class="col">
            <form class="form-horizontal" role="form" method="POST" action="/users/<?php echo $user->id ?>/edit_profile" enctype="multipart/form-data">
                {{ csrf_field() }}
                <label for="name"><b>Name: </b></label>
                <input type="text" name="name" value="<?php echo $user->name;?>" required>
                <br>
                <label for="birthdate"><b>Date of birth: </b></label>
                <input type="date" name="birthdate" id="birthdate" value="<?php echo $user->birthdate;?>" formnovalidate>

                <label for="fileToUpload"><b>User photo</b>
                    <input type="file" class="form-control" name="image">
                </label>
                <button type="submit" class="btn btn-primary a-btn-slide-text">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    <span><strong>Save changes</strong></span>
                </button>
            </form>
        </div>
    </div>
</div>