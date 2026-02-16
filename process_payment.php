<?php
include 'includes/header.php';

// استلام البيانات
$method = $_POST['payment_method'] ?? '';
$name = htmlspecialchars($_POST['name'] ?? '');
$type = htmlspecialchars($_POST['type'] ?? '');
$date = htmlspecialchars($_POST['date'] ?? '');
$phone_number = "249902103267"; // الرقم بصيغة دولية بدون +

// تجهيز رسالة الواتساب تلقائياً
$message = "مرحباً، أود تأكيد حجز لخدمة: " . $type . "%0A";
$message .= "الاسم: " . $name . "%0A";
$message .= "التاريخ: " . $date . "%0A";
$message .= "طريقة الدفع: بنكك (مرفق صورة الإشعار)";

$whatsapp_url = "https://wa.me/" . $phone_number . "?text=" . $message;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center card p-5 shadow-sm" style="border-radius: 20px;">
        
        <?php if ($method == 'bankak'): ?>
            <div class="text-primary mb-3"><i class="bi bi-bank" style="font-size: 4rem;"></i></div>
            <h4 class="fw-bold">خطوة واحدة متبقية يا <?php echo $name; ?>!</h4>
            <p class="mb-4 text-muted">يرجى تحويل مبلغ الخدمة إلى الحساب التالي، ثم الضغط على الزر بالأسفل لإرسال الإشعار عبر الواتساب.</p>
            
            <div class="p-3 bg-light border border-primary mb-4" style="border-radius: 10px; border-style: dashed !important;">
                <span class="d-block small text-primary fw-bold">حساب بنك الخرطوم (بنكك)</span>
                <span class="h4 fw-bold">4800487</span>
            </div>

            <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="btn btn-success btn-lg w-100 py-3 shadow">
                <i class="bi bi-whatsapp"></i> إرسال إشعار الدفع الآن
            </a>

        <?php elseif ($method == 'visa'): ?>
            <div class="text-info mb-3"><i class="bi bi-credit-card-2-front" style="font-size: 4rem;"></i></div>
            <h4>جاري التوجيه لبوابة Visa...</h4>
            <div class="spinner-grow text-info" role="status"></div>

        <?php else: ?>
            <div class="text-success mb-3"><i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i></div>
            <h4 class="fw-bold">تم تأكيد طلبك!</h4>
            <p>تم تسجيل حجزك لخدمة (<?php echo $type; ?>). سننتظرك في الموعد المحدد <?php echo $date; ?>.</p>
            <a href="index.php" class="btn btn-outline-primary mt-3">العودة للرئيسية</a>
        <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

