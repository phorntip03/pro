<?php
session_start();
if (!isset($_SESSION['personnel_id'])) {
    header("Location: blackendlogin.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

$personnel_id = $_SESSION['personnel_id'];
$name = $_POST['name_ps'];
$lastname = $_POST['lastname_ps'];
$email = $_POST['email'];

// ต้องใช้ชื่อ column ให้ตรงกับฐานข้อมูล
$sql = "UPDATE personnel SET name_ps = ?, lastname_ps = ?, email = ? WHERE personnel_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssi", $name, $lastname, $email, $personnel_id);

if ($stmt->execute()) {
    header("Location: edit-profile.php");
    exit();
} else {
    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error;
}
?>
