<?php
// 1. الاتصال بقاعدة البيانات
include('config.php');

// 2. التأكد من أن البيانات قادمة من النموذج (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // استلام البيانات وتجهيزها
    $customer_name = $_POST['customer_name'];
    $service_type = $_POST['service_type'];
    $sub_service_details = $_POST['sub_service_details'];
    $booking_date = $_POST['booking_date'];
    $payment_method = $_POST['payment_method'];

    try {
        // 3. كود الإدخال في قاعدة البيانات (SQL Insert)
        $sql = "INSERT INTO bookings (customer_name, service_type, sub_service_details, booking_date, payment_method) 
                VALUES (:name, :type, :details, :bdate, :pmethod)";
        
        $stmt = $conn->prepare($sql);
        
        // ربط القيم لمنع اختراق SQL Injection
        $stmt->bindParam(':name', $customer_name);
        $stmt->bindParam(':type', $service_type);
        $stmt->bindParam(':details', $sub_service_details);
        $stmt->bindParam(':bdate', $booking_date);
        $stmt->bindParam(':pmethod', $payment_method);

        // التنفيذ
        if ($stmt->execute()) {
            // 4. إذا نجح الحفظ، يتم التوجيه لصفحة التأكيد لعرض بيانات الدفع والواتساب
            // سنرسل البيانات عبر POST مخفي أو نمرر الـ ID
            echo "<form id='redirectForm' action='confirm.php' method='post'>
                    <input type='hidden' name='customer_name' value='$customer_name'>
                    <input type='hidden' name='service_type' value='$service_type'>
                    <input type='hidden' name='sub_service_details' value='$sub_service_details'>
                    <input type='hidden' name='booking_date' value='$booking_date'>
                    <input type='hidden' name='payment_method' value='$payment_method'>
                  </form>
                  <script>document.getElementById('redirectForm').submit();</script>";
        }

    } catch (PDOException $e) {
        die("خطأ في حفظ البيانات: " . $e->getMessage());
    }
} else {
    // إذا حاول شخص دخول الصفحة مباشرة
    header("Location: booking.php");
    exit();
}
?>

