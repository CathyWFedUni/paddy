<?php
require_once "api\data.php";
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$name = $_SESSION['user_name'];
if (isset($_POST['goButton'])) { //If user did submit the form
    $fromName = $_SESSION['user_name'];
    $topic = $_POST['query_header'];
    $message = $_POST['query_body'];
    sendMessageSQL($fromName, $topic, $message);
}
