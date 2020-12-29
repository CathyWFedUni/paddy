<?php
include "include/classes.php";
session_start();
$_SESSION['currentUser'] = User::constructUserFromDB(logged_in_user_ID());

require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";
if (!is_logged_in()) {
    header('location: Login');
}

$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$imageName = $_SESSION['user_profile_picture_unimplemented'];
?>

<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  
  <div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <?php if (is_logged_in()) {
    // checking if user is log in first and only show orgniser page to organiser
    echo "<hr class='divider'>";
    echo "<a href='Sessions'>Home</a>";
    echo "<a href='User'>User Account</a>";
    if (is_Organiser()) {
      echo "<hr class='divider'>";
      echo " <div class='nav_sub_heading'>";
      echo " </div>";
      echo "<a href='NewSession'>Create Session</a>";
      echo "<a href='UserManagement'>User Management</a>";
      echo "<a href='Inbox'>Inbox</a>";
    }else {
        echo "<a href='Contact'>Contact Organiser</a>";
    }
  }
    ?>

<form action="logout.php" method="POST">
	  <button> <a class="bottom_nav">Log out</a></button>
	</form>
</div>

<div id="main">
  <button class="openbtn" onclick="openNav()">☰</button>  
</div>

<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>

<aside class="sidenav">
  <br> 
  <img src='<?php echo"uploads/". $_SESSION['currentUser']->getUserImageRef(); ?>' alt="Profile Picture">
  <div class="nav_sub_heading">
  <?php echo htmlentities(logged_in_user()); ?>
  </div>

  
  <?php if (is_logged_in()) {
    // checking if user is log in first and only show orgniser page to organiser
    echo "<hr class='divider'>";
    echo "<a href='Sessions'>Home</a>";
    echo "<a href='User'>User Account</a>";   
    /*
    echo "<a href='calendar.php'>Calendar</a>";
    */
    if (is_Organiser()) {
        echo "<hr class='divider'>";
        echo " <div class='nav_sub_heading'>";
        echo "Organiser";
        echo " </div>";
        echo "<a href='NewSession'>Create Session</a>";
        echo "<a href='UserManagement'>User Management</a>";
        echo "<a href='Inbox'>Inbox</a>";
    } else {
       echo "<a href='Contact'>Contact Organiser</a>";
    }
}
?>

  <form action="logout.php" method="POST">
	  <button> <a class="bottom_nav">Log out</a></button>
	</form>
</aside>