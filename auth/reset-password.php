<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$username = $_SESSION['username'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "รหัสผ่านใหม่และยืนยันไม่ตรงกัน";
    } else {
        $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
        $stmt->close();

        if (!$storedPassword) {
            $error = "ไม่พบข้อมูลผู้ใช้";
        } else {
            if ($currentPassword === $storedPassword) {
                $Password = $newPassword;
                $stmt = $conn->prepare("UPDATE login SET password = ? WHERE username = ?");
                $stmt->bind_param("ss", $Password, $username);
                if ($stmt->execute()) {
                    $success = "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว";
                } else {
                    $error = "เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน";
                }
                $stmt->close();
            } else {
                $error = "รหัสผ่านเดิมไม่ถูกต้อง";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เปลี่ยนรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

    <div class="d-flex">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="container py-5">
            <h2 class="mb-4">เปลี่ยนรหัสผ่าน</h2>

            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } elseif (!empty($success)) { ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php } ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">รหัสผ่านเดิม</label>
                    <div class="input-group">
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password', this)" title="ดูรหัสผ่าน">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">รหัสผ่านใหม่</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password', this)" title="ดูรหัสผ่าน">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">บันทึก</button>
                <a href="backend-home.php" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        window.togglePassword = function(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
                btn.setAttribute("title", "ซ่อนรหัสผ่าน");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
                btn.setAttribute("title", "ดูรหัสผ่าน");
            }
        };
    });
    </script>
</body>
</html>
