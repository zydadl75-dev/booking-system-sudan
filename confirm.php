<?php
// 1. الاتصال بقاعدة البيانات
$conn = new mysqli("sql301.infinityfree.com", "if0_40459700", "96P21XgLltXX8", "if0_40459700_hospital_db");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) { die("فشل الاتصال بالقاعدة"); }

$msg = "";
$color = "#dc3545"; // أحمر افتراضي للفشل
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['customer_name'];
    $service_type = $_POST['service_type'];
    $method = $_POST['payment_method'];
    $booking_date = $_POST['booking_date'];
    
    // فك السعر وتفاصيل الخدمة
    $parts = explode('|', $_POST['service_data']);
    $price = (float)$parts[0];
    $service_details = $parts[1];

    if ($method != 'cash') {
        $acc_num = $_POST['acc_number'];

        // البحث عن الحساب أو إنشاؤه (الحل الذكي)
        $check = $conn->query("SELECT balance FROM users WHERE id = '$acc_num'");
        
        if ($check->num_rows > 0) {
            $user = $check->fetch_assoc();
            $current_balance = $user['balance'];
        } else {
            // إذا الحساب غير موجود، ننشئه ونعطيه رصيد افتراضي (3 مليون)
            $initial_gift = 3000000;
            $conn->query("INSERT INTO users (id, username, balance) VALUES ('$acc_num', '$name', $initial_gift)");
            $current_balance = $initial_gift;
        }

        // تنفيذ عملية الخصم
        if ($current_balance >= $price) {
            $new_balance = $current_balance - $price;
            $conn->query("UPDATE users SET balance = $new_balance WHERE id = '$acc_num'");
            
            $status = "تم الدفع";
            $pay_log = "$method ($acc_num)";
            $color = "#28a745"; // أخضر للنجاح
            $success = true;
        } else {
            $status = "فشل - رصيد غير كافٍ";
            $pay_log = "$method ($acc_num)";
            $success = false;
        }
    } else {
        // دفع كاش
        $status = "انتظار الدفع (كاش)";
        $pay_log = "كاش";
        $color = "#007bff";
        $success = true;
    }

    // حفظ الحجز في قاعدة البيانات
    if ($success || $method == 'cash') {
        $sql_book = "INSERT INTO bookings (customer_name, service_type, sub_service_details, booking_date, payment_method, status) 
                     VALUES ('$name', '$service_type', '$service_details', '$booking_date', '$pay_log', '$status')";
        $conn->query($sql_book);
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد العملية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .receipt-card {
            max-width: 450px;
            margin: 60px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 10px solid <?php echo $color; ?>;
            overflow: hidden;
        }
        .status-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
        .amount {
            font-size: 2rem;
            font-weight: 800;
            color: #333;
            margin: 10px 0;
        }
        .details-box {
            background: #fcfcfc;
            border: 1px dashed #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: right;
        }
        .btn-back {
            background: #333;
            color: white;
            border-radius: 10px;
            padding: 12px;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-back:hover { background: #000; color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="receipt-card p-4 text-center">
        <?php if ($success): ?>
            <div class="status-icon">✅</div>
            <h3 class="fw-bold">نجحت العملية</h3>
            <p class="text-muted mb-1">تم خصم مبلغ وقدره</p>
            <div class="amount"><?php echo number_format($price); ?> <small style="font-size: 1rem;">جنيه</small></div>
            
            <div class="details-box mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">العميل:</span>
                    <span class="fw-bold"><?php echo $name; ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">الخدمة:</span>
                    <span class="fw-bold"><?php echo $service_details; ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">طريقة الدفع:</span>
                    <span class="fw-bold"><?php echo ($method == 'cash') ? 'نقداً' : $method; ?></span>
                </div>
            </div>
        <?php else: ?>
            <div class="status-icon">❌</div>
            <h3 class="fw-bold text-danger">فشلت العملية</h3>
            <p class="text-muted">عذراً، الرصيد غير كافٍ في هذا الحساب.</p>
        <?php endif; ?>

        <a href="booking.php?type=<?php echo $service_type; ?>" class="btn-back shadow-sm">العودة لصفحة الحجز</a>
    </div>
</div>

</body>
</html>

