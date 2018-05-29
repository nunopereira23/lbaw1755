<div class="container">
    <div class="jumbotron">
      <?php if (!isset($error_type)){ ?>
        <div class="text-center"><i class="fa fa-5x fa-frown-o" style="color:#d9534f;"></i></div>
        <h1 class="text-center">404 Not Found<p></p>
            <p>
                <small class="text-center"> Something wrong happened</small>
            </p>
        </h1>
      <?php } else if ($error_type == 'Event_Canceled') { ?>
        <h1 class="text-center">Event canceled.<p></p>
        </h1>
      <?php } else if ($error_type == 'Event_Not_Found') { ?>
        <h1 class="text-center">Event not found.<p></p>
        </h1>
      <?php } else if ($error_type == 'Event_No_Permission') { ?>
        <h1 class="text-center">Event is private. <br>Need proper invite to acess.<p></p>
        </h1>
      <?php } else if ($error_type == 'Wrong_Confirmation_Code') { ?>
          <h1 class="text-center">Code you entered is not right. <br>Please try password reset again.<p></p>
          </h1>
      <?php } else if ($error_type == 'Email_Not_Found') { ?>
            <h1 class="text-center">This is email is not registered. <br>Please go back and try again.<p></p>
            </h1>
      <?php } else if ($error_type == 'Generate_Code') { ?>
            <h1 class="text-center">Must generate a password reset code before accessing this page.
            </h1>
      <?php } ?>
        <p class="text-center">Try pressing the back button or clicking on this button.</p>
        <p class="text-center"><a class="btn btn-primary" href="/"><i class="fa fa-home"></i> Go To Homepage</a></p>
    </div>
</div>
