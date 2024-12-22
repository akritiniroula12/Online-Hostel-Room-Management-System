<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   // setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
}


if (isset($_GET['room_id']) && isset($_GET['category_id'])) {
   $room_id = $_GET['room_id'];
   $category_id = $_GET['category_id'];

   $sql = "SELECT * FROM rooms WHERE category_id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$category_id]);
//    while ($room = $stmt->fetch(PDO::FETCH_ASSOC)) {
      
      
//   }
  
   } else {
      echo "No category selected.";
   }

   // rooms
   


   if (isset($_POST['book'])) {
      if (isset($_COOKIE['user_id'])) {
            $user_id = filter_var($_COOKIE['user_id'], FILTER_SANITIZE_NUMBER_INT);
      } else {
            echo "User not logged in. Please log in.";
            header('Location: login.php');
            exit;
      }
      $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
      $room_id = $_POST['room_id'];
      $room_id = filter_var($room_id, FILTER_SANITIZE_STRING);
      $check_in_date = $_POST['check_in_date'];
      $check_in_date = filter_var($check_in_date, FILTER_SANITIZE_STRING);
      $check_out_date = $_POST['check_out_date'];
      $check_out_date = filter_var($check_out_date, FILTER_SANITIZE_STRING);
      $payment_type = $_POST['payment_type'];
      $payment_type = filter_var($payment_type, FILTER_SANITIZE_STRING);

      // echo '<pre>';
      // print_r($_POST);
      // echo '</pre>';
      // exit;
  
      $total_rooms = 0;
  
      // Check availability of the room for the given dates
      $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE room_id = ? AND (check_in_date <= ? AND check_out_date >= ?)");
      $check_bookings->execute([$room_id, $check_out_date, $check_in_date]);
  
      while ($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)) {
          $total_rooms += 1; // Assuming one room per booking
      }
  
      if ($total_rooms > 0) {
          $warning_msg[] = 'Room is not available for the selected dates';
      } else {
          // Verify if the user already has a similar booking
          $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND room_id = ? AND check_in_date = ? AND check_out_date = ? AND payment_type = ?");
          $verify_bookings->execute([$user_id, $room_id, $check_in_date, $check_out_date, $payment_type]);
  
          if ($verify_bookings->rowCount() > 0) {
              $warning_msg[] = 'Room already booked!';
          } else {
              // Insert the booking into the database
              $book_room = $conn->prepare("INSERT INTO `bookings` (user_id, room_id, check_in_date, check_out_date, payment_type) VALUES (?, ?, ?, ?, ?)");
              $book_room->execute([$user_id, $room_id, $check_in_date, $check_out_date, $payment_type]);
              $success_msg[] = 'Room booked successfully!';
          }
      }
  }
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <section class="reservation" id="reservation">

    <form action="" method="post">
   <h3>Make a Reservation</h3>
   <div class="flex">
      <div class="box">
         <p>Your Name <span>*</span></p>
         <input type="text" name="name" maxlength="50" required placeholder="Enter your name" class="input">
      </div>
      <div class="box">
         <p>Your Email <span>*</span></p>
         <input type="email" name="email" maxlength="50" required placeholder="Enter your email" class="input">
      </div>
      <div class="box">
         <p>Your Number <span>*</span></p>
         <input type="number" name="number" maxlength="10" min="0" max="9999999999" required placeholder="Enter your number" class="input">
      </div>
      <div class="box">
         <p>Room <span>*</span></p>
         <select name="room_id" class="input" required>
            <option value="" selected disabled>Select Room</option>
            <?php while ($room = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
               <option value="<?= htmlspecialchars($room['id']) ?>" <?= $room['id'] == $room_id ? 'selected' : '' ?>>
                  <?= htmlspecialchars($room['title']) ?>
               </option>
            <?php endwhile; ?>
         </select>
      </div>
      <div class="box">
         <p>Check In <span>*</span></p>
         <input type="date" name="check_in_date" class="input" required>
      </div>
      <div class="box">
         <p>Check Out <span>*</span></p>
         <input type="date" name="check_out_date" class="input" required>
      </div>
      <div class="box">
         <p>Payment Type <span>*</span></p>
         <select name="payment_type" class="input" required>
            <option value="credit_card" selected>Credit Card</option>
            <option value="cash">Cash</option>
            <option value="online">Online</option>
         </select>
      </div>
      <!-- <div class="box">
         <p>Payment Status <span>*</span></p>
         <select name="payment_status" class="input" required>
            <option value="pending" selected>Pending</option>
            <option value="completed">Completed</option>
            <option value="failed">Failed</option>
         </select>
      </div> -->
      <!-- <div class="box">
         <p>Status <span>*</span></p>
         <select name="status" class="input" required>
            <option value="booked" selected>Booked</option>
            <option value="canceled">Canceled</option>
            <option value="completed">Completed</option>
         </select>
      </div> -->
   </div>
   <input type="submit" value="Book Now" name="book" class="btn">
</form>


</section>
</body>
</html>