<?php
$id = $_GET['id'];
require_once "db_connect.php";

$delete_entry = "DELETE FROM book WHERE id = $id"; 

if (mysqli_query($link, $delete_entry)) {
    mysqli_close($link);
    header('Location: edit.php');
    exit;
} else {
    echo "Error deleting entry";
}

?>