<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

require_once '../backend/config/connect.php';

// รับ id บุคลากรจากพารามิเตอร์
$id = $_GET['id'];

// ดึงข้อมูลบุคลากร
$sql = "SELECT * FROM personnel WHERE personnel_id = $id";
$result = $conn->query($sql);
$personnel = $result->fetch_assoc();

// ดึงข้อมูลตารางอ้างอิง
$branches = $conn->query("SELECT * FROM branch");
$positions = $conn->query("SELECT * FROM jobposition");
$statuses = $conn->query("SELECT * FROM personnelstatus");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลบุคลากร</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                <h3 class="text-center mb-4"><i class="bi bi-person-circle me-2"></i>แก้ไขข้อมูลบุคลากร</h3>

                <form method="POST" action="update-edit-personnel.php" enctype="multipart/form-data">
                    <input type="hidden" name="personnel_id" value="<?= $personnel['personnel_id'] ?>">

                    <div class="row">
                        <h4>ข้อมูลบุคลากร</h4>
                        <div class="col-md-6 mb-3">
                            <label>ชื่อ</label>
                            <input type="text" class="form-control" name="name_ps" value="<?= $personnel['name_ps'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>นามสกุล</label>
                            <input type="text" class="form-control" name="lastname_ps" value="<?= $personnel['lastname_ps'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>อีเมล</label>
                            <input type="email" class="form-control" name="email" value="<?= $personnel['email'] ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>สาขา</label>
                            <select class="form-select" name="branch_id" required>
                                <option value="">-- เลือกสาขา --</option>
                                <?php while ($b = $branches->fetch_assoc()): ?>
                                    <option value="<?= $b['branch_id'] ?>" <?= ($personnel['branch_id'] == $b['branch_id']) ? 'selected' : '' ?>>
                                        <?= $b['namebranch'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>ตำแหน่ง</label>
                            <select class="form-select" name="position_id" required>
                                <option value="">-- เลือกตำแหน่ง --</option>
                                <?php while ($p = $positions->fetch_assoc()): ?>
                                    <option value="<?= $p['position_id'] ?>" <?= ($personnel['position_id'] == $p['position_id']) ? 'selected' : '' ?>>
                                        <?= $p['nameposition'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>สถานะบุคลากร</label>
                            <select class="form-select" name="personnelstatus_id" required>
                                <option value="">-- เลือกสถานะ --</option>
                                <?php while ($s = $statuses->fetch_assoc()): ?>
                                    <option value="<?= $s['personnelstatus_id'] ?>" <?= ($personnel['personnelstatus_id'] == $s['personnelstatus_id']) ? 'selected' : '' ?>>
                                        <?= $s['namestatus_ps'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>อัปโหลดรูปภาพใหม่ (ถ้าต้องการ)</label>
                            <input type="file" class="form-control" name="img_ps" accept="image/*">
                            <?php if (!empty($personnel['img_ps'])): ?>
                                <img src="../assets/uploads/personnel/<?= $personnel['img_ps'] ?>" alt="รูปปัจจุบัน" class="mt-2 rounded" style="max-height:100px;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> บันทึกการแก้ไข</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
