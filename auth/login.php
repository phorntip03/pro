<?php
session_start();
include '../backend/config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = trim($conn->real_escape_string($_POST['password']));

    // SQL สำหรับเช็ก username + password
    $sql = "SELECT l.personnel_id, l.username 
            FROM login l
            WHERE l.username = ? AND l.password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // ถ้าเจอผู้ใช้
        $_SESSION['username'] = $row['username'];
        $_SESSION['personnel_id'] = $row['personnel_id']; 
        header("Location: ../admin/blackendhome.php");
        exit();
    } else {
        // ถ้าไม่เจอให้เด้งแจ้งเตือน แล้วกลับไป index.php
        echo "<script>
                alert('❌ ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
                window.location.href = '../../index.php';
              </script>";
        exit();
    }
}
?>
