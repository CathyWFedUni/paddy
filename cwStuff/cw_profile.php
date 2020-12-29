<?php session_start();
require_once "include/config.php";
require_once "include/auth.php";
require_once "include/updateDetails_profile.php";

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
// you have to be logged in to view this page
// This function is in utils.php

//require login
require_login();
//if not an admin take back to log in page
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>

	<?php include "include/nav.php";?>


	<div class="content">
        <h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
        
		<?php if (is_Organiser()) {echo "(Organiser)";}
?>
        <!-- add logout button -->
		<form action="logout.php" method="POST">
			<button>Log out</button>
		</form>

	</div>

   <!-- profile -->
   <div class="content">
		<h2> <?php echo htmlentities(logged_in_user()); ?> Personal Information</h2>

			<?php
// Get the list of results for this user
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$query1 = "	SELECT user_name, user_email, user_japanese_skill, user_english_skill, user_profile_picture_unimplemented, user_custom_description 
            FROM useraccount 
            WHERE user_name =" . $conn->quote($name);
//echo htmlspecialchars($query1) . "<br>";
$results = $conn->query($query1);
$row = $results->fetch();
if ($row) {
    switch ($row['user_japanese_skill']) {

        case 0:
            $userJapSkill = "Beginner";
            break;
        case 1:
            $userJapSkill = "Intermediate";
            break;
        case 2:
            $userJapSkill = "Fluent";
            break;
        case 3:
            $userJapSkill = "Primary";
            break;

    }

    switch ($row['user_english_skill']) {

        case 0:
            $userEngSkill = "Beginner";
            break;
        case 1:
            $userEngSkill = "Intermediate";
            break;
        case 2:
            $userEngSkill = "Fluent";
            break;
        case 3:
            $userEngSkill = "Primary";
            break;

    }

    ?>
						<form>
						<strong>Name: </strong> <?php echo htmlentities($row['user_name']); ?><p/>
						<strong>email:</strong> <?php echo htmlentities($row['user_email']); ?><p/>
                        <strong>Japanese Skill:</Strong>  <?php echo htmlentities($userJapSkill); ?><p/>
						<strong>English Skill:</strong> <?php echo htmlentities($userEngSkill); ?><p/>
                        <!-- <strong>Profile Link:</strong> <?php echo htmlentities($row['user_profile_picture_unimplemented']); ?><p/>
                        <strong>About me: </strong><?php echo htmlentities($row['user_custom_description']); ?></td> -->
			<?php
} else {
    echo "No results";
}
?>
			</table>
		</form>
	</div>


<!-- update profile page -->
  	<div class='content'>
	  <h2> Update Profile</h2>
		<form action="" method="POST">
			<strong> <p/> </strong>

            e-mail: <br/><input type="email" name="user_email"><p/>

			<!--update lanauge level and email address-->
            <?php echo htmlentities($languageLevel); ?>&nbsp;
            <select name="lag_Level" >
            <option value="">--- Select ---</option>
			<option value="2">Fluent</option>
			<option value="1">Intermediate</option>
			<option value="0">Beginner</option>
			</select>&nbsp;
 			<input type = 'submit' name = 'gobutton' Value='SUBMIT'>

</form>
	</div>
	<div class="content">
	<h2> Update Password</h2>
    <form action='' method='POST'>
        <label for='currentPassword' id = "user_custom_description">
            Current Password:
        </label>
        <input type='password' name ='currentPassword' required minlength='5' maxlength ='255' autocomplete = "current-password" id ='changePasswordField'><br>
        <label for='newPassword' id = "user_custom_description">
            New Password:
        </label>
        <input type='password' name ='newPassword' required minlength='5' maxlength ='255' autocomplete = "new-password" id ='changePasswordField'>
    <div>
        <button>Update Password</button>
    </div>
    </form>
</div>


<!-- update photo page -->
<div class='content'>
	<h2> Profile Picture</h2>

		<form >
			<img src= '<?php echo htmlentities($imageName); ?>'.mt_rand(). width="250" height="180">
		</form>


		<form action="upload.php" method="post" enctype="multipart/form-data">
		</br>
		</br>
		<strong>Select image to upload:</strong>
			<input type="file" name="file" id="fileToUpload">
			<button type="submit" value="submit" name="submit">UPLOAD</button>
		</form>
</div>



	<?php include "include/footer.php";?>

</body>
</html>