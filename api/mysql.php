<?php 
     header('Content-Type: application/json; charset=utf-8');

     $servername = "localhost";
     $username = "root";
     $password = "";
 
     try {
         $conn = new PDO("mysql:host=$servername;dbname=covid_tracker", $username, $password);
         // set the PDO error mode to exception
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //  echo "Connected successfully";
     } catch(PDOException $e) {
         echo "Connection failed: " . $e->getMessage();
     }
?>