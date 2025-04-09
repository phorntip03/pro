<?php
session_start();
include 'config.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");  // ถ้ายังไม่ได้เข้าสู่ระบบ ให้ไปที่หน้า login
    exit();
}

$username = $_SESSION['username'];  // เอาชื่อผู้ใช้จาก session

// รับค่าจากฟอร์ม
$newPassword = $_POST['password'];
$newEmail = $_POST['email'];

// อัปเดตข้อมูลในฐานข้อมูล
$sql = "UPDATE personnel SET password = ?, email = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $newPassword, $newEmail, $username);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "ข้อมูลถูกอัปเดตเรียบร้อยแล้ว";
} else {
    echo "ไม่สามารถอัปเดตข้อมูลได้";
}

$stmt->close();
$conn->close();
?>
