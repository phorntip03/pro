<?php
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_th_course = $_POST['name_th_course'];
    $name_eng_course = $_POST['name_eng_course'];
    $course_open = $_POST['course_open'];
    $course_off = $_POST['course_off'];
    $number_of_Student_cu = $_POST['number_of_Student_cu'];
    $credit_course = $_POST['credit_course'];
    $course_theory_number = $_POST['course_theory_number'];
    $course_practice_number = $_POST['course_practice_number'];
    $course_of_hours = $_POST['course_of_hours'];
    $price_course = $_POST['price_course'];
    $course_of_hours_theory = $_POST['course_of_hours_theory'];
    $course_of_hours_practice = $_POST['course_of_hours_practice'];
    $start_course = $_POST['start_course'];
    $close_course = $_POST['close_course'];
    $details_corse = $_POST['details_corse'];

    $sql = "INSERT INTO course (
        name_th_course, name_eng_course, course_open, course_off,
        number_of_Student_cu, credit_course, course_theory_number,
        course_practice_number, course_of_hours, price_course,
        course_of_hours_theory, course_of_hours_practice,
        start_course, close_course, details_corse
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiiiiiiisss",
        $name_th_course, $name_eng_course, $course_open, $course_off,
        $number_of_Student_cu, $credit_course, $course_theory_number,
        $course_practice_number, $course_of_hours, $price_course,
        $course_of_hours_theory, $course_of_hours_practice,
        $start_course, $close_course, $details_corse
    );

    if ($stmt->execute()) {
        echo "<script>alert('บันทึกสำเร็จ'); window.location.href='course-list.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
