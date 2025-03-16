<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    // หากไม่ได้ล็อกอิน ให้รีไดเร็กต์ไปหน้า login
    header("Location: blackendlogin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบหลังบ้าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 20px;
        }

        .nav-link {
            font-size: 1.1rem;
            padding: 10px 15px;
        }
        .nav-link.active {
            background-color:rgb(228, 80, 104);
            color: white;
        }
        .nav-pills .nav-link {
            color:rgb(255, 255, 255);
        }
        .dropdown-toggle {
            font-weight: bold;
        }
        .dropdown-menu {
            min-width: 200px;
        }
        .bg-body-tertiary {
            background-color: #ffffff;
        }
        .sidebar {
            background-color: rgb(255, 255, 255); /* พื้นหลังโปร่งแสง */
            margin-top: 0;
            padding-top: 0;
        }
        .sidebar .nav-link {
            color:rgb(0, 0, 0);
            font-size: 1.1rem;
            padding-left: 30px;
        }
        .sidebar .nav-link:hover {
            background-color:rgb(255, 255, 255);
        }
        .sidebar .nav-link.active {
            background-color:rgb(245, 68, 92);
            color: white;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #e9ecef;
        }
        .btn-outline-primary {
            border-color:rgb(253, 13, 13);
            color:rgb(255, 0, 0);
        }
    </style>
</head>
<body>
<div class="container">
<header class="d-flex align-items-center justify-content-end py-3 mb-0 gap-2">
    <span>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    <a href="logout.php" class="btn btn-outline-primary">ออกจากระบบ</a>
</header>


<div class="d-flex flex-column flex-shrink-0 p-3 sidebar" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">ระบบหลังบ้าน</span>
    </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <i class="bi bi-house-door me-2"></i>Home
                </a>
                <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>
                <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Updates</a></li>
            </li>
            <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
          Home
        </button>
        <div class="collapse show" id="home-collapse">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>
        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Updates</a></li>
        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Reports</a></li>
    </ul>
</div>
      </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-house-door me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-box me-2"></i>Orders
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-box me-2"></i>Products
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-person-circle me-2"></i>Customers
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
