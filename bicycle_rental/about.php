<?php

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

</head>
<body>
    
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header ends -->

    <section class="about">

        <div class="image">
            <img src="img/bg2.jpg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Bike Rental System is a fun, free, and trusted way to rent instantly online. We are a leading website and first marketplace platform in Mumbai City. Join thousands of others on the Bike Rental System to rent the bicylce you always like. Doing your rentals online is safe and convenient. 
We provide a user-friendly website where users can find and book a wide range of bicycles online. The company guarantees the best at affordable prices with verified reviews from previous renters and no booking fees!
The company aims a clean and green environment through promoting the usage of bicycles. With bicycles, you can have a richer travel experience than you will get with other vehicles. You can visit all of the hidden and beautiful places without harming the environment</p>
            <p>Bike Rental System is dedicated to bringing the best bicycle rentals online experience to everyone. The company targets to make renting online fun and memorable experiences for all. Join our community and rent today!</p>
            <div class="icons-container">
                <div class="icons">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>affordable price</span>
                </div>
                <div class="icons">
                    <i class="fas fa-headset"></i>
                    <span>24/7 service</span>
                </div>
            </div>
        </div>
    </section>

<!-- Reviews Section -->
<section class="reviews">
    <div class="main">
            <div class="slide">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>                   
                </div>
                <p>It is much easier to book a bicycle</p>
                <h3>john deo</h3>
                <img src="img/male_user.jpg" alt="">
            </div>
            <div class="slide">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>                    
                </div>
                <p>When i needed it most, it was more convenient</p>
                <h3>sarah kent</h3>
                <img src="img/female_user.jpg" alt="">
            </div>
        </div>
        <div class="main">
            <div class="slide">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>The website saves me a lot of time</p>
                <h3>julie mary</h3>
                <img src="img/female_user.jpg" alt="">
            </div>
            <div class="slide">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>                    
                </div>
                <p>The user interface is simple, which makes it easy to navigate </p>
                <h3>jack wilson</h3>
                <img src="img/male_user.jpg" alt="">
            </div>
        </div>
</section>
<!-- Footer Section -->
<?php 
        include 'components/footer.php';    
    ?>
    <!-- footer section ends -->
</body>
</html>