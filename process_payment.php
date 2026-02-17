<?php
// 1. الاتصال بقاعدة البيانات
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. استلام البيانات من فورم الحجز (booking.php) وتأمينها
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
    $sub_service_details = mysqli_real_escape_string($conn, $_POST['sub_service_details']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    
    // وضع حالة افتراضية للحجز
    $status = "قيد الانتظار"; 
    $payment_method = "عند التأكيد";

    // 3. استعلام الإدخال المحدث ليشمل العمود الجديد الذي أضفته
    $sql = "INSERT INTO bookings (customer_name, service_type, sub_service_details, booking_date, payment_method, status) 
            VALUES ('$customer_name', '$service_type', '$sub_service_details', '$booking_date', '$payment_method', '$status')";

    // 4. تنفيذ العملية والتحقق من النجاح
    if (mysqli_query($conn, $sql)) {
        // إذا نجح الحفظ في قاعدة البيانات، ننتقل لصفحة التأكيد لعرض الفاتورة وزر الواتساب
        // نستخدم POST لإرسال البيانات لصفحة confirm لضمان الأمان
        echo "<form id='redirectForm' action='confirm.php' method='POST'>
                <input type='hidden' name='customer_name' value='$customer_name'>
                <input type='hidden' name='service_type' value='$service_type'>
                <input type='hidden' name='sub_service_details' value='$sub_service_details'>
                <input type='hidden' name='booking_date' value='$booking_date'>
              </form>
              <script type='text/javascript'>
                document.getElementById('redirectForm').submit();
              </script>";
    } else {
        // في حال حدوث خطأ في قاعدة البيانات
        echo "خطأ في عملية الحفظ: " . mysqli_error($conn);
    }
} else {
    // منع الدخول المباشر للملف
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>

