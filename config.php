<?php
$host = "sql301.infinityfree.com"; $user = "if0_40459700"; $pass = "96P21XgLltXX8"; $db = "if0_40459700_hospital_db";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) { die("خطأ في الاتصال: " . $e->getMessage()); }
?>

