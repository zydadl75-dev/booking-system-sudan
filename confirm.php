<?php
// استلام البيانات القادمة من صفحة الحجز (booking.php)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : 'غير محدد';
    $service_type = isset($_POST['service_type']) ? $_POST['service_type'] : 'غير محدد';
    $details_and_price = isset($_POST['sub_service_details']) ? $_POST['sub_service_details'] : 'لم يتم اختيار تفاصيل';
    $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : 'غير محدد';

    // تجهيز رسالة الواتساب
    $whatsapp_number = "249922480148"; // استبدله برقمك الحقيقي بصيغة دولية
    $message = "مرحباً، أريد تأكيد حجز جديد:%0A" .
               "*الاسم:* " . $customer_name . "%0A" .
               "*الخدمة:* " . $service_type . "%0A" .
               "*التفاصيل والسعر:* " . $details_and_price . "%0A" .
               "*التاريخ:* " . $booking_date;
    
    $whatsapp_url = "https://wa.me/" . $whatsapp_number . "?text=" . $message;
} else {
    // إذا حاول شخص دخول الصفحة مباشرة دون ملء الفورم
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة الحجز النهائي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .receipt-card { border-radius: 25px; border: none; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .receipt-header { background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 30px; text-align: center; }
        .info-row { border-bottom: 1px dashed #dee2e6; padding: 15px 0; }
        .info-label { color: #6c757d; font-weight: 600; }
        .info-value { color: #212529; font-weight: bold; text-align: left; }
        .btn-whatsapp { background-color: #25D366; color: white; border-radius: 15px; padding: 15px; font-weight: bold; transition: 0.3s; border: none; }
        .btn-whatsapp:hover { background-color: #1ebd57; transform: translateY(-3px); color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card receipt-card bg-white">
                <div class="receipt-header">
                    <i class="bi bi-file-earmark-check-fill" style="font-size: 3rem;"></i>
                    <h3 class="mt-2">مراجعة بيانات الحجز</h3>
                    <p class="mb-0 opacity-75">يرجى التأكد من البيانات قبل الإرسال</p>
                </div>
                
                <div class="card-body p-4">
                    <div class="info-row d-flex justify-content-between">
                        <span class="info-label">اسم العميل:</span>
                        <span class="info-value"><?php echo $customer_name; ?></span>
                    </div>
                    
                    <div class="info-row d-flex justify-content-between">
                        <span class="info-label">نوع الخدمة:</span>
                        <span class="info-value text-primary"><?php echo $service_type; ?></span>
                    </div>
                    
                    <div class="info-row d-flex justify-content-between border-primary border-2">
                        <span class="info-label">التفاصيل والسعر:</span>
                        <span class="info-value text-success"><?php echo $details_and_price; ?></span>
                    </div>
                    
                    <div class="info-row d-flex justify-content-between">
                        <span class="info-label">تاريخ الحجز:</span>
                        <span class="info-value"><?php echo $booking_date; ?></span>
                    </div>

                    <div class="mt-5">
                        <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="btn btn-whatsapp w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-whatsapp me-2"></i> تأكيد وإرسال عبر واتساب
                        </a>
                        <a href="index.php" class="btn btn-link w-100 mt-3 text-muted decoration-none">إلغاء والعودة للرئيسية</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 text-muted small">
                <p><i class="bi bi-shield-lock-fill"></i> نظام تشفير الحجوزات آمن ومباشر</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>

