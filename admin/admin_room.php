<?php 
  include '../components/connect.php';

  if(isset($_COOKIE['admin_id'])){
    $admin_id = $_COOKIE['admin_id'];
 }else{
    $admin_id = '';
    header('location:login.php');
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room List</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

     <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

    <!-- Custom CSS for Table and General Styling -->
    <style>
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        /* Header */
        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Table */
        .room-table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .room-table th, .room-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .room-table th {
            background-color: #333;
            color: white;
        }

        .room-table td img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Table to display rooms -->
    <section>
        <h2 style="text-align: center; margin-top: 20px;">Room Details</h2>
        
        <table class="room-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Room Number</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Facilities</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection (replace with your actual database connection details)
                // include 'db_connect.php';

                // Fetch all rooms from the database
                $query = "SELECT * FROM rooms";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $rooms = $stmt->fetchAll();

                $i =1;

                // Loop through rooms and display them in the table
                foreach ($rooms as $room) {
                    echo "<tr>
                            <td>" .$i++ . "</td>
                            <td>" . htmlspecialchars($room['title']) . "</td>
                            <td>" . htmlspecialchars($room['description']) . "</td>
                            <td>" . htmlspecialchars($room['room_number']) . "</td>
                            <td>" . htmlspecialchars($room['type']) . "</td>
                            <td>" . htmlspecialchars($room['price']) . "</td>
                            <td>" . htmlspecialchars($room['status']) . "</td>
                            <td>" . htmlspecialchars($room['facilities']) . "</td>
                            <td><img src='uploads/rooms/" . $room['images'] . "' alt='Room Image'></td>
                            <td>
                                <a href='edit_room.php?id=" . $room['id'] . "'><i class='fa fa-edit'></i> Edit</a> | 
                                <a href='delete_room.php?id=" . $room['id'] . "'><i class='fa fa-trash'></i> Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
