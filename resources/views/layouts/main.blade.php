<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyBlog | My Awesome Blog {{ config('app.name', 'Laravel') }}</title>

    <link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
    <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    -->
    <script src="js/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="{{ route('company') }}">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li>
              @if (@guest) <!-- !Auth::guest()  -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
              @else
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Hi {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#"><span class="icon"><i class="fa fa-user-circle-o"></i></span> Profile</a>
                  <a class="dropdown-item" href="#"><span class="icon"><i class="fa fa-bell"></i></span> Notifications</a>
                  <a class="dropdown-item" href="#"><span class="icon"><i class="fa fa-cog"></i></span> Settings</a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="icon"><i class="fa fa-sign-out"></i></span> Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                  <div class="dropdown-divider"></div>
                </div>
              </li>
              @endif
            </ul>
          </div>
        </nav>
    </header>

    @yield('content')


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="copyright">&copy; 2019</p>
                </div>
                <div class="col-md-4">
                    <nav>
                        <ul class="social-icons">
                            <li><a href="#" class="i fa fa-facebook"></a></li>
                            <li><a href="#" class="i fa fa-twitter"></a></li>
                            <li><a href="#" class="i fa fa-google-plus"></a></li>
                            <li><a href="#" class="i fa fa-github"></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
