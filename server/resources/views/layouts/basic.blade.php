<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Electronics Store</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('admin.categories.index') }}">Admin panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                    class="nav-link">
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                    class="nav-link">
                        Products
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                @auth

                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>          
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
	<div class="container min-vh-80">
        @include('admin.components.msg_alert')
		@yield('content')
	</div>
</body>
</html>