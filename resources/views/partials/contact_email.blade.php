<!DOCTYPE html>
<head>
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <title> "Contact email" </title>
</head>
<div class="container">
    <div id="contactUsform">
        {{ csrf_field() }}
          <table align="center" cellspacing="0" cellpadding="0" border="0" width="500"  style="margin: 0 auto;padding-top:50px;padding-bottom:50px;" >
              <p style="font-size: 22px; text-align:center;"><strong>Feedback on IAmIn</strong></p>
              <div style="background-color: #ffffff;">
                  <table cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                          <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                              <h1 style="margin: 0 0 10px; font-size: 25px;color: #333333; font-weight: normal;">Message from  <?php echo $name ?></h1>
                              <p style="margin: 0 0 10px;"><?php echo $email ?> | <?php echo $phonenumber ?></p>
                              <p style="margin: 0 0 10px;"><?php echo $comment?></p>
                          </td>
                      </tr>
                    <!--  <tr>
                          <td style="padding: 0 20px 20px;">
                             <a href="https://google.com/" style="background: #222222; border: 1px solid #000000; font-family: sans-serif; font-size: 18px; padding: 13px 17px; display: block; border-radius: 4px;">Reset Password</a>
                          </td>
                      </tr>-->

                  </table>
              </div>

          </table>

        </div>
    </div>
</div>
