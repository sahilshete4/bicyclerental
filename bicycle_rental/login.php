<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
}
if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
 
    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $select_users->execute([$email, $pass]);
    $row = $select_users->fetch(PDO::FETCH_ASSOC);
 
    if($select_users->rowCount() > 0){
       setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
       header('location:home.php');
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
    <link rel="stylesheet" href="css/user_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/multiselect-dropdown.js"></script>
    <script src="scripts/index1.js"></script>
    <title>Login</title>
</head>
<body>
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header ends -->
    <section class="form-container">
   <form action="" method="post">
      <h3>welcome back!</h3>
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="enter your password" class="box">
      <p>don't have an account? <a href="register.html">register new</a></p>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>
</section>
    <!-- login section starts -->
    <!-- login section ends -->  
    <!-- Footer Section -->
    <?php 
        include 'components/footer.php';    
    ?>
    <!-- Footer ends -->  
    <!-- sweetalert cdn link -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
include 'components/message.php';
?>
</body>
</html>