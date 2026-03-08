<?php
// 1. إعدادات قاعدة البيانات (لا تغيير نهائياً)
$servername = "sql301.infinityfree.com";
$username   = "if0_40459700";
$password   = "96P21XgLltXX8"; 
$dbname     = "if0_40459700_hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

$show_success = false;
$name = ""; $service = ""; $price = 0; $pay_method = ""; 
$current_type = isset($_GET['type']) ? $_GET['type'] : 'سفر';
$step = isset($_GET['item_id']) ? 'details' : 'list'; 

// 2. معالجة البيانات عند الإرسال (نفس منطقك الأصلي تماماً)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $conn->real_escape_string($_POST['customer_name']);
    $phone   = $conn->real_escape_string($_POST['phone_number']);
    $details = $conn->real_escape_string($_POST['details']);
    $service = $_POST['service_type'];
    $price   = $_POST['final_price_hidden']; 
    $pay_method = $_POST['payment_method'];
    $booking_date = $_POST['booking_date'];
    $acc_num = isset($_POST['acc_num']) ? $conn->real_escape_string($_POST['acc_num']) : 'N/A';
    $full_info = "الهاتف: $phone | التاريخ: $booking_date | الخدمة: $service | التفاصيل: $details | الطريقة: $pay_method | الحساب: $acc_num | المبلغ: $price";
    $sql = "INSERT INTO bookings (customer_name, sub_service_details, booking_date) VALUES ('$name', '$full_info', '$booking_date')";
    if ($conn->query($sql) === TRUE) { $show_success = true; }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام الحجز والدفع المتكامل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; padding-top: 20px; }
        .booking-card { max-width: 800px; margin: 0 auto 30px; background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .selection-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .selection-item { background: white; border-radius: 15px; overflow: hidden; cursor: pointer; transition: 0.3s; border: 1px solid #eee; text-align: center; }
        .selection-item:hover { transform: translateY(-10px); box-shadow: 0 12px 20px rgba(0,0,0,0.15); }
        .item-img { width: 100%; height: 200px; object-fit: cover; }
        .price-tag { font-size: 1.8rem; color: #28a745; font-weight: bold; margin: 15px 0; }
        .bankak-modal { display: <?php echo $show_success ? 'flex' : 'none'; ?>; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; }
        .bankak-card { background: white; width: 90%; max-width: 380px; border-radius: 25px; padding: 25px; text-align: center; border-top: 8px solid #28a745; }
        .payment-box { background: #fffbe6; padding: 15px; border-radius: 12px; border: 1px dashed #ffc107; margin-top: 15px; text-align: right; }
    </style>
</head>
<body>

<div class="container">
    
    <?php if($current_type == 'سفر'): ?>
    <div class="booking-card">
        <?php if($step == 'list'): ?>
            <h2 class="text-primary mb-4 text-center">✈️ اختر وجهة السفر</h2>
            <div class="selection-grid">
                <div class="selection-item" onclick="window.location.href='?type=سفر&item_id=0'"><img src="https://images.unsplash.com/photo-1544016768-982d1554f0b9" class="item-img"><div class="p-3"><h5>الخرطوم ⬅️ جدة</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=سفر&item_id=1'"><img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c" class="item-img"><div class="p-3"><h5>الخرطوم ⬅️ دبي</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=سفر&item_id=2'"><img src="https://images.unsplash.com/photo-1553913861-c0fddf2619ee" class="item-img"><div class="p-3"><h5>الخرطوم ⬅️ القاهرة</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=سفر&item_id=3'"><img src="https://images.unsplash.com/photo-1524231757912-21f4fe3a7200" class="item-img"><div class="p-3"><h5>الخرطوم ⬅️ اسطنبول</h5></div></div>
            </div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="service_type" value="سفر">
                <input type="hidden" name="final_price_hidden" class="p-hidden">
                <select name="details" class="form-select d-none" id="s-select" onchange="updateTravel(this)">
                    <option value="الخرطوم - جدة" <?php echo $_GET['item_id']=='0'?'selected':''; ?> data-price="900000" data-desc="طيران بدر | رحلة مباشرة">جدة</option>
                    <option value="الخرطوم - دبي" <?php echo $_GET['item_id']=='1'?'selected':''; ?> data-price="1500000" data-desc="طيران الإمارات | شامل الوجبات">دبي</option>
                    <option value="الخرطوم - القاهرة" <?php echo $_GET['item_id']=='2'?'selected':''; ?> data-price="750000" data-desc="مصر للطيران | مواعيد دقيقة">القاهرة</option>
                    <option value="الخرطوم - اسطنبول" <?php echo $_GET['item_id']=='3'?'selected':''; ?> data-price="1800000" data-desc="الخطوط التركية | وزن مفتوح">اسطنبول</option>
                </select>
                <h3 class="text-primary mb-3">تفاصيل رحلة <?php echo ($_GET['item_id']=='0'?'جدة':($_GET['item_id']=='1'?'دبي':($_GET['item_id']=='2'?'القاهرة':'اسطنبول'))); ?></h3>
                <div class="p-3 bg-light rounded"><p class="desc-text fw-bold mb-1"></p><div class="price-tag">التكلفة: <span class="price-text"></span> ج.س</div></div>
                <div class="common-fields-container"></div>
                <div class="d-flex gap-2 mt-3"><a href="?type=سفر" class="btn btn-outline-secondary p-3 fw-bold">رجوع</a><button type="submit" class="btn btn-primary flex-grow-1 p-3 fw-bold">تأكيد الحجز</button></div>
            </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if($current_type == 'فندق'): ?>
    <div class="booking-card">
        <?php if($step == 'list'): ?>
            <h2 class="text-warning mb-4 text-center">🏨 اختر الفندق المناسب</h2>
            <div class="selection-grid">
                <div class="selection-item" onclick="window.location.href='?type=فندق&item_id=0'"><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" class="item-img"><div class="p-3"><h5>سلام روتانا</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=فندق&item_id=1'"><img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b" class="item-img"><div class="p-3"><h5>فندق كورنثيا</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=فندق&item_id=2'"><img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" class="item-img"><div class="p-3"><h5>قصر الصداقة</h5></div></div>
            </div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="service_type" value="فندق">
                <input type="hidden" name="final_price_hidden" class="p-hidden">
                <div class="row g-3 mb-3 text-start">
                    <div class="col-md-6"><label class="fw-bold">الفندق:</label>
                        <select id="h-select" class="form-select" onchange="updateHotel()">
                            <option value="سلام روتانا" <?php echo $_GET['item_id']=='0'?'selected':''; ?> data-day="60000" data-week="350000" data-month="1200000" data-img="https://images.unsplash.com/photo-1566073771259-6a8506099945" data-desc="5 نجوم | مسبح أولمبي">سلام روتانا</option>
                            <option value="كورنثيا" <?php echo $_GET['item_id']=='1'?'selected':''; ?> data-day="90000" data-week="550000" data-month="1800000" data-img="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b" data-desc="إطلالة نيلية | مطاعم عالمية">كورنثيا</option>
                            <option value="قصر الصداقة" <?php echo $_GET['item_id']=='2'?'selected':''; ?> data-day="45000" data-week="280000" data-month="900000" data-img="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" data-desc="هدوء تام | حدائق غناء">قصر الصداقة</option>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="fw-bold">المدة:</label>
                        <select id="d-select" class="form-select" onchange="updateHotel()">
                            <option value="يوم">يوم واحد</option><option value="أسبوع">أسبوع</option><option value="شهر">شهر</option>
                        </select>
                    </div>
                </div>
                <div class="text-center"><img class="item-img h-img rounded mb-3" src=""><p class="h-desc fw-bold text-secondary"></p><div class="price-tag">الإجمالي: <span class="h-price"></span> ج.س</div></div>
                <input type="hidden" name="details" id="h-final-details">
                <div class="common-fields-container"></div>
                <div class="d-flex gap-2 mt-3"><a href="?type=فندق" class="btn btn-outline-secondary p-3 fw-bold">رجوع</a><button type="submit" class="btn btn-warning flex-grow-1 p-3 fw-bold">تأكيد الحجز</button></div>
            </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if($current_type == 'عيادة'): ?>
    <div class="booking-card">
        <?php if($step == 'list'): ?>
            <h2 class="text-success mb-4 text-center">🩺 اختر الطبيب المختص</h2>
            <div class="selection-grid">
                <div class="selection-item" onclick="window.location.href='?type=عيادة&item_id=0'"><img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d" class="item-img"><div class="p-3"><h5>د. محمد كمال</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=عيادة&item_id=1'"><img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f" class="item-img"><div class="p-3"><h5>د. سارة عثمان</h5></div></div>
                <div class="selection-item" onclick="window.location.href='?type=عيادة&item_id=2'"><img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" class="item-img"><div class="p-3"><h5>د. أحمد ياسر</h5></div></div>
            </div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="service_type" value="عيادة">
                <input type="hidden" name="final_price_hidden" class="p-hidden">
                <select name="details" class="form-select d-none" id="c-select" onchange="updateClinic(this)">
                    <option value="د. محمد كمال" <?php echo $_GET['item_id']=='0'?'selected':''; ?> data-price="30000" data-img="https://images.unsplash.com/photo-1622253692010-333f2da6031d" data-desc="استشاري جراحة القلب والأوعية الدموية">د. محمد كمال</option>
                    <option value="د. سارة عثمان" <?php echo $_GET['item_id']=='1'?'selected':''; ?> data-price="20000" data-img="https://images.unsplash.com/photo-1594824476967-48c8b964273f" data-desc="استشارية أمراض النساء والتوليد">د. سارة عثمان</option>
                    <option value="د. أحمد ياسر" <?php echo $_GET['item_id']=='2'?'selected':''; ?> data-price="25000" data-img="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" data-desc="اختصاصي طب الأطفال وحديثي الولادة">د. أحمد ياسر</option>
                </select>
                <div class="text-center"><img class="item-img c-img rounded mb-3" style="max-width:350px; margin:0 auto;"><h4 class="c-name"></h4><p class="c-desc fw-bold text-secondary"></p><div class="price-tag">قيمة الكشف: <span class="c-price"></span> ج.س</div></div>
                <div class="common-fields-container"></div>
                <div class="d-flex gap-2 mt-3"><a href="?type=عيادة" class="btn btn-outline-secondary p-3 fw-bold">رجوع</a><button type="submit" class="btn btn-success flex-grow-1 p-3 fw-bold">تثبيت الموعد</button></div>
            </form>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>

<div class="bankak-modal">
    <div class="bankak-card">
        <h3 class="fw-bold">تم الحجز بنجاح</h3>
        <div class="display-6 fw-bold my-3 text-success"><?php echo number_format($price); ?> ج.س</div>
        <p>العميل: <?php echo $name; ?></p>
        <button class="btn btn-dark w-100 p-3 rounded-pill" onclick="window.location.href='?type=<?php echo $current_type; ?>'">إغلاق</button>
    </div>
</div>

<template id="tpl">
    <div class="row g-2 mt-3 text-start">
        <div class="col-md-4"><label class="small fw-bold">الاسم:</label><input type="text" name="customer_name" class="form-control" placeholder="الاسم الكامل" required></div>
        <div class="col-md-4"><label class="small fw-bold">الهاتف:</label><input type="tel" name="phone_number" class="form-control" placeholder="09xxxxxxx" required></div>
        <div class="col-md-4"><label class="small fw-bold">تاريخ الحجز:</label><input type="date" name="booking_date" class="form-control" required></div>
    </div>
    <div class="payment-box">
        <label class="fw-bold mb-2">وسيلة الدفع:</label>
        <select name="payment_method" class="form-select" onchange="toggleAcc(this)">
            <option value="بنكك">تطبيق بنكك (Bankak)</option>
            <option value="كاش">نقداً (كاش)</option>
        </select>
        <div class="acc-field mt-3"><label class="small fw-bold">رقم الحساب:</label><input type="text" name="acc_num" class="form-control" placeholder="أدخل الرقم"></div>
    </div>
</template>

<script>
    function toggleAcc(el) {
        const accField = el.parentElement.querySelector('.acc-field');
        accField.style.display = (el.value === 'بنكك') ? 'block' : 'none';
    }
    function updateTravel(el) {
        if(!el) return;
        const opt = el.selectedOptions[0];
        const card = el.closest('.booking-card');
        card.querySelector('.price-text').innerText = Number(opt.dataset.price).toLocaleString();
        card.querySelector('.desc-text').innerText = opt.dataset.desc;
        card.querySelector('.p-hidden').value = opt.dataset.price;
    }
    function updateHotel() {
        const hS = document.getElementById('h-select'); if(!hS) return;
        const h = hS.selectedOptions[0];
        const d = document.getElementById('d-select').value;
        let p = (d === 'يوم') ? h.dataset.day : (d === 'أسبوع' ? h.dataset.week : h.dataset.month);
        document.querySelector('.h-img').src = h.dataset.img;
        document.querySelector('.h-desc').innerText = h.dataset.desc;
        document.querySelector('.h-price').innerText = Number(p).toLocaleString();
        document.getElementById('h-final-details').value = h.value + ' - ' + d;
        document.querySelector('.p-hidden').value = p;
    }
    function updateClinic(el) {
        if(!el) return;
        const opt = el.selectedOptions[0];
        const card = el.closest('.booking-card');
        card.querySelector('.c-img').src = opt.dataset.img;
        card.querySelector('.c-desc').innerText = opt.dataset.desc;
        card.querySelector('.c-price').innerText = Number(opt.dataset.price).toLocaleString();
        card.querySelector('.p-hidden').value = opt.dataset.price;
    }
    window.onload = function() {
        const tpl = document.getElementById('tpl').content;
        document.querySelectorAll('.common-fields-container').forEach(div => div.appendChild(document.importNode(tpl, true)));
        updateTravel(document.getElementById('s-select'));
        updateHotel();
        updateClinic(document.getElementById('c-select'));
    }
</script>
</body>
</html>
