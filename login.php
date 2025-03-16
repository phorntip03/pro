<?php
session_start();
include 'connect.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if ($conn) {
        // SQL คำสั่งในการดึงข้อมูลผู้ใช้
        $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // ล็อคอินสำเร็จ
            $_SESSION['username'] = $username; // เก็บชื่อผู้ใช้ใน session
            header("Location: blackendhome.php"); // เปลี่ยนเส้นทางไปที่หน้า dashboard หรือหน้าหลักของผู้ใช้
            exit();
        } else {
            // ล็อคอินไม่สำเร็จ
            echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'); window.location.href='blackendlogin.php';</script>";
        }

        // ปิดการเชื่อมต่อ
        $conn->close();
    } else {
        echo "Connection failed: " . $conn->connect_error;
    }
}
?>
