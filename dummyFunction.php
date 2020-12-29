<?php
require_once "include/config.php";
require_once "include/auth.php";
require_once "include/utils.php";

// initializing variables
$userid = "";
$username = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', $DB_USER, $DB_PASSWORD, 'paddy');
// REGISTER USER

if (isset($_POST['reg_user'])) {
    if($_POST['reg_user'] == "true"){
        // receive all input values from the form
        // use mysqli_real_escape_string to prevent SQL injection.
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $primarylag = mysqli_real_escape_string($db, $_POST['primarylag']);
        
        // convert the selected language skill to a varaible which can be called later
        if ($primarylag == "Japanese") {
            $primarylagSelected = "user_japanese_skill";
        } else {
            $primarylagSelected = "user_english_skill";
        }   
    
        // form validation: ensure that the form is correctly filled ...
        // first check the database to make sure
        // a user does not already exist with the same username and/or email
        createDummy($username, $primarylagSelected);
    }
}
