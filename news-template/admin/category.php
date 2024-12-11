<?php include "header.php";

require "config.php";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$limit = 3;

$offset = ($page - 1) * $limit;


if ($_SESSION['role'] == 0) {
    header("Location: post.php");
} ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php

                $select = "SELECT * FROM category ORDER BY category_id DESC LIMIT $offset,$limit";

                $result = mysqli_query($conn, $select);

                if (mysqli_num_rows($result) > 0) {

                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Category Name</th>
                            <th>No. of Posts</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td class='id'><?php echo $no ?></td>
                                    <td><?php echo $row['category_name'] ?></td>
                                    <td><?php echo $row['post'] ?></td>
                                    <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php
                                $no++;
                            } ?>
                        </tbody>
                    </table>
                <?php } ?>


                <?php

                $select2 = "SELECT * FROM category";
                $result2 = mysqli_query($conn, $select2);
                if (mysqli_num_rows($result2) > 0) {

                    $total_records = mysqli_num_rows($result2);

                    $total_pages = ceil($total_records / $limit);

                    $current_page = basename($_SERVER['PHP_SELF']);

                    $page_incre = "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        $prev = $page - 1;
                        $page_incre .= "<li><a href=$current_page?page=$prev>Prev</a></li>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($page == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        $page_incre .= "<li class=$active><a href=$current_page?page=$i>$i</a></li>";
                    }
                    if ($page < $total_pages) {
                        $next = $page + 1;
                        $page_incre .= "<li><a href=$current_page?page=$next>Next</a></li>";
                    }
                    $page_incre .= "</ul>";
                    echo $page_incre;
                }

                ?>

            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>