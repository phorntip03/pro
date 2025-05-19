<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$course_id = $_GET['course_id'] ?? null;

if (!$course_id) {
    echo "<div class='alert alert-danger'>ไม่พบรหัสคอร์ส</div>";
    exit();
}

// ดึงชื่อคอร์ส
$sql_course = "SELECT name_th_course FROM course WHERE course_id = ?";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
$course = $result_course->fetch_assoc();

if (!$course) {
    echo "<div class='alert alert-danger'>ไม่พบข้อมูลคอร์ส</div>";
    exit();
}

// ดึงโมดูลในคอร์สนี้
$sql_modules = "SELECT * FROM module_course WHERE course_id = ?";
$stmt_modules = $conn->prepare($sql_modules);
$stmt_modules->bind_param("i", $course_id);
$stmt_modules->execute();
$result_modules = $stmt_modules->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการโมดูล - <?php echo htmlspecialchars($course['name_th_course']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="col-md-9 mt-5">
            <div class="card p-4">
                <h3 class="mb-4 text-success">
                    <i class="bi bi-list-task"></i> โมดูลในคอร์ส: <?php echo htmlspecialchars($course['name_th_course']); ?>
                </h3>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>ชื่อโมดูล</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_modules->num_rows > 0): ?>
                            <?php while ($module = $result_modules->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($module['name_th_modulecourse']); ?></td>
                                    <td class="text-center">
                                        <a href="edit_modulecourses.php?id=<?php echo $module['modulecourse_id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">ยังไม่มีโมดูลในคอร์สนี้</td>
                            </tr>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-between">
                    </tbody>
                </table>
                <a href="../admin/view-courses.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> กลับ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
