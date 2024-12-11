<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" name="btn">
    </form>
    <?php 
    
    if(isset($_POST['btn'])){
        $image = $_FILES['image'];

        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }
    
    ?>
</body>

</html>