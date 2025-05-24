<?php
session_start();
include '../backend/config/connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบหลังบ้าน</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="d-flex">
    <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

    <div class="col-md-9 mt-5">
        <div class="card p-4">
            <h3 class="mb-4 text-primary">
                <i class="bi bi-journal-bookmark-fill"></i> รายงานผลการเงิน
            </h3>

            <?php
            // เตรียมยอดรวม
            $totalCourseIncome = 0;
            $totalModuleIncome = 0;
            ?>

            <!-- รายงานรายวิชา -->
            <h5 class="text-success mb-3">รายได้จากรายวิชา</h5>
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อรายวิชา</th>
                        <th>ราคา</th>
                        <th>จำนวนผู้ลงทะเบียน</th>
                        <th>รวมรายได้</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlCourse = "
                        SELECT 
                            c.name_th_course AS course_name,
                            c.price_course AS course_price,
                            COUNT(sc.student_id) AS student_count,
                            (c.price_course * COUNT(sc.student_id)) AS total_income
                        FROM course c
                        LEFT JOIN student sc ON c.course_id = sc.course_id
                        GROUP BY c.course_id
                    ";
                    $resultCourse = $conn->query($sqlCourse);

                    while ($row = $resultCourse->fetch_assoc()) {
                        $totalCourseIncome += $row['total_income'];
                        echo "<tr>";
                        echo "<td>{$row['course_name']}</td>";
                        echo "<td>" . number_format($row['course_price'], 2) . "</td>";
                        echo "<td>{$row['student_count']}</td>";
                        echo "<td>" . number_format($row['total_income'], 2) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <hr class="my-4">

            <!-- รายงานกลุ่มวิชา -->
            <h5 class="text-success mb-3">รายได้จากกลุ่มวิชา</h5>
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อกลุ่มวิชา</th>
                        <th>ราคา</th>
                        <th>จำนวนผู้ลงทะเบียน</th>
                        <th>รวมรายได้</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlModule = "
                        SELECT 
                            m.name_th_modulecourse AS module_name,
                            m.price_module AS module_price,
                            COUNT(sm.student_id) AS student_count,
                            (m.price_module * COUNT(sm.student_id)) AS total_income
                        FROM module_course m
                        LEFT JOIN student sm ON m.modulecourse_id = sm.modulecourse_id
                        GROUP BY m.modulecourse_id
                    ";
                    $resultModule = $conn->query($sqlModule);

                    while ($row = $resultModule->fetch_assoc()) {
                        $totalModuleIncome += $row['total_income'];
                        echo "<tr>";
                        echo "<td>{$row['module_name']}</td>";
                        echo "<td>" . number_format($row['module_price'], 2) . "</td>";
                        echo "<td>{$row['student_count']}</td>";
                        echo "<td>" . number_format($row['total_income'], 2) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- รวมรายรับทั้งหมด -->
            <div class="mt-4">
                <div class="alert alert-info text-center fs-5">
                    <strong>รวมรายรับทั้งหมด:</strong>
                    <?php echo number_format($totalCourseIncome + $totalModuleIncome, 2); ?> บาท
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
