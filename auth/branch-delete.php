<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

include '../backend/config/connect.php';

if (isset($_GET['id'])) {
    $branch_id = intval($_GET['id']);

    // ตรวจสอบว่ามี personnel ที่ใช้ branch นี้หรือไม่
    $check_sql = "SELECT COUNT(*) AS count FROM personnel WHERE branch_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $branch_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count_row = $result->fetch_assoc();

    if ($count_row['count'] > 0) {
        // ถ้ามีการใช้งาน branch นี้อยู่
        echo "<script>
            alert('ไม่สามารถลบสาขานี้ได้ เนื่องจากมีบุคลากรที่ยังใช้อยู่');
            window.location.href = '../admin/branch-manage.php';
        </script>";
        exit();
    }

    // หากไม่มีการใช้งาน branch นี้ ลบได้
    $delete_sql = "DELETE FROM branch WHERE branch_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $branch_id);
    if ($stmt->execute()) {
        echo "<script>
            alert('ลบข้อมูลสาขาสำเร็จ');
            window.location.href = '../admin/branch-manage.php';
        </script>";
    } else {
        echo "<script>
            alert('เกิดข้อผิดพลาดในการลบ');
            window.location.href = '../admin/branch-manage.php';
        </script>";
    }
}
?>
