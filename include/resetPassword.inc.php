<?php

if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pws"];
    $passwordRepeat = $_POST["passwordRepeat"];

    if (empty($password) || empty($passwordRepeat)){

        header("Location: ../CreateNewPassword.php?newpwd=empty");
        exit(); 
    } elseif ($password != $passwordRepeat){
        header("Location: ../createNewPassword.php?newpwd=pwdnotsame");
        exit(); 
    }

    $currentDate = date("U"); 
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    //select the token from the database , validator to valitate user is a validated user 
    $sql = "SELECT * FROM pwdReset WHERE pswResetSelector=? AND pwdResetExpires >= ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt1->execute()) {
        echo "There was an error!";
        exit(); 
    } else {           
        $stmt->bindParam(1, $selector);     
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            // If it exists
            if (!$row) {
                echo "You need to re-submit your reset request.";
                exit(); 
            } else {
                //match the token from the database with the token we sent from the form 
                // in order to compare we need to make both token in binary data so we have to convert the validated token from hexadecimal into binary

                $tokenBin = hex2bin(validator);
                $tokeCheck = password_verify($tokenBin, row["pwdResetToken"]);
                
                if($tokenCheck === false){
                    echo "You need to re-submit your reset request.";
                    exit(); 
                } elseif ($tokenCheck === true){
                    //grap the email of the user by using token
                    $tokenEmail = $row['pwsResetEmail']; 

                    $sql ="SELECT * FROM useraccount WHERE user_email =?;"; 
                    $stmt = $conn->prepare($sql);                  
                    if (!$stmt->execute()) {
                        echo "There was an error!";
                        exit(); 
                        // If it exists
                    } else {           
                        $stmt->bindParam(1, $tokenEmail);                                                                
                            if ($stmt->execute()) {
                                $row = $stmt->fetch();
                                // If it exists
                                if (!$row) {
                                    echo "There was an error.";
                                    exit(); 
                                } else {
                                    //update the password in the user table 
                                    $updatePWDSQL = "UPDATE useraccount SET user_password = ? WHERE user_email = ?";
                                    $stmt1 = $conn->prepare($updatePWDSQL); 
                                    //when bind password we need to hash password first 
                                    $newPwdHash = password_hash($password, PASSWORD_DEFAULT); 
                                    $stmt1->bindParam(1, $newPwdHash);   
                                    $stmt1->bindParam(2, $tokenEmail);
                                    $stmt1->execute(); 

                                    //delete token that belong to the same user based on the email 
                                    $deleteToken = "DELECT FROM pwdReset WHERE pwdResetEmail=?"; 
                                    $stmt = $conn->prepare($deleteToken);                  
                                    if (!$stmt->execute()) {
                                        echo "There was an error!";
                                        exit(); 
                                        // If it exists
                                    } else {           
                                        $stmt->bindParam(1, $tokenEmail)
                                        $stmt->execute(); 
                                        header("Location: ../login.php?newpwd=passwordupdated");    



                }

            }
                
                
    }

}else
    header("Location: ../loginpage.php");
}


?>