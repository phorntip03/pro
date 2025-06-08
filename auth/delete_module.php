<?php
session_start();
include '../backend/config/connect.php';

// เช็ค login ก่อน
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

// รับค่าจาก URL
if (!isset($_GET['module_id']) || !isset($_GET['course_id'])) {
    header("Location: manage_courses.php");
    exit();
}

$module_id = $_GET['module_id'];
$course_id = $_GET['course_id'];

// ลบโมดูลจากฐานข้อมูล
$sql = "DELETE FROM module_course WHERE module_course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $module_id);

if ($stmt->execute()) {
    // ตั้งค่า toast success
    $_SESSION['toast_success'] = "ลบโมดูลสำเร็จ!";
}

// กลับไปที่หน้า manage_modules.php ของคอร์สนั้น
header("Location: view-courses.php?course_id=$course_id");
exit();
