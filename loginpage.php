<?php
session_start();

require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";

require_once "include/function_login.php";
if (is_logged_in()) {
	header('location: Sessions');
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
				<div class="logo">
					<img src="images/paddy_logo.PNG" alt="Paddy Logo">
				</div>

				<!-- User Login Form -->
				<form class="login_form validate-form" action='' method="POST">
					<span class="login_form-title">
						Member Login
					</span>

					<!-- Username -->
					<div class="wrap-input validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input" type="text" name="username" id="username" placeholder="Username" required>
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Password-->
					<div class="wrap-input validate-input" data-validate="Password is required">
						<input class="input" type="password" name="password" id="password" placeholder="Password" required>
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="background-form-btn">
						<button type="submit" name="Login" class="login_form-btn">Login</button>
					</div>

					<!--  Password Reset, checking if there is a get parameter that we can grasp and check if the get value is equal to the password updated, if it is then success message pops up -->
					<?php 
					if (isset($_GET["newpwd"])) {
						if (($_GET["newpwd"]) == "passwordupdated") {
							echo '<p class="signupsuccess">Your password has been reset!</p>'; 
						}
					}
					?>

					<!-- Forgot Password -->
					<a class="txt1" href="resetPassword.php">
						Forgot Password ?
					</a>

					<!-- Register New Account -->
					<a name="Register" class="login_form-btn" href="Registration">Create Account</a>
				</form>
			</div>
		</div>
	</div>
</div>

</body>

</html>