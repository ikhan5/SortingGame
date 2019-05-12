<?php
session_start(); 
include("header.php");

echo '<div id="background" alt="Photo by Aditya Vyas on Unsplash"></div>';
if(!isset($_SESSION['username']))
{
    include("login.php");
}else{
    include("game.php");
    
}
include("footer.php");
