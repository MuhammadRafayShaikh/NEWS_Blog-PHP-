<?php include "header.php";

require "config.php";

$select = "SELECT * FROM setting";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($result);




?>
<style>
    img {
        height: 200px;
        width: 100%;
    }
</style>
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
                        <label for="post_title">Website Name</label>
                        <input type="text" name="web_name" class="form-control" value="<?php echo $row['website_name'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Website Logo</label>
                        <input type="file" name="new_img">
                        <img src="images/<?php echo $row['logo'] ?>" alt="">
                        <input type="hidden" name="old_img" value="<?php echo $row['logo'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Footer Description</label>
                        <textarea name="footer_desc" class="form-control" rows="5"><?php echo $row['footer'] ?></textarea>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->

                <?php

                if (isset($_POST['submit'])) {
                    if (empty($_FILES['new_img']['name'])) {
                        $file_name = $_POST['old_img'];
                    } else {
                        $check = false;
                        $file_name = $_FILES['new_img']['name'];
                        $file_size = $_FILES['new_img']['size'];
                        $file_type = $_FILES['new_img']['type'];
                        $file_tmp = $_FILES['new_img']['tmp_name'];
                        $explode = explode(".", $file_name);
                        $file_extension = strtolower(end($explode));
                        $extensions = array("jpg", "jpeg", "png", "webp");

                        if (in_array($file_extension, $extensions) === false) {
                            echo "<h2>Unsupported file format, Please select JPG or PNG file</h2>";
                            exit();
                        } else if ($file_size >= 2097152) {
                            echo "<h2>File size must less than or equal to 2mb</h2>";
                            exit();
                        } else {
                            move_uploaded_file($file_tmp, "images/" . $file_name);
                        }
                    }


                    $web_name = $_POST['web_name'];
                    $footer_desc = $_POST['footer_desc'];

                    $update = "UPDATE setting SET website_name='$web_name',logo='$file_name',footer='$footer_desc' WHERE 1";

                    $result = mysqli_query($conn, $update);

                    if ($result) {
                        echo "<script>Successfully Update</script>";
                        header("Location: setting.php");
                        exit();
                    } else {
                        echo "<h2>Not Update</h2>";
                    }
                }


                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>