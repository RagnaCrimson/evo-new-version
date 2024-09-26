<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login_styles.css" rel="stylesheet">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="img/eet-logo.png" alt="Logo">
        </div>
        <h2 class="text-center mb-4">Login</h2>
        <form method="POST" action="login.php" aria-labelledby="login-heading">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required aria-required="true">
            </div>
            <button type="submit" class="btn btn-primary btn-block" onclick="login()">Sign in</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
