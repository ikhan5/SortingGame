<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for activating the user's account
 *              this page checks to see whether or not the user
 *              has activated their account, if they have, then 
 *              they are redirected to the game page, otherwise they
 *              are given a input field to enter their activation code
 *              sent to them via email. 
 * Date Created: May 14th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Made Activation code simpler
 */
session_start();
require_once 'model/Database.php';
require_once 'model/scores_db.php';
require_once 'model/users_db.php';
include("header.php");

$u = new UserDB();
$username = $_SESSION['username'];
$activated = $u->checkActivation($username);
$access_code = $u->getAccessCode($username);
$email = $u->getUserEmail($username);

$code_errors = '';
if (isset($_POST['activation_code'])) {
    $confirm_user = $access_code == $_POST['activation_code'];
    if ($confirm_user) {
        $u->activateAccount($username);
        header("Location: index.php");
    } else {
        $code_errors = "Invalid Code, please try again.";
    }
}
if ($activated) {
    header("Location: index.php");
}

echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
?>
<div class="container-fluid bg-light mx-auto mx-0 mt-5 w-50">
    <div class="jumbotron">
        <h1 class="display-4">Email Activation</h1>
        <p class="text-danger"><strong><?= $code_errors ?></strong></p>
        <p class="lead">Please check your email and enter your activation code. Email may take 1-2 minutes.</p>
        <form action="activate.php" method="POST">
            <input maxLength='6' class="p-1" type="text" name="activation_code" />
            <button class="btn btn-info" type="submit" name="submit">OK</button>
        </form>
    </div>
</div>

<?php
include("footer.php");
?>