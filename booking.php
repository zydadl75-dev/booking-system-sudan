<?php
// استلام نوع الخدمة وتوحيد المسميات لضمان ظهور القوائم
$service_type = isset($_GET['type']) ? $_GET['type'] : 'سفر';
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الحجز الفوري - نظام الحجوزات الذكي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .booking-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .form-label { color: #495057; margin-bottom: 8px; }
        .form-control-lg { border-radius: 12px; font-size: 1rem; border: 1px solid #dee2e6; }
        .form-control-lg:focus { border-color: #007bff; box-shadow: 0 0 0 0.25 row rgba(0, 123, 255, 0.1); }
        .btn-confirm { border-radius: 15px; padding: 15px; font-size: 1.1rem; transition: all 0.3s; }
        .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,123,255,0.3); }
        .service-badge { background-color: #e7f1ff; color: #007bff; padding: 10px 20px; border-radius: 10px; display: inline-block; font-weight: bold; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card booking-card p-4 p-md-5 bg-white">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">تأكيد الحجز الفوري</h2>
                    <p class="text-muted">أدخل بياناتك وسيتم التواصل معك لتأكيد السعر النهائي</p>
                </div>

                <form action="confirm.php" method="POST">
                    <input type="hidden" name="service_type" value="<?php echo $service_type; ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-person-fill me-2"></i>الاسم الثلاثي:</label>
                        <input type="text" name="customer_name" class="form-control form-control-lg bg-light" 
                               placeholder="أدخل اسمك بالكامل..." required>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="service-badge">
                            نوع الخدمة: <?php echo $service_type; ?> <i class="bi bi-check2-circle ms-2"></i>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-tag-fill me-2"></i>اختر التفاصيل والسعر (جنيه سوداني):</label>
                        <select name="sub_service_details" class="form-select form-select-lg bg-light" style="border-radius: 12px;" required>
                            <option value="">-- اضغط هنا للاختيار --</option>

                            <?php if($service_type == 'سفر'): ?>
                                <optgroup label="طيران بدر - رحلات من الخرطوم">
                                    <option value="الخرطوم إلى الرياض - 850,000 جنيه">الخرطوم إلى الرياض (850,000 جنيه)</option>
                                    <option value="الخرطوم إلى جدة - 780,000 جنيه">الخرطوم إلى جدة (780,000 جنيه)</option>
                                    <option value="الخرطوم إلى دبي - 950,000 جنيه">الخرطوم إلى دبي (950,000 جنيه)</option>
                                    <option value="الخرطوم إلى قطر - 920,000 جنيه">الخرطوم إلى قطر (920,000 جنيه)</option>
                                </optgroup>

                            <?php elseif($service_type == 'عيادة' || $service_type == 'طبية'): ?>
                                <optgroup label="العيادات التخصصية">
                                    <option value="كشف طبيب أطفال - 45,000 جنيه">طبيب أطفال (45,000 جنيه)</option>
                                    <option value="كشف طبيب جراحة - 65,000 جنيه">طبيب جراحة (65,000 جنيه)</option>
                                    <option value="كشف طبيب باطنية - 40,000 جنيه">طبيب باطنية (40,000 جنيه)</option>
                                </optgroup>

                            <?php elseif($service_type == 'فندق' || $service_type == 'فنادق'): ?>
                                <optgroup label="فندق 5 نجوم - الخرطوم/بورتسودان">
                                    <option value="إقامة يوم واحد - 70,000 جنيه">إقامة يوم واحد (70,000 جنيه)</option>
                                    <option value="إقامة أسبوع - 300,000 جنيه">إقامة أسبوع (300,000 جنيه)</option>
                                    <option value="إقامة شهر - 800,000 جنيه">إقامة شهر (800,000 جنيه)</option>
                                </optgroup>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-calendar-event-fill me-2"></i>تاريخ الحجز:</label>
                        <input type="date" name="booking_date" class="form-control form-control-lg bg-light" 
                               min="<?php echo $today; ?>" required>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary btn-confirm w-100 fw-bold">
                            مراجعة وتأكيد الحجز <i class="bi bi-arrow-left-circle ms-2"></i>
                        </button>
                    </div>
                </form>

            </div>
            <div class="text-center mt-4">
                <small class="text-muted">© 2026 نظام الحجوزات الذكي - جميع الحقوق محفوظة</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

