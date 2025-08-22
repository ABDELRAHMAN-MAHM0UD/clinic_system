<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="loginBody">

    <div class="container">
        <h3>Welcome
            <br>
            To <br>

            Our <br>

            Clinic!
        </h3>
                    <br>
            <br>
            <br>

        <div class="button-row">
            <form action="{{ route('login') }}" method="GET">
                <button type="submit">Login</button>
            </form>

            <form action="{{ route('register') }}" method="GET">
                <button type="submit">Register</button>
            </form>
        </div>
    </div>

</body>

</html>