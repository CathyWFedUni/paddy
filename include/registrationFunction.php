<?php
require_once "config.php";
require_once "auth.php";
require_once "utils.php";

// initializing variables
$userid = "";
$username = "";
$email = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', $DB_USER, $DB_PASSWORD, 'paddy');
// REGISTER USER
if (isset($_POST['reg_user'])) {

    // receive all input values from the form
    // use mysqli_real_escape_string to prevent SQL injection.
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $primarylag = mysqli_real_escape_string($db, $_POST['primarylag']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
    // convert the selected lanague skill to a varaible which can be called later
    if ($primarylag == "Japanese") {
        $primarylagSelected = "user_japanese_skill";
    } else {
        $primarylagSelected = "user_english_skill";
    }   
   
    // form validation: ensure that the form is correctly filled ...
    if (empty($username)) {array_push($errors, "Username is required");}
    if (empty($email)) {array_push($errors, "Email is required");}
    if (empty($primarylag)) {array_push($errors, "Primary Langauge is required");}
    if (strlen($password_1) < 5) {array_push($errors, "Password must at least 5 characters");}
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $errors = checkUser($username, $email, $errors);
    

    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_BCRYPT);
        createUser($username, $email, $primarylagSelected, $password);
    }
}
