<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Sends the user email to update their
 *              score in the database.
 * Date Created: April 20th, 2019
 * Last Modified: April 25th, 2019
 * Recent Changes: Added Comments, removed
 *                 unnecessary code blocks
 */
require_once 'model/Database.php';
require_once 'model/users_db.php';
if (!isset($_SESSION)) {
  session_start();
}
$username = $_SESSION['username'];
// $score = $_POST['score'];
$u = new UserDB();
$score = $u->insertScore($username, 21);

echo $score['score'];
