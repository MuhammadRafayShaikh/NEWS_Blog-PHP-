<?php

include 'header.php';
require 'admin/config.php';

$search = mysqli_real_escape_string($conn, $_GET['search']);



if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($conn, (int)$_GET['page']);
} else {
    $page = 1;
}

$limit = 2;
$offset = ($page - 1) * $limit;

?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <h2 class="page-heading">Search : <?php echo htmlspecialchars($search); ?></h2>
                    <?php

                    $select = "SELECT * FROM post LEFT JOIN user ON post.author = user.user_id LEFT JOIN category ON post.category = category.category_id WHERE post.title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' || post.description LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' ORDER BY post.post_id DESC LIMIT $offset, $limit";

                    $result = mysqli_query($conn, $select);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo htmlspecialchars($row['title']); ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo htmlspecialchars($row['category']) ?>'><?php echo htmlspecialchars($row['category_name']); ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?aid=<?php echo htmlspecialchars($row['author']) ?>'><?php echo htmlspecialchars($row['username']); ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo htmlspecialchars($row['post_date']); ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo htmlspecialchars($row['description']); ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<h2>No Search Found</h2>";
                    }
                    ?>

                    <?php

                    $select2 = "SELECT * FROM post WHERE post.title LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
                    $result2 = mysqli_query($conn, $select2);

                    if (mysqli_num_rows($result2) > 0) {
                        $total_records = mysqli_num_rows($result2);

                        // $total_records = $row2['total'];

                        $total_pages = ceil($total_records / $limit);

                        $current_page = basename($_SERVER['PHP_SELF']);

                        $page_incre = "<ul class='pagination'>";
                        if ($page > 1) {
                            $prev = $page - 1;
                            $page_incre .= "<li><a href='$current_page?page=$prev&search=" . urlencode($search) . "'>Previous</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($page == $i) ? "active" : "";
                            $page_incre .= "<li class='$active'><a href='$current_page?page=$i&search=" . urlencode($search) . "'>$i</a></li>";
                        }
                        if ($page < $total_pages) {
                            $next = $page + 1;
                            $page_incre .= "<li><a href='$current_page?page=$next&search=" . urlencode($search) . "'>Next</a></li>";
                        }
                        $page_incre .= "</ul>";

                        echo $page_incre;
                    }

                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>