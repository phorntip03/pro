<?php
session_start();
require_once '../config/db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name_th = $_POST['name_th_modulecourse'];
    $name_en = $_POST['name_eng_modulecourse'];
    $open = $_POST['modulecourse_open'];
    $close = $_POST['modulecourse_off'];
    $students = $_POST['number_of_Student_module'];
    $credit = $_POST['credit_module'];
    $theory = $_POST['module_theory_number'];
    $practice = $_POST['module_practice_number'];
    $hours = $_POST['module_of_hours'];
    $price = $_POST['price_module'];
    $hours_theory = $_POST['module_of_hours_theory'];
    $hours_practice = $_POST['module_of_hours_practice'];
    $details = $_POST['details_module'];

    // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูล
    $sql = "INSERT INTO module_course (
        name_th, name_en, open_date, close_date,
        student_count, credit, theory_count, practice_count,
        total_hours, price, hours_theory, hours_practice, details
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssiiiiiiiss",
        $name_th, $name_en, $open, $close,
        $students, $credit, $theory, $practice,
        $hours, $price, $hours_theory, $hours_practice, $details
    );

    if ($stmt->execute()) {
        echo "<script>alert('บันทึกสำเร็จ'); window.location.href='../backend/add-subject.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: {$stmt->error}'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
