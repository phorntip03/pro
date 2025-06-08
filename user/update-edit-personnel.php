<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

// รับข้อมูลจากฟอร์ม
$id = $_POST['personnel_id'];
$name_ps = $_POST['name_ps'];
$lastname_ps = $_POST['lastname_ps'];
$email = $_POST['email'];
$branch_id = $_POST['branch_id'];
$position_id = $_POST['position_id'];
$personnelstatus_id = $_POST['personnelstatus_id'];

// ตรวจสอบว่าอัปโหลดไฟล์ใหม่หรือไม่
if (isset($_FILES['img_ps']) && $_FILES['img_ps']['name'] != '') {
    $target_dir = "../assets/uploads/personnel/";
    $new_filename = uniqid() . "_" . basename($_FILES["img_ps"]["name"]);
    $target_file = $target_dir . $new_filename;

    // อัปโหลดไฟล์
    if (move_uploaded_file($_FILES["img_ps"]["tmp_name"], $target_file)) {
        // ลบไฟล์เก่า (ถ้าต้องการ)
        $getOldImg = $conn->query("SELECT img_ps FROM personnel WHERE personnel_id = $id");
        $oldImg = $getOldImg->fetch_assoc();
        if (!empty($oldImg['img_ps']) && file_exists($target_dir . $oldImg['img_ps'])) {
            unlink($target_dir . $oldImg['img_ps']);
        }

        // อัปเดตรูปใหม่ด้วย
        $updateImg = ", img_ps = '$new_filename'";
    } else {
        echo "<script>alert('อัปโหลดรูปภาพไม่สำเร็จ');history.back();</script>";
        exit();
    }
} else {
    $updateImg = "";
}

// อัปเดตข้อมูล
$sql = "UPDATE personnel SET 
    name_ps = '$name_ps',
    lastname_ps = '$lastname_ps',
    email = '$email',
    branch_id = '$branch_id',
    position_id = '$position_id',
    personnelstatus_id = '$personnelstatus_id'
    $updateImg
    WHERE personnel_id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('แก้ไขข้อมูลสำเร็จ');window.location='personnel_list.php';</script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$conn->close();
?>
