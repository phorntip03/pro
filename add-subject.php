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
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }
        header {
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             background-color:rgb(44, 62, 80);
             z-index: 1000;
             padding: 15px 20px;
             color: white;
             box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
        }
        .sidebar {
            width: 280px;
            background-color:rgb(44, 62, 80);
            padding: 15px;
            color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: white;
            font-size: 1.1rem;
            padding-left: 20px;
        }
        .sidebar .nav-link.active {
            background-color: #E74C3C;
            color: white;
            border-radius: 5px;
        }
        .menu-section {
            background-color: #27AE60;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
            color: white;
        }
        .menu-list {
            list-style: none;
            padding: 0;
        }
        .menu-list a {
            display: block;
            text-decoration: none;
            background-color: #3498DB;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            text-align: center;
            color: white;
            transition: 0.3s;
        }
        .menu-list a:hover {
            background: #1ABC9C;
            transform: scale(1.05);
        }
        .content-container {
            padding: 80px 20px;
        }
        .carousel-inner img {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .bottom-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .bottom-section .left-box, .bottom-section .right-box {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .h1{
            text-align: center;
        }
        
    </style>
</head>
<body>
    <!-- Header -->
    <header class="d-flex align-items-center px-4">
        <span>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="logout.php" class="btn btn-success ms-auto">ออกจากระบบ</a>
    </header>
    <!-- Header -->
     
    <!-- Sidebar -->
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="/" class="d-flex align-items-center mb-3 text-decoration-none">
                <span class="fs-4">ระบบหลังบ้าน</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="blackendhome.php" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i> Home
                    </a>
                </li>
            <hr>

           <!-- เมนู -->
           <div class="menu-section">แก้ไขข้อมูลส่วนตัว</div>
            <ul class="menu-list">
                <li><a href="edit-profile.php"><i class="fas fa-user-edit"></i> แก้ไขประวัติ</a></li>
                <li><a href="edit-branch.php"><i class="fas fa-code-branch"></i> แก้ไขข้อมูลสาขา</a></li>
            </ul>

            <div class="menu-section">เพิ่มคอร์ส</div>
            <ul class="menu-list">
                <li><a href="add-group.php"><i class="fas fa-layer-group"></i> เพิ่มกลุ่มวิชา</a></li>
                <li><a href="add-subject.php"><i class="fas fa-book-open"></i> เพิ่มรายวิชา</a></li>
            </ul>

            
            <div class="menu-section">เมนูทั่วไป</div>
            <ul class="menu-list">
                <li><a href="check-registration.php"><i class="fas fa-user-check"></i> ตรวจสอบจำนวนผู้ลงทะเบียนเรียน</a></li>
                <li><a href="view-courses.php"><i class="fas fa-book"></i> ดูคอร์สเรียน</a></li>
                <li><a href="results.php"><i class="fas fa-poll"></i> ผลการเรียน</a></li>
                <li><a href="finance-report.php"><i class="fas fa-file-invoice-dollar"></i> รายงานการเงิน</a></li>
                <li><a href="reset-password.php"><i class="fas fa-key"></i> ตั้งค่ารหัสผ่าน</a></li>
            </ul>

            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="img/i2.jpg" alt="Profile" width="32" height="32" class="rounded-circle me-2">
                    <strong> <?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
        <!-- Sidebar -->

     <!-- Main Content -->
     <main class="content-container">
        <div class="container">
            <div class="card shadow p-4 mb-5 ">
                <h2 class="text-center mb-4">เพิ่มรายวิชา</h2>
                <form action="update-profile.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="text" class="form-control" id="name_th_course" name="name_th_course" placeholder="ชื่อกลุ่มวิชาภาษาไทย">
                            <label for="name_th_course">ชื่อกลุ่มวิชาภาษาไทย</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="text" class="form-control" id="name_eng_course" name="name_eng_course" placeholder="ชื่อกลุ่มวิชาภาษาอังกฤษ">
                            <label for="name_eng_course">ชื่อกลุ่มวิชาภาษาอังกฤษ</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="course_open" name="course_open">
                            <label for="course_open">วันเปิดรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="course_off" name="course_off">
                            <label for="course_off">วันปิดรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="number_of_Student_cu" name="number_of_Student_cu">
                            <label for="number_of_Student_cu">จำนวนนักเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="credit_course" name="credit_course">
                            <label for="credit_course">หน่วยกิตกลุ่มวิชาเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_theory_number" name="course_theory_number">
                            <label for="course_theory_number">จำนวนทฤษฎี</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_practice_number" name="course_practice_number">
                            <label for="course_practice_number">จำนวนปฏิบัติ</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours" name="course_of_hours">
                            <label for="course_of_hours">จำนวนชั่วโมงเรียนรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="price_course" name="price_course">
                            <label for="price_course">ราคากลุ่มวิชาเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours_theory" name="course_of_hours_theory">
                            <label for="course_of_hours_theory">จำนวนชั่วโมงทฤษฎีรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="number" class="form-control" id="course_of_hours_practice" name="course_of_hours_practice">
                            <label for="course_of_hours_practice">จำนวนชั่วโมงปฎิบัติรายวิชา</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="start_course" name="start_course">
                            <label for="start_course">วันที่เริ่มเรียน</label>
                        </div>
                        <div class="col-md-6 mb-3 form-floating">
                            <input type="date" class="form-control" id="close_course" name="close_course">
                            <label for="close_course">วันที่จบการเรียน</label>
                        </div>
                        <div class="col-12 mb-3 form-floating">
                            <input type="text" class="form-control" id="details_corse" name="details_corse" placeholder="รายละเอียดรายวิชา">
                            <label for="details_corse">รายละเอียดรายวิชา</label>
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
