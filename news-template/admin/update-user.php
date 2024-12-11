<?php
include "header.php";
require "config.php";


if ($_SESSION['role'] == 0) {
    header("Location: post.php");
}
$id = $_GET['id'];
$select = "SELECT * FROM user WHERE user_id = $id";
$result = mysqli_query($conn, $select);

$row = mysqli_fetch_assoc($result);


?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <form method="POST">
                    <div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id']; ?>">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role">
                            <option value="0" <?php echo ($row['role'] == '0') ? 'selected' : ''; ?>>Normal User</option>
                            <option value="1" <?php echo ($row['role'] == '1') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                </form>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>

<?php if (isset($_POST['submit'])) {
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $update2 = "UPDATE user SET first_name='$f_name', last_name='$l_name', username='$username', role=$role WHERE user_id = $id";

    $result2 = mysqli_query($conn, $update2);

    if ($result2) {
        header("location: users.php");
        exit();
    } else {
        echo "<h2>Something Went Wrong</h2>";
    }
}
mysqli_close($conn);
?>

<?php include "footer.php"; ?>