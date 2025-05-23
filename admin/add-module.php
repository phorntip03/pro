<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

include(__DIR__ . '/../backend/config/connect.php');

// ดึงคอร์ส
$course_query = "
    SELECT 
        course_id, 
        CONCAT(name_th_course, ' / ', name_eng_course) AS display_name 
    FROM course
";
$course_result = mysqli_query($conn, $course_query);

// ดึงผู้สอน
$personnel_query = "SELECT personnel_id, CONCAT(name_ps, ' ', lastname_ps) AS fullname FROM personnel";
$personnel_result = mysqli_query($conn, $personnel_query);

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มกลุ่มวิชา</title>

    <!-- Bootstrap & Icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/add-group-style.css">
</head>

<body>

    <?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 content-container">
                <div class="container">
                    <div class="card shadow p-4 mb-5">
                        <h2 class="text-center mb-4">เพิ่มกลุ่มวิชา</h2>

                        <form action="../auth/add-module.php" method="post">
                            <div class="row">

                                <!-- ข้อมูลกลุ่มวิชา -->
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" class="form-control" id="name_th_modulecourse" name="name_th_modulecourse" placeholder="ชื่อกลุ่มวิชาภาษาไทย">
                                    <label for="name_th_modulecourse">ชื่อกลุ่มวิชาภาษาไทย</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" class="form-control" id="name_eng_modulecourse" name="name_eng_modulecourse" placeholder="ชื่อกลุ่มวิชาภาษาอังกฤษ">
                                    <label for="name_eng_modulecourse">ชื่อกลุ่มวิชาภาษาอังกฤษ</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="date" class="form-control" id="modulecourse_open" name="modulecourse_open">
                                    <label for="modulecourse_open">วันเปิดกลุ่มวิชา</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="date" class="form-control" id="modulecourse_off" name="modulecourse_off">
                                    <label for="modulecourse_off">วันปิดกลุ่มวิชา</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="number_of_Student_module" name="number_of_Student_module" placeholder="จำนวนนักเรียน">
                                    <label for="number_of_Student_module">จำนวนนักเรียน</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="credit_module" name="credit_module" placeholder="หน่วยกิต">
                                    <label for="credit_module">หน่วยกิตกลุ่มวิชา</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="module_theory_number" name="module_theory_number" placeholder="จำนวนทฤษฎี">
                                    <label for="module_theory_number">จำนวนทฤษฎี</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="module_practice_number" name="module_practice_number" placeholder="จำนวนปฏิบัติ">
                                    <label for="module_practice_number">จำนวนปฏิบัติ</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="module_of_hours" name="module_of_hours" placeholder="จำนวนชั่วโมง">
                                    <label for="module_of_hours">จำนวนชั่วโมงเรียน</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="price_module" name="price_module" placeholder="ราคา">
                                    <label for="price_module">ราคากลุ่มวิชา</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="module_of_hours_theory" name="module_of_hours_theory" placeholder="ชั่วโมงทฤษฎี">
                                    <label for="module_of_hours_theory">จำนวนชั่วโมงทฤษฎี</label>
                                </div>

                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="number" class="form-control" id="module_of_hours_practice" name="module_of_hours_practice" placeholder="ชั่วโมงปฏิบัติ">
                                    <label for="module_of_hours_practice">จำนวนชั่วโมงปฏิบัติ</label>
                                </div>

                                <div class="col-12 mb-3 form-floating">
                                    <input type="text" class="form-control" id="details_module" name="details_module" placeholder="รายละเอียด">
                                    <label for="details_module">รายละเอียดกลุ่มวิชา</label>
                                </div>

                                <!-- Dropdown คอร์ส -->
                                <div class="col-md-6 mb-3 form-floating">
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="" disabled selected>-- เลือกคอร์ส --</option>
                                        <?php while($row = mysqli_fetch_assoc($course_result)): ?>
                                            <option value="<?= $row['course_id']; ?>"><?= $row['display_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <label for="course_id">คอร์สที่เกี่ยวข้อง</label>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
