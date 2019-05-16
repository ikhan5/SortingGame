<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Main page for the Sorting Game website. The index page
 *              acts somewhat as a controller, as based on whether the user is
 *              logged in, the user is directed to the appropriate page. 
 * Date Created: April 20th, 2019
 * Last Modified: April 25th, 2019
 * Recent Changes: Added comments
 */
session_start();
include("header.php");

echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
if (!isset($_SESSION['username'])) {
    include("login.php");
} else {
    include("game.php");
}
include("footer.php");
