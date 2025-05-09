<?php
session_start();
$personnel_id = $_SESSION['personnel_id'];

$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

$name = $_POST['name_ps'];
$lastname = $_POST['lastname_ps'];
$email = $_POST['email'];
$branch = $_POST['branch'];

// เช็คว่ามีการอัปโหลดรูปใหม่หรือไม่
if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
    $target_dir = "uploads/";
    $filename = basename($_FILES["profile_img"]["name"]);
    $target_file = $target_dir . time() . "_" . $filename;

    // อัปโหลดไฟล์
    if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
        // อัปเดตข้อมูลพร้อมชื่อรูป
        $img_name = basename($target_file);
        $sql = "UPDATE personnel SET name_ps=?, lastname_ps=?, email=?, img_ps=? WHERE personnel_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $lastname, $email, $img_name, $personnel_id);
    } else {
        echo "อัปโหลดรูปไม่สำเร็จ";
        exit;
    }
} else {
    // ไม่มีการอัปโหลดรูป
    $sql = "UPDATE personnel SET name_ps=?, lastname_ps=?, email=? WHERE personnel_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $lastname, $email, $personnel_id);
}

$stmt->execute();
$stmt->close();
$conn->close();

header("Location: profile.php");
exit();
?>
