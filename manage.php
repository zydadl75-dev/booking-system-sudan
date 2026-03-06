<?php
session_start();

// البيانات سرية هنا فقط ولا تظهر في المتصفح
$admin_user     = "ايات";
$admin_password = "My dream123@";

$error = "";
if (isset($_POST['login'])) {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        // رسالة الخطأ تظهر فقط عند كتابة بيانات غلط
        $error = "خطأ في بيانات الدخول!";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// الاتصال بالقاعدة
$servername = "sql301.infinityfree.com";
$username   = "if0_40459700";
$password   = "96P21XgLltXX8"; 
$dbname     = "if0_40459700_hospital_db";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// كود الحذف
if (isset($_SESSION['admin_logged_in']) && isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM bookings WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION['admin_logged_in'])): 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دخول الإدارة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif; }
        .login-card { background: white; padding: 2rem; border-radius: 12px; shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 380px; }
    </style>
</head>
<body>
    <div class="login-card shadow">
        <h4 class="text-center mb-4 fw-bold text-primary">دخول الإدارة</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" placeholder="أدخل اسم المستخدم" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">كلمة المرور</label>
                <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">دخول</button>
            <?php if($error): ?>
                <div class="alert alert-danger mt-3 py-2 small text-center"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
<?php exit; endif; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>لوحة التحكم</title>
</head>
<body class="p-4 bg-light">
    <div class="container bg-white p-4 rounded shadow-sm">
        <div class="d-flex justify-content-between mb-4">
            <h3>قائمة الحجوزات</h3>
            <a href="?logout=1" class="btn btn-sm btn-outline-danger">تسجيل خروج</a>
        </div>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>الاسم</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
                while($row = $result->fetch_assoc()): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['sub_service_details']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('حذف هذا الحجز؟')">حذف</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

