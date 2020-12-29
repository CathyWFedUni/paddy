<?php
include "include/sidebar.php";
require_once "include/messageFunction.php";
?>

<!-- Contact Page -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact</title>
</head>

<body>
  <div class="grid-container">
    <main class="main">
      <div class="main-cards">
        <div class="card">Contact Organiser
          <div class="leftSideCards">

            <!-- Contact Organiser Form -->
            <form action="" method="POST">
              <label for="Topic">Topic</label><br>

              <!-- Select Issue Type -->
              <select required class="input" name="query_header">
                <option value="Technical Problem">Technical Problem</option>
                <option value="Availability"> Availability </option>
                <option value="Pairing"> Pairing </option>
                <option value="Technical Issue">Techical Issue </option>
                <option value="Conversation Session"> Conversation Session </option>
                <option value="Account Problem">Account Problem</option>
                <option value="Other"> Other </option>
              </select>
              
              <label for="sdesc">Message</label><br>
              <textarea class="textareainput" rows="16" cols="65" name="query_body" maxlength="128"></textarea>
              <input class="login_form-btn" type="submit" name='goButton' value="Send">
            </form>

          </div>
        </div>
        <?php
        include "include/rSideBar.php";
        ?>
      </div>
    </main>
  </div>
</body>
</html>