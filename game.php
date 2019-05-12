<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Inserts the user email into the database.
 *              Also acts as the main index for user's who 
 *              have signed in successfully.
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

?>

<div id="game_container">
    <input id="email" type="hidden" value="<?= $email ?>">
    <p class="text-white" id="scoreDisplay">Total Score: <span id="score"></span></p>
    <div class="game_header text-center mt-3">
        <h1 id="version">Game of Thrones</h1>
        <div class="row">
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