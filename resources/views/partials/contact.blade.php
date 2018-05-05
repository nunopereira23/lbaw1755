<div class="container">
    <link href="{{ asset('css/contact.css') }}" rel="stylesheet">
    {{--class="form-horizontal" role="form" method="POST" action="{{ route('contact_us') }}">--}}
    <form id="contactUsform">
        {{ csrf_field() }}
        <div class="container">
            <h2>Contact us</h2>
            <p>Please fill in this form.</p>
            <hr>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter your name" name="name" id="name">

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter your email" name="email" id="email" required>

            <label for="phoneNumber"><b>Password confirmation</b></label>
            <input type="text" name="phoneNumber" id="phoneNumber" placeholder="Enter your phone number">

            <label for="comment"><b>Comment</b></label>
            <textarea class="form-control" placeholder="You can leave us a comment" rows="5" id="comment"></textarea>

            <div class="clearfix">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>