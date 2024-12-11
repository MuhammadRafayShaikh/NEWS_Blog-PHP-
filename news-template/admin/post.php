<?php

include "header.php";

require "config.php";

$limit = 3;
if (isset($_GET['id'])) {
    $page = $_GET['id'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                if ($_SESSION['role'] == '1') {
                    $select = "SELECT post.post_id, post.title, post.description, post.post_date, category.category_name, user.username, post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    ORDER BY post.post_id
                    DESC LIMIT $offset,$limit";
                } else if ($_SESSION['role'] == '0') {
                    $select = "SELECT post.post_id, post.title, post.description, post.post_date, category.category_name, user.username, post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE post.author = {$_SESSION['user_id']}
                    ORDER BY post.post_id
                    DESC LIMIT $offset,$limit";
                }
                $result = mysqli_query($conn, $select);
                if (mysqli_num_rows($result)) {



                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td class='id'><?php echo $no ?></td>
                                    <td><?php echo $rows['title'] ?></td>
                                    <td><?php echo $rows['category_name'] ?></td>
                                    <td><?php echo $rows['post_date'] ?></td>
                                    <td><?php echo $rows['username'] ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $rows['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo $rows['post_id'] ?>&cat_id=<?php echo $rows['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } ?>

                <?php

                $select2 = "SELECT * FROM post";
                $result2 = mysqli_query($conn, $select2);
                if (mysqli_num_rows($result2) > 0) {

                    $total_records = mysqli_num_rows($result2);

                    $total_pages = ceil($total_records / $limit);

                    $current_page = basename($_SERVER['PHP_SELF']);

                    $page_incre = "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        $prev = $page - 1;
                        $page_incre .= "<li><a href=$current_page?id=$prev>Prev</a></li>";
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        $page_incre .= "<li class='$active'><a href=$current_page?id=$i>$i</a></li>";
                    }
                    if ($page < $total_pages) {
                        $next = $page + 1;
                        $page_incre .= "<li><a href=$current_page?id=$next>Next</a></li>";
                    }
                    $page_incre .= "</ul>";
                }

                echo $page_incre;
                ?>

                <!-- <li class="active"><a>1</a></li>

                 -->

            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>