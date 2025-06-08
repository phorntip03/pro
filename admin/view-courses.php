<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$sql = "
    SELECT 
        c.course_id,
        c.name_th_course,
        CONCAT(p.name_ps, ' ', p.lastname_ps) AS creator,
        GROUP_CONCAT(mc.name_th_modulecourse SEPARATOR ', ') AS module_names
    FROM 
        course c
    LEFT JOIN 
        module_course mc ON c.course_id = mc.course_id
    LEFT JOIN
        personnel p ON c.personnel_id = p.personnel_id
    GROUP BY 
        c.course_id, c.name_th_course
";

$result = $conn->query($sql);

// toast success
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
    <title>จัดการคอร์สทั้งหมด</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>
<body>

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="col-md-9 mt-5">
            <div class="card p-4">
                <h3 class="mb-4 text-primary"><i class="bi bi-journal-code"></i> จัดการคอร์สทั้งหมด</h3>

               <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อคอร์ส</th>
                        <th>ผู้สร้าง</th>
                        <th>โมดูล</th>
                        <th style="width: 120px;">แก้ไขคอร์ส</th>
                        <th style="width: 140px;">จัดการโมดูล</th>
                        <th style="width: 120px;">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class="fw-bold text-start"><?php echo htmlspecialchars($row['name_th_course']); ?></td>
                            <td><?php echo htmlspecialchars($row['creator'] ?? 'ไม่ระบุ'); ?></td>
                            <td class="text-start">
                                <?php 
                                if (!empty($row['module_names'])) {
                                    $modules = explode(', ', $row['module_names']);
                                    foreach ($modules as $module) {
                                        echo '<span class="badge bg-primary text-light me-1 mb-1">' . htmlspecialchars($module) . '</span>';
                                    }
                                } else {
                                    echo '<span class="text-muted">ไม่มีโมดูล</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="edit_subject.php?id=<?php echo $row['course_id']; ?>" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-pencil-square"></i> แก้ไข
                                </a>
                            </td>
                            <td>
                                <a href="edit_module.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-info btn-sm w-100">
                                    <i class="bi bi-list-check"></i> จัดการโมดูล
                                </a>
                            </td>
                            <td>
                                <a href="../auth/delete_course.php?id=<?php echo $row['course_id']; ?>" 
                                class="btn btn-danger btn-sm w-100" 
                                onclick="return confirm('คุณต้องการลบคอร์สนี้หรือไม่?')">
                                    <i class="bi bi-trash"></i> ลบ
                                </a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">ยังไม่มีคอร์ส</td>
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
