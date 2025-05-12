<?php
session_start();
include(__DIR__ . '/../backend/config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_th_course = $_POST['name_th_course'];
    $name_eng_course = $_POST['name_eng_course'];
    $course_open = $_POST['course_open'];
    $course_off = $_POST['course_off'];
    $start_course = $_POST['start_course'];
    $close_course = $_POST['close_course'];
    $number_of_Student_cu = $_POST['number_of_Student_cu'];
    $credit_course = $_POST['credit_course'];
    $course_theory_number = $_POST['course_theory_number'];
    $course_practice_number = $_POST['course_practice_number'];
    $course_of_hours = $_POST['course_of_hours'];
    $course_of_hours_theory = $_POST['course_of_hours_theory'];
    $course_of_hours_practice = $_POST['course_of_hours_practice'];
    $price_course = $_POST['price_course'];
    $details_corse = $_POST['details_corse'];
    $personnel_id = $_POST['personnel_id'];

    $sql = "INSERT INTO course (
                name_th_course, name_eng_course, course_open, course_off,
                start_course, close_course, number_of_Student_cu, credit_course,
                course_theory_number, course_practice_number, course_of_hours,
                course_of_hours_theory, course_of_hours_practice,
                price_course, details_corse, personnel_id
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssiiiiiidssi",
        $name_th_course, $name_eng_course, $course_open, $course_off,
        $start_course, $close_course, $number_of_Student_cu, $credit_course,
        $course_theory_number, $course_practice_number, $course_of_hours,
        $course_of_hours_theory, $course_of_hours_practice,
        $price_course, $details_corse, $personnel_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../admin/add-subject.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../admin/add-subject.php");
    exit();
}
?>
