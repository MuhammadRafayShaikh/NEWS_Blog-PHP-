<?php
include "header.php";
require "config.php";

if ($_SESSION['role'] == 0) {
    header("Location: post.php");
}

$limit = 3;
if (isset($_GET['id'])) {
    $page = $_GET['id'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $limit;

echo $offset;

$select = "SELECT * FROM user ORDER BY user_id DESC LIMIT $offset,$limit";

$result = mysqli_query($conn, $select);


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>

            <?php
            if (mysqli_num_rows($result) > 0) {
            ?>
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?> <tr>
                                    <td class='id'><?php echo $no ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php
                                        if ($row['role'] == 1) {
                                            echo 'Admin';
                                        } else {
                                            echo 'Normal';
                                        }

                                        ?></td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php
                            $no++;
                            }
                            ?>

                        </tbody>
                    </table>
                <?php } ?>

                <?php

                $select2 = "SELECT * FROM user";
                $result2 = mysqli_query($conn, $select2);
                if (mysqli_num_rows($result2) > 0) {

                    // echo mysqli_num_rows($result2);
                    $total_records = mysqli_num_rows($result2);

                    $total_pages = ceil($total_records / $limit);

                    $current_page = basename($_SERVER['PHP_SELF']);

                    // echo $current_page;

                    // echo $total_pages;

                    $page_incre = "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        $prev = $page - 1;

                        $page_incre .= "<li><a href='$current_page?id=$prev'>Prev</a></li>";
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        $page_incre .= "<li class='$active'><a href='$current_page?id=$i'>$i</a></li>";
                    }
                    if ($page < $total_pages) {
                        $next = $page + 1;
                        // $page_incre .= "<li><a href'$current_page?id=$pre'>Next</a></li>";
                        $page_incre .= "<li><a href='$current_page?id=$next'>Next</a></li>";
                    }

                    $page_incre .= "</ul>";
                    echo $page_incre;
                }

                ?>

                <!-- <li class="active"><a>1</a></li> -->

                </div>

        </div>
    </div>
</div>
<?php include "header.php"; ?>