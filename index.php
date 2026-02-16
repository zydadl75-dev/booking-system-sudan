<?php include 'includes/header.php'; ?>

<div class="text-center my-5 py-4">
    <h1 class="display-4 fw-bold text-dark">نظام الحجوزات الذكي</h1>
    <p class="lead text-muted mb-5">خدماتنا بين يديك.. اختر وجهتك أو موعدك الآن</p>
    
    <div class="row mt-4 justify-content-center">
        <div class="col-md-3 mx-2 card shadow-lg p-0 bg-white rounded border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=500" class="card-img-top" style="height: 180px; object-fit: cover;" alt="سفر">
            <div class="p-3 text-center">
                <h3 class="h5 fw-bold text-primary">خدمات السفر</h3>
                <p class="small text-muted">رحلات سياحية وحجوزات عالمية</p>
                <a href="booking.php?type=سفر" class="btn btn-primary btn-sm w-100 mt-2">ابدأ الحجز</a>
            </div>
        </div>

        <div class="col-md-3 mx-2 card shadow-lg p-0 bg-white rounded border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=500" class="card-img-top" style="height: 180px; object-fit: cover;" alt="عيادة">
            <div class="p-3 text-center">
                <h3 class="h5 fw-bold text-primary">الخدمات الطبية</h3>
                <p class="small text-muted">مواعيد عيادات واستشارات فورية</p>
                <a href="booking.php?type=عيادة" class="btn btn-primary btn-sm w-100 mt-2">احجز موعدك</a>
            </div>
        </div>

        <div class="col-md-3 mx-2 card shadow-lg p-0 bg-white rounded border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500" class="card-img-top" style="height: 180px; object-fit: cover;" alt="فندق">
            <div class="p-3 text-center">
                <h3 class="h5 fw-bold text-primary">الفنادق والمنتجعات</h3>
                <p class="small text-muted">إقامات مريحة في أفخم الفنادق</p>
                <a href="booking.php?type=فندق" class="btn btn-primary btn-sm w-100 mt-2">احجز إقامتك</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

