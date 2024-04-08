<?php
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

include 'components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
    header('location:login.php');
}

if(isset($_POST['delete'])){

    $delete_id = $_POST['request_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
 
    $verify_delete = $conn->prepare("SELECT * FROM `requests` WHERE id = ?");
    $verify_delete->execute([$delete_id]);
 
    if($verify_delete->rowCount() > 0){
       $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ?");
       $delete_request->execute([$delete_id]);
       $success_msg[] = 'booking cancelled successfully!';
    }else{
       $warning_msg[] = 'request deleted already!';
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
    <title>My bookings</title>
</head>
<body>
    

    <!-- req received sec -->
        <section class="requests">
            <h1>My bookings</h1>
            <div class="box-container">
            <?php
      $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
      $select_requests->execute([$admin_id]);
      if($select_requests->rowCount() > 0){
         while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

        $select_sender = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_sender->execute([$fetch_request['sender']]);
        $fetch_sender = $select_sender->fetch(PDO::FETCH_ASSOC);

        $select_property = $conn->prepare("SELECT * FROM `bicycle` WHERE id = ?");
        $select_property->execute([$fetch_request['bicycle_id']]);
        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);

        $select_date = $conn->prepare("SELECT * FROM `requests` WHERE id = ?");
        $select_date->execute([$fetch_request['id']]);
        $fetch_date = $select_date->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="box">
            <p>name : <span><?= $fetch_sender['name'];?></span></p>
            <p>number : <a href="tel:<?= $fetch_sender['number'];?>"><?= $fetch_sender['number'];?></a></p>
            <p>email : <a href="tel:<?= $fetch_sender['email'];?>"><?= $fetch_sender['email'];?></a></p>
      <p>enquiry for : <span><?= $fetch_property['bicycle_name']; ?></span></p>
      <p>from date : <span><?= $fetch_date['from_date']; ?></span></p>
      <p>to date : <span><?= $fetch_date['to_date']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
         <input type="submit" value="cancel booking" class="btn" onclick="return confirm('cancel this booking?');" name="delete">
         
      </form>
      </div>
   <?php
    }
   }else{
      echo '<p class="empty">you have no bookings!</p>';
   }
   ?>
            </div>

        </section>
    <!-- req received sec -->
    
    
    
    <!-- sweetalert cdn link -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 

include 'components/message.php';

?>

</body>

</html>