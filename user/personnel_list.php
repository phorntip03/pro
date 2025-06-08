<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

$sql = "SELECT 
            personnel_id,
            name_ps, 
            lastname_ps, 
            email, 
            img_ps 
        FROM personnel
        ORDER BY personnel_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อบุคลากร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <style>
        img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">📋 รายชื่อบุคลากร</h3>
                <a href="add-personnel.php" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> เพิ่มบุคลากร
                </a>
            </div>

            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>Email</th>
                        <th>รูปภาพ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                <?php while ($row = $result->fetch_assoc()) {
                    $personnel_id = $row['personnel_id'];
                    $checkLoginSql = "SELECT id FROM login WHERE personnel_id = $personnel_id LIMIT 1";
                    $loginResult = $conn->query($checkLoginSql);
                    $hasLogin = $loginResult->num_rows > 0;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name_ps']) ?></td>
                        <td><?= htmlspecialchars($row['lastname_ps']) ?></td>
                        <td><?= !empty($row['email']) ? htmlspecialchars($row['email']) : '-' ?></td>
                        <td>
                            <?php if (!empty($row['img_ps'])) { ?>
                                <img src="../uploads/<?= htmlspecialchars($row['img_ps']) ?>" alt="รูปภาพ">
                            <?php } else { echo "-"; } ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="edit_personnel.php?id=<?= $personnel_id ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> แก้ไข
                                </a>
                                <a href="delete_personnel.php?id=<?= $personnel_id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ?')">
                                    <i class="bi bi-trash"></i> ลบ
                                </a>
                                <?php if (!$hasLogin) { ?>
                                    <a href="add_login_form.php?personnel_id=<?= $personnel_id ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-key"></i> เพิ่มการเข้าสู่ระบบ
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
