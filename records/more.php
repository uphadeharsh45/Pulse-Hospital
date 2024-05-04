<?php

   require '../../vendor/autoload.php';
   // connect to mongodb
   $conn= new MongoDB\Client;
   echo "Connection to database successfully";
   // select a database
   $db = $conn->mydb;
   echo "Database mydb selected";
?>
