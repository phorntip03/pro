<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];


    $check = $conn->prepare("SELECT * FROM studentstatus WHERE student_id = ?");
    $check->bind_param("i", $student_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // อัปเดตสถานะเดิม
        $sql = $conn->prepare("UPDATE studentstatus SET namestatus_st = ? WHERE student_id = ?");
        $sql->bind_param("si", $status, $student_id);
    } else {
        // เพิ่มสถานะใหม่
        $sql = $conn->prepare("INSERT INTO studentstatus (student_id, namestatus_st) VALUES (?, ?)");
        $sql->bind_param("is", $student_id, $status);
    }

    if ($sql->execute()) {
        // กลับไปที่หน้าแสดงรายชื่อนักเรียนหลังอัปเดต
        header("Location: check-registration.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
} else {
    echo "ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง";
}
?>
