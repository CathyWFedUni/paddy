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
            <?php
             //set up variable
             $selector = $_GET["selector"];
             $validator = $_GET["validator"];

            //check if token is inside URL to ensure no one is messing up with the token
            if (empty($selector) || empty($validator)){
                echo " Could not validate your request!";
            } else {
                //user function to validate toeken
                if(ctype_xdigit($seletor) !== false && ctype_xdigit($validator) !== false){
                    ?>

                    <!--validate the user is a valid user -->
                    <form action = "includes/resetPassword.inc.php" method ="post">
                        <input type="hidden" name="selector" value="<?php echo $selector ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator ?>">
                        <input type="password" name="pws" placeholder="Enter a new password...">
                        <!--Repeat password to avoid input error -->
                        <input type="password" name="pwsRepeat" placeholder="Repeat new password...">
                        <button type="submit" naem="reset-password-submit">Reset password </button>
                    </form>

                    <?php

                }
            }
            
        ?>           

        </section>
    </div>   

</body>

</html>