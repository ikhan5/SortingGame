<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="google-signin-client_id" content="395120795264-ojtqea5s9vsa1b7eaa0mno0h8h9d43do.apps.googleusercontent.com">
    <!--Online-->
    <!-- <meta name="google-signin-client_id" content="395120795264-m9cd1g2n8ugjrkt2evc95ur2r5q5r4v7.apps.googleusercontent.com"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sorting Game</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body id="body">
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Sorting Game</a></li>
                <li class="nav-item"><a href="scores.php" class="nav-link">High Scores</a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php
            //When a user is signed in, the navbar displays their email with an option to logout,
            // otherwise a link to the login form is displayed. 
            if (!(isset($_SESSION['username']))) {
                echo '<li class="nav-item"><a href="index.php">Login</a></li>';
            } else {
                echo '<li class="nav-item"><span class="text-white mr-4">Hello, ' . $_SESSION['username'] . '!</span><a href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a></li>';
            }
            ?>
        </ul>
    </nav>