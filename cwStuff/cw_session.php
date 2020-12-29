<?php
	session_start();
	require_once "include/nav.php";


	//echo is_Organizer();

	if (is_Organizer()):

		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

		// you have to be logged in to view this page
		// This function is in utils.php

		//require login
		require_login();

?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Message</title>
			<link rel="stylesheet" type="text/css" href="style/main.css">
		</head>
		<body>
			<?php include "include/nav.php";?>
			<div class="content">
			<h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
			<!-- add logout button -->
			<form action="logout.php" method="POST">
				<button>Log out</button>
			</form>
			</div>
			<!-- Sent Item -->
			<div class="content">
			<?php
				// Get the list of results for this user
				$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
				$query = 	'
							SELECT
							u.user_id, u.user_name, u.user_japanese_skill, u.user_english_skill, u.user_email, us.isOrganiser
							FROM useraccount u
							INNER JOIN usersettings us
							ON
							u.user_id = us.user_id
							WHERE u.user_id != ?;
							';

			//echo htmlspecialchars($query);
			$stmt = $conn->prepare($query);
			$userID = logged_in_user_ID();
			$stmt->bindValue(1, $userID);
			$stmt->execute();

			?>

	    	<h2>Inbox</h2>

	    <form>
	    <table><tr><th width = "13%">Name </th><th width = "28%">email </th><th width = "21%">Primary Language</th><th width = "29%">Role</th><th width = "29%">Pair</th></tr></table>
	        <?php foreach ($stmt as $row):

        $pair = "No";
        $userName = $row['user_name'];
        $email = $row['user_email'];
        $userJapSkill = $row['user_japanese_skill'];
        if ($userJapSkill == 3) {
            $primaryLag = "Japanese";
        } else {
            $primaryLag = "English";
        }
        $userEngSkill = $row['user_english_skill'];
        $isOrganizer = $row['isOrganiser'];
        if ($isOrganizer == 1) {
            $role = "Organiser";
        } else {
            $role = "Member";
        }

        ?>

		            <table>
		                <td width = "13%"><?php echo htmlentities($userName); ?></td>
		                <td width = "28%"><?php echo htmlentities($email); ?></td>
		                <td width = "10%"><?php echo htmlentities($primaryLag); ?></td>
		                <td width = "21%"><?php echo htmlentities($role); ?></td>
		                <td width = "29%"><?php echo htmlentities($pair); ?></td>

		            </tr>
		            </table>

		        <?php endforeach;?>

								</form>

								</div>


								    <?php include "include/footer.php";?>
								    </body>
								    </html>
								<?php endif?>