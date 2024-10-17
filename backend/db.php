<?php
$host = 'localhost';
$db = 'forum-app';
$user = 'root'; // Default username for XAMPP
$pass = ''; // Default password for XAMPP 

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
