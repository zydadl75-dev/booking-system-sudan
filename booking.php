<?php

// 1. إعدادات قاعدة البيانات

$servername = "sql301.infinityfree.com";

$username   = "if0_40459700";

$password   = "96P21XgLltXX8"; 

$dbname     = "if0_40459700_hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8mb4");

$show_success = false;

$name = ""; $service = ""; $price = 0; $pay_method = ""; $current_type = isset($_GET['type']) ? $_GET['type'] : 'سفر';

// 2. معالجة البيانات عند الإرسال

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name    = $conn->real_escape_string($_POST['customer_name']);

    $phone   = $conn->real_escape_string($_POST['phone_number']);

    $details = $conn->real_escape_string($_POST['details']);

    $service = $_POST['service_type'];

    $price   = $_POST['final_price_hidden']; 

    $pay_method = $_POST['payment_method'];

    $booking_date = $_POST['booking_date']; // التاريخ الجديد

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

        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

        .booking-card { display: none; max-width: 800px; margin: 30px auto; background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        .active { display: block !important; }

        .item-img { width: 100%; height: 300px; object-fit: cover; border-radius: 15px; border: 1px solid #ddd; }

        .price-tag { font-size: 1.8rem; color: #28a745; font-weight: bold; margin: 15px 0; }

        

        /* مودال بنكك */

        .bankak-modal { display: <?php echo $show_success ? 'flex' : 'none'; ?>; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; }

        .bankak-card { background: white; width: 90%; max-width: 380px; border-radius: 25px; padding: 25px; text-align: center; border-top: 8px solid #28a745; }

        .success-icon { background: #7ED321; width: 60px; height: 60px; border-radius: 12px; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 35px; }

        .receipt-table { background: #f9f9f9; border-radius: 15px; padding: 15px; margin: 15px 0; text-align: right; }

        .receipt-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; border-bottom: 1px solid #eee; }

        

        .payment-box { background: #fffbe6; padding: 15px; border-radius: 12px; border: 1px dashed #ffc107; margin-top: 15px; }

    </style>

</head>

<body>

<div class="container">

    <div id="form-سفر" class="booking-card">

        <h2 class="text-primary mb-4">✈️ حجز طيران دولي</h2>

        <form method="POST">

            <input type="hidden" name="service_type" value="سفر">

            <input type="hidden" name="final_price_hidden" class="p-hidden">

            <select name="details" class="form-select form-select-lg mb-3" onchange="updateTravel(this)">

                <option value="الخرطوم - جدة" data-price="900000" data-desc="طيران بدر | رحلة مباشرة">الخرطوم ⬅️ جدة (900,000 ج)</option>

                <option value="الخرطوم - دبي" data-price="1500000" data-desc="طيران الإمارات | شامل الوجبات">الخرطوم ⬅️ دبي (1,500,000 ج)</option>

                <option value="الخرطوم - القاهرة" data-price="750000" data-desc="مصر للطيران | مواعيد دقيقة">الخرطوم ⬅️ القاهرة (750,000 ج)</option>

                <option value="الخرطوم - اسطنبول" data-price="1800000" data-desc="الخطوط التركية | وزن مفتوح">الخرطوم ⬅️ اسطنبول (1,800,000 ج)</option>

            </select>

            <div class="feature-box p-3 bg-light rounded"><p class="desc-text fw-bold"></p><div class="price-tag">التكلفة: <span class="price-text"></span> ج.س</div></div>

            <div class="common-fields-container"></div>

            <button type="submit" class="btn btn-primary w-100 p-3 mt-3 fw-bold">تأكيد الحجز والخصم</button>

        </form>

    </div>

    <div id="form-فندق" class="booking-card">

        <h2 class="text-warning mb-4">🏨 حجز فنادق ومنتجعات</h2>

        <form method="POST">

            <input type="hidden" name="service_type" value="فندق">

            <input type="hidden" name="final_price_hidden" class="p-hidden">

            <div class="row mb-3">

                <div class="col-md-6">

                    <select id="h-select" class="form-select" onchange="updateHotel()">

                        <option value="سلام روتانا" data-day="60000" data-week="350000" data-month="1200000" data-img="https://images.unsplash.com/photo-1566073771259-6a8506099945" data-desc="5 نجوم | مسبح أولمبي">فندق سلام روتانا</option>

                        <option value="كورنثيا" data-day="90000" data-week="550000" data-month="1800000" data-img="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b" data-desc="إطلالة نيلية | مطاعم عالمية">فندق كورنثيا</option>

                        <option value="قصر الصداقة" data-day="45000" data-week="280000" data-month="900000" data-img="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb" data-desc="هدوء تام | حدائق غناء">فندق قصر الصداقة</option>

                    </select>

                </div>

                <div class="col-md-6">

                    <select id="d-select" class="form-select" onchange="updateHotel()">

                        <option value="يوم">يوم واحد</option><option value="أسبوع">أسبوع</option><option value="شهر">شهر</option>

                    </select>

                </div>

            </div>

            <div class="text-center"><img class="item-img h-img" src=""><p class="h-desc fw-bold mt-3 text-secondary"></p><div class="price-tag">الإجمالي: <span class="h-price"></span> ج.س</div></div>

            <input type="hidden" name="details" id="h-final-details">

            <div class="common-fields-container"></div>

            <button type="submit" class="btn btn-warning w-100 p-3 mt-3 fw-bold">تأكيد الحجز</button>

        </form>

    </div>

    <div id="form-عيادة" class="booking-card">

        <h2 class="text-success mb-4">🩺 حجز عيادات تخصصية</h2>

        <form method="POST">

            <input type="hidden" name="service_type" value="عيادة">

            <input type="hidden" name="final_price_hidden" class="p-hidden">

            <select name="details" class="form-select form-select-lg mb-3" onchange="updateClinic(this)">

                <option value="د. محمد كمال" data-price="30000" data-img="https://images.unsplash.com/photo-1622253692010-333f2da6031d" data-desc="استشاري جراحة القلب والأوعية الدموية">د. محمد كمال (30,000 ج)</option>

                <option value="د. سارة عثمان" data-price="20000" data-img="https://images.unsplash.com/photo-1594824476967-48c8b964273f" data-desc="استشارية أمراض النساء والتوليد">د. سارة عثمان (20,000 ج)</option>

                <option value="د. أحمد ياسر" data-price="25000" data-img="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d" data-desc="اختصاصي طب الأطفال وحديثي الولادة">د. أحمد ياسر (25,000 ج)</option>

            </select>

            <div class="text-center"><img class="item-img c-img" src=""><p class="c-desc fw-bold mt-3 text-secondary"></p><div class="price-tag">قيمة الكشف: <span class="c-price"></span> ج.س</div></div>

            <div class="common-fields-container"></div>

            <button type="submit" class="btn btn-success w-100 p-3 mt-3 fw-bold">تثبيت موعد الكشف</button>

        </form>

    </div>

</div>

<div class="bankak-modal">

    <div class="bankak-card">

        <div class="success-icon">✓</div>

        <h3 class="fw-bold">نجحت العملية</h3>

        <p class="text-muted small">تم خصم مبلغ وقدره</p>

        <div class="display-6 fw-bold mb-3"><?php echo number_format($price); ?> <span class="fs-6">جنيه</span></div>

        <div class="receipt-table">

            <div class="receipt-row"><span>العميل:</span><b><?php echo $name; ?></b></div>

            <div class="receipt-row"><span>الخدمة:</span><b><?php echo $service; ?></b></div>

            <div class="receipt-row" style="border:0"><span>طريقة الدفع:</span><b><?php echo $pay_method; ?></b></div>

        </div>

        <button class="btn btn-dark w-100 p-3 rounded-pill" onclick="window.location.href='?type=<?php echo $current_type; ?>'">العودة لصفحة الحجز</button>

    </div>

</div>

<template id="tpl">

    <div class="row g-2 mt-3">

        <div class="col-md-4"><label class="small fw-bold">الاسم:</label><input type="text" name="customer_name" class="form-control" placeholder="الاسم الكامل" required></div>

        <div class="col-md-4"><label class="small fw-bold">الهاتف:</label><input type="tel" name="phone_number" class="form-control" placeholder="09xxxxxxx" required></div>

        <div class="col-md-4"><label class="small fw-bold">تاريخ الحجز:</label><input type="date" name="booking_date" class="form-control" required></div>

    </div>

    

    <div class="payment-box">

        <label class="fw-bold mb-2">وسيلة الدفع:</label>

        <select name="payment_method" class="form-select pay-selector" onchange="toggleAcc(this)">

            <option value="بنكك">تطبيق بنكك (Bankak)</option>

            <option value="فيزا">بطاقة فيزا (Visa)</option>

            <option value="كاش">نقداً (كاش)</option>

        </select>

        <div class="acc-field mt-3">

            <label class="small fw-bold">رقم الحساب:</label>

            <input type="text" name="acc_num" class="form-control" placeholder="أدخل الرقم">

        </div>

    </div>

</template>

<script>

    function toggleAcc(el) {

        const accField = el.parentElement.querySelector('.acc-field');

        accField.style.display = (el.value === 'بنكك' || el.value === 'فيزا') ? 'block' : 'none';

    }

    function updateTravel(el) {

        const opt = el.selectedOptions[0];

        const card = el.closest('.booking-card');

        card.querySelector('.price-text').innerText = Number(opt.dataset.price).toLocaleString();

        card.querySelector('.desc-text').innerText = opt.dataset.desc;

        card.querySelector('.p-hidden').value = opt.dataset.price;

    }

    function updateHotel() {

        const h = document.getElementById('h-select').selectedOptions[0];

        const d = document.getElementById('d-select').value;

        let price = (d === 'يوم') ? h.dataset.day : (d === 'أسبوع' ? h.dataset.week : h.dataset.month);

        document.querySelector('.h-img').src = h.dataset.img;

        document.querySelector('.h-desc').innerText = h.dataset.desc;

        document.querySelector('.h-price').innerText = Number(price).toLocaleString();

        document.getElementById('h-final-details').value = `${h.value} - ${d}`;

        document.querySelector('#form-فندق .p-hidden').value = price;

    }

    function updateClinic(el) {

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

        const params = new URLSearchParams(window.location.search);

        const type = params.get('type') || 'سفر';

        document.getElementById('form-' + type)?.classList.add('active');

        updateTravel(document.querySelector('#form-سفر select'));

        updateHotel();

        updateClinic(document.querySelector('#form-عيادة select'));

    }

</script>

</body>

</html>

