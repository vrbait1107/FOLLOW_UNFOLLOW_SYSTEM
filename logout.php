<?php
if (isset($_POST['logout'])) {
    session_start();
    $_SESSION = array();
    session_destroy();
    header("location: login.php");
}
