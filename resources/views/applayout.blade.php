<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Kurimi</title>
    <link rel="stylesheet" href="{{ asset('css/application.css') }}">
    <style>
      
    </style>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert("{{ $errors->first() }}");
            });
        </script>
    @endif


</head>

<body>
    <aside class="navbar-custom">
        <div class="side-item-navbar {{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ url('/') }}">Dashboard</a>
        </div>
        <div class="side-item-navbar {{ Request::routeIs('itemview') ? 'active' : '' }}">
            <a href="{{ route('itemview') }}">Item Management</a>
        </div>
        <div class="side-item-navbar {{ Request::routeIs('invoiceview') ? 'active' : '' }}">
            <a href="{{ route('invoiceview') }}">Receipt Management</a>
        </div>
        <div class="side-item-navbar">
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    </aside>
    <div class="main-content">
        @yield('content')
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
