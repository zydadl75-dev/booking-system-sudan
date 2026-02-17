<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام الحجوزات الذكي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* تنسيق الهيدر للموبايل واللابتوب */
        .navbar { background-color: #1a1d20 !important; padding: 10px 0; }
        .navbar-brand { font-size: 1.2rem; color: #fff !important; }
        
        /* تنسيق زر القائمة في التلفون */
        .navbar-toggler { border: none; padding: 0; }
        .navbar-toggler:focus { shadow: none; outline: none; }
        
        /* تنسيق الروابط داخل القائمة */
        .nav-link { color: #ffffff !important; padding: 10px 15px !important; border-bottom: 1px solid #333; }
        @media (min-width: 992px) {
            .nav-link { border-bottom: none; }
        }
        
        /* تنسيق البطاقات لتكون متناسقة في التلفون */
        .container { padding-right: 15px; padding-left: 15px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-calendar-check-fill me-2"></i> نظام الحجوزات
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0 text-center">
                <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">من نحن</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a class="nav-link btn btn-primary text-white px-4 mx-lg-2" href="manage.php" style="border:none;">إدارة الحجوزات</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
