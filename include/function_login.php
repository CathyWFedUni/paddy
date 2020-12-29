 <?php
include "include/classes.php";
require_once "api\data.php";


if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = get_or_default($_POST, 'username', '');
    $password = get_or_default($_POST, 'password', '');
  
    if (isset($username) && isset($password)) {
        //select user details based on user name
        $userID = getUserIDfromUserName($username);
        $isDummy = isDummy($userID);

                // Check whether the hash of the password is the same as the one in the database
                if (password_verify($password, $db_password)) {
                    if($isDummy == 0){
                        if ($isOrganiser == 1) {
                            header('NewSession.php');
                            login($username, $isOrganiser);
                            $_SESSION['currentUser'] = User::constructUserFromDB(logged_in_user_ID());
                            header('location: Sessions');
                        } else {
                            login($username, $isOrganiser);
                            $_SESSION['currentUser'] = User::constructUserFromDB(logged_in_user_ID());
                            header('location: Sessions');
                            exit;
                        }
                        
                    } else {
                        logout();
                    }

                } else {
                    
                    echo "<script> alert('Incorrect password') </script>";
                }           
    } else {

        echo "Please enter username and password";
    }
}

