<!DOCTYPE html>
<html>

<head>
    <title>Gym Mgmt Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('welcome.css') }}">
</head>

<body>
    @if (Route::has('login'))
        @auth
            <div class="login">
                <p> <a href="{{ url('/home') }}">Dashboard</a></p>
            </div>
        @else
            @if (Route::has('register'))
            @endif
            <div class="login">
                <p> <a href="{{ route('login') }}">Log in</a></p>
            </div>

        @endauth
    @endif
    <div class="container">
        <div class="title">
            <div class="name">
                <h1>{{ config('app.name') }}</h1>
            </div>
            <div class="company">
                <p>BROSS SOLUTIONS PVT. LTD.</p>
            </div>
        </div>
    </div>
</body>

</html>
