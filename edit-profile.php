<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['personnel_id'])) {
    header("Location: blackendlogin.php");
    exit();
}

$personnel_id = $_SESSION['personnel_id'];
$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

$sql = "SELECT p.name_ps, p.lastname_ps, p.email, b.namebranch 
        FROM personnel p
        JOIN branch b ON p.branch_id = b.branch_id
        WHERE p.personnel_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $personnel_id);
$stmt->execute();
$result = $stmt->get_result();

$name = $lastname = $email = $branch = "";

if ($row = $result->fetch_assoc()) {
    $name = $row['name_ps'];
    $lastname = $row['lastname_ps'];
    $email = $row['email'];
    $branch = $row['namebranch'];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .sidebar {
            background-color: #34495e;
            min-height: 100vh;
            color: white;
            padding: 1rem;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 0.3rem;
        }
        .sidebar a:hover, .sidebar a.fw-bold {
            background-color: #1abc9c;
            color: white;
        }
        .main {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #2980b9;
        }
        .btn-primary {
            background-color: #2980b9;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1f618d;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>

<header>
    <span class="text-white fw-semibold">👋 ยินดีต้อนรับ</span>
    
    <div class="dropdown ms-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="img/i2.jpg" alt="Profile" width="32" height="32" class="rounded-circle me-2">
            <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
            <li><a class="dropdown-item" href="#">🆕 โปรเจคใหม่</a></li>
            <li><a class="dropdown-item" href="#">⚙️ การตั้งค่า</a></li>
            <li><a class="dropdown-item" href="#">👤 โปรไฟล์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">🚪 ออกจากระบบ</a></li>
        </ul>
    </div>
</header>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (Desktop) -->
        <nav class="col-md-3 col-lg-2 d-none d-md-block sidebar">
            <h4 class="mb-4">เมนู</h4>
            <a href="blackendhome.php">🏠 หน้าหลัก</a>
            <a href="edit-profile.php" class="fw-bold">✏️ แก้ไขประวัติ</a>
            <a href="edit-branch.php">🌿 แก้ไขสาขา</a>
            <hr>
            <a href="add-group.php">➕ เพิ่มกลุ่มวิชา</a>
            <a href="add-subject.php">📘 เพิ่มรายวิชา</a>
            <hr>
            <a href="check-registration.php">👨‍🎓 ตรวจสอบการลงทะเบียน</a>
            <a href="view-courses.php">📚 ดูคอร์สเรียน</a>
            <a href="results.php">📊 ผลการเรียน</a>
            <a href="finance-report.php">💰 รายงานการเงิน</a>
            <a href="reset-password.php">🔑 ตั้งรหัสผ่านใหม่</a>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 main">
            <div class="card p-4">
                <h3 class="text-center mb-4">📋 แก้ไขข้อมูลส่วนตัว</h3>
                <form action="update-profile.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name_ps" id="name_ps" value="<?= htmlspecialchars($name); ?>" required>
                        <label for="name_ps">ชื่อ</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lastname_ps" id="lastname_ps" value="<?= htmlspecialchars($lastname); ?>" required>
                        <label for="lastname_ps">นามสกุล</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email); ?>" required>
                        <label for="email">อีเมล</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="branch" id="branch" value="<?= htmlspecialchars($branch); ?>" readonly>
                        <label for="branch">สาขา</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 me-2">บันทึก</button>
                        <a href="profile.php" class="btn btn-secondary px-5">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
