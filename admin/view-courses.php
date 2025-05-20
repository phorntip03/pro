<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$personnel_id = $_SESSION['personnel_id'];

$sql = "
    SELECT 
        c.course_id,
        c.name_th_course,
        GROUP_CONCAT(mc.name_th_modulecourse SEPARATOR ', ') AS name_th_modulecourse
    FROM 
        course c
    LEFT JOIN 
        module_course mc ON c.course_id = mc.course_id
    WHERE 
        c.personnel_id = ?
    GROUP BY 
        c.course_id, c.name_th_course
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $personnel_id);
$stmt->execute();
$result = $stmt->get_result();

// เช็คว่ามีข้อความ toast_success ส่งมาหรือไม่
$toast_success = "";
if (isset($_SESSION['toast_success'])) {
    $toast_success = $_SESSION['toast_success'];
    unset($_SESSION['toast_success']);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>คอร์สเรียนของฉัน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/view-courses-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="col-md-9 mt-5">
            <div class="card p-4">
                <h3 class="mb-4 text-primary"><i class="bi bi-journal-bookmark-fill"></i> คอร์สเรียนของคุณ</h3>

                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ชื่อคอร์ส</th>
                            <th>โมดูลในคอร์ส</th>
                            <th style="width: 140px;">แก้ไขคอร์ส</th>
                            <th style="width: 140px;">จัดการโมดูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="fw-bold text-start"><?php echo htmlspecialchars($row['name_th_course'] ?? 'ไม่มีชื่อคอร์ส'); ?></td>
                                <td class="text-start">
                                    <?php 
                                    if (!empty($row['name_th_modulecourse'])) {
                                        $modules = explode(', ', $row['name_th_modulecourse']);
                                        foreach ($modules as $module) {
                                            echo '<span class="badge bg-primary text-light me-1 mb-1">' . htmlspecialchars($module) . '</span>';
                                        }
                                    } else {
                                        echo '<span class="text-muted">ยังไม่มีโมดูล</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="edit_subject.php?id=<?php echo $row['course_id']; ?>" class="btn btn-warning btn-sm w-100">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </a>
                                </td>
                                <td>
                                    <a href="edit_module.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-list-task"></i> โมดูล
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">ยังไม่มีคอร์ส</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($toast_success)): ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="toast-success">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($toast_success); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
