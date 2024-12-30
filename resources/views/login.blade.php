<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Login</title>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert("{{ $errors->first() }}");
        });
    </script>
    @endif
    <style>
        .loginCard {
            font-family: 'Poppins',sans-serif;
        }

        .buttonSubmit{
            font-family: 'Poppins',sans-serif;
            font-weight: bold;
            font-size: 17px;
        }
    </style>
</head>

<body>  
    <div class="loginCard">
        <div class="logoContainer">
            <img src="{{ asset('logo3.png') }}" alt="Logo" class="logo" >
        </div>
        <div class="loginForm">
            <form action="{{route("loginPost")}}" method="POST" >
                @csrf
                <div class="loginGrid">
                    <label class="labelInput">Username</label>
                    <input type="text" class="textBoxInput" name="email"/>
                </div>
                <div class="loginGrid">
                    <label class="labelInput">Password</label>
                    <input type="password" class="textBoxInput" name="password"/>
                </div>
                <div class="loginGrid">
                    <input type="submit" class="buttonSubmit" value="LOGIN" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
