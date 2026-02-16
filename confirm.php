<?php 
include 'includes/header.php'; 

// استلام البيانات وتأمينها
$name = htmlspecialchars($_POST['customer_name'] ?? '');
$type = htmlspecialchars($_POST['service_type'] ?? 'عام');
$date = htmlspecialchars($_POST['booking_date'] ?? '');

if (empty($name) || empty($date)) {
    header("Location: index.php"); // إعادة للرئيسية إذا كانت البيانات ناقصة
    exit();
}
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-7 card p-4 shadow-sm border-0" style="border-radius: 20px;">
        <h3 class="text-center mb-4 text-success"><i class="bi bi-check2-circle"></i> مراجعة تفاصيل الحجز</h3>
        
        <div class="alert alert-light border shadow-sm mb-4">
            <p><strong>الاسم:</strong> <?php echo $name; ?></p>
            <p><strong>نوع الخدمة:</strong> <?php echo $type; ?></p>
            <p><strong>التاريخ:</strong> <?php echo $date; ?></p>
        </div>

        <h5 class="mb-3 fw-bold">اختر وسيلة الدفع المفضلة:</h5>
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="type" value="<?php echo $type; ?>">
            <input type="hidden" name="date" value="<?php echo $date; ?>">

            <div class="list-group mb-4">
                <label class="list-group-item d-flex gap-3 py-3">
                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="bankak" required>
                    <span class="d-flex flex-column">
                        <strong class="d-block text-primary">تطبيق بنكك (بنك الخرطوم)</strong>
                        <small>تحويل مباشر للحساب: 4800487(أرفق الإشعار لاحقاً)</small>
                    </span>
                </label>

                <label class="list-group-item d-flex gap-3 py-3">
                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="visa">
                    <span class="d-flex flex-column">
                        <strong class="d-block">بطاقة فيزا / ماستر كارد (Visa)</strong>
                        <small>الدفع عبر بوابة الدفع الإلكتروني الآمنة</small>
                    </span>
                </label>

                <label class="list-group-item d-flex gap-3 py-3">
                    <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="cod">
                    <span class="d-flex flex-column">
                        <strong class="d-block">الدفع عند الاستلام / الموقع</strong>
                        <small>يتم الدفع نقداً عند الحضور أو الاستفادة من الخدمة</small>
                    </span>
                </label>
            </div>

            <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm">
                إتمام عملية الحجز والطلب
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

