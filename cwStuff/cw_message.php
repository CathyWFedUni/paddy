<?php
session_start();
require_once "include/config.php";
require_once "include/auth.php";

//echo is_Organizer();

if (is_Organiser()):

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
    $query = '
			                SELECT
			                q.query_user_id, q.query_header, q.query_body, q.query_date, u.user_email, u.user_japanese_skill, u.user_english_skill
			                FROM useraccount u
			                INNER JOIN userquery q
			                ON
			                    u.user_id = q.query_user_id
			                WHERE q.query_user_id = 2
			                ORDER BY q.query_date desc;
			                ';

//echo htmlspecialchars($query);
    $querySuccess = false;
    $stmt = $conn->prepare($query);
    $userID = logged_in_user_ID();
    $stmt->bindValue(1, $userID);
    if($stmt->execute()){
        
    } else {
        echo "<script> alert('why won't it just work') </script>";
    }

    ?>


		    <h2>Inbox</h2>

		    <form>
		    <table><tr><th width = "13%">From </th><th width = "28%">email </th><th width = "10%">Date</th><th width = "21%">Topic</th><th width = "29%">Message</th></tr></table>
		        <?php foreach ($stmt as $row):

    ?>

		        <table>
		            <td width = "13%"><?php echo htmlentities($row['query_user_id']); ?></td>
		            <td width = "28%"><?php echo htmlentities($row['user_email']); ?></td>
		            <td width = "10%"><?php echo htmlentities($row['query_date']); ?></td>
		            <td width = "21%"><?php echo htmlentities($row['query_header']); ?></td>
		            <td width = "29%"><?php echo htmlentities($row['query_body']); ?></td>

		        </tr>
		        </table>

		    <?php endforeach;?>

    </form>

    </div>


    <?php include "include/footer.php";?>

    </body>
    </html>
<?php else: ?>
    <?php
require_once "include/messageFunction.php";
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

        <div class="content">
            <form action="" method="POST">
                <strong><p/> </strong>
                <h2> Send Message </h2>
                <p/>


    <label for="topic">Topic:  </label>
                <select name="query_header" >
                    <option value="">--Select--</option>
                    <option value="Availability"> Availability </option>
                    <option value="Pairing"> Pairing </option>
                    <option value="Technical Issue">Techical Issue </option>
                    <option value="Converstion Session"> Converstion Session </option>
                    <option value="Other"> Other </option>
                </select>
                <p/>

                Message: <br/><textarea rows="16" cols="65" name="query_body"></textarea><br />
                <p/>

                <input type ="submit" name = 'goButton' Value='SUBMIT'>
            </form>
            <p/>

        </div>

    <!-- Sent Item -->
        <div class="content">
        <?php
// Get the list of results for this user
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$query = '
            SELECT
            q.query_user_id, q.query_header, q.query_body, q.query_date, u.user_email, u.user_japanese_skill, u.user_english_skill
            FROM useraccount u
            INNER JOIN userquery q
            ON
                u.user_id = q.query_user_id
            WHERE q.query_user_id= ?
            ORDER BY q.query_date desc;
            ';

//echo htmlspecialchars($query);

$stmt = $conn->prepare($query);
$userID = logged_in_user_ID();
$stmt->bindValue(1, $userID);
$stmt->execute();

?>


            <h2>Sent Item</h2>
            <table><tr><th width = "20%">Date</th><th width = "20%">Topic</th><th width = "60%">Message</th></tr></table>
                <?php foreach ($stmt as $row): ?>

                    <table>
                    <tr>
                        <td width = "20%"><?php echo htmlentities($row['query_date']); ?></td>
                        <td width = "20%"><?php echo htmlentities($row['query_header']); ?></td>
                        <td width = "60%"><?php echo htmlentities($row['query_body']); ?></td>

                    </tr>
                    </table>
                    <?php endforeach;?>
            </div>
            <div class="content">
            <h2>Inbox</h2>


            <table><tr><th width = "20%">Date</th><th width = "20%">Sender</th><th width = "20%">Topic</th><th width = "40%">Message</th></tr></table>
                <?php foreach ($stmt as $row): ?>
                    <table>
                    <tr>
                        <td width = "20%"><?php echo htmlentities($row['user_name']); ?></td>
                        <td width = "20%"><?php echo htmlentities($row['query_time']); ?></td>
                        <td width = "20%"><?php echo htmlentities($row['query_header']); ?></td>
                        <td width = "20%"><?php echo htmlentities($row['query_body']); ?></td>

                    </tr>
                    </table>

                <?php endforeach;?>


        </div>

    <?php include "include/footer.php";?>

    </body>
    </html>
<?php endif?>