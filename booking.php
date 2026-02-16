<?php 
include 'includes/header.php'; 

// 1. جلب نوع الخدمة من الرابط (URL) الذي ضغط عليه المستخدم في الصفحة الرئيسية
// إذا لم يتم تحديد نوع، سيتم عرض "عام" كخيار افتراضي
$service_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'عام'; 

// 2. تحديد تاريخ اليوم كأقل تاريخ مسموح به لمنع الحجز في الماضي
$today = date('Y-m-d');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px; background-color: #f8f9fa;">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">تأكيد الحجز الفوري</h2>
                        <p class="text-muted small">يرجى إدخال بياناتك للتواصل عبر الواتساب واستلام التذكرة</p>
                    </div>

                    <form action="confirm.php" method="POST">
                        
                        <input type="hidden" name="service_type" value="<?php echo $service_type; ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold">الاسم الثلاثي:</label>
                            <input type="text" name="customer_name" class="form-control form-control-lg border-0 shadow-sm" 
                                   placeholder="أدخل اسمك هنا..." required style="border-radius: 10px;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">نوع الخدمة المطلوبة:</label>
                            <div class="p-3 bg-white border shadow-sm d-flex align-items-center justify-content-between" 
                                 style="border-radius: 10px;">
                                <span class="fw-bold text-dark"><?php echo $service_type; ?></span>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">تاريخ الحجز المطلوب:</label>
                            <input type="date" name="booking_date" class="form-control form-control-lg border-0 shadow-sm" 
                                   min="<?php echo $today; ?>" required style="border-radius: 10px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow" 
                                style="border-radius: 15px; background-color: #007bff;">
                            مراجعة وتأكيد الحجز
                        </button>

                        <div class="text-center mt-3">
                            <p class="text-muted small">بمجرد الضغط، سيتم توجيهك لمراجعة البيانات قبل الدفع.</p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

