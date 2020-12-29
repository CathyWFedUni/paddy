<?php
        include "include/sidebar.php";
        require_once "api\data.php";
        if (is_Organiser()) {
            require_once "include/messageFunction.php";
        } else {
            header("Location: homepage.php");
        }
        ?>

<!-- Inbox Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact</title>
</head>

<body>
    <div class="grid-container">            
        <main class="main">
            <div class="main-cards">
                <div class="card">Inbox

                    <!-- Table To Store Messages -->
                    <table class="sessiontable" id="myTable">
                        <thead>

                            <tr>
                                <th>From&nbsp;</th>
                                <th>&nbsp;Name</th>
                                <th>Email&nbsp;</th>
                                <th>&nbsp;Date</th>
                                <th>Topic&nbsp;</th>
                                <th>&nbsp;Message</th>
                            </tr>

                        </thead>
                        <tbody>

                            <?php
                            //Getting Message To Populate Table

                            //inbox(); 
                            $messages = inbox();
                            if($messages != null){
                                foreach ($messages as $row) {
                                    $query_user_id = $row['query_user_id'];
                                    $user_name = $row['user_name'];
                                    $user_email = $row['user_email'];
                                    $query_date = $row['query_date'];
                                    $query_header = $row['query_header'];
                                    $query_body = $row['query_body'];
                    
                                echo "<tr>";
                                echo"<td>$query_user_id</td>";
                                echo"<td>$user_name</td>";
                                echo"<td>$user_email</td>";
                                echo"<td>$query_date</td>";
                                echo"<td>$query_header</td>";
                                echo"<td>$query_body</td>";
                                echo "</tr>";
                                            
                                }
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                include "include/rSideBar.php";
                ?>

            </div>
        </main>
    </div>
</body>
</html>