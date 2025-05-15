<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

$personnel_id = $_SESSION['personnel_id'];

// ดึงชื่อคอร์สและชื่อโมดูลจาก module_course โดยไม่ใช้ตาราง module
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
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>คอร์สเรียนของฉัน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/backend-style.css">
    <link rel="stylesheet" href="../assets/css/view-courses-style.css">
</head>
<body>
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <div class="col-md-9 mt-5">
            <div class="card p-4">
                <h3 class="mb-4 text-primary"><i class="bi bi-journal-bookmark-fill"></i> คอร์สเรียนของคุณ</h3>

                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr class="text-center">
                            <th>ชื่อคอร์ส</th>
                            <th>โมดูลในคอร์ส</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name_th_course'] ?? 'ไม่มีชื่อคอร์ส'); ?></td>
                                <td>
                                    <?php 
                                    if (!empty($row['name_th_modulecourse'])) {
                                        $modules = explode(', ', $row['name_th_modulecourse']);
                                        foreach ($modules as $module) {
                                            echo '<span class="badge bg-primary text-light me-1">' . htmlspecialchars($module) . '</span>';
                                        }
                                    } else {
                                        echo '<span class="text-muted">ยังไม่มีโมดูล</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit_course.php?id=<?php echo $row['course_id']; ?>" class="btn btn-warning btn-sm mb-1">
                                        <i class="bi bi-pencil-square"></i> แก้ไขคอร์ส
                                    </a>
                                    <a href="edit_module.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-list-task"></i> จัดการโมดูล
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else { ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">ยังไม่มีคอร์ส</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
