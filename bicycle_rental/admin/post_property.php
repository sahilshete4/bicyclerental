<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
    header('location:login.php');
}

if(isset($_POST['post'])){
    $id = create_unique_id();
   $bicycle_name = $_POST['bicycle_name'];
   $bicycle_name = filter_var($bicycle_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = '../uploaded_file/'.$rename_image_01;

   if($image_01_size > 2000000){
    $warning_msg[] = 'image 01 size too large!';
 }else{
    $insert_property = $conn->prepare("INSERT INTO `bicycle`(id, admin_id, bicycle_name, price, status, image_01) VALUES(?,?,?,?,?,?)"); 
    $insert_property->execute([$id, $admin_id, $bicycle_name, $price, $status, $rename_image_01]);
    move_uploaded_file($image_01_tmp_name, $image_01_folder);
    $success_msg[] = 'bicycle posted successfully!';
 }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style1.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/multiselect-dropdown.js"></script>
    <script src="scripts/index1.js"></script>
    <title>Post property</title>
</head>
<body>
    <!-- header sec -->
    <?php include '../components/admin_header.php'; ?>
    <!-- header sec -->

    <!-- post_p sec starts -->

    <section class="property-form">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>bicycle details</h2>
            <div class="box">
                <p>bicycle name <span>*</span></p>
                <input type="text" name="bicycle_name" maxlength="50" required placeholder="enter bicycle name" class="input">
            </div>
            <div class="flex">
            <div class="box">
                <p>price <span>*</span></p>
                <input type="number" name="price" maxlength="10" min="0" max="9999" required placeholder="enter bicycle price" class="input">
            </div>
            <div class="box">
                <p>bicycle status <span>*</span></p>
                <select name="status" class="input" required>
                    <option value="available">available</option>
                    <option value="not available">not available</option>
                </select>
            </div>
            </div>
            <div class="box">
                <p>image 01 <span>*</span></p>
                <input type="file" name="image_01" class="input" accept="image/*" required>
            </div>
            
      
      <input type="submit" value="post bicycle" class="btn" name="post">
        </form>
    </section>

    <!-- post p sec ends -->
  
    <!-- sweetalert cdn link -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 

include '../components/message.php';

?>

</body>

</html>