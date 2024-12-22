<?php
// Clear the user_id cookie by setting its expiration time in the past
setcookie('user_id', '', time() - 3600, '/');

// Redirect to the login page
header('Location: login.php');
exit;
?>