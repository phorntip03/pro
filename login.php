<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);


    $sql = "SELECT l.personnel_id, l.username 
    FROM login l
    WHERE l.username = ? AND l.password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
$_SESSION['username'] = $row['username'];
$_SESSION['personnel_id'] = $row['personnel_id']; 
header("Location: edit-profile.php");
exit();
} else {
echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
}
}
?>
