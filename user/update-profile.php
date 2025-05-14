<?php
session_start();
$personnel_id = $_SESSION['personnel_id'];

$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

$name = $_POST['name_ps'];
$lastname = $_POST['lastname_ps'];
$email = $_POST['email'];

// เตรียมชื่อไฟล์ภาพ
$uploadDir = "../uploads/";
$imgFilename = "profile_" . $personnel_id . ".jpg";
$targetPath = $uploadDir . $imgFilename;

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
    if (file_exists($targetPath)) {
        unlink($targetPath);
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

    $sql = "UPDATE personnel SET name_ps=?, lastname_ps=?, email=?, img_ps=? WHERE personnel_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $lastname, $email, $imgFilename, $personnel_id);
} else {
    $sql = "UPDATE personnel SET name_ps=?, lastname_ps=?, email=? WHERE personnel_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $lastname, $email, $personnel_id);
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
