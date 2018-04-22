<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('I am In') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        @if (Auth::check())
        <div class="container-fluid" id="navbar">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">I am In!</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="../events">EVENTS </a></li>
              <li><a href="../create_event">CREATE EVENT</a></li>
              <li><a href="../faq">FAQ</a></li>
              <li><a href="../contact">CONTACT US</a></li>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{ Auth::user()->name }} <span
                          class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{{ url('/profile') }}"> Profile </a></li>
                  <li><a href="{{ url('/logout') }}"> Logout </a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        @else
          <div class="container-fluid" id="navbar">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">I am In!</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                <li><a href="../events">EVENTS </a></li>
                <li><a href="../create_event">CREATE EVENT</a></li>
                <li><a href="../faq">FAQ</a></li>
                <li><a href="../contact">CONTACT US</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> AUTH <span
                            class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ url('register') }}"> Sign up </a></li>
                    <li><a href="{{ url('login') }}"> Sign in </a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        @endif

      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
