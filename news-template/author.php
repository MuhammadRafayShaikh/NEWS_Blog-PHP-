<?php include 'header.php';

require 'admin/config.php';

$aut = $_GET['aid'];

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 3;
$offset = ($page - 1) * $limit;



$select2 = "SELECT * FROM post LEFT JOIN user ON post.author = user.user_id WHERE author = $aut";

$result2 = mysqli_query($conn, $select2);

$row2 = mysqli_fetch_assoc($result2);

?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <h2 class="page-heading"><?php echo $row2['username'] ?></h2>
                    <?php

                    $select = "SELECT * FROM post LEFT JOIN category ON post.category = category.category_id LEFT JOIN user ON post.author = user.user_id WHERE author = $aut LIMIT $offset,$limit";

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
                                            <h3><a href="single.php?id=<?php echo $row['post_id'] ?>"><?php echo $row['title'] ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?aid=<?php echo $row['user_id'] ?>'><?php echo $row['username'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date'] ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 100) ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php

                        }
                    }
                    ?>

                    <?php


                    if (mysqli_num_rows($result2) > 0) {
                        $total_records = mysqli_num_rows($result2);

                        $total_pages = ceil($total_records / $limit);


                        $current_page = basename($_SERVER['PHP_SELF']);

                        $page_incre = "<ul class='pagination'>";
                        if ($page > 1) {
                            $prev = $page - 1;
                            $page_incre .= "<li><a href='$current_page?aid=$aut&page=$prev'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($page == $i) {
                                $active = "active";
                            } else {
                                $active = "";
                            }
                            $page_incre .= "<li class=$active><a href='$current_page?aid=$aut&page=$i'>$i</a></li>";
                        }
                        if ($page < $total_pages) {
                            $next = $page + 1;
                            $page_incre .= "<li><a href='$current_page?aid=$aut&page=$next'>Next</a></li>";
                        }
                        $page_incre .= "</ul>";

                        echo $page_incre;
                    }

                    ?>


                    <!-- <li class="active"><a href="">1</a></li>

                    <li><a href="">3</a></li>
                    </ul> -->
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>