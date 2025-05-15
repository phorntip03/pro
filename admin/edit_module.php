<?php
session_start();
include '../backend/config/connect.php';

// แสดง error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

// ตรวจสอบว่าได้รับ ID และเป็นตัวเลข
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ไม่พบข้อมูลกลุ่มวิชา (ID ไม่ถูกต้อง)";
    exit();
}

$id = intval($_GET['id']); // แปลงเป็นตัวเลขเพื่อความปลอดภัย

// ดึงข้อมูลกลุ่มวิชา
$sql = "SELECT * FROM module_course WHERE modulecourse_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("คำสั่ง SQL ผิดพลาด: " . $conn->error);
}

$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("การดำเนินการล้มเหลว: " . $stmt->error);
}

$result = $stmt->get_result();
$module = $result->fetch_assoc();

if (!$module) {
    echo "ไม่พบข้อมูลกลุ่มวิชาในฐานข้อมูล (ID: $id)";
    exit();
}

// ดึงข้อมูลคอร์ส
$course_result = $conn->query("SELECT course_id, CONCAT(name_th_course, ' (', name_eng_course, ')') AS display_name FROM course");

// ดึงข้อมูลผู้สอน
$personnel_result = $conn->query("SELECT personnel_id, CONCAT(name_ps, ' ', lastname_ps) AS fullname FROM personnel");

// บันทึกการแก้ไข
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE module_course SET 
        name_th_modulecourse=?, name_eng_modulecourse=?, modulecourse_open=?, modulecourse_off=?,
        number_of_Student_module=?, credit_module=?, module_theory_number=?, module_practice_number=?,
        module_of_hours=?, price_module=?, module_of_hours_theory=?, module_of_hours_practice=?,
        details_module=?, course_id=?, personnel_id=?
        WHERE modulecourse_id=?");

    $stmt->bind_param(
        "ssssiiiiiiiissii",
        $_POST['name_th_modulecourse'],
        $_POST['name_eng_modulecourse'],
        $_POST['modulecourse_open'],
        $_POST['modulecourse_off'],
        $_POST['number_of_Student_module'],
        $_POST['credit_module'],
        $_POST['module_theory_number'],
        $_POST['module_practice_number'],
        $_POST['module_of_hours'],
        $_POST['price_module'],
        $_POST['module_of_hours_theory'],
        $_POST['module_of_hours_practice'],
        $_POST['details_module'],
        $_POST['course_id'],
        $_POST['personnel_id'],
        $id
    );

    if ($stmt->execute()) {
        header("Location: module_list.php?update=success");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขกลุ่มวิชา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="container mt-5">
            <h3 class="mb-4">แก้ไขกลุ่มวิชา</h3>
            <form method="post" class="row">
                <?php
                function selected($a, $b) {
                    return $a == $b ? 'selected' : '';
                }
                ?>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="text" class="form-control" name="name_th_modulecourse" value="<?= $module['name_th_modulecourse']; ?>" required>
                    <label>ชื่อกลุ่มวิชาภาษาไทย</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="text" class="form-control" name="name_eng_modulecourse" value="<?= $module['name_eng_modulecourse']; ?>">
                    <label>ชื่อกลุ่มวิชาภาษาอังกฤษ</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="date" class="form-control" name="modulecourse_open" value="<?= $module['modulecourse_open']; ?>">
                    <label>วันเปิดกลุ่มวิชา</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="date" class="form-control" name="modulecourse_off" value="<?= $module['modulecourse_off']; ?>">
                    <label>วันปิดกลุ่มวิชา</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="number_of_Student_module" value="<?= $module['number_of_Student_module']; ?>">
                    <label>จำนวนนักเรียน</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="credit_module" value="<?= $module['credit_module']; ?>">
                    <label>หน่วยกิตกลุ่มวิชา</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="module_theory_number" value="<?= $module['module_theory_number']; ?>">
                    <label>จำนวนทฤษฎี</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="module_practice_number" value="<?= $module['module_practice_number']; ?>">
                    <label>จำนวนปฏิบัติ</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="module_of_hours" value="<?= $module['module_of_hours']; ?>">
                    <label>จำนวนชั่วโมงเรียน</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="price_module" value="<?= $module['price_module']; ?>">
                    <label>ราคากลุ่มวิชา</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="module_of_hours_theory" value="<?= $module['module_of_hours_theory']; ?>">
                    <label>จำนวนชั่วโมงทฤษฎี</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <input type="number" class="form-control" name="module_of_hours_practice" value="<?= $module['module_of_hours_practice']; ?>">
                    <label>จำนวนชั่วโมงปฏิบัติ</label>
                </div>

                <div class="col-12 mb-3 form-floating">
                    <input type="text" class="form-control" name="details_module" value="<?= $module['details_module']; ?>">
                    <label>รายละเอียดกลุ่มวิชา</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <select class="form-select" name="course_id" required>
                        <option value="">-- เลือกคอร์ส --</option>
                        <?php while ($row = $course_result->fetch_assoc()): ?>
                            <option value="<?= $row['course_id']; ?>" <?= selected($module['course_id'], $row['course_id']); ?>>
                                <?= $row['display_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <label>คอร์สที่เกี่ยวข้อง</label>
                </div>

                <div class="col-md-6 mb-3 form-floating">
                    <select class="form-select" name="personnel_id" required>
                        <option value="">-- เลือกผู้สอน --</option>
                        <?php while ($row = $personnel_result->fetch_assoc()): ?>
                            <option value="<?= $row['personnel_id']; ?>" <?= selected($module['personnel_id'], $row['personnel_id']); ?>>
                                <?= $row['fullname']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <label>ผู้สอนประจำกลุ่มวิชา</label>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
                    <a href="module_list.php" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
