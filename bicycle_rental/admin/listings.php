<?php
// error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));


include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else {
    $admin_id = '';
    header('location:login.php');
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['bicycle_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `bicycle` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if($verify_delete->rowCount() > 0){
        
        $delete_listing = $conn->prepare("DELETE FROM `bicycle` WHERE id = ?");
        $delete_listing->execute([$delete_id]);
        $success_msg[] = 'listing deleted successfully!';
     }else{
        $warning_msg[] = 'listing deleted already!';
     }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/style1.css"> -->
    <link rel="stylesheet" href="../css/admin_style1.css">

    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai|Bree+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script type="text/javascript" src="/scripts/multiselect-dropdown.js"></script>
    <script src="../scripts/index1.js"></script>
    <title>Listings</title>
</head>
<body>
    
<!-- header sec -->
<?php include '../components/admin_header.php'; ?>
    <!-- header sec -->
    <!-- listing section starts -->
   <section class="listings">
        <h1 class="heading">my listings</h1>
        <div class="box-container">

        <?php 
            $select_listings = $conn->prepare("SELECT * FROM `bicycle` WHERE admin_id = ? ORDER BY date DESC");
            $select_listings->execute([$admin_id]);
            if ($select_listings->rowCount() > 0) {
                while ($fetch_listing = $select_listings->fetch(PDO::FETCH_ASSOC)) {
                    
                $listing_id = $fetch_listing['id'];                
        ?>
        <form action="" method="POST" class="box">
                <input type="hidden" name="bicycle_id" value="<?= $listing_id; ?>">
                <div class="thumb">
                    <!-- <p><i class="far fa-image"></i><span></span></p> -->
                    <img src="../uploaded_file/<?= $fetch_listing['image_01']; ?>" alt="">
                </div>
                <div class="price"><i class="fas fa-indian-rupee-sign"></i><?= $fetch_listing['price'];?>/day</div>
                <div class="status"><?= $fetch_listing['status']?></div>
                <h4 class="name"><?= $fetch_listing['bicycle_name'];?></h4>
                <div class="flex-btn">
                    <a href="../update_bicycle.php?get_id=<?= $listing_id; ?>" class="btn">update</a>
                    <input type="submit" value="delete" name="delete" class="btn" onclick="return confirm('delete this listing?');">
                </div>               
        </form>
        <?php 
            }
        }else {
            echo '<p class="empty">no listings found!</p>';
        }
        ?>
        </div>
    </section>

    <!-- listing ends -->    
    <!-- sweetalert cdn link -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
include '../components/message.php';
?>
</body>
</html>