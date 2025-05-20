<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $name_th_course = $_POST['name_th_course'];
    $name_eng_course = $_POST['name_eng_course'];
    $course_open = $_POST['course_open'];
    $course_off = $_POST['course_off'];
    $details_corse = $_POST['details_corse'];
    $course_of_hours = $_POST['course_of_hours'];
    $course_of_hours_theory = $_POST['course_of_hours_theory'];
    $course_of_hours_practice = $_POST['course_of_hours_practice'];
    $credit_course = $_POST['credit_course'];
    $price_course = $_POST['price_course'];
    $number_of_Student_cu = $_POST['number_of_Student_cu'];
    $start_course = $_POST['start_course'];
    $close_course = $_POST['close_course'];
    $course_theory_number = $_POST['course_theory_number'];
    $course_practice_number = $_POST['course_practice_number'];

    $sql = "UPDATE course SET 
        name_th_course = ?, 
        name_eng_course = ?, 
        course_open = ?, 
        course_off = ?, 
        details_corse = ?, 
        course_of_hours = ?, 
        course_of_hours_theory = ?, 
        course_of_hours_practice = ?, 
        credit_course = ?, 
        price_course = ?, 
        number_of_Student_cu = ?, 
        start_course = ?, 
        close_course = ?, 
        course_theory_number = ?, 
        course_practice_number = ?
        WHERE course_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssiiiiisssiii",
        $name_th_course,
        $name_eng_course,
        $course_open,
        $course_off,
        $details_corse,
        $course_of_hours,
        $course_of_hours_theory,
        $course_of_hours_practice,
        $credit_course,
        $price_course,
        $number_of_Student_cu,
        $start_course,
        $close_course,
        $course_theory_number,
        $course_practice_number,
        $course_id
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "บันทึกข้อมูลสำเร็จ";
        header("Location: ../admin/view-courses.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error . "</div>";
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง</div>";
}
?>
