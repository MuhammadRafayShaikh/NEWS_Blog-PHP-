<?php

if ($_SESSION['role'] == 0) {
    header("Location: post.php");
}
require "config.php";

$id = $_GET['id'];

$delete = "DELETE FROM `user` WHERE user_id = $id";

$result = mysqli_query($conn, $delete);

if ($result) {
    header("Location: users.php");
} else {
    echo "<h2>Something Went Wrong</h2>";
}


mysqli_close($conn);

?>