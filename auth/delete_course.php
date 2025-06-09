<?php
session_start();
include __DIR__ . '/../backend/config/connect.php';

if (!isset($_GET['id'])) {
    $_SESSION['toast_success'] = "ไม่พบคอร์สที่ต้องการลบ";
    header("Location: ../admin/view-courses.php");
    exit();
}

$course_id = $_GET['id'];

// เปิด transaction
$conn->begin_transaction();

try {
    // 1. ลบโมดูลทั้งหมดที่เกี่ยวข้องกับคอร์สนี้
    $stmt1 = $conn->prepare("DELETE FROM module_course WHERE course_id = ?");
    $stmt1->bind_param("i", $course_id);
    $stmt1->execute();
    $stmt1->close();

    // 2. ลบคอร์ส
    $stmt2 = $conn->prepare("DELETE FROM course WHERE course_id = ?");
    $stmt2->bind_param("i", $course_id);
    $stmt2->execute();
    $stmt2->close();

    // ยืนยันการลบ
    $conn->commit();

    $_SESSION['toast_success'] = "ลบคอร์สและโมดูลที่เกี่ยวข้องเรียบร้อยแล้ว";
} catch (Exception $e) {
    // ยกเลิกการลบหากเกิดข้อผิดพลาด
    $conn->rollback();
    $_SESSION['toast_success'] = "เกิดข้อผิดพลาดในการลบข้อมูล: " . $e->getMessage();
}

$conn->close();
header("Location: ../admin/view-courses.php");
exit();
?>
