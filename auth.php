<?php
session_start(); 
// access the current session & check to see whether the user is logged in

//Use session 
if(empty($_SESSION["id"])) {
    header('Location:restricted.php'); 
    exit(); 
}
//require auth.php on all pages that are restricted to registered users only 

?>