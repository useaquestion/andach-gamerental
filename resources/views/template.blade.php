<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('APP_GOOGLE_ANALYTICS_TRACKING_ID') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ env('APP_GOOGLE_ANALYTICS_TRACKING_ID') }}');

      @if (Auth::check())
      gtag('set', {'user_id': '{{ Auth::id() }}'});
      @endif

      @yield('google-analytics')
    </script>

    <!--JSON-LD Microdata-->
    @yield('microdata')

    <!--Favicon Information-->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description', 'Andach Games, Video Game Rentals for Xbox One, 360, PS3, PS4 Gaming. Rent unlimited games for only &pound;9.99 per month!')">
    <meta name="author" content="">
    <meta name="p:domain_verify" content="99c61c01911c03b4928a9b63f479c92a"/>

    <title>@yield('title', 'Andach Video Game Rentals - Xbox One and 360, PS3, PS4 and Wii')</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.min.css" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">

    <!-- Custom styles for this template -->
    <link href="/css/app.css" rel="stylesheet">

    <link rel="canonical" href="{{ url()->current() }}" />

    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:title" content="@yield('title', 'Andach Video Game Rentals - Xbox One and 360, PS3, PS4 and Wii')"/>
    <meta property="og:site_name" content="Andach Video Game Rentals"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="@yield('meta-description', 'Andach Games, Video Game Rentals for Xbox One, 360, PS3, PS4 Gaming. Rent unlimited games for only &pound;9.99 per month!')" />
    <meta property="og:image" content="@yield('image', '')" />

    <meta property="twitter:card" content="product" />
    <meta property="twitter:description" content="@yield('meta-description', 'Andach Games, Video Game Rentals for Xbox One, 360, PS3, PS4 Gaming. Rent unlimited games for only &pound;9.99 per month!')" />
    <meta property="twitter:title" content="@yield('title', 'Andach Video Game Games - Xbox One and 360, PS3, PS4 and Wii')"/>
    <meta property="twitter:url" content="{{ url()->current() }}"/>
    <meta property="twitter:image" content="@yield('image', '')" />

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    <script>
    window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#000"
        },
        "button": {
          "background": "#f1d600"
        }
      },
      "theme": "classic",
      "position": "bottom-right"
    })});
    </script>

  </head>

  <body>

      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <div>
              <a href="/"><img src="/images/template/andach-rental-logo.png" alt="Andach Header Logo" /></a>
          </div>
          <div id="navbar-title">
            <a class="navbar-brand" href="/">Andach Game Rentals</a><br />
            <h1>@yield('h1', 'Xbox and Playstation game rentals!')</h1>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('plan.index') }}">Game Rental Plans</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/about-us">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/contact">Contact</a>
              </li>
              @if (Auth::check())
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('log-out') }}">Log Out</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('user.account') }}">My Account</a>
                </li>
                @if (Auth::user()->isAdmin())
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.admin') }}">Admin</a>
                  </li>
                @endif
              @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">Log In</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
              @endif
              
            </ul>
          </div>
        </div>
      </nav>

    <!-- Game Rental Menu -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #DBA800;">
      <div class="container">
        <div id="navbar-title">
          Rent
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdownGames" aria-controls="navbarNavDropdownGames" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdownGames">
          <ul class="navbar-nav ml-auto navbar-gamebar">
            @foreach ($gamemenu as $system)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{ route('game.search', ['system_id' => $system->url]) }}" id="navbarDropdownMenuLink-{{ $system->url }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ $system->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-{{ $system->url }}">
                  <a class="dropdown-item" href="{{ route('game.search', ['system_id' => $system->url]) }}">All Games</a>
                  <div class="dropdown-divider"></div>
                    @foreach ($gamegenres as $genre)
                    <a class="dropdown-item" href="{{ route('game.search', ['system_id' =>  $system->url, 'genre_id' => $genre->slug]) }}">{{ $genre->name }}</a> 
                    @endforeach
                </div>
              </li>
            @endforeach
          </ul>
        </div>

        <form action="/search-games" method="get">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
          </div>
          <input type="text" name="name" class="form-control" placeholder="Search for a Game" />
        </div>
        </form>
      </div>
    </nav>

    <!-- Products Menu -->
    <!--
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #db3a34">
      <div class="container">
        <div id="navbar-title">
          Buy
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdownProducts" aria-controls="navbarNavDropdownProducts" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdownProducts">
          <ul class="navbar-nav ml-auto navbar-gamebar">
             @foreach ($productCategories as $prodCat)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{ route('product.showcategory', $prodCat['slug']) }}" id="navbarDropdownMenuLink-{{ $prodCat['slug'] }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ $prodCat['name'] }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-{{ $prodCat['slug'] }}">
                  <a class="dropdown-item" href="{{ route('product.showcategory', $prodCat['slug']) }}">All Products</a>
                  <div class="dropdown-divider"></div>
                    @foreach ($prodCat['child'] as $childProdCat)
                    <a class="dropdown-item" href="{{ route('product.showcategory', $childProdCat['slug']) }}">{{ $childProdCat['name'] }}</a> 
                    @endforeach
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </nav>
    -->

    <div class="container" style="background-color: #e9ecef">
      @yield('breadcrumbs')
    </div>

    @if (Session::has('success'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-success"><b>Success:</b> {!! Session::get('success') !!}</div>
        </div>
      </div>
    </div>
    @endif

    @if (Session::has('info'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-info"><b>Info:</b> {!! Session::get('info') !!}</div>
        </div>
      </div>
    </div>
    @endif

    @if (Session::has('danger'))
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="alert alert-danger"><b>Error:</b> {!! Session::get('danger') !!}</div>
        </div>
      </div>
    </div>
    @endif

    @if (isset($errors))
      @if ($errors->any())
      <div class="container" id="errorscontainer">
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif
    @endif

    <!-- Page Content -->
    <div class="container" id="contentcontainer">
      @yield('content')
    </div>

    <!-- Footer -->
    @include('footer')

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--If we use the CDN version rather than the self-hosted it doesn't work. Yay programming!-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.5/esm/popper.min.js"></script>-->
    <script src="/js/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js"></script>

    @yield('javascript')

  </body>

</html>
