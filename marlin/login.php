<?php
session_start();

include_once 'db.php';

if (!isset($_SESSION['message_login'])) {
    $_SESSION['message_login'] = [];
} else {
    $success_login = $_SESSION['message_login']['success'] ? $_SESSION['message_login']['success'] : null;
    $error_login = $_SESSION['message_login']['error'] ? $_SESSION['message_login']['error'] : null;
}

unset($_SESSION['message_login']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/php/marlin/index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="/php/marlin/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/php/marlin/register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>

                            <div class="card-body">
                                <form method="POST" action="handler_login.php">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control is-invalid " name="email"  autocomplete="email" autofocus >

                                            <?php if (isset($error_login['email_empty'])): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $error_login['email_empty']; ?></strong>
                                                </span>
                                            <?php endif ?>

                                            <?php if (isset($error_login['email_exist'])): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $error_login['email_exist']; ?></strong>
                                                </span>
                                            <?php endif ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control is-invalid" name="password"  autocomplete="current-password">

                                            <?php if (isset($error_login['password_empty'])): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $error_login['password_empty']; ?></strong>
                                                </span>
                                            <?php endif ?>

                                            <?php if (isset($error_login['invalid_password'])): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $error_login['invalid_password']; ?></strong>
                                                </span>
                                            <?php endif ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                               Login
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
