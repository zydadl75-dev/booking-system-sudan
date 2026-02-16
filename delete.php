<?php
include 'config.php';
if(isset($_GET['id'])){
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: manage.php");
?>

