<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DTP Motoshop') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <style>
            /* Modify brand and text color */ 
            .navbar-custom .navbar-brand, 
            .navbar-custom .navbar-text { 
                color: #FF8C00; 
            } 

            .btn-custom {
                color: #FF8C00;
                border: 2px solid #FF8C00;
            }

            /* CUSTOMIZE THE CAROUSEL  -------------------------------------------------- */
            /* Carousel base class */
            .carousel {
                margin-bottom: 1em;
            }
            /* Since positioning the image, we need to help out the caption */
            .carousel-caption {
                bottom: 10px;
                z-index: 10;
            }

            /* Declare heights because of positioning of img element */
            .carousel-item {
                height: 500px;
            }

            /* MARKETING CONTENT -------------------------------------------------- */
            /* Center align the text within the three columns below the carousel */
            .marketing .col-lg-4 {
            margin-bottom: 1rem;
            text-align: center;
            }
            .marketing h2 {
            font-weight: 400;
            }
            .marketing .col-lg-4 p {
            margin-right: .75rem;
            margin-left: .75rem;
            }

            /* Featurettes ------------------------- */
            .featurette-divider {
            margin: 2rem 0; /* Space out the Bootstrap <hr> more */
            }

            /* Thin out the marketing headings */
            .featurette-heading {
            font-weight: 300;
            line-height: 1;
            letter-spacing: -.05rem;
            }

            /* RESPONSIVE CSS -------------------------------------------------- */
            @media (min-width: 40em) {
            /* Bump up size of carousel content */
            .carousel-caption p {
                margin-bottom: 1rem;
                font-size: 1.25rem;
                line-height: 1.4;
            }

            .featurette-heading {
                font-size: 50px;
            }
            }

            @media (min-width: 62em) {
            .featurette-heading {
                margin-top: 1rem;
            }
            }

    </style>
    
</head>
<body>

<div id="nav">
    <div class="container">
    <nav class="navbar navbar-custom navbar-expand-md navbar-dark bg-dark">
        <div style="height:100px">
            <a href="/"><img src="{{ asset('public/logo.png') }}"  class="mx-auto d-block w-auto h-100" onclick=""></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <!-- Item do Menu -->
                <li class="nav-item active">
                    <a class="nav-link text-warning" href="/" style="font-weight: bold">Home <span class="sr-only"></span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-warning" href="{{ route('contato') }} " style="font-weight: bold">Contato <span class="sr-only"></span></a>
                </li>
    
                <!-- Item do Menu -->
                @php
                    $links = auth()->user() ? cache('links') : null;
                @endphp
                @isset($links)
                    @foreach ($links as $link)
                    <li class="nav-item">
                        <a class="nav-link text-warning" href={{ route($link['link']) }}> {{ ucfirst($link['name'] ) }}</a>
                    </li>
                    @endforeach
                @endisset
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
    
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    </div>

    <div class="container mt-1">
        <div class="d-flex justify-content-center">
        <ul class="nav nav-pills bg-dark">
            @php
                $types = cache('types');
                $marcas = cache('marcas');
            @endphp
            
            @isset($marcas)
            @foreach ($types as $type)
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-warning" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ strtoupper($type->name) }}</a>
                    <div class="dropdown-menu">
                        @foreach ($marcas[$type->id] as $brand)
                        <a class="dropdown-item" href="{{ '/list/'.$type->id.'/'.$brand['id'] }}">{{ $brand['name'] }}</a>
                        @endforeach 
                    </div>
                </div>
            @endforeach
            @endisset
        </ul>
        </div>
    </div>
</div>
  <main class="py-1">
        @yield('content')   
  </main>

</div>
    <!-- FOOTER -->
    <footer class="container mt-5">
        <div class="container mb-1">
            <ul class="list-group list-group-horizontal-sm justify-content-center">
                <a class="list-group-item bg-dark text-warning mr-1" href="https://goo.gl/maps/PKqNfH3JfdRTqy81A">R. João Rodrigues Pinheiro, 919 - Capão Raso, Curitiba - PR</a>
                <a class="list-group-item bg-dark text-warning mr-1" href="http://api.whatsapp.com/send?phone=554130143213">
                    <img src="{{ asset('public/whatsapp_icon.png') }}" width="28" height="28">
                    41 3014-3213
                </a>
                <a class="list-group-item bg-dark text-warning mr-1" href="https://www.instagram.com/dtpmotoshop/">
                    <img src="{{ asset('public/Instagram_icon.png') }}" width="28" height="28">
                </a>
                <a class="list-group-item bg-dark text-warning mr-1" href="https://www.facebook.com/dtomotoshop/">
                    <img src="{{ asset('public/facebook_icon.png') }}" width="28" height="28">
                </a>
                <li class="list-group-item bg-dark text-warning mr-1">dtp@dtp.com.br</li>
            </ul>
        </div>
        <p>2019-2020 Dtp Motoshop.</p>
    </footer>
</body>