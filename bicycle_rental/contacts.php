<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else {
    $user_id = '';
}

if(isset($_POST['send'])){

    $msg_id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);
 
    $verify_contact = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $verify_contact->execute([$name, $email, $number, $message]);
 
    if($verify_contact->rowCount() > 0){
       $warning_msg[] = 'message sent already!';
    }else{
       $send_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
       $send_message->execute([$msg_id, $name, $email, $number, $message]);
       $success_msg[] = 'message send successfully!';
    }
 
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
    <!-- Header Section -->
    <?php include 'components/user_header.php'; ?>

    <!-- Header ends -->
    <!-- <div class="heading">
        <h2>Contact Us</h2>
    </div> -->
    <!-- Contact section starts -->
    <section class="contact">
        <div class="row">
            <div class="image">
                <img src="img/Contact us-rafiki.png" alt="">
            </div>
        <form action="" method="POST">
            <h4>get in touch</h4>
            <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
            <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
            <input type="number" name="number" required maxlength="10" max="9999999999" min="0" placeholder="enter your number" class="box">
            <textarea name="message" id="" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
            <input type="submit" value="send message" name="send" class="btn">
        </form>
    </div>
    </section>
<!-- Contact section ends -->

<!-- faq section starts -->
    <section class="faq" id="faq">
        <h1 class="heading">FAQ</h1>
        <div class="box-container">
            <div class="box active">
            <h3><span>how to cancel booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, assumenda. Quas quisquam alias dicta unde nesciunt, ducimus nihil sint repellendus?</p>
        </div>
            <div class="box">
            <h3><span>how to cancel booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, assumenda. Quas quisquam alias dicta unde nesciunt, ducimus nihil sint repellendus?</p>
        </div>
            <div class="box">
            <h3><span>how to cancel booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, assumenda. Quas quisquam alias dicta unde nesciunt, ducimus nihil sint repellendus?</p>
        </div>
            <div class="box">
            <h3><span>how to cancel booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, assumenda. Quas quisquam alias dicta unde nesciunt, ducimus nihil sint repellendus?</p>
        </div>
        </div>
    </section>
<!-- faq section ends -->








    <!-- sweetalert cdn link -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <?php 

include 'components/message.php';

?>
    <!-- Footer Section starts-->
    <?php 
        include 'components/footer.php';    
    ?>
<!-- footer section ends -->
</body>

</html>