<?php

require "config.php";

if (isset($_FILES['fileToUpload'])) {
    // $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
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
        // echo "<h2>Successfully Insert Image</h2>";
    }

    // if (isset($_POST['submit'])) {
    // session_start();
    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $postdesc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $post_date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $insert = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES ('$post_title','$postdesc','$category','$post_date','$author','$file_name');";

    $insert .= "UPDATE category SET post = post + 1 WHERE category_id = $category";

    $result = mysqli_multi_query($conn, $insert) or die("Query Failed");

    if ($result) {
        header("Location: post.php");
    } else {
        echo "<h2>Failed to Insert Post</h2>";
    }
}
// }
