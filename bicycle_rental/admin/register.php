<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   // header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admins->execute([$name]);

   if($select_admins->rowCount() > 0){
      $warning_msg[] = 'Username already taken!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(id, name, password) VALUES(?,?,?)");
         $insert_admin->execute([$id, $name, $c_pass]);
         $success_msg[] = 'Registered successfully!';
         header('location:login.php');
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="../scripts/index1.js"></script>
</head>
<body style="padding-left: 0;">

<!-- login section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>register new</h3>
      <input type="text" name="name" placeholder="enter username" maxlength="20" class="box" required >
      <input type="password" name="pass" placeholder="enter password" maxlength="20" class="box" required >
      <input type="password" name="c_pass" placeholder="confirm password" maxlength="20" class="box" required >
      <input type="submit" value="register now" name="submit" class="btn">
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
