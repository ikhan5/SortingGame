<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Gets the users score based on the 
 *              current user's email. 
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
$u = new UserDB();
$score = $u->getHighScore($username);

echo $score['score'];
