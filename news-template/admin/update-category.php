<?php include "header.php";
if ($_SESSION['role'] == 0) {
    header("Location: post.php");
}

$id = $_GET['id'];

$select = "SELECT * FROM category WHERE category_id = $id";

$result = mysqli_query($conn, $select);

$row = mysqli_fetch_assoc($result);
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading"> Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="cat_id" class="form-control" value="<?php echo $row['category_id'] ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name'] ?>" placeholder="" required>
                    </div>
                    <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                </form>

                <?php

                if (isset($_POST['sumbit'])) {
                    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);

                    $select = "SELECT category_name FROM category WHERE category_name = '$cat_name'";

                    $result = mysqli_query($conn, $select);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<h2>Category already exist</h2>";
                    } else {
                        $update = "UPDATE category SET category_name='$cat_name' WHERE category_id = $id";
                        $result = mysqli_query($conn, $update);
                        if ($result) {
                            header("Location: category.php");
                        } else {
                            echo "<h2>Something Went Wrong</h2>";
                        }
                    }
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>