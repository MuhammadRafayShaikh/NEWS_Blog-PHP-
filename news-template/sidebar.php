<?php
require 'admin/config.php';

$current_date = date("d M, Y");

$last_date = date("d M, Y", strtotime('-1 days'));
$select = "SELECT * FROM post LEFT JOIN user ON post.author = user.user_id LEFT JOIN category ON post.category = category.category_id WHERE post.post_date BETWEEN '$last_date' AND '$current_date' ORDER BY post.post_id DESC LIMIT 0,4";

$result = mysqli_query($conn, $select);
?>

<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {


        ?>
                <div class="recent-post">
                    <a class="post-img" href="">
                        <img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" />
                    </a>
                    <div class="post-content">
                        <h5><a href="single.php?id=<?php echo $row['post_id'] ?>"><?php echo $row['title'] ?></a></h5>
                        <span>
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            <a href='category.php'><?php echo $row['category_name'] ?></a>
                        </span>
                        <span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo $row['post_date'] ?>
                        </span>
                        <a class="read-more" href="single.php?id=<?php echo $row['post_id'] ?>">read more</a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<h2>Not Found Latest NEWS</h2>";
        }
        ?>
    </div>
    <!-- /recent posts box -->
</div>