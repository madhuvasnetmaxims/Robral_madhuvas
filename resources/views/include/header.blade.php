<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <meta name="csrf-token" content="RrGQCPKPp1JEhVUxt9bWidxaAEmOYqd53ZDG1dD0">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
      <title>Robral</title>

      <style>
        .card {
            border-radius: 15px; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px); 
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1); 
        }

        .card-img-top {
            height: 100px; 
            object-fit: cover; 
        }

        .card-footer {
            padding: 1rem 0;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
        }

      </style>
   </head>
   <body>

<!-- Header Area -->
<header id="myHeader">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #000000;">
    <a class="navbar-brand text-white" href="{{ route('index') }}">Robral</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse m-2" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link text-white" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">About us</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Contact us
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('view.cart') }}" class="nav-link text-white" tabindex="-1" aria-disabled="true">
            <i class="fa fa-shopping-cart"></i> Cart (
              <span id="cart-count">
                @if(Session::has('login_true'))
                    {{ App\Models\Cart::where('user_id', Session::get('login_true'))->Count() }}
                @else
                    {{ Session::get('cart') ? count(Session::get('cart')) : 0 }}
                @endif
              </span>
            )
          </a>
        </li>
      </ul>

      <!-- User Login/Logout and Registration Links -->
      @if(Session::has('login_true')) 
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('logout') }}">
              Logout
            </a>
          </li>

              @if(Session::has('username'))
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome, {{ Session::get('username') }}!  </a>
              </li>
             
             
              @endif
             
        </ul>
      @else
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('login') }}" >
              Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('register') }}" >
              Register
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome, Guest!  </a>
          </li>
        </ul>
      @endif

     
      <form class="form-inline my-2 my-lg-0" action="{{ route('index') }}" method="GET">
        <input 
            class="form-control mr-sm-2" 
            type="search" 
            name="search" 
            placeholder="Search for products" 
            aria-label="Search"
            value="{{ request('search') }}" 
        >
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
    </div>
  </nav>
</header>

<!-- Close -->


