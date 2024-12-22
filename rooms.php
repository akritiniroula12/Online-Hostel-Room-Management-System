<?php
include 'components/connect.php';
// Check if category_id is passed in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $sql = "SELECT * FROM rooms WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$category_id]);

   //  while ($room = $stmt->fetch(PDO::FETCH_ASSOC)) {
   //      // Display room details here
   //      echo "Room Name: " . htmlspecialchars($room['category_id']);
   //  }
} else {
    echo "No category selected.";
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

      .btn.disabled {
         pointer-events: none;
         opacity: 0.6;
         cursor: not-allowed;
      }

   </style>
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <section class="about" id="about">
   <div class="container">
      <div class="row">
         <!-- Hostel Card 1 -->
         <?php
            while ($room = $stmt->fetch(PDO::FETCH_ASSOC)) {
         ?>
    <div style="margin-left: 20px;" class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <!-- Display room image, if available -->
            <img src="./images/hostel5.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($room['title']); ?>">
            <div class="card-body">
                <!-- Display room title -->
                <h5 class="card-title"><?php echo htmlspecialchars($room['title']); ?></h5> 
                
                <!-- Display room description -->
                <p class="card-text"><?php echo htmlspecialchars($room['description']); ?></p>
                
                <!-- Display room number and status -->
                <p class="card-text"><strong>Room Number:</strong> <?php echo htmlspecialchars($room['room_number']); ?></p>
                <p class="card-text"><strong>Status:</strong> <?php echo htmlspecialchars($room['status']); ?></p>

                <!-- Button to view rooms -->
                <!-- <a href="rooms.php?room_id=<?php echo $room['id']; ?>" class="btn btn-primary">Book Room Now</a> -->
                <a href="./book_room.php?room_id=<?php echo $room['id']; ?>&category_id=<?php echo $room['category_id']; ?>" 
   class="btn btn-primary <?php echo ($room['status'] !== 'available') ? 'disabled' : ''; ?>" 
   <?php echo ($room['status'] !== 'available') ? 'aria-disabled="true"' : ''; ?>>
   Book Room Now
</a>
            </div>
        </div>
    </div>
<?php
}
?>

      </div>
   </div>
</section>
</body>
</html>