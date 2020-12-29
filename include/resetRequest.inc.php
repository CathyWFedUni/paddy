<?php

if(isset(($_POST["reset_request_submit"])){
    
    //converting the selector into hexidecimal value 
    $selector = bin2hex(random_byptes(8)); 
    //add toekn to the database without convertiing to hexidecimals as we need to hash it later for security purposes 
    $token = random_bype(32); 

    // TODO: This URL needs to be updated
    //$adding the seletor and token to the link
    $url = "http://localhost/ITECH3208_LanguageClub/resetPassword/createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token) .
    
    //create a expirary date for the token by adding 1 hour (1800 sec) to it so that user has enough time to reset password and 
    $expires = date("U") + 1800; 

    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

    $userEmail = $_Post["email"]; 

    // delete any entry from the database that may include this user and the token
    $sql = "DELETE FROM pwdReset WHERE pwsResetEmail=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute()) {
        echo "There was an error!";
        exit(); 
    } else {
        $stmt->bindParam(1, $userEmail);       
        $stmt->execute();         
    }

    //insert token into the database 
    $sql = "INSERT INTO pwdReset (pswResetEmail, pswResetSelector, pswResetToken, pswResetExpires) VALUES (?,?,?,?); ";
    $stmt1 = $conn->prepare($sql);
    if (!$stmt1->execute()) {
        echo "There was an error!";
        exit(); 
    } else {
        //hash the token for security purposes
        $hashedToken = password_hash($token, PASSWORD_DEFAULT); 
        $stmt1->bindParam(1, $userEmail);
        $stmt1->bindParam(2, $selector);     
        $stmt1->bindParam(3, $hashedToken);     
        $stmt1->bindParam(4, $expires);         
        $stmt1->execute();         
    }
    
    $to = $userEmail;
    // set up email details 
    $subject = 'Reset your password';

    $message = '<p> we received a password reset request. The link to reset your password is as below. If you did not make this request please ignore this email. </p>';
    //message continue...
    $message .= '<p> Here is your password reset link: </br>'; 
    $message .= '<a href="' .$urs . '">' . $url . '</a></p>';

    $headers = "FROM: Paddy \r\n "; 
    $headers .= "Reply-To: organiser@gmail.com \r\n"; 
    //allow html to become a part of the email, e.g.: link or layout 
    $headers .="Content-type: text/html\r\n";
    
    //send to actual user 
    mail($to, $subject, $message, $headers); 
    //add success message to the resetPassword page 
    header ("Location: ../resetPassword.php?reset=success"); 


} else {
    header("Location: ../loginpage.php")
}