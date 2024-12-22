<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   // setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
}

if(isset($_POST['cancel'])){

   $booking_id = $_POST['booking_id'];
   $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);
   // echo '<pre>';
   //    print_r($_POST);
   //    echo '</pre>';
   //    exit;

   $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE id = ?");
   $verify_booking->execute([$booking_id]);

   if($verify_booking->rowCount() > 0){
      $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE id = ?");
      $delete_booking->execute([$booking_id]);
      $success_msg[] = 'booking cancelled successfully!';
   }else{
      $warning_msg[] = 'booking cancelled already!';
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookings</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- booking section starts  -->

<section class="bookings">

   <h1 class="heading">my bookings</h1>

   <div class="box-container">

   <?php
      // Prepare a JOIN query to get user data along with booking details
      $select_bookings = $conn->prepare(
         "SELECT u.id, u.name, u.email, u.phone, b.id AS booking_id, b.room_id, b.check_in_date, b.check_out_date, b.payment_status, b.payment_type, b.status AS booking_status 
          FROM `users` u
          JOIN `bookings` b ON u.id = b.user_id
          WHERE u.id = ?"
      );
      
      // Execute the query with the user_id
      $select_bookings->execute([$user_id]);
      
      // Check if any bookings are found
      if ($select_bookings->rowCount() > 0) {
         while ($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)) {
   ?>
   
   <div class="box">
      <!-- Displaying user data -->
      <p>User Name: <span><?= $fetch_booking['name']; ?></span></p>
      <p>User Email: <span><?= $fetch_booking['email']; ?></span></p>
      <p>User Phone: <span><?= $fetch_booking['phone']; ?></span></p>

      <!-- Displaying booking details -->
      <p>Room ID: <span><?= $fetch_booking['room_id']; ?></span></p>
      <p>Check-in Date: <span><?= $fetch_booking['check_in_date']; ?></span></p>
      <p>Check-out Date: <span><?= $fetch_booking['check_out_date']; ?></span></p>
      <p>Payment Status: <span><?= $fetch_booking['payment_status']; ?></span></p>
      <p>Payment Type: <span><?= $fetch_booking['payment_type']; ?></span></p>
      <p>Booking Status: <span><?= $fetch_booking['booking_status']; ?></span></p>

      <!-- Cancel booking form -->
      <form action="" method="POST">
         <input type="hidden" name="booking_id" value="<?= $fetch_booking['booking_id']; ?>">
         <input type="submit" value="Cancel Booking" name="cancel" class="btn" onclick="return confirm('Are you sure you want to cancel this booking?');">
      </form>
   </div>
   
   <?php
         }
      } else {
   ?>   
      <div class="box" style="text-align: center;">
         <p style="padding-bottom: .5rem; text-transform:capitalize;">No bookings found!</p>
         <a href="index.php#reservation" class="btn">Book New</a>
      </div>
   <?php
      }
   ?>
</div>


</section>

<!-- booking section ends -->


























<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>