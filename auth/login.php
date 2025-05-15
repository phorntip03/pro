<?php
session_start();
include '../backend/config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = trim($conn->real_escape_string($_POST['password']));

    // JOIN กับ personnel 
    $sql = "SELECT l.personnel_id, l.username, p.img_ps
            FROM login l
            JOIN personnel p ON l.personnel_id = p.personnel_id
            WHERE l.username = ? AND l.password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['personnel_id'] = $row['personnel_id'];
        $_SESSION['img_ps'] = $row['img_ps']; 

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
