<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);


    if ($conn) {
        // SQL คำสั่งในการดึงข้อมูลผู้ใช้
        $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // ล็อคอินสำเร็จ
            $_SESSION['username'] = $username;
            header("Location: blackendhome.php"); 
            exit();
        } else {
            // ล็อคอินไม่สำเร็จ
            echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); window.location.href='blackendlogin.php';</script>";
        }

        $conn->close();
    } else {
        echo "Connection failed: " . $conn->connect_error;
    }
}
?>
