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
    <title>เพิ่มกลุ่มวิชา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/add-group-style.css"> <!-- ลิงก์ CSS ใหม่ -->
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

     <!-- Main Content -->
     <main class="col-md-9 ms-sm-auto col-lg-10 content-container">
        <div class="container">
            <div class="card shadow p-4 mb-5 ">
                <h2 class="text-center mb-4">เพิ่มกลุ่มวิชา</h2>
                <form action="../auth/add-module.php" method="post">
                    <div class="row">
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
                            <input type="number" class="form-control" id="number_of_Student_module" name="number_of_Student_module">
                            <label for="number_of_Student_module">จำนวนนักเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="credit_module" name="credit_module">
                            <label for="credit_module">หน่วยกิตกลุ่มวิชาเรียน</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="module_theory_number" name="module_theory_number">
                            <label for="module_theory_number">จำนวนทฤษฎี</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="module_practice_number" name="module_practice_number">
                            <label for="module_practice_number">จำนวนปฏิบัติ</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="module_of_hours" name="module_of_hours">
                            <label for="module_of_hours">จำนวนชั่วโมงเรียนกลุ่มวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="price_module" name="price_module">
                            <label for="price_module">ราคากลุ่มวิชาเรียน</label>
                        </div>

                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="module_of_hours_theory" name="module_of_hours_theory">
                            <label for="module_of_hours_theory">จำนวนชั่วโมงทฤษฎีกลุ่มวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="module_of_hours_practice" name="module_of_hours_practice">
                            <label for="module_of_hours_practice">จำนวนชั่วโมงปฎิบัติกลุ่มวิชา</label>
                        </div>

                        <div class="col-12 mb-3 form-floating">
                            <input type="text" class="form-control" id="details_module" name="details_module" placeholder="รายละเอียดกลุ่มวิชา">
                            <label for="details_module">รายละเอียดกลุ่มวิชา</label>
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
