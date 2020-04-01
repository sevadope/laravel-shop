<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <title>@yield('title')</title>
</head>
<body class="c-app">
   <div class="c-sidebar c-sidebar-dark c-sidebar-lg-show c-sidebar-fixed">
       <div class="c-sidebar-brand">
           <h2>Admin panel</h2>
       </div>
        <ul class="c-sidebar-nav">
            @yield('sidebar')
        </ul>
    </div>
    <div class="c-wrapper">
        <header class="c-header c-header-light bg-light px-3">
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none"
                type="button"
                data-toggle="#sidebar" data-class="c-sidebar-lg-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="c-header-nav mfs-auto">
                @yield('header-right-nav')
            </ul>

        </header>
        <div class="c-body bg-gray-200">
            <main class="c-main">
                <div class="container-fluid">
                    @include('admin.components.msg_alert')
                    @yield('content')
                </div>
            </main>
        </div>
        <footer class="c-footer">
            @yield('footer')
        </footer>
    </div>
</body>
</html>