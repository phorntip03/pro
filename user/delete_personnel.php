<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

$id = $_GET['id'];

// ลบข้อมูล login ที่อิงกับ personnel_id นี้ก่อน
$conn->query("DELETE FROM login WHERE personnel_id = $id");

// ดึงไฟล์ภาพเก่ามาเพื่อลบออก
$getOldImg = $conn->query("SELECT img_ps FROM personnel WHERE personnel_id = $id");
$oldImg = $getOldImg->fetch_assoc();
if (!empty($oldImg['img_ps']) && file_exists("../assets/uploads/personnel/" . $oldImg['img_ps'])) {
    unlink("../assets/uploads/personnel/" . $oldImg['img_ps']);
}

// ลบข้อมูลใน personnel
$sql = "DELETE FROM personnel WHERE personnel_id = $id";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('ลบข้อมูลเรียบร้อย');window.location='personnel_list.php';</script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$conn->close();
?>
