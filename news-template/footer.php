<?php

require 'admin/config.php';

$select = "SELECT * FROM setting";

$result = mysqli_query($conn, $select);

$row = mysqli_fetch_assoc($result);

?>

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span><?php echo $row['footer'] ?></span>
            </div>
        </div>
    </div>
</div>
</body>
<a href="https://muhammadrafayshaikh.github.io/Monument/" target="blank"></a>
</html>