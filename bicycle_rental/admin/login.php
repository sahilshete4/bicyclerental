<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
   //  header('location:login.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
 
    $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1");
    $select_admins->execute([$name, $pass]);
    $row = $select_admins->fetch(PDO::FETCH_ASSOC);
 
    if($select_admins->rowCount() > 0){
       setcookie('admin_id', $row['id'], time() + 60*60*24*30, '/');
       header('location:dashboard.php');
    }else{
       $warning_msg[] = 'Incorrect username or password!';
    }
 
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="../scripts/index1.js"></script>
</head>
<body style="padding-left: 0;">

<!-- login section starts  -->

<section class="form-container" style="min-height: 100vh;">

   <form action="" method="POST">
      <h3>welcome back!</h3>
      <input type="text" name="name" placeholder="enter username" maxlength="20" class="box" required>
      <input type="password" name="pass" placeholder="enter password" maxlength="20" class="box" required>
      <input type="submit" value="login now" name="submit" class="btn">
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
