<?php include 'includes/header.php'; 
$type = $_GET['type'] ?? 'عام'; ?>
<div class="row justify-content-center">
    <div class="col-md-6 card p-4 shadow-sm">
        <h3 class="mb-4 text-center">طلب حجز: <?php echo $type; ?></h3>
        <form action="confirm.php" method="POST">
            <input type="hidden" name="service_type" value="<?php echo $type; ?>">
            <div class="mb-3">
                <label class="form-label">الاسم الكامل:</label>
                <input type="text" name="customer_name" class="form-control" placeholder="أدخل اسمك الثلاثي" required>
            </div>
            <div class="mb-3">
                <label class="form-label">تاريخ الحجز المطلوب:</label>
                <input type="date" name="booking_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">مراجعة وتأكيد الحجز</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

