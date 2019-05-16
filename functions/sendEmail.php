<?php
require_once('model/Database.php');
require_once 'model/scores_db.php';
require_once 'model/users_db.php';
/* Author: Imzan Khan
 * Feature: Notifications
 * Description: Sets up the email settings for the validation
 *              feature          
 * Date Created: May 13th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Access code changed to be more simple
 */
session_start();
$u = new UserDB();
$username = $_SESSION['username'];
$access = $u->getAccessCode($username);
$email = $u->getUserEmail($username);
$user_code = $access;

date_default_timezone_set('America/Toronto');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

function format($input)
{
    $formatted = trim($input);
    $formatted = stripslashes($input);
    $formatted = htmlspecialchars($input);
    return $formatted;
}

$output = '';
$email = $email;
$username = $username;
$subject = "Sorting Game: Account Activation";
$content = "Here's your code to activate your account: $user_code";
$mail = new PHPMailer;
$mail->Host = 'a2plcpnl0588.prod.iad2.secureserver.net';
$mail->isSMTP();
$mail->Port = '587';
$mail->SMTPAuth = true;
$mail->Username = "sorting@imzankhan.ca";
$mail->Password = "*3uU([Z6AI20";
$mail->SMTPSecure = 'tls';
$mail->setFrom('sorting@imzankhan.ca', 'Sorting Game');
$mail->addAddress($email, $username);
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = "<p style='font-size:22px;'>Hello " . $username . ",<br/><br/>"
    . $content . "<br/><br/> Sincerely,<br/>Sorting Game</p>";
$mail->AltBody = '';
$result = $mail->Send();

if ($result["code"] == '400') {
    $output .= html_entity_decode($result['full_error']);
}
if ($output == '') {
    echo 'Success';
} else {
    echo $output;
}
