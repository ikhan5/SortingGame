<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for all the tutorial page for users to test out the
 *              game without signing in, being timed, or having a score added.
 * Date Created: May 17th, 2019
 * Last Modified: May 20th, 2019
 * Recent Changes: Added Tutorial
 */
session_start();
include("header.php");
?>
<div id="tut_container">
    <h1 class="display-5 text-light mt-2 text-center game_header">Tutorial</h1>
    <h2 class="tut_question text-light mt-2 text-center">Order the following characters in alphabetical order by dragging the names into place:</h2>
    <div class="container">
        <ul id="tut_options" class="list-group">
            <li class="tut_option list-group-item-dark p-2 my-2">Jon Snow</li>
            <li class="tut_option list-group-item-dark p-2 my-2">Arya Stark</li>
            <li class="tut_option list-group-item-dark p-2 my-2">Sansa Stark</li>
            <li class="tut_option list-group-item-dark p-2 my-2">Daenerys Targaryen</li>
            <li class="tut_option list-group-item-dark p-2 my-2">Tyrion Lannister</li>
        </ul>
        <div class="game_options col-xs-2 text-center">
            <button id="tut_restart" class="btn btn-primary mt-2 px-5">Try Again?</button>
            <button id="tut_start" class="btn btn-danger mt-2 px-5">Ready?</button>
            <button id="tut_submit" class="btn mt-2 px-5">Submit</button>
        </div>
    </div>
    <div id="instructions">
        <div class="instruction_start text-light">
            <p class="arrow"><i class="fas fa-long-arrow-alt-up"></i></p>
            <p>Click the Ready Button to start the game!</p>
        </div>
        <div class="instruction_submit text-light ">
            <p class="arrow_submit"><i class="fas fa-long-arrow-alt-up"></i></p>
            <p>Click the Submit Button when you wish to submit your answer!</p>
        </div>
    </div>


</div>
</div>
<?php
include("footer.php");
?>