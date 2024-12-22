<?php

include '../components/connect.php';

$select_categories = $conn->prepare("SELECT * FROM `rooms_categories`");
$select_categories->execute();
$categories = $select_categories->fetchAll(PDO::FETCH_ASSOC);

// if (isset($_POST['submit'])) {
//     // Sanitize and assign input values
//     $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
//     $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
//     $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
//     $room_number = filter_var($_POST['room_number'], FILTER_SANITIZE_NUMBER_INT);
//     $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
//     $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
//     $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
//     $facilities = filter_var($_POST['facilities'], FILTER_SANITIZE_STRING);

//     // echo '<pre>';
//     //   print_r($_POST);
//     //   echo '</pre>';
//     //   exit;
 
//     // Handle file uploads (images)
//     if (isset($_FILES['images'])) {
//        $imagePaths = [];
//        $files = $_FILES['images'];
 
//        // Loop through each uploaded file and save it
//        for ($i = 0; $i < count($files['name']); $i++) {
//           $fileTmp = $files['tmp_name'][$i];
//           $fileName = $files['name'][$i];
//           $fileDest = 'uploads/' . $fileName;
 
//           // Move file to the destination folder
//           if (move_uploaded_file($fileTmp, $fileDest)) {
//              $imagePaths[] = $fileDest;
//           }
//        }
//     }
 
//     // Convert the image paths into a comma-separated string
//     $imagePathsString = !empty($imagePaths) ? implode(',', $imagePaths) : '';
 
//     // Insert the data into the rooms table
//     $stmt = $conn->prepare("INSERT INTO rooms (category_id, title, description, room_number, type, price, status, facilities, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
//     if ($stmt->execute([$category_id, $title, $description, $room_number, $type, $price, $status, $facilities, $imagePathsString])) {
//        echo "Room added successfully!";
//     } else {
//        echo "Failed to add room!";
//     }
//  }

// if (isset($_POST['submit'])) {

//     // Sanitize input
//     $category_id = $_POST['category_id'];
//     $title = $_POST['title'];
//     $description = $_POST['description'];
//     $room_number = $_POST['room_number'];
//     $type = $_POST['type'];
//     $price = $_POST['price'];
//     $status = $_POST['status'];
//     $facilities = $_POST['facilities'];

//     // Handle image upload
//     $imageName = '';
//     if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
//         $imageName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
//         move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/rooms/' . $imageName);
//     }

//     // Insert data into database
//     $query = "INSERT INTO rooms (category_id, title, description, room_number, type, price, status, facilities, images) 
//               VALUES (:category_id, :title, :description, :room_number, :type, :price, :status, :facilities, :image)";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':category_id', $category_id);
//     $stmt->bindParam(':title', $title);
//     $stmt->bindParam(':description', $description);
//     $stmt->bindParam(':room_number', $room_number);
//     $stmt->bindParam(':type', $type);
//     $stmt->bindParam(':price', $price);
//     $stmt->bindParam(':status', $status);
//     $stmt->bindParam(':facilities', $facilities);
//     $stmt->bindParam(':image', $imageName);

//     if ($stmt->execute()) {
//         echo "Room added successfully!";
//     } else {
//         echo "Failed to add room.";
//     }
// }

if (isset($_POST['submit'])) {

    // Sanitize input
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $room_number = filter_var($_POST['room_number'], FILTER_SANITIZE_NUMBER_INT);
    $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $facilities = filter_var($_POST['facilities'], FILTER_SANITIZE_STRING);

    // Handle image upload
    $imageName = '';
    $uploadDir = 'uploads/rooms/';

    // Check if the directory exists and is writable
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Sanitize and process the file name
        $imageName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Validate file type (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo "Error: Only JPEG, PNG, and GIF images are allowed.";
            exit;
        }

        // Move the uploaded file
        $targetFile = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "No file uploaded or there was an error with the upload.";
        exit;
    }

    // Insert data into database
    try {
        $query = "INSERT INTO rooms (category_id, title, description, room_number, type, price, status, facilities, images) 
                  VALUES (:category_id, :title, :description, :room_number, :type, :price, :status, :facilities, :image)";
        $stmt = $conn->prepare($query);

        // Bind parameters to avoid SQL injection
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':room_number', $room_number);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':facilities', $facilities);
        $stmt->bindParam(':image', $imageName);

        // Execute the query
        if ($stmt->execute()) {
            echo "Room added successfully!";
        } else {
            echo "Failed to add room.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <!-- <link rel="stylesheet" href="../css/admin_style.css"> -->
    <style>
        .form-container {
            background-color: white;
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        /* Title */
        .form-container h3 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 15px;
        }

        /* Label */
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        /* Input Fields */
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        /* Textarea specific */
        .form-group textarea {
            resize: vertical;
        }

        /* Focused input */
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Small Text */
        .form-group small {
            font-size: 12px;
            color: #777;
        }

        /* Button */
        .form-group .btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>

</head>

<body>

    <!-- login section starts  -->

    <section class="form-container" style="min-height: 100vh;">

        <form action="" method="POST" enctype="multipart/form-data" class="form-container">
            <h3>Add New Room</h3>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" required>
                    <option value="">Select Category</option>
                    <?php
                    // Loop through the categories and create an option for each
                    foreach ($categories as $category) {
                        echo "<option value=\"" . $category['id'] . "\">" . htmlspecialchars($category['category_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Room Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter room title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" placeholder="Enter room description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="room_number">Room Number:</label>
                <input type="number" name="room_number" id="room_number" placeholder="Enter room number" required>
            </div>

            <div class="form-group">
                <label for="type">Room Type:</label>
                <select name="type" id="type" required>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" placeholder="Enter price" min="0" required>
            </div>

            <div class="form-group">
                <label for="status">Room Status:</label>
                <select name="status" id="status" required>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <div class="form-group">
                <label for="facilities">Facilities:</label>
                <input type="text" name="facilities" id="facilities" placeholder="Enter facilities (comma separated)" required>
            </div>

            <div class="form-group">
                <label for="images">Room Images:</label>
                <input type="file" name="image" id="images" multiple required>
                <small>Upload image (JPEG, PNG, GIF)</small>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn">Add Room</button>
            </div>
        </form>



    </section>

    <!-- login section ends -->


















    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <?php include '../components/message.php'; ?>

</body>

</html>