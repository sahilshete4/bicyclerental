<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
    header('location:login.php');
}

$select_admins = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
$select_admins->execute([$admin_id]);
$fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
      $success_msg[] = 'name updated!';
      
   }

   

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $fetch_admins['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $warning_msg[] = 'old password not matched!';
      }elseif($new_pass != $c_pass){
         $warning_msg[] = 'confirm passowrd not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_pass->execute([$c_pass, $admin_id]);
            $success_msg[] = 'password updated successfully!';
         }else{
            $warning_msg[] = 'please enter new password!';
         }
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="../css/admin_style1.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="../scripts/index1.js"></script>
</head>
<body style="padding-left: 0;">

<!-- login section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>update profile</h3>
      <input type="text" name="name" placeholder="<?= $fetch_admins['name']; ?>" maxlength="20" class="box">
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="20" class="box">
      <input type="password" name="new_pass" placeholder="enter new password" maxlength="20" class="box">
      <input type="password" name="c_pass" placeholder="confirm new password" maxlength="20" class="box">
      <input type="submit" value="update now" name="submit" class="btn">
   </form>

</section>

<!-- login section ends -->
    







   <!-- sweetalert cdn link -->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 

include '../components/message.php';

?>














</body>
</html>
