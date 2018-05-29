@extends('layouts/email')

@section('content')
    <div class="container">

        <div id="contactUsform">

              <table align="center" cellspacing="0" cellpadding="0" border="0" width="500"  style="margin: 0 auto;padding-top:50px;padding-bottom:50px;" >
                  <p style="font-size: 22px; text-align:center;"><strong>Password reset on IAmIn</strong></p>
                  <div style="background-color: #ffffff;">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%" style="text-align:center;">
                          <tr>
                              <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                  <h1 style="margin: 0 0 10px; font-size: 20px;color: #333333; font-weight: normal;">Here is your confirmation code: </h1>
                                  <p style="margin: 0 0 10px;"><?php echo $code; ?></p>
                              </td>
                          </tr>

                      </table>
                  </div>
              </table>

            </div>
        </div>
    </div>

@endsection
