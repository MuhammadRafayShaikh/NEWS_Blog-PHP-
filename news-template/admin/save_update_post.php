<?php

require 'config.php';

if (empty($_FILES['new_image']['name'])) {
    $file_name = $_POST['old_image'];
} else {
    $check = false;
    // $errors = array();

    $file_name = $_FILES['new_image']['name'];
    $file_size = $_FILES['new_image']['size'];
    $file_tmp = $_FILES['new_image']['tmp_name'];
    $file_type = $_FILES['new_image']['type'];
    $dot = '.';
    // explode : convert string into array by delimiter that you want to pass
    $explode = explode($dot, $file_name);
    $file_ext = strtolower(end($explode));
    // $file_ext = strtolower($explode[1]);
    // print_r($file_ext);
    $extensions = array("jpg", "jpeg", "png", "webp");

    if (in_array($file_ext, $extensions) === false) {
        echo "<h2>This format is not allowed, Please insert JPG or PNG File</h2>";
        // die();
        // $error = (array("This format is not allowed, Please insert JPG or PNG File"));
        // echo $error[0];
        // array_push($errors,"This format is not allowed, Please insert JPG or PNG File");
        // echo "<h2>This format is not allowed, Please insert JPG or PNG File</h2>";
    } else if ($file_size >= 2097152) {
        echo "<h2>File size must be less than or equal to 2mb</h2>";
        // die();
    } else {
        move_uploaded_file($file_tmp, "upload/" . $file_name);
        $check = true;
        // echo "<h2>Successfully Insert Image</h2>";
    }
}
$date = date("d M, Y");

$update = "UPDATE post SET title='{$_POST['post_title']}',description='{$_POST['postdesc']}',category={$_POST['category']},post_date='$date',post_img='$file_name' WHERE post_id = {$_POST['post_id']};";

if ($_POST['old_category'] != $_POST['category']) {
    $update .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
    $update .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
}

$result = mysqli_multi_query($conn, $update);

if ($result) {
    header("Location: post.php");
    exit();
} else {
    echo "<h2>Unfortunately Post is not Update</h2>";
}
