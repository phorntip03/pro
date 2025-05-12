<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
include(__DIR__ . '/../backend/config/connect.php');
// ดึงผู้สอน
$personnel_query = "SELECT personnel_id, CONCAT(name_ps, ' ', lastname_ps) AS fullname FROM personnel";
$personnel_result = mysqli_query($conn, $personnel_query);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มรายวิชา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/add-subject-style.css">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 content-container">
            <div class="container">
                <div class="card shadow p-4 mb-5">
                    <h2 class="text-center mb-4">เพิ่มรายวิชา</h2>
                    <form action="../auth/add-course.php" method="post">
                        <div class="row">
                            <!-- ข้อมูลทั่วไปของรายวิชา -->
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" class="form-control" id="name_th_course" name="name_th_course" placeholder="ชื่อรายวิชาภาษาไทย">
                                <label for="name_th_course">ชื่อรายวิชาภาษาไทย</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="text" class="form-control" id="name_eng_course" name="name_eng_course" placeholder="ชื่อรายวิชาภาษาอังกฤษ">
                                <label for="name_eng_course">ชื่อรายวิชาภาษาอังกฤษ</label>
                            </div>

                            <!-- วันเวลา -->
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="date" class="form-control" id="course_open" name="course_open">
                                <label for="course_open">วันเปิดรายวิชา</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="date" class="form-control" id="course_off" name="course_off">
                                <label for="course_off">วันปิดรายวิชา</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="date" class="form-control" id="start_course" name="start_course">
                                <label for="start_course">วันเริ่มรายวิชา</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="date" class="form-control" id="close_course" name="close_course">
                                <label for="close_course">วันจบเรียนรายวิชา</label>
                            </div>

                            <!-- จำนวน / หน่วยกิต -->
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="number_of_Student_cu" name="number_of_Student_cu" placeholder="จำนวนนักเรียน">
                                <label for="number_of_Student_cu">จำนวนนักเรียน</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="credit_course" name="credit_course" placeholder="หน่วยกิต">
                                <label for="credit_course">หน่วยกิต</label>
                            </div>

                            <!-- ชั่วโมง/ทฤษฎี/ปฏิบัติ -->
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="course_theory_number" name="course_theory_number" placeholder="จำนวนทฤษฎี">
                                <label for="course_theory_number">จำนวนทฤษฎี</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="course_practice_number" name="course_practice_number" placeholder="จำนวนปฏิบัติ">
                                <label for="course_practice_number">จำนวนปฏิบัติ</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="course_of_hours" name="course_of_hours" placeholder="จำนวนชั่วโมงรวม">
                                <label for="course_of_hours">จำนวนชั่วโมงรวม</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="course_of_hours_theory" name="course_of_hours_theory" placeholder="จำนวนชั่วโมงทฤษฎี">
                                <label for="course_of_hours_theory">จำนวนชั่วโมงทฤษฎี</label>
                            </div>
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="course_of_hours_practice" name="course_of_hours_practice" placeholder="จำนวนชั่วโมงปฏิบัติ">
                                <label for="course_of_hours_practice">จำนวนชั่วโมงปฏิบัติ</label>
                            </div>

                            <!-- ราคาและรายละเอียด -->
                            <div class="col-md-6 mb-3 form-floating">
                                <input type="number" class="form-control" id="price_course" name="price_course" placeholder="ราคารายวิชา">
                                <label for="price_course">ราคารายวิชา</label>
                            </div>
                            <div class="col-12 mb-3 form-floating">
                                <input type="text" class="form-control" id="details_corse" name="details_corse" placeholder="รายละเอียดรายวิชา">
                                <label for="details_corse">รายละเอียดรายวิชา</label>
                            </div>
                             <!-- Dropdown ผู้สอน -->
                             <div class="col-md-6 mb-3 form-floating">
                                    <select class="form-select" id="personnel_id" name="personnel_id" required>
                                        <option value="" disabled selected>-- เลือกผู้สอน --</option>
                                        <?php while($row = mysqli_fetch_assoc($personnel_result)): ?>
                                            <option value="<?= $row['personnel_id']; ?>"><?= $row['fullname']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="personnel_id">ผู้สอนประจำกลุ่มวิชา</label>
                                </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-primary px-4 mx-2" type="submit">บันทึก</button>
                                <a href="profile.php" class="btn btn-secondary px-4 mx-2">ยกเลิก</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
