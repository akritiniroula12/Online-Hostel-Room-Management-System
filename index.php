<?php

include 'components/connect.php';
include 'components/include.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   // setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:login.php');
}



if(isset($_POST['check'])){

   $check_in = $_POST['check_in'];
   $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);

   $total_rooms = 0;

   $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_in = ?");
   $check_bookings->execute([$check_in]);

   while($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)){
      $total_rooms += $fetch_bookings['rooms'];
   }

   // if the hostel has total 30 rooms 
   if($total_rooms >= 30){
      $warning_msg[] = 'rooms are not available';
   }else{
      $success_msg[] = 'rooms are available';
   }

}



if(isset($_POST['send'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $message = $_POST['message'];
   $message = filter_var($message, FILTER_SANITIZE_STRING);

   $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_message->execute([$name, $email, $number, $message]);

   if($verify_message->rowCount() > 0){
      $warning_msg[] = 'message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$id, $name, $email, $number, $message]);
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
   <title>home</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .about .row {
         display: flex;
         justify-content: center;
         margin-bottom: 20px;
      }

      .card {
         width: 300px;
         border: 1px solid #ddd;
         border-radius: 10px;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         overflow: hidden;
         text-align: center;
      }

      .card-img-top {
         width: 100%;
         height: 200px;
         object-fit: cover;
      }

      .card-body {
         padding: 15px;
      }

      .card-title {
         font-size: 20px;
         margin-bottom: 10px;
      }

      .card-text {
         font-size: 14px;
         color: #555;
         margin-bottom: 15px;
      }

      .btn {
         background-color: #007bff;
         color: #fff;
         border: none;
         padding: 10px 15px;
         text-decoration: none;
         border-radius: 5px;
      }

      .btn:hover {
         background-color: #0056b3;
      }

   </style>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- home section starts  -->

<section class="home" id="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">

         <div class="box swiper-slide">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKdbZp4ZT7gh8XjnzpQBfyXgjq6KSYruOYkK-M1hfHHGPX91dXoqGccVBLHNJAU6i62kU&usqp=CAU" alt="">
            <div class="flex">
               <h3>luxurious rooms</h3>
               <a href="#reservation" class="btn">make a reservation</a>
            </div>
         </div>

         <div class="box swiper-slide">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKdbZp4ZT7gh8XjnzpQBfyXgjq6KSYruOYkK-M1hfHHGPX91dXoqGccVBLHNJAU6i62kU&usqp=CAU" alt="">
            <div class="flex">
               <h3>Best Hostels Rooms in Itahari, Nepal</h3>
               <a href="#reservation" class="btn">make a reservation</a>
            </div>
         </div>

         <!-- <div class="box swiper-slide">
            <img src="images/home-img-3.jpg" alt="">
            <div class="flex">
               <h3>luxurious halls</h3>
               <a href="#contact" class="btn">contact us</a>
            </div>
         </div> -->

      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

   </div>

</section>

<!-- home section ends -->

<!-- availability section starts  -->
<!-- <h2>Hello</h2> -->
<!-- <section class="availability" id="availability">
   <form action="" method="post">
      <div class="flex">
         <div class="box">
            <p>check in <span>*</span></p>
            <input type="date" name="check_in" class="input" required>
         </div>
         <div class="box">
            <p>check out <span>*</span></p>
            <input type="date" name="check_out" class="input" required>
         </div>
         <div class="box">
            <p>adults <span>*</span></p>
            <select name="adults" class="input" required>
               <option value="1">1 adult</option>
               <option value="2">2 adults</option>
               <option value="3">3 adults</option>
               <option value="4">4 adults</option>
               <option value="5">5 adults</option>
               <option value="6">6 adults</option>
            </select>
         </div>
         <div class="box">
            <p>childs <span>*</span></p>
            <select name="childs" class="input" required>
               <option value="-">0 child</option>
               <option value="1">1 child</option>
               <option value="2">2 childs</option>
               <option value="3">3 childs</option>
               <option value="4">4 childs</option>
               <option value="5">5 childs</option>
               <option value="6">6 childs</option>
            </select>
         </div>
         <div class="box">
            <p>rooms <span>*</span></p>
            <select name="rooms" class="input" required>
               <option value="1">1 room</option>
               <option value="2">2 rooms</option>
               <option value="3">3 rooms</option>
               <option value="4">4 rooms</option>
               <option value="5">5 rooms</option>
               <option value="6">6 rooms</option>
            </select>
         </div>
      </div>
      <input type="submit" value="check availability" name="check" class="btn">
   </form>

</section> -->

<!-- availability section ends -->

<!-- about section starts  -->
<!-- <h2>Hello</h2> -->
<!-- <section class="about" id="about">

   <div class="row">
      <div class="image">
         <img src="images/about-img-1.jpg" alt="">
      </div>
      <div class="content">
         <h3>best staff</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi laborum maxime eius aliquid temporibus unde?</p>
         <a href="#reservation" class="btn">make a reservation</a>
      </div>
   </div>

   <div class="row revers">
      <div class="image">
         <img src="images/about-img-2.jpg" alt="">
      </div>
      <div class="content">
         <h3>best foods</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi laborum maxime eius aliquid temporibus unde?</p>
         <a href="#contact" class="btn">contact us</a>
      </div>
   </div>

   <div class="row">
      <div class="image">
         <img src="images/about-img-3.jpg" alt="">
      </div>
      <div class="content">
         <h3>swimming pool</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi laborum maxime eius aliquid temporibus unde?</p>
         <a href="#availability" class="btn">check availability</a>
      </div>
   </div>

</section> -->

<section class="about" id="about">
   <div class="container">
      <div class="row">
         <!-- Hostel Card 1 -->
         <?php
            // Assuming the necessary database connection is already established
            $sql = "SELECT * FROM rooms_categories";  // Query to fetch all room categories
            $result = $conn->query($sql);    // Execute the query

            // Check if there are any records in the table
            if ($result->rowCount() > 0) {
               // Start the row container for cards
               // echo '<div class="row">';

               // Loop through each record in the result
               while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <div style="margin-left: 20px;" class="col-lg-3 col-md-6 mb-4">
                        <div class="card">
                           <img src="./images/hostel1.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($row['category_name']); ?>">
                           <div class="card-body">
                              <h5 class="card-title"><?php echo htmlspecialchars($row['category_name']); ?></h5> <!-- Display category name -->
                              <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p> <!-- Display category description -->
                              <a href="rooms.php?category_id=<?php echo $row['id']; ?>" class="btn btn-primary">View Rooms</a>
                           </div>
                        </div>
                  </div>
                  <?php
               }
               // echo '</div>';  // End the row container for cards
            } else {
               // If no records found, display a message
               echo "<p>No categories found.</p>";
            }
         ?>
      </div>
   </div>
</section>



<!-- about section ends -->

<!-- services section starts  -->

<section class="services">
   <div class="box-container">

      <div class="box">
         <!-- <img src="images/icon-1.png" alt="Wi-Fi"> -->
         <h3>Free Wi-Fi</h3>
         <p>Enjoy fast and reliable internet in your room and common areas during your stay.</p>
      </div>

      <div class="box">
         <!-- <img src="images/icon-2.png" alt="Laundry"> -->
         <h3>Laundry Service</h3>
         <p>Get your clothes washed and dried quickly with our convenient laundry services.</p>
      </div>

      <div class="box">
         <!-- <img src="images/icon-3.png" alt="Room Service"> -->
         <h3>Room Service</h3>
         <p>Order food and beverages directly to your room for a comfortable and relaxing experience.</p>
      </div>

      <div class="box">
         <!-- <img src="images/icon-4.png" alt="Booking Assistance"> -->
         <h3>Booking Assistance</h3>
         <p>Our team is ready to help you with booking tours, transportation, and other activities.</p>
      </div>

      <div class="box">
         <!-- <img src="images/icon-5.png" alt="Security"> -->
         <h3>24/7 Security</h3>
         <p>Your safety is our priority, with round-the-clock security and surveillance on-site.</p>
      </div>

      <div class="box">
         <!-- <img src="images/icon-6.png" alt="Common Room"> -->
         <h3>Common Room</h3>
         <p>Relax & study, meet other Student, or socialize in our cozy common area of our hostel.</p>
      </div>

   </div>
</section>


<!-- services section ends -->s

<!-- reservation section starts  -->

<!-- <section class="reservation" id="reservation">

   <form action="" method="post">
      <h3>make a reservation</h3>
      <div class="flex">
         <div class="box">
            <p>your name <span>*</span></p>
            <input type="text" name="name" maxlength="50" required placeholder="enter your name" class="input">
         </div>
         <div class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="enter your email" class="input">
         </div>
         <div class="box">
            <p>your number <span>*</span></p>
            <input type="number" name="number" maxlength="10" min="0" max="9999999999" required placeholder="enter your number" class="input">
         </div>
         <div class="box">
            <p>rooms <span>*</span></p>
            <select name="rooms" class="input" required>
               <option value="1" selected>1 room</option>
               <option value="2">2 rooms</option>
               <option value="3">3 rooms</option>
               <option value="4">4 rooms</option>
               <option value="5">5 rooms</option>
               <option value="6">6 rooms</option>
            </select>
         </div>
         <div class="box">
            <p>check in <span>*</span></p>
            <input type="date" name="check_in" class="input" required>
         </div>
         <div class="box">
            <p>check out <span>*</span></p>
            <input type="date" name="check_out" class="input" required>
         </div>
         <div class="box">
            <p>adults <span>*</span></p>
            <select name="adults" class="input" required>
               <option value="1" selected>1 adult</option>
               <option value="2">2 adults</option>
               <option value="3">3 adults</option>
               <option value="4">4 adults</option>
               <option value="5">5 adults</option>
               <option value="6">6 adults</option>
            </select>
         </div>
         <div class="box">
            <p>childs <span>*</span></p>
            <select name="childs" class="input" required>
               <option value="0" selected>0 child</option>
               <option value="1">1 child</option>
               <option value="2">2 childs</option>
               <option value="3">3 childs</option>
               <option value="4">4 childs</option>
               <option value="5">5 childs</option>
               <option value="6">6 childs</option>
            </select>
         </div>
      </div>
      <input type="submit" value="book now" name="book" class="btn">
   </form>

</section> -->

<!-- reservation section ends -->

<!-- gallery section starts  -->

<section class="gallery" id="gallery">

   <div class="swiper gallery-slider">
      <div class="swiper-wrapper">
         <img src="images/hostel2.jpg" class="swiper-slide" alt="">
         <img src="images/hostel3.jpg" class="swiper-slide" alt="">
         <img src="images/gallery-img-3.webp" class="swiper-slide" alt="">
         <img src="images/gallery-img-4.webp" class="swiper-slide" alt="">
         <img src="images/hostel4.jpg" class="swiper-slide" alt="">
         <img src="images/hostel5.jpg" class="swiper-slide" alt="">
      </div>
      <div class="swiper-pagination"></div>
   </div>

</section>

<!-- gallery section ends -->

<!-- contact section starts  -->

<section class="contact" id="contact">

   <div class="row">

      <form action="" method="post">
         <h3>send us message</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="number" required maxlength="10" min="0" max="9999999999" placeholder="enter your number" class="box">
         <textarea name="message" class="box" required maxlength="1000" placeholder="enter your message" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>

      <!-- <div class="faq">
         <h3 class="title">frequently asked questions</h3>
         <div class="box active">
            <h3>how to cancel?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus sunt aspernatur excepturi eos! Quibusdam, sapiente.</p>
         </div>
         <div class="box">
            <h3>is there any vacancy?</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ipsam neque quaerat mollitia ratione? Soluta!</p>
         </div>
         <div class="box">
            <h3>what are payment methods?</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ipsam neque quaerat mollitia ratione? Soluta!</p>
         </div>
         <div class="box">
            <h3>how to claim coupons codes?</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ipsam neque quaerat mollitia ratione? Soluta!</p>
         </div>
         <div class="box">
            <h3>what are the age requirements?</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ipsam neque quaerat mollitia ratione? Soluta!</p>
         </div>
      </div> -->

   </div>

</section>

<!-- contact section ends -->

<!-- reviews section starts  -->

<!-- <section class="reviews" id="reviews">

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">
         <div class="swiper-slide box">
            <img src="images/pic-1.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-2.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-3.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-4.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-5.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-6.png" alt="">
            <h3>john deo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates blanditiis optio dignissimos eaque aliquid explicabo.</p>
         </div>
      </div>

      <div class="swiper-pagination"></div>
   </div>

</section> -->

<!-- reviews section ends  -->





<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>