<?php
session_start();
include 'connect.php';  // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['username']) || !isset($_SESSION['personnel_id'])) {
    header("Location: blackendlogin.php");
    exit();
}

// ดึง personnel_id จาก session
$personnel_id = $_SESSION['personnel_id'];

// ตรวจสอบว่า personnel_id ถูกตั้งค่าอย่างถูกต้อง
if (empty($personnel_id)) {
    die("เกิดข้อผิดพลาด: personnel_id ไม่ได้ถูกตั้งค่าใน session");
}

// SQL query เพื่อดึงข้อมูลจากตาราง login และ personnel
$sql = "
    SELECT l.username, p.name_ps, p.lastname_ps, p.email
    FROM login l
    INNER JOIN personnel p ON l.user_id = p.id
    WHERE l.user_id = ?
";
$stmt = $conn->prepare($sql);

// ตรวจสอบว่าการเตรียมคำสั่ง SQL สำเร็จหรือไม่
if ($stmt === false) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL");
}

// Binding parameter
$stmt->bind_param("i", $personnel_id);  // binding the personnel_id to the query
$stmt->execute();

// ดึงผลลัพธ์จากการ query
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (!$data) {
    die("ไม่พบข้อมูลของผู้ใช้ในระบบ");
}

$stmt->close();
$conn->close();
?>
