<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for all the user's high scores they've accumulated. The 
 *              scores are displayed in descending order (highest score first)
 *              and the first thress scores are highlighted. Pagination based on the number
 *              of scores in the database and desired results per page.
 * Date Created: May 12th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Added comments
 */
session_start();
include("header.php");
?>
<h1 class="display-5 text-light mt-2 text-center">Tutorial</h1>
<h2 class="tut_question display-5 text-light mt-2 text-center">Order the following characters in alphabetical order:</h2>
<div class="container">
    <ul id="tut_options" class="list-group">
        <li class="tut_option list-group-item-dark p-2 my-2">Jon Snow</li>
        <li class="tut_option list-group-item-dark p-2 my-2">Arya Stark</li>
        <li class="tut_option list-group-item-dark p-2 my-2">Sansa Stark</li>
        <li class="tut_option list-group-item-dark p-2 my-2">Daenerys targaryen</li>
        <li class="tut_option list-group-item-dark p-2 my-2">Tyrion Lannister</li>
    </ul>
</div>
</div>



<?php
include("footer.php");
?>