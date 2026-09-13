<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli(
 hostname: "localhost",
    username: "root",
    password: "",
    database: ""

);
// !!!!!!  
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
      mysqli_query($conn, "SET time_zone ='+08:00'"); // ph time zone

return $conn;


