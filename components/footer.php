<!-- footer section starts  -->
<style>
   /* Footer Styling */
.footer {
   background-color: #2C3E50;
   color: #fff;
   padding: 40px 20px;
}

.footer-container {
   display: grid;
   grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
   gap: 30px;
   justify-items: flex-start;
   max-width: 1200px;
   margin: 0 auto;
}

.footer-box {
   padding: 10px;
}

.footer-box h3 {
   font-size: 1.5rem;
   margin-bottom: 20px;
   font-weight: bold;
   color: #ecf0f1;
}

.footer-box ul {
   list-style-type: none;
   padding: 0;
}

.footer-box ul li {
   margin-bottom: 10px;
}

.footer-box ul li a {
   text-decoration: none;
   color: #ecf0f1;
   font-size: 1rem;
   display: flex;
   align-items: center;
}

.footer-box ul li a:hover {
   color: #3498db;
}

.footer-box ul li a i {
   margin-right: 10px;
}

/* Social Links */
.social-links li {
   margin-bottom: 10px;
}

.social-links li a {
   color: #ecf0f1;
   font-size: 1.2rem;
   display: flex;
   align-items: center;
}

.social-links li a:hover {
   color: #3498db;
}

.footer-credit {
   text-align: center;
   padding-top: 30px;
   font-size: 1rem;
   color: #ecf0f1;
   border-top: 2px solid #34495e;
   margin-top: 30px;
}

</style>
<section class="footer">
   <div class="footer-container">

      <div class="footer-box">
         <h3>Contact Information</h3>
         <ul>
            <li><a href="tel:9800000000"><i class="fas fa-phone"></i> +977-9800000000</a></li>
            <li><a href="tel:9840269140"><i class="fas fa-phone"></i> +977-984029140</a></li>
            <li><a href="info.akriti@gmail.com"><i class="fas fa-envelope"></i> info.akriti@gmail.com</a></li>
            <li><a href="info.susmeena@gmail.com"><i class="fas fa-envelope"></i> info.susmeena@gmail.com</a></li>
            <li><a href="#"><i class="fas fa-map-marker-alt"></i> Itahari-sunsari, Nepal - 56705</a></li>
         </ul>
      </div>

      <div class="footer-box">
         <h3>Quick Links</h3>
         <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="#reservation">Reservation</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#reviews">Reviews</a></li>
         </ul>
      </div>

      <div class="footer-box">
         <h3>Follow Us</h3>
         <ul class="social-links">
            <li><a href="#">Facebook <i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#">Twitter <i class="fab fa-twitter"></i></a></li>
            <li><a href="#">Instagram <i class="fab fa-instagram"></i></a></li>
            <li><a href="#">LinkedIn <i class="fab fa-linkedin"></i></a></li>
            <li><a href="#">YouTube <i class="fab fa-youtube"></i></a></li>
         </ul>
      </div>

   </div>

   <div class="footer-credit">
      <p>&copy; 2024 designed by Susmeena & Akriti BCA Fourth Semester Projects</p>
   </div>
</section>


<!-- footer section ends -->