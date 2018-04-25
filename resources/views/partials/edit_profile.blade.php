<link href="{{ asset('css/edit_profile.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>User Profile</h4></div>
            <div class="panel-body">
                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                    <img alt="User Pic"
                         src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
                         id="profile-image1" class="img-circle img-responsive">
                </div>
                <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                    <form method="post" action="/users/<?php echo $user->id ?>/edit_profile">
                        {{ csrf_field() }}
                        Name: <label>
                            <input type="text" name="name" value="<?php echo $user->name;?>">
                        </label>
                        Birth Date:<label>
                            <input type="text" name="birthdate" value="<?php echo $user->birthdate;?>">
                        </label>
                        <hr>
                        <button type="submit" class="btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span><strong>Save changes</strong></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>