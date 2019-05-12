<?php
/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Destroys the user's session 
 *              when the user signs out.
 * Date Created: April 20th, 2019
 * Last Modified: April 25th, 2019
 * Recent Changes: Added Comments, removed
 *                 unnecessary code blocks
 */
session_start();
unset($_SESSION['username']);
$_SESSION = [];
session_destroy();

header('Location: index.php');
