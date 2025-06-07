<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

// ดึงข้อมูลจากตาราง personnel เท่านั้น
$sql = "SELECT 
            name_ps, 
            lastname_ps, 
            email, 
            img_ps 
        FROM personnel
        ORDER BY personnel_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>รายชื่อบุคลากร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/edit-profile-style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 30px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }
        .btn-group > a {
            margin: 2px;
        }
    </style>
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

<h2 class="text-center mt-4">📋 รายชื่อบุคลากร</h2>

<div class="text-center mb-3">
    <a href="add-personnel.php" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> เพิ่มบุคลากร
    </a>
     <a href="add_login_form.php?personnel_id=<?= $row['personnel_id'] ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-key"></i> เพิ่มการเข้าสู่ระบบ
    </a>
</div>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>Email</th>
            <th>รูปภาพ</th>
            <th>การจัดการ</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name_ps'] ?? '') ?></td>
            <td><?= htmlspecialchars($row['lastname_ps'] ?? '') ?></td>
            <td><?= !empty($row['email']) ? htmlspecialchars($row['email']) : '-' ?></td>
            <td>
                <?php if (!empty($row['img_ps'])) { ?>
                    <img src="../uploads/<?= htmlspecialchars($row['img_ps']) ?>" alt="รูปภาพ">
                <?php } else { echo "-"; } ?>
            </td>
            <td>
                    <a href="edit_personnel.php?id=<?= $row['personnel_id'] ?>" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil"></i> แก้ไข
                    </a>
                    <a href="delete_personnel.php?id=<?= $row['personnel_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ?')">
                        <i class="bi bi-trash"></i> ลบ
                    </a>
                </div>
            </td>
        </tr>
        </div>
    <?php } ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
