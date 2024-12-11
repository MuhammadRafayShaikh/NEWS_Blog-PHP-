<?php

require 'admin/config.php';

$page = basename($_SERVER['PHP_SELF']);

switch ($page) {

    case 'single.php':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $select_t = "SELECT * FROM post WHERE post_id = $id";
            $result = mysqli_query($conn, $select_t);
            $row_t = mysqli_fetch_assoc($result);
            $page_title = $row_t['title'];
        } else {
            $page_title = "Not Found";
        }
        break;

    case 'author.php':
        if (isset($_GET['aid'])) {
            $id = $_GET['aid'];
            $select_t = "SELECT * FROM user WHERE user_id = $id";
            $result = mysqli_query($conn, $select_t);
            $row_t = mysqli_fetch_assoc($result);
            $page_title = 'News By ' . $row_t['first_name'] . ' ' . $row_t['last_name'];
        } else {
            $page_title = "Not Found";
        }
        break;

    case 'category.php':
        if (isset($_GET['cid'])) {
            $id = $_GET['cid'];
            $select_t = "SELECT * FROM category WHERE category_id = $id";
            $result = mysqli_query($conn, $select_t);
            $row_t = mysqli_fetch_assoc($result);
            $page_title = $row_t['category_name'] . " News";
        } else {
            $page_title = "Not Found";
        }
        break;

    case 'search.php':
        if (isset($_GET['search'])) {
            $page_title = $_GET['search'];
        } else {
            $page_title = "Not Found";
        }
        break;


    default:
        $page_title = "News Blog";
        break;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <?php

                    $select = "SELECT * FROM setting";
                    $result = mysqli_query($conn, $select);
                    $row = mysqli_fetch_assoc($result);

                    ?>
                    <a href="index.php" id="logo"><img src="admin/images/<?php echo $row['logo'] ?>"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php

                    if (isset($_GET['cid'])) {
                        $cid = $_GET['cid'];
                    }

                    $select = "SELECT * FROM category WHERE post >= 1";

                    $result = mysqli_query($conn, $select);

                    if (mysqli_num_rows($result) > 0) {
                    ?>
                        <ul class='menu'>
                            <?php
                            if (!isset($_GET['cid'])) {
                                $home = "active";
                            }
                            ?>
                            <li><a class="<?php echo $home ?>" href='index.php'>HOME</a></li>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($_GET['cid'])) {
                                    if ($row['category_id'] == $cid) {
                                        $select = "active";
                                    } else {
                                        $select = "";
                                    }
                                }
                            ?>
                                <li><a class="<?php echo $select ?>" href='category.php?cid=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a></li>
                            <?php
                            } ?>
                        </ul>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->