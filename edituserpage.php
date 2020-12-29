<?php 
include "include/sidebar.php";
require_once "include/config.php";
require_once "include/auth.php";
require_once "include/updateDetails_profile.php";

//Database Connection Redundant
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
//$name = $_SESSION['user_name'];
?>

<!-- Edit Profile Page -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Account</title>
</head>
<div class="grid-container">
  <main class="main">
    <div class="main-cards">
      <div class="card">Edit Account

        <!-- Change Profile Picture -->
        <form class="profilepicform" action="upload.php" method="post" enctype="multipart/form-data">
          <label for="profilepic">Update Profile Picture:</label><br>
          <img src='<?php echo htmlentities($imageName); ?>' .mt_rand(). width="200" height="120">
          <input type="file" name="file" id="fileToUpload">
          <button class="edit_account-btn" type="submit" value="submit" name="submit">UPLOAD</button>
        </form>

        <!-- Change Profile Password -->
        <form action='' method='POST'>

          <!-- Current Password -->
          <label for='currentPassword' id="user_custom_description">Current Password:</label>
          <input class="input" type='password' name='currentPassword' maxlength='32' autocomplete="current-password" id='changePasswordField'
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required><br>

          <!-- New Password -->
          <label for='newPassword' id="user_custom_description">New Password: </label>
          <input class="input" type='password' name='newPassword' required minlength='5' maxlength='32' autocomplete="new-password" id='changePasswordField'>

          <button class="edit_account-btn">Update Password</button>

        </form>

        <!-- Update User Information -->
        <form name="updateaccount" action="" method="POST">

          <!-- Update Email -->
          <label for="email">Email:</label><br>
          <input class="input" type="email" id="email" name="user_email" maxlength="128" value=><br>

          <!-- Update Language Level -->
        
          <label for="lag_Level">  <?php echo htmlentities($language); ?></label><br>
          <select class="input" name="lag_Level">
            <option value='' disabled selected hidden>Select...</option>
            <option value="2">Fluent</option>
            <option value="1">Intermediate</option>
            <option value="0">Beginner</option>
          </select>&nbsp;

          <input class="edit_account-btn" type="submit" name="submit" value="Save">
        </form>

        <!-- Update User Bio -->
        <form name="updateBio" action="" method="POST">

          <label for="bio">Biography:</label><br>
          <textarea class="textareainput" rows="4" cols="50" name="user_custom_description" maxlength="128"></textarea>

          <input class="edit_account-btn" type="submit" name="submitBio" value="Save">
        </form>
      </div>

      <?php
      include "include/rSideBar.php";
      ?>

    </div>
  </main>
</div>

</html>