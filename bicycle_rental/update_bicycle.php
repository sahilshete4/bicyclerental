<?php

include 'components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
}else {
    $get_id = '';
    header('location:home.php');
}

if (isset($_POST['update'])) {
    $update_id = $_POST['bicycle_id'];
    $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
    $bicycle_name = $_POST['bicycle_name'];
   $bicycle_name = filter_var($bicycle_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $old_image_01 = $_POST['old_image_01'];
   $old_image_01 = filter_var($old_image_01, FILTER_SANITIZE_STRING);
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_file/'.$rename_image_01;

    if (!empty($image_01)) {
        if($image_01_size > 2000000){
            $warning_msg[] = 'image 01 size is too large';
        }else{
            $update_image_01=$conn->prepare("UPDATE `bicycle` SET image_01 = ? WHERE id = ?");
            $update_image_01->execute([$rename_image_01, $update_id]);
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            if ($old_image_01 != '') {
                unlink('uploaded_file/'.$old_image_01);
            }
        }
    }


    
     $update_listing = $conn->prepare("UPDATE `bicycle` SET bicycle_name = ?, price = ?, status = ? WHERE id=?");
     $update_listing->execute([$bicycle_name, $price, $status, $update_id]);

     $success_msg[] = 'listing updated!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/multiselect-dropdown.js"></script>
    <script src="scripts/index1.js"></script>
    <title>Update Bicycle</title>
</head>
<body>
  

    <!-- update bicycle starts -->
    <section class="property-form">

        <?php 
            $select_bicycle = $conn->prepare("SELECT * FROM `bicycle` WHERE id = ? LIMIT 1");
            $select_bicycle->execute([$get_id]);
            if ($select_bicycle->rowCount() > 0) {
                while ($fetch_bicycle = $select_bicycle->fetch(PDO::FETCH_ASSOC)) {

                $bicycle_id = $fetch_bicycle['id'];
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <h2>bicycle details</h2>
            <input type="hidden" name="bicycle_id" value="<?= $bicycle_id;?>">
            <input type="hidden" name="old_image_01" value="<?= $fetch_bicycle['image_01'];?>">
            
            <div class="box">
                <p>bicycle name</p>
                <input type="text" name="bicycle_name" maxlength="50" placeholder="enter bicycle name" class="input" value="<?=$fetch_bicycle['bicycle_name'];?>">
            </div>
            <div class="flex">
            <div class="box">
                <p>price</p>
                <input type="number" name="price" maxlength="10" min="0" max="9999" placeholder="enter bicycle price" class="input" value="<?=$fetch_bicycle['price'];?>">
            </div>
            <div class="box">
                <p>bicycle status</p>
                <select name="status" class="input">
                   
                    <option value="available">available</option>
                    <option value="not available">not available</option>
                </select>
            </div>
            </div>
            <div class="box">
                <p>update image 01</p>
                <img src="uploaded_file/<?= $fetch_bicycle['image_01'];?>" alt="">
                <input type="file" name="image_01" class="input" accept="image/*">
            </div>
            
                
      
      <input type="submit" value="update bicycle" class="btn" name="update">
        </form>

        <?php 
          }
        }else {
            echo '<p class="empty">bicycle not found!</p>';
        }
        ?>
    </section>
    <!-- ub ends -->
    
    
    
    <!-- sweetalert cdn link -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 

include 'components/message.php';

?>

</body>

</html>