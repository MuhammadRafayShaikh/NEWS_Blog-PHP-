<?php

require 'config.php';

$id = $_GET['id'];

$delete = "DELETE FROM `category` WHERE category_id = $id";

$result = mysqli_query($conn, $delete);

if ($result) {
    header("Location: category.php");
} else {
    echo "<h2>Something went wrong</h2>";
}
