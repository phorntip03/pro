<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ไม่พบรหัสคอร์สที่ต้องการแก้ไข</div>";
    exit;
}

$course_id = $_GET['id'];
$sql = "SELECT * FROM course WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='alert alert-warning'>ไม่พบข้อมูลคอร์ส</div>";
    exit;
}

$course = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลคอร์ส - <?= htmlspecialchars($course['name_th_course']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

      <div class="card p-3 col-md-6 offset-md-1 module-editor">
            <h3 class="mb-4">แก้ไขข้อมูลคอร์ส</h3>
            <form action="../auth/update_course.php" method="POST">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['course_id']) ?>">

                <div class="mb-3">
                    <label class="form-label">ชื่อคอร์ส (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="name_th_course" required value="<?= htmlspecialchars($course['name_th_course']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">ชื่อคอร์ส (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" name="name_eng_course" value="<?= htmlspecialchars($course['name_eng_course']) ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">วันที่เปิดสอน</label>
                        <input type="date" class="form-control" name="course_open" value="<?= $course['course_open'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">วันที่ปิดสอน</label>
                        <input type="date" class="form-control" name="course_off" value="<?= $course['course_off'] ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียดคอร์ส</label>
                    <textarea class="form-control" name="details_corse" rows="4"><?= htmlspecialchars($course['details_corse']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">จำนวนชั่วโมงรวม</label>
                        <input type="number" class="form-control" name="course_of_hours" value="<?= $course['course_of_hours'] ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ชั่วโมงภาคทฤษฎี</label>
                        <input type="number" class="form-control" name="course_of_hours_theory" value="<?= $course['course_of_hours_theory'] ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ชั่วโมงภาคปฏิบัติ</label>
                        <input type="number" class="form-control" name="course_of_hours_practice" value="<?= $course['course_of_hours_practice'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">หน่วยกิต</label>
                        <input type="number" class="form-control" name="credit_course" value="<?= $course['credit_course'] ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">ราคา</label>
                        <input type="number" class="form-control" name="price_course" value="<?= $course['price_course'] ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">จำนวนผู้เรียน</label>
                        <input type="number" class="form-control" name="number_of_Student_cu" value="<?= $course['number_of_Student_cu'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">วันที่เริ่มคอร์ส</label>
                        <input type="date" class="form-control" name="start_course" value="<?= $course['start_course'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">วันที่สิ้นสุดคอร์ส</label>
                        <input type="date" class="form-control" name="close_course" value="<?= $course['close_course'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">จำนวนหัวข้อทฤษฎี</label>
                        <input type="number" class="form-control" name="course_theory_number" value="<?= $course['course_theory_number'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">จำนวนหัวข้อปฏิบัติ</label>
                        <input type="number" class="form-control" name="course_practice_number" value="<?= $course['course_practice_number'] ?>">
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                <a href="../admin/view-courses.php" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> ย้อนกลับ</a>
                 <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
