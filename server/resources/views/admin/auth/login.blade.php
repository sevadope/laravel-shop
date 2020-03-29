<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel Login</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <h1>Admin Panel</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>Login</h1>
                        <form method="post" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="email" name="email" 
                                type="text" class="form-control"
                                placeholder="Email">
                            </div>
                            <div class="input-group mb-5">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>

                            <button type="submit" class="btn btn-primary px-5">
                                Submit
                            </button>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</body>
</html>