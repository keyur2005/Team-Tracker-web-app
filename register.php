<?php
/* We need to validate the user info, then store the information in our database table. Really important to make sure we are storing the user password in a secure manner - hash the password using password_hash( ) */

//validate & store form info 

$input_first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS); 
$input_last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS); 
$input_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS); 
$input_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL); 
$input_password = filter_input(INPUT_POST, 'password'); 
$input_password_confirm = filter_input(INPUT_POST, 'confirm_password');





//print error msg according to require statement
if (empty($input_first_name) || empty($input_last_name) || empty($input_email) ||   empty($input_username)  ||  empty($input_password) ||  empty($input_password_confirm)) {
    echo "<p> You must fill out all the info please! </p>"; 
}
elseif ($input_email === false) {
    echo "<p> Please provide a valid email address </p>"; 
}
elseif ($input_password != $input_password_confirm) {
    echo "<p> Passwords don't match! </p>"; 
}
//require 8 characters in length 
elseif (strlen($input_password) < 8) {
    echo "<p> Passwords must be at least 8 characters! </p>"; 
}

//require uppercase, lowercase, digit & symbol 
elseif (!preg_match('^(?=.{10,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$^', $input_password)) {
    echo "<p> Passwords should have one uppercase character, a digit and a symbol!  </p>"; 
} 
else {
    try{
    //hash the password 
    $hashedpassword = password_hash($input_password,PASSWORD_DEFAULT); 
    //connect to the db 
    require_once 'connect.php';
    //check to see if username already exists 
    $namecheck = "SELECT * FROM users WHERE username = :username"; 
    //prepare 
    $statement = $db->prepare($namecheck); 
    //bind 
    $statement->bindParam(":username", $input_username); 
    //execute
    $statement->execute(); 
        if($statement->rowCount() == 1) {
            echo "<p> Username already exists!</p>"; 
            echo "<a href='index.php'> Back to registration/login </a>"; 
            exit(); 
        }
        else {
        //set up the query 
        $query = "INSERT INTO users (first_name, last_name, username, email, password) VALUES (:first_name, :last_name, :username, :email, :password)";
        //prepare 
        $stmt =  $db->prepare($query); 
        //bindParam
        $stmt->bindParam(':first_name', $input_first_name); 
        $stmt->bindParam(':last_name', $input_last_name); 
        $stmt->bindParam(':username', $input_username); 
        $stmt->bindParam(':email', $input_email); 
        $stmt->bindParam(':password', $hashedpassword); 
        //execute 
        $stmt->execute();
        header('Location:index.php'); 
        }
    } 
    catch(Exception $e) {
        $errormessage = $e->getMessage();
        echo "<p> Opps! Something went wrong? </p>"; 
        echo $errormessage; 
    }
    finally {
        $stmt->closeCursor(); 
    }
}