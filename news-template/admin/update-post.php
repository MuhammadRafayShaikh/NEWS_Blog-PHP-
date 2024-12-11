<?php include "header.php";

if ($_SESSION['role'] == 0) {
    $id = $_GET['id'];
    $select3 = "SELECT author FROM post WHERE post_id = $id";
    $result3 = mysqli_query($conn, $select3);
    $row3 = mysqli_fetch_assoc($result3);
    $author = $row3['author'];

    if ($author != $_SESSION['user_id']) {
        header("Location: post.php");
    }
}



$id = $_GET['id'];

$select = "SELECT post.post_id, post.title, post.description, post.post_date, post.post_img, category.category_name, user.username, post.category FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE post_id = $id";

$result = mysqli_query($conn, $select);

while ($row = mysqli_fetch_assoc($result)) {


?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="admin-heading">Update Post</h1>
                </div>
                <div class="col-md-offset-3 col-md-6">
                    <!-- Form for show edit-->
                    <form action="save_update_post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-group">
                            <input type="hidden" name="post_id" class="form-control" value="<?php echo $row['post_id'] ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTile">Title</label>
                            <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $row['title'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1"> Description</label>
                            <textarea name="postdesc" class="form-control" required rows="5"><?php echo $row['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCategory">Category</label>
                            <select class="form-control" name="category">
                                <option value="" disabled> Select Category</option>
                                <?php

                                $select2 = "SELECT * FROM category";

                                $result2 = mysqli_query($conn, $select2) or die("Query Failed");

                                if (mysqli_num_rows($result2) > 0) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        if ($row['category'] == $row2['category_id']) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                ?>
                                        <option <?php echo $selected ?> value="<?php echo $row2['category_id'] ?>"><?php echo $row2['category_name'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" name="old_category" value="<?php echo $row['category'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Post image</label>
                            <input type="file" name="new_image">
                            <img src="upload/<?php echo $row['post_img'] ?>" height="150px">
                            <input type="hidden" name="old_image" value="<?php echo $row['post_img'] ?>">
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                    </form>
                <?php } ?>
                <!-- Form End -->
                <?php
                // $check;
                // if (empty($_FILES['new_image']['name'])) {
                //     $file_name = $_POST['old_image'];
                // } else {
                //     $check = false;

                //     $file_name = $_FILES['new_image']['name'];
                //     $file_size = $_FILES['new_image']['size'];
                //     $file_tmp = $_FILES['new_image']['tmp_name'];
                //     $file_type = $_FILES['new_image']['type'];
                //     $dot = '.';
                //     $explode = explode($dot, $file_name);
                //     $file_ext = strtolower(end($explode));
                //     $extensions = array("png", "jpg", "jpeg", "webp");

                //     if (in_array($file_ext, $extensions) === false) {
                //         echo "<h2>This format is not allowed, Please insert JPG or PNG File</h2>";
                //     } else if ($file_size >= 2097152) {
                //         echo "<h2>File size must be less than or equal to 2mb</h2>";
                //     } else {
                //         move_uploaded_file($file_tmp, "upload/" . $file_name);
                //         $check = true;
                //     }
                // }

                // if (isset($_FILES['new_image'])) {
                //     $check = false;
                //     // $errors = array();

                //     $file_name = $_FILES['new_image']['name'];
                //     $file_size = $_FILES['new_image']['size'];
                //     $file_tmp = $_FILES['new_image']['tmp_name'];
                //     $file_type = $_FILES['new_image']['type'];
                //     $dot = '.';
                //     // explode : convert string into array by delimiter that you want to pass
                //     $explode = explode($dot, $file_name);
                //     $file_ext = strtolower(end($explode));
                //     // $file_ext = strtolower($explode[1]);
                //     // print_r($file_ext);
                //     $extensions = array("jpg", "jpeg", "png", "webp");

                //     if (in_array($file_ext, $extensions) === false) {
                //         echo "<h2>This format is not allowed, Please insert JPG or PNG File</h2>";
                //         // die();
                //         // $error = (array("This format is not allowed, Please insert JPG or PNG File"));
                //         // echo $error[0];
                //         // array_push($errors,"This format is not allowed, Please insert JPG or PNG File");
                //         // echo "<h2>This format is not allowed, Please insert JPG or PNG File</h2>";
                //     } else if ($file_size >= 2097152) {
                //         echo "<h2>File size must be less than or equal to 2mb</h2>";
                //         // die();
                //     } else {
                //         move_uploaded_file($file_tmp, "upload/" . $file_name);
                //         $check = true;
                //         // echo "<h2>Successfully Insert Image</h2>";
                //     }
                // }
                // if (isset($_POST['submit']) && $check === true) {
                //     $post_title = $_POST['post_title'];
                //     $postdesc = $_POST['postdesc'];
                //     $category = $_POST['category'];
                //     $date = date("d M, Y");


                //     if ($file_name == "") {
                //         echo $update = "UPDATE post SET title='$post_title',description='$postdesc',category='$category',post_date='$date' WHERE post_id = $id";
                //     } else {
                //         echo $update = "UPDATE post SET title='$post_title',description='$postdesc',category='$category',post_date='$date',post_img='$file_name' WHERE post_id = $id";
                //     }
                // }
                ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>