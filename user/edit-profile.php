<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['personnel_id'])) {
    header("Location: blackendlogin.php");
    exit();
}

$personnel_id = $_SESSION['personnel_id'];
$conn = new mysqli("localhost", "root", "", "courseproject");
$conn->set_charset("utf8");

// เตรียม SQL
$sql = "SELECT p.name_ps, p.lastname_ps, p.email, b.namebranch, p.img_ps, ps.namestatus_ps 
        FROM personnel p
        JOIN branch b ON p.branch_id = b.branch_id
        JOIN personnelstatus ps ON p.personnelstatus_id = ps.personnelstatus_id
        WHERE p.personnel_id = ?";

// เตรียม statement ก่อนตรวจสอบ
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// bind parameter และ execute
$stmt->bind_param("i", $personnel_id);
$stmt->execute();
$result = $stmt->get_result();

$name = $lastname = $email = $branch = $img_ps = $namestatus_ps = "";

if ($row = $result->fetch_assoc()) {
    $namestatus_ps = $row['namestatus_ps'];
    $name = $row['name_ps'];
    $lastname = $row['lastname_ps'];
    $email = $row['email'];
    $branch = $row['namebranch'];
    $img_ps = $row['img_ps'];
}

$profileImgPath = "../assets/images/default-profile.png";
if (!empty($img_ps) && file_exists("../uploads/" . $img_ps)) {
    $profileImgPath = "../uploads/" . $img_ps;
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
    <link rel="stylesheet" href="../assets/css/edit-profile-style.css">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card card-profile p-4 bg-white mt-4">
                <h3 class="text-center mb-4"><i class="bi bi-person-circle me-2"></i>แก้ไขข้อมูลส่วนตัว</h3>

                <form action="update-profile.php" method="post" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <img id="preview_image" src="<?= $profileImgPath ?>" class="rounded-circle border border-2 border-secondary shadow-sm" width="150" height="150" alt="Profile Image">
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*">
                        <label for="profile_image"><i class="bi bi-image me-2"></i>เลือกรูปโปรไฟล์ใหม่</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="namestatus_ps" id="namestatus_ps" required>
                            <option value="">-- เลือกคำนำหน้า --</option>
                            <?php
                            $statusResult = $conn->query("SELECT * FROM personnelstatus");
                            while ($statusRow = $statusResult->fetch_assoc()) {
                                $selected = ($namestatus_ps == $statusRow['namestatus_ps']) ? 'selected' : '';
                                echo "<option value='{$statusRow['namestatus_ps']}' $selected>{$statusRow['namestatus_ps']}</option>";
                            }
                            ?>
                        </select>
                        <label for="namestatus_ps"><i class="bi bi-person me-2"></i>คำนำหน้า</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name_ps" id="name_ps" value="<?= htmlspecialchars($name); ?>" required>
                        <label for="name_ps"><i class="bi bi-person me-2"></i>ชื่อ</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lastname_ps" id="lastname_ps" value="<?= htmlspecialchars($lastname); ?>" required>
                        <label for="lastname_ps"><i class="bi bi-person me-2"></i>นามสกุล</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email); ?>" required>
                        <label for="email"><i class="bi bi-envelope me-2"></i>อีเมล</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="branch" id="branch" value="<?= htmlspecialchars($branch); ?>" readonly>
                        <label for="branch"><i class="bi bi-building me-2"></i>สาขา</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-save me-2"></i>บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
