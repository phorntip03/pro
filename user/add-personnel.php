<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

// ดึงข้อมูลตารางอ้างอิง
$branches = $conn->query("SELECT * FROM branch");
$positions = $conn->query("SELECT * FROM jobposition");
$statuses = $conn->query("SELECT * FROM personnelstatus");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลบุคลากร</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/edit-profile-style.css">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card card-profile p-4 bg-white mt-4">
                <h3 class="text-center mb-4"><i class="bi bi-person-circle me-2"></i>เพิ่มบุคลากร</h3>

                <form method="POST" action="add_login_personnel.php" enctype="multipart/form-data">
                    <div class="row">
                        <h4>ข้อมูลบุคลากร</h4>
                        <div class="col-md-6 mb-3">
                            <label>ชื่อ</label>
                            <input type="text" class="form-control" name="name_ps" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>นามสกุล</label>
                            <input type="text" class="form-control" name="lastname_ps" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>อีเมล</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>สาขา</label>
                            <select class="form-select" name="branch_id" required>
                                <option value="">-- เลือกสาขา --</option>
                                <?php while ($b = $branches->fetch_assoc()): ?>
                                    <option value="<?= $b['branch_id'] ?>"><?= $b['namebranch'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>ตำแหน่ง</label>
                            <select class="form-select" name="position_id" required>
                                <option value="">-- เลือกตำแหน่ง --</option>
                                <?php while ($p = $positions->fetch_assoc()): ?>
                                    <option value="<?= $p['position_id'] ?>"><?= $p['nameposition'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>สถานะบุคลากร</label>
                            <select class="form-select" name="personnelstatus_id" required>
                                <option value="">-- เลือกสถานะ --</option>
                                <?php while ($s = $statuses->fetch_assoc()): ?>
                                    <option value="<?= $s['personnelstatus_id'] ?>"><?= $s['namestatus_ps'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>อัปโหลดรูปภาพ</label>
                            <input type="file" class="form-control" name="img_ps" accept="image/*" required>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
