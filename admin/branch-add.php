<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
include '../backend/config/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namebranch = trim($_POST['namebranch']);
    if (!empty($namebranch)) {
        $stmt = $conn->prepare("INSERT INTO branch (namebranch) VALUES (?)");
        $stmt->bind_param("s", $namebranch);
        $stmt->execute();
        header("Location: branch-manage.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสาขา</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>
<div class="container mt-5">
    <h1>เพิ่มสาขาใหม่</h1>
    <form method="post" class="mt-4">
    <div class="mb-3">
            <label for="branch_id" class="form-label">ลำดับที่</label>
            <input type="text" name="branch_id" id="branch_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="namebranch" class="form-label">ชื่อสาขา</label>
            <input type="text" name="namebranch" id="namebranch" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">✅ บันทึก</button>
        <a href="branch-manage.php" class="btn btn-secondary">↩️ กลับ</a>
    </form>
</div>
</body>
</html>
