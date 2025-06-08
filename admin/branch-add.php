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

    <div class="container">
        <h2>เพิ่มสาขา</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="namebranch" class="form-label">ชื่อสาขา</label>
                <input type="text" name="namebranch" id="namebranch" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">บันทึก</button>
            <a href="branch-manage.php" class="btn btn-secondary">ย้อนกลับ</a>
        </form>
    </div>
</div>
</body>
</html>
