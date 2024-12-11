<?php include 'header.php';
require 'admin/config.php';

$id = $_GET['id'];

$select = "SELECT post.post_id, post.title, post.description, post.post_date, post.post_img, user.user_id, user.username, user.role, category.category_id, category.category_name FROM post 
LEFT JOIN category ON post.category = category.category_id
LEFT JOIN user ON post.author = user.username
WHERE post_id = $id";

$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_assoc($result)) {


?>
        <div id="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <!-- post-container -->
                        <div class="post-container">
                            <div class="post-content single-post">
                                <h3><?php echo $row['title'] ?></h3>
                                <div class="post-information">
                                    <span>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <?php echo $row['category_name'] ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <a href='author.php'><?php echo $row['username'] ?></a>
                                    </span>
                                    <span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo $row['post_date'] ?>
                                    </span>
                                </div>
                                <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img'] ?>" alt="" />
                                <p class="description">
                                    <?php echo $row['description'] ?>
                                </p>
                            </div>
                        </div>
                        <!-- /post-container -->
                    </div>
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
    <?php
    }
} else {
    echo "<h2>No Record Found</h2>";
} ?>
        </div>


        <?php include 'footer.php'; ?>