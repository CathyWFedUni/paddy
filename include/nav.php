<?php
require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";

?>

<nav>
<h1>Paddy</h1>
<h3>Japanese Australian Language Club</h3>

<?php if (is_logged_in()) {

    echo " <a href='cw_profile.php'> Profile </a>";
    if (is_Organiser()) {
        echo "<a href='./data/fakedata.php'> Pairing</a>";
        echo " <a href='contact.php'> Inbox </a>";
        // need to comment it out
        echo " <a href='contact.php'> Message </a>";
    } else {
        echo " <a href='contact.php'> Message </a>";}

    echo "<a href='sessionpage.php'> Session </a>";

} else {echo "<a href='registerpage.php'> Sign Up </a>";}
?>
</nav>
