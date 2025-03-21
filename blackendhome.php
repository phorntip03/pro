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
    <title>ระบบหลังบ้าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        header {
             position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             background: white;
             z-index: 1000;
             padding: 15px 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
        }
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: rgb(0, 0, 0);
            font-size: 1.1rem;
            padding-left: 30px;
        }
        .sidebar .nav-link.active {
            background-color: rgb(245, 68, 92);
            color: white;
        }
        .menu-section {
            background: #ddd;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .menu-list {
            list-style: none;
            padding: 0;
        }
        .menu-list li {
            padding: 5px 0;
        }
        .menu-list a {
            display: block;
            text-decoration: none;
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid gray;
            color: black;
            text-align: center;
        }
        .menu-list a:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="d-flex align-items-center px-4">
        <span>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="logout.php" class="btn btn-outline-primary ms-auto">ออกจากระบบ</a>
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

            <!-- เมนูใหม่ที่เพิ่ม -->
            <div class="menu-section">แก้ไขข้อมูลส่วนตัว</div>
            <ul class="menu-list">
                <li><a href="edit-profile.php">แก้ไขประวัติ</a></li>
                <li><a href="edit-branch.php">แก้ไขข้อมูลสาขา</a></li>
            </ul>

            <div class="menu-section">เพิ่มคอร์ส</div>
            <ul class="menu-list">
                <li><a href="add-group.php">เพิ่มกลุ่มวิชา</a></li>
                <li><a href="add-subject.php">เพิ่มรายวิชา</a></li>
            </ul>

            <ul class="menu-list">
                <li><a href="check-registration.php">ตรวจสอบจำนวนผู้ลงทะเบียนเรียน</a></li>
                <li><a href="view-courses.php">ดูคอร์สเรียน</a></li>
                <li><a href="results.php">ผลการเรียน</a></li>
                <li><a href="finance-report.php">รายงานการเงิน</a></li>
                <li><a href="reset-password.php">ตั้งค่ารหัสผ่าน</a></li>
            </ul>

            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://github.com/mdo.png" alt="Profile" width="32" height="32" class="rounded-circle me-2">
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
            <div class="top-section">ส่วนที่ 1</div>
            <div class="bottom-section">
                <div class="left-box">ส่วนที่ 2</div>
                <div class="right-box">ส่วนที่ 3</div>
            </div>
        </main>
        <!-- Main Content -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
