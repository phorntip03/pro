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
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

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
