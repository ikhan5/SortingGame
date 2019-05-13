<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Interface for User to Sign In
 * Date Created: April 20th, 2019
 * Last Modified: mAY 12th, 2019
 * Recent Changes: Added manual Login and Registration
 */
require_once('./model/Database.php');
require_once('./model/users_db.php');
$log_errors = $reg_errors = $reg_success = $reg_username = $username = '';

if (isset($_POST['login'])) {
    $username =  $_POST['username'];
    $password =  $_POST['password'];

    if (empty($username) || empty($password)) {
        $log_errors = "Please enter all fields.";
    } else {
        $u = new UserDB();
        $users = $u->getAllUsers();
        foreach ($users as $user) {
            $user_test = $user->username == $username;
            $pass_test = password_verify($password, $user->password_hash);
            if ($user_test && $pass_test) {
                $_SESSION['username'] = $username;
                header("location: index.php");
            } else {
                $log_errors = "Invalid Username or Password";
            }
        }
    }
}

if (isset($_POST['register'])) {
    $reg_username = trim($_POST['reg_username']);
    $reg_password = trim($_POST['reg_password']);
    $confirm = trim($_POST['confirm']);

    if ($_POST['reg_password'] != $_POST['confirm']) {
        $reg_errors = "Passwords Must Match";
    } elseif (empty($reg_username) || empty($reg_password) || empty($confirm)) {
        $reg_errors = "Please enter all fields.";
    } else {
        $u = new UserDB();
        $username_avail = $u->checkUsername($reg_username);
        if ($username_avail) {
            $reg_errors = "Username Exists";
        } else {
            $$reg_success = "Registration Successful!";
            $password_hash = password_hash($reg_password, 1);
            $u = new UserDB();
            $user = $u->insertUser($reg_username, $password_hash);
        }
    }
}

?>
<div id="login_container" class="container-fluid mx-auto mx-0 mt-3">
    <h1 class="welcome text-light mt-1 text-center">Welcome to the Sorting Game: <p class="my-4" id="version">
            Game of
            Thrones Version
        </p>
    </h1>
    <div class="row">
        <div class='col-sm-6 mt-2'>
            <p class="error-field text-danger"><strong><?= $log_errors ?></strong> </p>
            <div class="border-bottom mb-3 w-75">
                <h2 class="text-light">Sign In</h2>
            </div>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label class="mr-1 text-light" for="username">Username: </label>
                    <div class="col-sm-10">
                        <input placeholder="Enter your username here..." value="<?= htmlspecialchars($username) ?>" class="form-control" type="text" id="username" name="username" required />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="text-light" for="password">Password: </label>
                    <div class="col-sm-10">
                        <input placeholder="Enter your password here..." class="form-control" type="password" id="password" name="password" required />
                    </div>
                </div>
                <div class="form-group row ml-3">
                    <button class="btn btn-primary" type="submit" id="login" name="login">Log In</button>
                </div>
            </form>
        </div>
        <div class='col-sm-6 mt-2'>
            <p class="error-field text-danger"> <strong><?= $reg_errors ?> </strong> </p>
            <p class="error-field text-success"> <strong><?= $reg_success ?> </strong> </p>
            <div class="border-bottom mb-3 w-75">
                <h2 class="text-light">Register</h2>
            </div>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label class="mr-1 text-light" for="reg_username">Username: </label>
                    <div class="col-sm-10">
                        <input placeholder="Usernames must be at least 6 characters long" minlength="6" maxlength="20" size="20" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,20}$" value="<?= htmlspecialchars($reg_username) ?>" class="form-control" type="text" id="reg_username" name="reg_username" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="mr-1 text-light" for="reg_password">Password: </label>
                    <div class="col-sm-10">
                        <input placeholder="Passwords must be at least 6 characters long" minlength="6" class="form-control" type="password" id="reg_password" name="reg_password" required />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="mr-1 text-light" for="confirm">Confirm Password: </label>
                    <div class="col-sm-10">
                        <input placeholder="Confirm your password here..." minlength="6" class="form-control" type="password" id="confirm" name="confirm" required />
                    </div>
                </div>
                <button class="btn btn-primary ml-3" type="submit" id="register" name="register">Register</button>
            </form>
        </div>
    </div>
</div>