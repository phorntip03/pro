<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายวิชา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/add-subject-style.css"> <!-- ลิงก์ CSS ใหม่ -->
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 content-container">
        <div class="container">
            <div class="card shadow p-4 mb-5 ">
                <h2 class="text-center mb-4">เพิ่มรายวิชา</h2>
                <form action="../auth/add-course.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="text" class="form-control" id="name_th_course" name="name_th_course" placeholder="ชื่อรายวิชาภาษาไทย">
                            <label for="name_th_course">ชื่อรายวิชาภาษาไทย</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="text" class="form-control" id="name_eng_course" name="name_eng_course" placeholder="ชื่อรายวิชาภาษาอังกฤษ">
                            <label for="name_eng_course">ชื่อรายวิชาภาษาอังกฤษ</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="course_open" name="course_open" placeholder="วันเปิดรายวิชา">
                            <label for="course_open">วันเปิดรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="course_off" name="course_off" placeholder="วันปิดรายวิชา">
                            <label for="course_off">วันปิดรายวิชา</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="start_course" name="start_course" placeholder="วันเริ่มรายวิชา">
                            <label for="start_course">วันเริ่มรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="close_course" name="close_course" placeholder="วันจบเรียนรายวิชา">
                            <label for="close_course">วันจบเรียนรายวิชา</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="number_of_Student_cu" name="number_of_Student_cu" placeholder="จำนวนนักเรียน">
                            <label for="number_of_Student_cu">จำนวนนักเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="credit_course" name="credit_course" placeholder="หน่วยกิตรายวิชาเรียน">
                            <label for="credit_course">หน่วยกิตรายวิชาเรียน</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_theory_number" name="course_theory_number" placeholder="จำนวนทฤษฎีรายวิชา">
                            <label for="course_theory_number">จำนวนทฤษฎีรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_practice_number" name="course_practice_number" placeholder="จำนวนปฏิบัติรายวิชา">
                            <label for="course_practice_number">จำนวนปฏิบัติรายวิชา</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours" name="course_of_hours" placeholder="จำนวนชั่วโมงเรียนรายวิชา">
                            <label for="course_of_hours">จำนวนชั่วโมงเรียนรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="price_course" name="price_course" placeholder="ราคารายวิชาเรียน">
                            <label for="price_course">ราคารายวิชาเรียน</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours_theory" name="course_of_hours_theory" placeholder="จำนวนชั่วโมงทฤษฎีรายวิชา">
                            <label for="course_of_hours_theory">จำนวนชั่วโมงทฤษฎีรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours_practice" name="course_of_hours_practice" placeholder="จำนวนชั่วโมงปฎิบัติรายวิชา">
                            <label for="course_of_hours_practice">จำนวนชั่วโมงปฎิบัติรายวิชา</label>
                        </div>

                        <div class="col-12 mb-3 form-floating">
                            <input type="text" class="form-control" id="details_module" name="details_module" placeholder="รายละเอียดรายวิชา">
                            <label for="details_module">รายละเอียดรายวิชา</label>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4 mx-2" type="submit">บันทึก</button>
                        <a href="profile.php" class="btn btn-secondary px-4 mx-2">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
