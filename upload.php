<?php session_start();
require_once "include/config.php";
require_once "include/auth.php";
require_once "api\data.php";

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$name = $_SESSION['user_name'];
//echo htmlentities(logged_in_user());
//echo htmlspecialchars($name);

// $userid = logged_in_user();
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    //print_r($fileName);
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    //file extention, extract file name and extention, e.g.:[name] => cathywu.JPG
    $fileExt = explode('.', "$fileName");

    //"end() gets last piece of data from an array which is the file extention and make it into lower case before validation,e g.: Array ( [name] => cathywu.JPG [type] => image/jpeg [tmp_name] => C:\xampp\tmp\php8508.tmp [error] => 0 [size] => 17971 )
    $fileActualExt = strtolower(end($fileExt));

    //create an array to check which type of extension are allowed in the website
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    //check if the file uploaded meets the requirements set inthe $allowed variable
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {     
                //create a new file name for the file. The name contains user ID and an unique ID that sourced from timeformat in microsecond so we do not have the same name for the file
                $fileNameNew = $name . "." . uniqid('', true) . "." . $fileActualExt;
                //check if there is a current file, if yes delete the current file
                updateProfilePic($name);                 

                //print_r($fileNameNew); 
                $fileDestination = 'uploads/' . $fileNameNew;
                //call function to upload the file
                move_uploaded_file($fileTmpName, $fileDestination); 
                            
                //update the userIamgeRef when uploading the file
                updatePic($name, $fileNameNew);

                $_SESSION['user_profile_picture_unimplemented'] = $fileDestination;
                header("Location: edituserpage.php?uploadsuccess");
            } else {

                echo "File is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "Incorrect file type!";
        header("Location: edituserpage.php?uploadFail");
    }

}
