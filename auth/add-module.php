<?php
session_start();
require_once(__DIR__ . '/../backend/config/connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // รับค่าจากฟอร์ม
    $course_id = $_POST['course_id'];
    $personnel_id  = $_POST['personnel_id'];
    $name_th  = $_POST['name_th_modulecourse'];
    $name_en = $_POST['name_eng_modulecourse'];
    $open = $_POST['modulecourse_open'];
    $off = $_POST['modulecourse_off'];
    $students = $_POST['number_of_Student_module'];
    $theory = $_POST['module_theory_number'];
    $practice = $_POST['module_practice_number'];
    $hours  = $_POST['module_of_hours'];
    $hours_theory = $_POST['module_of_hours_theory'];
    $hours_practice = $_POST['module_of_hours_practice'];
    $credit  = $_POST['credit_module'];
    $price   = $_POST['price_module'];
    $details  = $_POST['details_module'];

    // ค่าที่ตอนนี้ยังไม่ได้ใช้
    $certificate         = ''; 


    $sql = "INSERT INTO module_course (
        course_id, personnel_id,
        name_th_modulecourse, name_eng_modulecourse,
        modulecourse_open, modulecourse_off,
        number_of_Student_module, module_theory_number, module_practice_number,
        module_of_hours, module_of_hours_theory, module_of_hours_practice,
        credit_module, price_module, details_module,
        certificate_module
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    // เตรียม statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iissssiisiiiiiss",
            $course_id, $personnel_id,
            $name_th, $name_en,
            $open, $off,
            $students, $theory, $practice,
            $hours, $hours_theory, $hours_practice,
            $credit, $price, $details,
            $certificate
        );

     
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('บันทึกข้อมูลสำเร็จ');
                window.location.href='../admin/add-group.php'; 
            </script>";
        } else {
            $error_message = mysqli_stmt_error($stmt);
            echo "<script>
                alert('เกิดข้อผิดพลาด: $error_message');
                history.back();
            </script>";
        }


        mysqli_stmt_close($stmt);

    } else {
        $error_message = mysqli_error($conn);
        echo "<script>
            alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: $error_message');
            history.back();
        </script>";
    }


    mysqli_close($conn);
}
?>
