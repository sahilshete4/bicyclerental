<?php

if(isset($_POST['send'])){

   $select_listings = $conn->prepare("SELECT * FROM `bicycle` ORDER BY date DESC LIMIT 5");
   $select_listings->execute();
   $fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC);

$from_date = $_POST['from_date'];
$from_date = filter_var($from_date, FILTER_SANITIZE_STRING);
$to_date = $_POST['to_date'];
$to_date = filter_var($to_date, FILTER_SANITIZE_STRING);

  
   if($user_id != ''){

      $request_id = create_unique_id();
      $bicycle_id = $_POST['bicycle_id'];
      $bicycle_id = filter_var($bicycle_id, FILTER_SANITIZE_STRING);

      $select_receiver = $conn->prepare("SELECT admin_id FROM `bicycle` WHERE id = ? LIMIT 1");
      $select_receiver->execute([$bicycle_id]);
      $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
      $receiver = $fetch_receiver['admin_id'];

      $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE bicycle_id = ? AND sender = ? AND receiver = ?");
      $verify_request->execute([$bicycle_id, $user_id, $receiver]);

      if(($verify_request->rowCount() > 0)){
         $warning_msg[] = 'request sent already!';
      }elseif($from_date > $to_date){
         $warning_msg[] = 'enter the proper date';
      }
      else{
         $send_request = $conn->prepare("INSERT INTO `requests`(id, bicycle_id, sender, receiver, from_date, to_date) VALUES(?,?,?,?,?,?)");
         $send_request->execute([$request_id, $bicycle_id, $user_id, $receiver, $from_date, $to_date]);
         $success_msg[] = 'request sent successfully!';
      }

   }else{
      $warning_msg[] = 'please login first!';
   }
}

?>