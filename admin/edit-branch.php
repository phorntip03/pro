<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
include '../backend/config/connect.php';

$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM branch WHERE branch_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namebranch = trim($_POST['namebranch']);
    if (!empty($namebranch)) {
        $stmt = $conn->prepare("UPDATE branch SET namebranch = ? WHERE branch_id = ?");
        $stmt->bind_param("si", $namebranch, $id);
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
    <title>แก้ไขสาขา</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>
<div class="container mt-5">
    <h1>แก้ไขสาขา</h1>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="namebranch" class="form-label">ชื่อสาขา</label>
            <input type="text" name="namebranch" id="namebranch" class="form-control" required value="<?php echo htmlspecialchars($row['namebranch']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">💾 บันทึก</button>
        <a href="branch-manage.php" class="btn btn-secondary">↩️ กลับ</a>
    </form>
</div>
</body>
</html>
