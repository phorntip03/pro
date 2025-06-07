<?php
session_start();
include '../backend/config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = trim($conn->real_escape_string($_POST['password']));

    // เอา JOIN ออก
    $sql = "SELECT id, username FROM login WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['personnel_id'] = $row['personnel_id'];
        $_SESSION['student_id'] = $row['student_id'];

        header("Location: ../admin/blackendhome.php");
        exit();
    } else {
        echo "<script>
                alert('❌ ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
                window.location.href = '../../index.php';
              </script>";
        exit();
    }
}
?>
