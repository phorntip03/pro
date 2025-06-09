<?php
session_start();
include __DIR__ . '/../backend/config/connect.php';

if (!isset($_GET['module_id']) || !isset($_GET['course_id'])) {
    $_SESSION['toast_success'] = "ไม่พบโมดูลที่ต้องการลบ";
    header("Location: ../admin/view-courses.php");
    exit();
}

$module_id = $_GET['module_id'];
$course_id = $_GET['course_id'];

$conn->begin_transaction();

try {

    $stmt = $conn->prepare("DELETE FROM module_course WHERE modulecourse_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $module_id, $course_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    $_SESSION['toast_success'] = "ลบโมดูลเรียบร้อยแล้ว";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['toast_success'] = "เกิดข้อผิดพลาดในการลบโมดูล: " . $e->getMessage();
}

$conn->close();
header("Location: ../admin/view-courses.php");
exit();
?>
