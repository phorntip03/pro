<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$branch_id = $_GET['id'] ?? 0;

// ตรวจสอบก่อนว่ามี personnel ที่ใช้ branch นี้อยู่หรือไม่
$check = mysqli_query($conn, "SELECT * FROM personnel WHERE branch_id = $branch_id");

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('ไม่สามารถลบสาขานี้ได้ เนื่องจากมีบุคลากรที่เกี่ยวข้องอยู่'); window.location.href='branch-manage.php';</script>";
    exit();
}

// หากไม่มีการอ้างอิง ให้ลบได้
$sql = "DELETE FROM branch WHERE branch_id = $branch_id";
mysqli_query($conn, $sql);

header("Location:../admin/branch-manage.php");
exit();
?>
