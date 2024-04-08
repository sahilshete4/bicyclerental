<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
    header('location:login.php');
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
    
    <title>Dashboard</title>
</head>
<body>
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header ends -->
    <!-- dashboard section starts -->
    <section class="dashboard">
        <h1>dashboard</h1>
        <div class="box-container">
            <div class="box">
            <?php 
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
                $select_user->execute([$user_id]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
            ?>
            <h3>Welcome!</h3>
            <p><?= $fetch_user['name'];?></p>
            <a href="update.php" class="d-btn">update profile</a>
            </div>          
        </div>
    </section>
    <!-- dashboard section ends -->
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