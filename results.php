<?php
session_start();
require_once 'connect.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

// รับค่าจากฟอร์ม
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['password'] ?? '';

if ($password !== $confirmPassword) {
    echo "<script>alert('รหัสผ่านไม่ตรงกัน'); window.history.back();</script>";
    exit();
}

$username = $_SESSION['username'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // แฮชรหัสผ่าน

// อัปเดตลงฐานข้อมูล
$sql = "UPDATE login SET password = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt->execute([$hashedPassword, $username])) {
    echo "<script>alert('อัปเดตรหัสผ่านสำเร็จ'); window.location.href='profile.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดต'); window.history.back();</script>";
}
?>
