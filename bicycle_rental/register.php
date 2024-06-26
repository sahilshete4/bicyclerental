<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    
    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_email->execute([$email]);

    if ($select_email->rowCount() > 0) {
        $warning_msg[] = 'email already taken!';
    }else {
        if ($pass != $c_pass) {
            $warning_msg[] = 'password not matched!';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, password) VALUES(?,?,?,?,?)");
            $insert_user->execute([$id, $name, $number, $email, $c_pass]);

            if ($insert_user) {
                $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
                $verify_user->execute([$email, $pass]);
                $row = $verify_user->fetch(PDO::FETCH_ASSOC);

                if ($verify_user->rowCount() > 0) {
                    setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
                    header('location:home.php');
                }else {
                    $error_msg[] = 'something went wrong';
                }
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
    <link rel="stylesheet" href="css/user_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/multiselect-dropdown.js"></script>
    <script src="scripts/index1.js"></script>
    <title>Register</title>
</head>
<body>
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>

    <!-- Header ends -->

    <!-- register section starts -->

    <section class="form-container">

   <form action="" method="post">
      <h3>create an account!</h3>
      <input type="tel" name="name" required maxlength="50" placeholder="enter your name" class="box">
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <input type="number" name="number" required min="0" max="9999999999" maxlength="10" placeholder="enter your number" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="enter your password" class="box">
      <input type="password" name="c_pass" required maxlength="20" placeholder="confirm your password" class="box">
      <p>already have an account? <a href="login.html">login now</a></p>
      <input type="submit" value="register now" name="submit" class="btn">
   </form>

</section>

    <!-- register section ends -->
    
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