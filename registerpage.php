<?php
include 'include/registrationFunction.php';
?>

<!-- Register Page -->
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
</head>

<body>

	<div class="mobile">
		<div class="background">
			<div class="whitebox">
				<div class="logintext" data-tilt>
					<span class="login_form-title">
						Already have a account? <br>
						Welcome Back!
					</span>
					<a class="login_form-btn" href="loginpage.php">
						Login
					</a>
				</div>

				<!-- Register Form -->
				<form method="post" class="login_form validate-form" action="Registration">
					<?php include 'errors.php'; ?>
					<span class="login_form-title">
						Create Account
					</span>

					<!-- Username -->
					<div class="wrap-input validate-input" method="post" action="Registration">
						<input id="Test" required class="input" type="text" name="username" maxlength="32" placeholder="Username"  value="<?php echo $username; ?>">
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa-envelope" aria-hidden="true"></i>
						</span>
					</div>


					<!-- Email -->
					<div class="wrap-input validate-input">
						<input required class="input" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Native Language -->
					<div class="wrap-input validate-input">
						<select required class="input" name="primarylag">
							<option value="" disabled selected hidden>Preferred Language</option>
							<option value="English">English</option>
							<option value="Japanese">Japanese</option>
						</select>
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Password -->
					<div class="wrap-input validate-input">
						<input required class="input" type="password" maxlength="32"  placeholder="Password" name="password_1" 
						pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required>
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Retype Password -->
					<div class="wrap-input validate-input">
						<input required class="input" type="password" maxlength="32"  placeholder="Retype Password" name="password_2" >
						<span class="focus-input"></span>
						<span class="symbol-input">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Terms and Conditions -->
					<div class="wrap-input validate-input">
						<input required type="checkbox" id="t&C" name="t&C" value="t&C">
						<label for="t&C"> Terms and Conditions</label><br>
					</div>

					<!-- Register Button -->
					<div class="background-form-btn">
						<button class="login_form-btn" type="submit" class="btn" name="reg_user">
							Register
						</button>
					</div>

					<!-- Register Button -->
					<div class="background-form-btn">
					<a class="back-btn" href="loginpage.php">
						Back
					</a>
					</div>
				</div>
			</form>
		</div>
	</div>

</body>

</html>