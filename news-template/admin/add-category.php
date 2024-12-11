<?php

include "header.php";
require "config.php";

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->

                <?php

                if (isset($_POST['save'])) {
                    $cat = mysqli_real_escape_string($conn, $_POST['cat']);

                    $select = "SELECT category_name FROM category WHERE category_name = '$cat'";

                    $result = mysqli_query($conn, $select);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<h2>Category already exist</h2>";
                    } else {
                        $insert = "INSERT INTO category(category_name) VALUES ('$cat')";
                        $result = mysqli_query($conn, $insert);
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