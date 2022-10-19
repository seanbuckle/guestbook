<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: add_entry.php");
exit;
?>