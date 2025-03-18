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
             background: white; /* ป้องกันโปร่งใส */
             z-index: 1000; /* ทำให้ Header อยู่ด้านหน้า */
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
        .btn-outline-primary {
            border-color: rgb(253, 13, 13);
            color: rgb(255, 0, 0);
        }
        .content-container {
            display: flex;
            flex-direction: column;
            align-items: center; /* จัดกึ่งกลาง */
            justify-content: center; /* จัดให้อยู่ตรงกลาง */
            padding: 20px;
            height: 100%;
        }
        .top-section {
            width: 80%;
            background-color: #ddd;
            padding: 20px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .bottom-section {
            display: flex;
            gap: 20px;
            width: 80%;
        }
        .left-box, .right-box {
            flex: 1;
            background-color: #eee;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="d-flex justify-content-between px-4" style="position: fixed; top: 0; left: 0; width: 100%; background: white; z-index: 1000; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); padding: 15px;">
        <span>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="logout.php" class="btn btn-outline-primary">ออกจากระบบ</a>
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
                    <a href="#" class="nav-link active">
                        <i class="bi bi-house-door me-2"></i> Home
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <i class="bi bi-box me-2"></i> Orders
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <i class="bi bi-people me-2"></i> Customers
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://github.com/mdo.png" alt="Profile" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
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
