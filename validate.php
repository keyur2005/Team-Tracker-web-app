<?php
//validate our user information, checking to see whether information has been entered and whether it is in the proper format

//creating an empty array to store error messages 
$errors = array();
//check to see whether data has been entered and whether it is the correct format, provide a heplful error message if not and set the flag variable to true 

if (empty($input_firstname) || empty($input_lastname)) {
  $error_msg_1 = "Please enter first and last name";
  array_push($errors, $error_msg_1);
}

if (empty($input_position)) {
  $error_msg_2 = "Please enter your position";
  array_push($errors, $error_msg_2);
}

//add optional filter for checking whether email, returns false if not a valid email
if ($input_email == false || empty($input_email)) {
  $error_msg_3 = "Please enter a valid email address!";
  array_push($errors, $error_msg_3);
}

//add optional filter for checking whether integer, returns false if not an integer 
if (empty($input_phone_num)) {
  $error_msg_4 = "Please enter your Phone number";
  array_push($errors, $error_msg_4);
}

if (empty($input_team_name)) {
  $error_msg_5 = "Don't forget to share your team name!";
  array_push($errors, $error_msg_5);
}

  
//photo validation 
//check if the right size and right format 
$ok_files = ['image/gif','image/jpeg','image/jpg', 'image/png']; 

if(in_array($photo_type, $ok_files) === FALSE) {
  $error_msg_7 = "Please submit a photo that is a jpg, png or gif ";
  array_push($errors, $error_msg_7);
}

//check the file size 
if($photo_size < 0 || $photo_size >= 327680) {
  $error_msg_8 = "Please a photo no larger than 340 kb!";
  array_push($errors, $error_msg_8);
}

//check if any errors on upload 
if ($_FILES['photo']['error'] !== 0) {
  $error_msg_9 = "There was an error uploading your file";
  array_push($errors, $error_msg_9);
}

if ($responseData["success"] === false) {
    $error_msg_10 = "No robots please!!";
    array_push($errors, $error_msg_10);
  }



?>