<?php
// $host = 'localhost';
// $db = 'creativesuite_coworkit_web';
// // $user = 'creativesuite_coworkit_web';
// // $pass = '12345678';
// $user = "root";
// $pass = "";

// $conn = new mysqli($host, $user, $pass, $db);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Allow requests from any origin (for development only)
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Access-Control-Allow-Credentials: true");

// // If it's an OPTIONS request (preflight), exit early
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


$host = 'localhost';
$db = 'lynx_admin';
$user = 'lynx_admin';
$pass = '12345678';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "connection Success";
}
?>

