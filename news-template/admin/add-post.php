<?php include "header.php";

require "config.php";

if (isset($_FILES['fileToUpload'])) {
    $check = false;
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
        $check = true;
        // echo "<h2>Successfully Insert Image</h2>";
    }
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select name="category" class="form-control">
                            <option value="" disabled> Select Category</option>
                            <?php

                            $select = "SELECT * FROM category";

                            $result = mysqli_query($conn, $select) or die("Query Failed");

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <option value="<?php echo $row['category_id'] ?>" selected><?php echo $row['category_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Post image</label>
                        <input type="file" name="fileToUpload" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->
                <?php

                if (isset($_POST['submit']) && $check === true) {
                    // session_start();
                    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);   
                    $postdesc = mysqli_real_escape_string($conn, $_POST['postdesc']);
                    $category = mysqli_real_escape_string($conn, $_POST['category']);
                    $post_date = date("d M, Y");
                    $author = $_SESSION['user_id'];

                    $sql = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES ('$post_title','$postdesc','$category','$post_date','$author','$file_name');";

                    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = $category";

                    $result = mysqli_multi_query($conn, $sql) or die("Query Failed");

                    if ($result) {
                        header("Location: post.php");
                    } else {
                        echo "<h2>Failed to Insert Post</h2>";
                    }
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>