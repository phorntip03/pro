<?php
session_start();
$personnel_id = $_SESSION['personnel_id'];

$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

// รับค่าจากฟอร์ม
$namestatus = $_POST['namestatus_ps'];
$name       = $_POST['name_ps'];
$lastname   = $_POST['lastname_ps'];
$email      = $_POST['email'];
$branch_id  = $_POST['branch_id'];

// แปลงคำนำหน้าให้เป็น personnelstatus_id
$stmtStatus = $conn->prepare("SELECT personnelstatus_id FROM personnelstatus WHERE namestatus_ps = ?");
$stmtStatus->bind_param("s", $namestatus);
$stmtStatus->execute();
$resultStatus = $stmtStatus->get_result();

if ($rowStatus = $resultStatus->fetch_assoc()) {
    $personnelstatus_id = $rowStatus['personnelstatus_id'];
} else {
    $_SESSION['msg'] = "ไม่พบคำนำหน้าที่เลือก";
    header("Location: ../user/edit-profile.php");
    exit;
}
$stmtStatus->close();

// เตรียมอัปโหลดรูป
$uploadDir = "../uploads/";
$imgFilename = "profile_" . $personnel_id . ".jpg";
$targetPath  = $uploadDir . $imgFilename;

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
    if (file_exists($targetPath)) {
        unlink($targetPath); // ลบรูปเก่า
    }

    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (in_array($_FILES['profile_image']['type'], $allowedTypes)) {
        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            $_SESSION['msg'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            header("Location: ../user/edit-profile.php");
            exit;
        }
    } else {
        $_SESSION['msg'] = "รองรับเฉพาะไฟล์ JPG หรือ PNG เท่านั้น";
        header("Location: ../user/edit-profile.php");
        exit;
    }

    // อัปเดตพร้อมรูป
    $sql = "UPDATE personnel 
            SET name_ps=?, lastname_ps=?, email=?, img_ps=?, personnelstatus_id=?, branch_id=?
            WHERE personnel_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiii", $name, $lastname, $email, $imgFilename, $personnelstatus_id, $branch_id, $personnel_id);
} else {
    // อัปเดตไม่เปลี่ยนรูป
    $sql = "UPDATE personnel 
            SET name_ps=?, lastname_ps=?, email=?, personnelstatus_id=?, branch_id=?
            WHERE personnel_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $name, $lastname, $email, $personnelstatus_id, $branch_id, $personnel_id);
}

if ($stmt->execute()) {
    $_SESSION['msg'] = "บันทึกข้อมูลสำเร็จ!";
} else {
    $_SESSION['msg'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
}

$stmt->close();
$conn->close();

header("Location: edit-profile.php?status=success");
exit();
?>
