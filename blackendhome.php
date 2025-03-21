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
        .custom-logout-btn {
            background-color: #ff5733; /* สีปุ่ม */
            color: white; /* สีตัวอักษร */
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .custom-logout-btn:hover {
            background-color: #e74c3c; /* สีตอนเอาเมาส์ไปชี้ */
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
            <div class="text-center">
                <h2>ยินดีต้อนรับสู่ระบบจัดการฐานข้อมูลหลักสูตร</h2>
                <p>จัดการข้อมูลของคุณและข้อมูลหลักสูตรได้เลยค่ะ</p>
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/i1.jpg" class="d-block w-100" alt="สไลด์ที่ 1">
                        </div>
                        <div class="carousel-item">
                            <img src="img/i2.jpg" class="d-block w-100" alt="สไลด์ที่ 2">
                        </div>
                        <div class="carousel-item">
                            <img src="img/i3.jpg" class="d-block w-100" alt="สไลด์ที่ 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="bottom-section mt-4">
                <div class="left-box">
                    <h4>ข่าวสาร</h4>
                    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/i1.jpg" class="d-block w-100" alt="สไลด์ที่ 1">
        </div>
        <div class="carousel-item">
            <img src="img/i2.jpg" class="d-block w-100" alt="สไลด์ที่ 2">
        </div>
        <div class="carousel-item">
            <img src="img/i3.jpg" class="d-block w-100" alt="สไลด์ที่ 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
</div>

                <div class="right-box">
                    <h4>รายงานสถิติ</h4>
                    <img src="https://via.placeholder.com/300x200" alt="สถิติ" class="img-fluid rounded">
                </div>
            </div>
        </main>
<!-- Main Content -->


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
