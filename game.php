<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for the Sorting Game operation, this page
 *              contains: The options for the game user's will need 
 *              to sort. All game UI are displayed, such as score, 
 *              timer, and round count. At the end of round 5, the 
 *              current game is over and the user can see their 
 *              results in comparison to the leader board, as well 
 *              as their current high score.
 * Date Created: April 20th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Made Activation code simpler
 */
require_once 'model/Database.php';
require_once 'model/scores_db.php';
require_once 'model/users_db.php';

$u = new UserDB();
$s = new ScoreDB();
$username = $_SESSION['username'];
$activated = $u->checkActivation($username);
$high_score = $s->getHighScore($username);
$gs = $s->getAllHighScores(1, 1);
$global_score = $gs[0]->high_score;

if (!isset($_SESSION)) {
    session_start();
} elseif (!isset($_SESSION['username'])) {
    header("location: index.php");
} elseif (!$activated) {
    header("location: activate.php");
}
?>

<div id="game_container">
    <p class="text-white" id="scoreDisplay">Total Score: <span id="score"></span></p>
    <div class="game_header text-center mt-3">
        <h1 id="version">Game of Thrones</h1>
        <div class="row round-info">
            <p class="text-white col-md-6" id="roundDisplay">Round: <span id="round"></span> of 5</p>
            <div class="timer text-white col-md-6"></div>
        </div>
        <h2 class="question display-5 text-light mt-1">Order the following characters in alphabetical order:</h2>
    </div>
    <div class="container">
        <ul id="options" class="list-group"></ul>
        <div class="game_options col-xs-2 text-center">
            <button id="restart" class="btn btn-primary mt-2 px-5">Next Round</button>
            <button id="start" class="btn btn-danger mt-2 px-5">Ready?</button>
            <button id="submit" class="btn mt-2 px-5">Submit</button>
        </div>
    </div>
</div>

<div class="jumbotron bg-dark" id="results_container">
    <i class="close fas fa-times text-light float-right"></i>
    <h2 class="text-center text-white">Game Results:</h2>
    <div class="container-fluid game_stats">
        <p class="bg-secondary text-warning py-2 px-5">Global High Score: <span id="globalHighScoreDisplay"><?= $global_score ?></span></p>
        <p class="bg-secondary text-white py-2 px-5">Your High Score: <span id="highScoreDisplay"><?= $high_score ?></span></p>
        <p class="bg-secondary text-white py-2 px-5">Total Score: <span id="finalScoreDisplay"></span></p>
        <p class="bg-secondary text-white py-2 px-5">Average Time Per Question: <span id="averageTimeDisplay"></span></p>
    </div>
</div>