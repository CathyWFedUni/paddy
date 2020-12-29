<!DOCTYPE html>
<html lang="en">

<head>
  <title>Profile Page</title>
</head>

<body>
  <!-- <div class="background_homepage"> -->
  <div class="grid-container">
    <?php

    include "include/sidebar.php";
    require_once "include/auth.php";
    $imageName = $_SESSION['currentUser']->getUserImageRef();
    $id = $_SESSION['user_id'];
    ?>
    <main class="main">
      <div class="parentcard">
        <div class="leftColumn">
          <div class="userinfo">

            <?php/*
              require_once "api\data.php";
              $languageLevels = getlanguageLevelsDB($id);
              $userJapSkill = $languageLevels[0]; 
              $userEngSkill = $languageLevels[1]; 
              $userEmail = $languageLevels[2];
              $bio = $languageLevels[3];    
              */         


            ?>
            <div class="profilePictureHolder">
              <img src='<?php echo "uploads/" . htmlentities($imageName); ?>' alt="Profile Picture">
            </div>
            <h1><?php echo $_SESSION['currentUser']->getUserName(); ?></h1>
            <h1><?php echo $_SESSION['currentUser']->getUserEmail();; ?></h1>

            <p><?php echo $_SESSION['currentUser']->getUserCustomInfo(); ?></p>

            <div class="background-form-btn">
              <a name="EditAccount" class="login_form-btn" href="EditDetails">Edit</a>
            </div>

            <div class="responsiveChildcard">

            <div class="childcard">
            <img class="cardimage" src="images/role_icon.png" alt="Member Picture">

            <?php if (is_Organiser()) {
              echo "<h1 class='cardheading'>Organiser<h1>";
            } else {
              echo "<h1 class='cardheading'>Member<h1>";
            }
            ?>

          </div>

          <div class="childcard">
            <img class="cardimage" src="images/LanguageIcon.png" alt="SpeechIcon Picture">
            <h1 class="cardheading">Japanese Skill: <?php echo $_SESSION['currentUser']->getJapSkillString(); ?> </h1>
          </div>

          <div class="childcard">
            <img class="cardimage" src="images/LanguageIcon.png" alt="SpeechIcon Picture">
            <h1 class="cardheading">English Skill: <?php echo $_SESSION['currentUser']->getEngSkillString(); ?> </h1>
          </div>
          </div>
          </div>

         
          
        </div>
        <div class="rightColumn">
          <div class="childcard">
            <img class="cardimage" src="images/role_icon.png" alt="Member Picture">

            <?php if (is_Organiser()) {
              echo "<h1 class='cardheading'>Organiser<h1>";
            } else {
              echo "<h1 class='cardheading'>Member<h1>";
            }
            ?>

          </div>

          <div class="childcard">
            <img class="cardimage" src="images/LanguageIcon.png" alt="SpeechIcon Picture">
            <h1 class="cardheading">Japanese Skill: <?php echo $_SESSION['currentUser']->getJapSkillString(); ?> </h1>
          </div>

          <div class="childcard">
            <img class="cardimage" src="images/LanguageIcon.png" alt="SpeechIcon Picture">
            <h1 class="cardheading">English Skill: <?php echo $_SESSION['currentUser']->getEngSkillString(); ?> </h1>
          </div>
        </div>
      </div>
  </div>
  </main>

  </div>
  <!-- </div> -->


</body>

</html>