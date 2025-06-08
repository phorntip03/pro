<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $namebranch = mysqli_real_escape_string($conn, $_POST['namebranch']);

    $sql = "INSERT INTO branch (namebranch) VALUES ('$namebranch')";
    if (mysqli_query($conn, $sql)) {
        header("Location: branch-manage.php");
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสาขา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">เพิ่มสาขา</h4>
                        <a href="branch-manage.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> ย้อนกลับ
                        </a>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="namebranch" class="form-label">ชื่อสาขา</label>
                            <input type="text" name="namebranch" id="namebranch" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> บันทึก
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
