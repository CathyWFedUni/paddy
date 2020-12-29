<!DOCTYPE html>
<html lang="en">

<head>
  <title>Create Session</title>
  <meta charset="UTF-8">
</head>

<body>
  <div class="grid-container">

    <?php
    
    include "include/sidebar.php";
    if (is_Organiser()) {
    } else {
      header("Location: homepage.php");
    }
   
    
    //Time Of Session
    if (isset($_POST['stime']) && isset($_POST['sdate'])) {
      $time = $_POST['stime'];
      $date = $_POST['sdate'];
      $sessionName;
      //Name Of Session
      if (isset($_POST['sname']) && $_POST['sname'] != NULL) {
        $sessionName = $_POST['sname'];
      } else {
        $sessionName = 'Session';
      }
      //Create Session
      if ($time != NULL && $date != NULL) {
        $sessionObject = new Session($time, $date, 50, $sessionName);
        if ($sessionObject->storeObject()) {
          echo "<script> alert('Successful') </script>";
        } else {
          echo "<script> alert('Error') </script>";
        }
      }
    }
    ?>

    <main class="main">
      <div class="main-cards">
        <div class="card">
          <h1>Create Session</h1>

          <!-- Create Session Form -->
          <form name="createsession" action="" method='post'>

            <!-- Session Name -->
            <label for="sname">Session Name:</label><br>
            <input class="input" type="text" id="sname" name="sname" maxlength="128"><br>

            <!-- Session Date -->
            <label for="sdate">Session Date:</label><br>
            <input class="input" type="date" id="sdate" name="sdate"><br>

            <!-- Session Time -->
            <label for="stime">Session Time:</label><br>
            <input class="input" type="time" id="stime" name="stime"><br>

            <button type="submit" class="login_form-btn">Submit</button>
          </form>
        </div>

        <?php
        //Right Sidebar
        include "include/rSideBar.php";
        ?>

      </div>
    </main>
  </div>
</body>
</html>