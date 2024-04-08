<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
}

include 'components/req_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_style.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/ultiselect-dropdown.js"></script>
    <script src="scripts/index1.js"></script>
    <title>Bicycle Rental</title>
</head>
<body>
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>

    <!-- Header ends -->

    <!-- home section starts -->

    <section class="home" id="home">
        <div class="rightbox">
        <h1 class="h-primary">Get A Chance To Ride Your Favourite Bike.</h1>
    </div>
    <a href="#listings" class="btn1">Rent Now</a>

    
</section>



    <!-- home section ends -->

    <!-- about section starts -->

    <section class="home-about">
        <div class="image">
            <img src="img/bg2.jpg" alt="about">
        </div>

        <div class="content">
            <h2>about us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum commodi velit natus aliquam cumque, illo possimus deleniti in sed nobis!
            </p>
            <a href="about.php" class="abt-btn">read more</a>
        </div>
    </section>

    <!-- about section ends -->

    <!-- list section starts -->

    <section class="listings" id="listings" >
        <h1>latest listings</h1>
        <div class="box-container">

        <?php 
            $select_listings = $conn->prepare("SELECT * FROM `bicycle` ORDER BY date DESC LIMIT 5");
            $select_listings->execute();
            if ($select_listings->rowCount() > 0) {
                while ($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)) {
                    # code...
                $bicycle_id = $fetch_listing['id'];

                $select_users = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
                $select_users->execute([$fetch_listing['admin_id']]);
                $fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);                
        ?>
        <form action="" method="POST" class="box">
            
            <input type="hidden" name="bicycle_id" value="<?= $bicycle_id; ?>">
            <div class="thumb">
                <img src="uploaded_file/<?= $fetch_listing['image_01']; ?>" alt="">
            </div>
            <div class="admin">
                <h3><?= substr($fetch_users['name'], 0, 1);?></h3>
                <div>
                    <p><?= $fetch_users['name'];?></p>
                    <span><?= $fetch_listing['date'];?></span>
                </div>
            </div>           
                <p class="price"><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_listing['price'];?>/day</span></p>
                <p class="status"><span><?= $fetch_listing['status'];?></span></p>
                <h3 class="name"><?= $fetch_listing['bicycle_name'];?></h3>
                <p>From<input type="date" name="from_date" required></p>
                <p>To<input type="date" name="to_date" required></p>
                

            
            <div class="flex-btn">
                
                <input type="submit" value="book" name="send" class="btn">
            </div>
        </form>
        <?php 
        }}
    else {
        echo '<p class="empty">no property listed yet!</p>';
    }
        ?>
        </div>
    </section>
    
    <!-- list section ends -->
    
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