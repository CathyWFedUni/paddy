
<!-- Page most likely needs to be deleted -->
<?php

require_once "include/auth.php";
if (!is_logged_in()) {
	header('location: loginpage.php');
}
include 'include/functions.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Paddy Club</title>
	<link rel="stylesheet" type="text/css" href="style/main.css">
</head>

<body>
	<!-- Where is the navigation bar? -->

	<?php include "include/nav.php"; ?>

	<div class="content">

		<h1>Welcome to the Paddy Club</h1>
		<p>Here you can login to and find other language fans</p>

		<?php

		if (is_logged_in()) : ?>
			<h2>Currently logged in as <?php echo htmlspecialchars(logged_in_user()); ?></h2>
			<form action="logout.php" method="POST">
				<button>Log out</button>
			</form>
		<?php else : ?>

			<form action="cw_login.php" method="POST">
				<ul>
					<li>
						<label for="user_id">User ID</label>
						<input type="text" size="10" maxlength="10" name="user_id" id="user_id">
					</li>
					<p />

					<li>
						<label for="password">Password</label>
						<input type="password" size="10" name="password" id="password">
					</li>
				</ul>
				<button>login</button>
			</form>

		<?php endif ?>
	</div>

	<?php include "include/footer.php"; ?>

	<script src="script/validate_login.js"></script>

</body>

</html>