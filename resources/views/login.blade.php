<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class ="loginBody">

    <div class="container">
        <h3>Login</h3>
        <form>
            <div>
                <label>Phone Number</label>
                <input type="number" id="phone" placeholder="Enter your phone number">
            </div>

            <div>
                <label>Password</label>
                <input type="password" id="password" placeholder="Enter your password">
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
