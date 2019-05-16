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
require_once '../model/Database.php';
require_once '../model/scores_db.php';
require_once '../model/users_db.php';
if (!isset($_SESSION)) {
  session_start();
}
$username = $_SESSION['username'];
$score = $_POST['score'];
$s = new ScoreDB();
$score = $s->insertScore($username, $score);

