<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$modulecourse_id = $_GET['id'] ?? null;

if (!$modulecourse_id) {
    echo "<div class='alert alert-danger'>ไม่พบรหัสโมดูล</div>";
    exit();
}

$sql = "SELECT * FROM module_course WHERE modulecourse_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $modulecourse_id);
$stmt->execute();
$result = $stmt->get_result();
$module = $result->fetch_assoc();

if (!$module) {
    echo "<div class='alert alert-danger'>ไม่พบข้อมูลโมดูล</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_th         = $_POST['name_th_modulecourse'];
    $name_eng        = $_POST['name_eng_modulecourse'];
    $open            = $_POST['modulecourse_open'];
    $off             = $_POST['modulecourse_off'];
    $number_student  = $_POST['number_of_Student_module'];
    $theory_num      = $_POST['module_theory_number'];
    $practice_num    = $_POST['module_practice_number'];
    $hours           = $_POST['module_of_hours'];
    $hours_theory    = $_POST['module_of_hours_theory'];
    $hours_practice  = $_POST['module_of_hours_practice'];
    $credit          = $_POST['credit_module'];
    $price           = $_POST['price_module'];
    $details         = $_POST['details_module'];

    $update_sql = "UPDATE module_course SET 
        name_th_modulecourse = ?, 
        name_eng_modulecourse = ?, 
        modulecourse_open = ?, 
        modulecourse_off = ?, 
        number_of_Student_module = ?, 
        module_theory_number = ?, 
        module_practice_number = ?, 
        module_of_hours = ?, 
        module_of_hours_theory = ?, 
        module_of_hours_practice = ?, 
        credit_module = ?, 
        price_module = ?, 
        details_module = ?
    WHERE modulecourse_id = ?";

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "ssssiiiiiiissi",
        $name_th, $name_eng, $open, $off, $number_student, $theory_num, $practice_num,
        $hours, $hours_theory, $hours_practice, $credit, $price, $details, $modulecourse_id
    );

    if ($update_stmt->execute()) {
        header("Location: edit_module.php?course_id=" . $module['course_id']);
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขโมดูล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/edit_modulecourses-styel.css">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>
 
        <div class="card p-2 col-md-8 offset-md-1 module-editor">
            <div class="card p-3 col-md-15 offset-md-2">
                <h3 class="mb-4 text-primary">
                    <i class="bi bi-pencil-square"></i> แก้ไขข้อมูลโมดูล
                </h3>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>ชื่อโมดูล (TH)</label>
                        <input type="text" name="name_th_modulecourse" class="form-control" value="<?php echo htmlspecialchars($module['name_th_modulecourse']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>ชื่อโมดูล (ENG)</label>
                        <input type="text" name="name_eng_modulecourse" class="form-control" value="<?php echo htmlspecialchars($module['name_eng_modulecourse']); ?>">
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label>วันที่เปิด</label>
                            <input type="date" name="modulecourse_open" class="form-control" value="<?php echo $module['modulecourse_open']; ?>">
                        </div>
                        <div class="col">
                            <label>วันที่ปิด</label>
                            <input type="date" name="modulecourse_off" class="form-control" value="<?php echo $module['modulecourse_off']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label>จำนวนนักศึกษา</label>
                            <input type="number" name="number_of_Student_module" class="form-control" value="<?php echo $module['number_of_Student_module']; ?>">
                        </div>
                        <div class="col">
                            <label>จำนวนทฤษฎี</label>
                            <input type="number" name="module_theory_number" class="form-control" value="<?php echo $module['module_theory_number']; ?>">
                        </div>
                        <div class="col">
                            <label>จำนวนปฏิบัติ</label>
                            <input type="number" name="module_practice_number" class="form-control" value="<?php echo $module['module_practice_number']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label>ชั่วโมงรวม</label>
                            <input type="number" name="module_of_hours" class="form-control" value="<?php echo $module['module_of_hours']; ?>">
                        </div>
                        <div class="col">
                            <label>ชั่วโมงทฤษฎี</label>
                            <input type="number" name="module_of_hours_theory" class="form-control" value="<?php echo $module['module_of_hours_theory']; ?>">
                        </div>
                        <div class="col">
                            <label>ชั่วโมงปฏิบัติ</label>
                            <input type="number" name="module_of_hours_practice" class="form-control" value="<?php echo $module['module_of_hours_practice']; ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label>หน่วยกิต</label>
                            <input type="number" name="credit_module" class="form-control" value="<?php echo $module['credit_module']; ?>">
                        </div>
                        <div class="col">
                            <label>ราคา (บาท)</label>
                            <input type="number" name="price_module" class="form-control" value="<?php echo $module['price_module']; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>รายละเอียด</label>
                        <textarea name="details_module" class="form-control" rows="3"><?php echo htmlspecialchars($module['details_module']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="edit_module.php?course_id=<?php echo $module['course_id']; ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> กลับ
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> บันทึก
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
