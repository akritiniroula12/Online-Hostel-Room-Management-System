<?php

   $db_name = 'mysql:host=localhost;dbname=hostel_database';
   $db_user_name = 'root';
   $db_user_pass = '';

   $conn = new PDO($db_name, $db_user_name, $db_user_pass);

   // function create_unique_id(){
   //    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   //    $rand = array();
   //    $length = strlen($str) - 1;

   //    for($i = 0; $i < 20; $i++){
   //       $n = mt_rand(0, $length);
   //       $rand[] = $str[$n];
   //    }
   //    return implode($rand);
   // }

   // if (isset($_COOKIE['user_id'])) {
   //    // Retrieve the user_id from the cookie
   //    $user_id = $_COOKIE['user_id'];
   //    echo "User ID: " . $user_id;
   // } else {
   //    echo "User ID cookie is not set.";
   // }

?>