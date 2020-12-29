<?php
require_once "api\data.php";
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$userID = $_SESSION['user_id'];
if($_SESSION['currentUser']->getUserJapSkill() < $_SESSION['currentUser']->getUserEngSkill()){
    //Primary Language: English
    $language = "Japanese Level:";
} else {
    //Primary Language: Japanese
    $language = "English Level:";
}

//update email and language level-->
//when both email and language are updated
if (isset($_POST['lag_Level'])&& isset($_POST['user_email'])&& ($_POST['user_email'])!=null &&($_POST['lag_Level'])!=null) {
    $email = $_POST['user_email'];
    $lag_Level = $_POST['lag_Level'];
    updateEmailLanguage( $userID, $email,$lag_Level);
}

//only when Language level is set
 elseif (isset($_POST['lag_Level']) && ($_POST['lag_Level']!=null)) {
    $lag_Level = $_POST['lag_Level'];
    
    updateLanguageLevel($userID, $lag_Level); 

    //when only email is updated
} elseif (isset($_POST['user_email']) && ($_POST['user_email'])!=null) {
    $email = $_POST['user_email'];
    updateEmail($userID, $email); 

} elseif (isset($_POST['lag_Level'])&& isset($_POST['user_email'])&& ($_POST['user_email'])!=null &&($_POST['lag_Level'])!=null) {
    $email = $_POST['user_email'];
    $lag_Level = $_POST['lag_Level'];
    updateEmailLanguage($email,$lag_Level); 
}

?>


<!--update Bio-->
<?php

if (isset($_POST['user_custom_description'])&& ($_POST['user_custom_description']!=null)) {
    $user_custom_description = $_POST['user_custom_description'];
    updateBio($userID, $user_custom_description);
}
?>


<!--update password-->
<?php

if (isset($_POST['currentPassword']) && isset($_POST['newPassword'])) {
    updatePassword($_SESSION['currentUser']->getID()); 
}
?>

