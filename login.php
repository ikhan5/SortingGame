<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Interface for User to Sign In and/or Register.
 *              On successful registration, an access code is generated 
 *              and inserted into the database to be compared for account
 *              activated. When the User logs in, the email is sent to the 
 *              user with the access code.
 * Date Created: April 20th, 2019
 * Last Modified: May 12th, 2019
 * Recent Changes: Added manual Login and Registration
 */
require_once('./model/Database.php');
require_once 'model/scores_db.php';
require_once 'model/users_db.php';

$log_errors = $reg_errors = $reg_success = $reg_username = $username = $email = '';
if (isset($_POST['login'])) {
    $username =  filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    if (empty($username) || empty($password)) {
        $log_errors = "Please enter all fields.";
    } else {
        $u = new UserDB();
        $users = $u->getAllUsers();
        foreach ($users as $user) {

            $user_test = $user->username == $username;
            $email_test = $user->email == $username;
            $pass_test = password_verify($password, $user->password_hash);

            if (($user_test && $pass_test) || ($email_test && $pass_test)) {
                $_SESSION['username'] = $u->getUsername($username);
                $activated = $u->checkActivation($username);
                if (!$activated) {
                    include('./functions/sendEmail.php');
                    header("Location: activate.php");
                } else {
                    header("location: index.php");
                }
            } else {
                $log_errors = "Invalid Username or Password";
            }
        }
    }
}

if (isset($_POST['register'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $reg_username = filter_input(INPUT_POST, 'reg_username');
    $reg_password = filter_input(INPUT_POST, 'reg_password');
    $confirm = filter_input(INPUT_POST, 'confirm');

    if ($reg_password != $confirm) {
        $reg_errors = "Passwords Must Match";
    } elseif (empty($reg_username) || empty($reg_password) || empty($confirm) || empty($email)) {
        $reg_errors = "Please enter all fields.";
    } else {
        $u = new UserDB();
        $username_avail = $u->checkUsername($reg_username);
        $email_avail = $u->checkEmail($email);
        if ($username_avail && $email_avail) {
            $reg_errors = "Both Email and Username already Exists";
        } elseif ($email_avail) {
            $reg_errors = "Email already Exists";
        } elseif ($username_avail) {
            $reg_errors = "Username already Exists";
        } else {
            $access_code = sprintf("%06d", mt_rand(1, 999999));
            $reg_success = "Registration Successful! You may now login";
            $password_hash = password_hash($reg_password, 1);
            $u = new UserDB();
            $user = $u->insertUser($reg_username, $password_hash, $email, $access_code);
        }
    }
}
?>

<div id="login_container" class="container-fluid mx-auto mx-0 mt-3">
    <h1 class="welcome text-light mt-1 text-center">Welcome to the Sorting Game: <p class="mt-2" id="version">
            Game of
            Thrones Version
        </p>
    </h1>
    <div class="row">
        <div class='col-sm-6 mt-2'>
            <p class="error-field text-danger"><strong><?= $log_errors ?></strong> </p>
            <div class="border-bottom mb-3">
                <h2 class="text-light">Sign In</h2>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label class="text-light col-form-label" for="username">Username or Email: </label>
                    <div class="col">
                        <input placeholder="Enter your username or email here..." value="<?= htmlspecialchars($username) ?>" class="form-control" type="text" id="username" name="username" required />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="text-light col-form-label" for="password">Password: </label>
                    <div class="col">
                        <input placeholder="Enter your password here..." class="form-control" type="password" id="password" name="password" required />
                    </div>
                </div>
                <div class="form-group ml-3">
                    <button class="btn btn-primary px-3" type="submit" id="login" name="login">Log In</button>
                </div>
            </form>
        </div>
        <div class='col-sm-6 mt-2'>
            <p class="error-field text-danger"> <strong><?= $reg_errors ?> </strong> </p>
            <p class="error-field text-success"> <strong><?= $reg_success ?> </strong> </p>
            <div class="border-bottom mb-3">
                <h2 class="text-light">Register</h2>
            </div>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label class="text-light col-form-label" for="email">Email: </label>
                    <div class="col">
                        <input placeholder="Enter your email here..." value="<?= htmlspecialchars($email) ?>" class="form-control" type="email" id="email" name="email" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-light col-form-label" for="reg_username">Username: </label>
                    <div class="col">
                        <input placeholder="Usernames must be at least 4 characters long" size="20" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" value="<?= htmlspecialchars($reg_username) ?>" class="form-control" type="text" id="reg_username" name="reg_username" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-light col-form-label" for="reg_password">Password: </label>
                    <div class="col">
                        <input placeholder="Passwords must be at least 6 characters long" minlength="6" class="form-control" type="password" id="reg_password" name="reg_password" required />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="text-light col-form-label" for="confirm">Confirm Password: </label>
                    <div class="col">
                        <input placeholder="Confirm your password here..." minlength="6" class="form-control" type="password" id="confirm" name="confirm" required />
                    </div>
                </div>
                <div class="form-group ml-3">
                    <button class="btn btn-primary px-3" type="submit" id="register" name="register">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>