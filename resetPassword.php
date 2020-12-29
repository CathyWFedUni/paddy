<?php
session_start();

require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";
require_once "include/function_login.php";

if (is_logged_in()) {
	header('location: homepage.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
<div class="mobile">
		<div class="background">
			<div class="whitebox">
				<div class="logo js-tilt" data-tilt>
					<img src="images/paddy_logo.PNG" alt="Paddy Logo">
				</div>
	<div class="login_form validate-form">
        <section class = "wrap-input validate-input">
            <h1> Reset your password </h1>
            </br>
            <h2> An e-mail will be sent to you with instrocutions on how to reset your password. </h2>
            </br>
            <form action ="includes/resetRequest.inc.php" method ="post">
                <input type="text" class="input" name="email" placeholder="Enter your e-mail address...">
                </br>
                <button type= "submit" class="login_form-btn" name="reset-request-submit"> Receive new Passwrod by e-mail</button>
            </form>
            <?php 
            //add a success message once password has been reset 
                if(isset($_GET["reset"])){
                    if($_GET["reset"]== "success") {
                        echo '<p class="signupsuccess">Check your e-mail!</p>';
                    }
                }
            ?>
        </section>
    </div>   

</body>

</html>