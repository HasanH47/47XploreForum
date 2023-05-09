<?php 
use App\Models\Setting;
$settings = Setting::first();
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '47XploreForum') }}</title>

    <!-- Load file CSS Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Load Fonts Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- Load file CSS Toastr -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<!-- Load file CSS custom -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<!-- Load file JavaScript jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Load file JavaScript Bootstrap -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<!-- Load file JavaScript Toastr -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	
	<!-- Load file JavaScript custom -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
    	<script src="{{asset('js/app.js')}}" defer></script>

</head>

<body>
    <div class="container-fluid">
      <!-- First section -->
      <nav class="navbar navbar-dark bg-dark">
        <div class="container">
          <h1>
            @if ($settings->forum_name)
            <a href="/" class="navbar-brand">{{$settings->forum_name}}</a>
              @else
            <a href="/" class="navbar-brand">Dev Forum</a>
            @endif
          </h1>
          <form action="{{route('category.search')}}" method="POST" class="form-inline mr-3 mb-2 mb-sm-0">
            @csrf
            <input type="text" class="form-control" name="keyword" placeholder="search" />
            <button type="submit" class="btn btn-success">Search Forum</button>
          </form>
          @guest
          <a class="nav-item nav-link text-white btn btn-dark" href="{{route('login')}}">Login</a>
          <a class="nav-item nav-link text-white btn btn-dark" href="{{route('register')}}">Register</a>
          @endguest
            @auth
              <form id="logout-form" action="{{route('logout')}}" method="POST">
              @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
            @endauth
          </a>
        </div>
      </nav>

      <!-- first section end -->
    </div>
    <div class="container">
      <nav class="breadcrumb" style="background-color: #e9ecef; padding: 8px 15px;">
        @if (optional(auth()->user())->is_admin)
    <a href="/dashboard/home" class="breadcrumb-item active">Dashboard</a>
@else
    <a href="/home" class="breadcrumb-item active">Dashboard</a>
@endif
      </nav>
      
      @yield('content')
                        {{-- <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div> --}}
    <div class="container-fluid">
      <footer class="small bg-dark text-white">
        <div class="container py-4">
          <ul class="list-inline mb-0 text-center">
            <li class="list-inline-item">
              &copy; 2021 Simon's tech school forum
            </li>
            <li class="list-inline-item">All rights reserved</li>
            <li class="list-inline-item">Terms and privacy policy</li>
          </ul>
        </div>
      </footer>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
{{-- <script src="jquery.js"></script>
<script src="toastr.js"></script> --}}
{{-- @toastr_render --}}
</html>
