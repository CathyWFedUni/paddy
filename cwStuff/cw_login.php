<?php
session_start();
require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";
require_once "include/function_login.php";

//I am a change
?>

<!DOCTYPE html>
<html>
<head>
    <title>Paddy - Login</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>
	<?php include "include/nav.php";?>

	<div class="content">

		<h1>Welcome to the Paddy Club</h1>

		<?php if (is_logged_in()): ?>
			<h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
			<form action="logout.php" method="POST">
				<button>Log out</button>
			</form>
		<?php else: ?>

		<form action="" method="POST">
			<?php if (isSet($username)): ?>
				<div class="warning">Login failed, please try again</div>
			<?php endif;?>
			<ul>
                <li>
                    <label for="username">User ID</label>
                    <input type="text" size="50" maxlength="10"
                    name="username" id="username"
                    value="<?php echo htmlentities($user_id); ?>">
                </li>
                <p/>
                <li>
                    <label for="password">Password</label>
                    <input type="password" size="10" name="password" id="password">
                </li>
                <p/>
                <li>
                <button>Log In</button>
                </li>

			</ul>
			<p>Not yet a member? <a href="registration.php">Sign Up</a> </p>
		</form>

		<?php endif;?>
	</div>

	<?php include "include/footer.php";?>

	<script src="script/validate_login.js"></script>
</body>
</html>