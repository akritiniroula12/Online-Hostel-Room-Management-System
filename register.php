<?php

// include '../components/connect.php';
include './components/connect.php';

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);

   // Check if the username or email already exists
   $check_admins = $conn->prepare("SELECT * FROM `users` WHERE name = ? OR email = ? LIMIT 1");
   $check_admins->execute([$name, $email]);

   if ($check_admins->rowCount() > 0) {
      $warning_msg[] = 'Username or email already exists!';
   } else {
      // Insert the new admin into the database
      $insert_admin = $conn->prepare("INSERT INTO `users` (name, email, password, phone) VALUES (?, ?, ?, ?)");
      $insert_admin->execute([$name, $email, $password, $phone]);
      $success_msg[] = 'Registration successful! You can now login.';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/admin_style.css">

</head>
<body>

<!-- register section starts  -->

<section class="form-container" style="min-height: 100vh;">

   <form action="" method="POST">
      <h3>Create an Account</h3>
      <p>Please fill in the details below to register.</p>
      <input type="text" name="name" placeholder="Enter username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="email" name="email" placeholder="Enter email" maxlength="50" class="box" required>
      <input type="password" name="password" placeholder="Enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="phone" placeholder="Enter phone number" maxlength="15" class="box" required oninput="this.value = this.value.replace(/\D/g, '')">
      <input type="submit" value="Register now" name="submit" class="btn">
   </form>

</section>

<!-- register section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include './components/message.php'; ?>

</body>
</html>
