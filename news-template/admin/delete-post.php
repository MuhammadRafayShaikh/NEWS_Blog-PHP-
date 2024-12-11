<?php

require 'config.php';

$id = $_GET['id'];

$cat_id = $_GET['cat_id'];

$sql = "SELECT * FROM post WHERE post_id = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

unlink("upload/" . $row['post_img']);

$sql2 = "DELETE FROM `post` WHERE post_id = $id;";

$sql2 .= "UPDATE category SET post = post - 1 WHERE category_id = $cat_id";

$result2 = mysqli_multi_query($conn, $sql2);

if ($result2) {
    header("Location: post.php");
    exit();
} else {
    echo "<h2>Post is not Delete</h2>";
}

// $sql .= "UPDATE category SET post = post + 1 WHERE category_id = $category";
