<!DOCTYPE html>
<head>
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    <title> "Contact us" </title>
</head>
<div class="container">
    <form  id="contactUsform" style="margin:0" onclick="return toSend()">

        <div class="container">
            <h1>Contact us</h1>
            <p>Please fill in this form.</p>
            <hr>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter your name" name="name" id="name">

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter your email" name="email" id="email" >

            <label for="phoneNumber"><b>Phone number</b></label>
            <input type="text" placeholder="Enter your phone number" name="phoneNumber" id="phoneNumber">

            <label for="comment"><b>Comment</b></label>
            <textarea class="form-control" placeholder="You can leave us a comment" name="comment" rows="5" id="comment"></textarea>

            <div class="clearfix">
                <button type="submit" id="sendFeedback" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalSuccess" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body" style="font-size:15px;">
                    <p class="modal-title" id="modalSuccessBody"></p>
                    <br>
                    <button type="button" class="btn btn-primary btn-xs mb-0" data-dismiss="modal" style="float:right;">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

<meta name="csrf-token" content="{{ csrf_token() }}"/>


<script type="text/javascript">


  function toSend(){
    $(document).unbind().on("click", "#sendFeedback", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        var name =   $("#name").val();
        var email =   $("#email").val();
        var phonenumber =   $("#phoneNumber").val();
        var comment = $("#comment").val();

        if (name == "")
          name = "Anonymous";
          
        if (email == "")
          email = "No email provided";

        if (phonenumber == "")
          phonenumber = "No phone number provided";

        if (comment == "")
        {
          $("#modalSuccessBody").empty();
          $("#modalSuccessBody").append("You must provide a comment.");
          $("#modalSuccess").modal('toggle');
          //$("#sendFeedback").load(location.href+" #sendFeedback>*","");

        } else {

          $.ajax({
              url: '/contact/',
              type: 'POST',
              data: {
                  _token: CSRF_TOKEN,
                  name: name,
                  email: email,
                  phoneNumber:phonenumber,
                  comment:comment
                },
              dataType: 'JSON',
              success: function (data) {
                if (data == "Submited")
                {

                  var name =   $("#name").val("");
                  var email =   $("#email").val("");
                  var phonenumber =   $("#phoneNumber").val("");
                  var comment = $("#comment").val("");
                  $("#contactUsform").load(location.href+" #contactUsform>*","");

                  $("#modalSuccessBody").empty();
                  if (data == "Submited") {
                      $("#modalSuccessBody").append("Feedback sent.");
                  } else if (data == "NotSubmited") {
                      $("#modalSuccessBody").append("Feedbak error.");
                  }
                  $("#modalSuccess").modal('toggle');
                }

              }
          });
        }
    });
    return false;
  }

</script>
