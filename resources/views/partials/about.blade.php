<link href="{{ asset('css/about.css') }}" rel="stylesheet">

<div class="container">
    <hr>
    <div class="py-3 text-center">
        <h1> ABOUT US </h1>
    </div>
    <br>
    <div class="py-3 text-center">
        <p> As our lives tend to be more and more busy, it brings the need of properly schedule our events in an organised way.
            So, it would be very helpful to have a platform that could store and present events in an interactive and user-friendly way,
            so that their users could manage and better plan future events that they want to share with other friends.
            We thought of developing this, also to give the possibility for users to search for forthcoming public events nearby to attend.
        </p>
    </div>
    <hr>
    <div class="py-3 text-center">
        <h2>AUTHORS</h2>
    </div>
    <div class="row">
        <div class="col-sm justify-content-center">
            <br>
            <img src="{{ asset('../images/about_page/lenka2.jpeg') }}">
            <p> Lenka </p>
        </div>
        <div class="col-sm justify-content-center">
            <br>
            <img src="{{ asset('../images/about_page/miska.jpeg') }}">
            <p> Michaela </p>
        </div>
        <div class="col-sm justify-content-center">
            <br>
            <img src="{{ asset('../images/about_page/nuno.jpeg') }}">
            <p> Nuno </p>
        </div>
        <div class="col-sm justify-content-center">
            <br>
            <img src="{{ asset('../images/about_page/tiago.jpeg') }}">
            <p> Tiago </p>
        </div>
    </div>
    <form method="post" action="{{ route('upload') }}">
        {{ csrf_field() }}
        <div class="col-md-6 mb-3">
            <label for="fileToUpload"><b>Event photo</b></label>
            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Create">
        </div>
    </form>
</div>