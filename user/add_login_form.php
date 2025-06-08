<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$personnel_id = $_GET['personnel_id'] ?? null;

if (!$personnel_id) {
    echo "ไม่พบรหัสบุคลากร"; exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // เก็บ plain text

    $sql = "INSERT INTO login (username, password, personnel_id) VALUES ('$username', '$password', $personnel_id)";
    if (mysqli_query($conn, $sql)) {
        header("Location: update-personnel.php"); // หรือกลับไปหน้าแสดงบุคลากร
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการเพิ่มบัญชีผู้ใช้";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>เพิ่มบัญชีเข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>เพิ่มบัญชีเข้าสู่ระบบ</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">ชื่อผู้ใช้</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">รหัสผ่าน</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">บันทึก</button>
        <a href="personnel-list.php" class="btn btn-secondary">กลับ</a>
    </form>
</div>
</body>
</html>
