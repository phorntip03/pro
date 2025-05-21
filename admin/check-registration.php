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
    <title>รายชื่อนักเรียนลงทะเบียน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="d-flex">
    <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

    <div class="container py-5">
        <div class="card p-4">
            <h3 class="mb-4 text-primary"><i class="bi bi-journal-bookmark-fill"></i> รายชื่อนักเรียนลงทะเบียน</h3>

            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อนักเรียน</th>
                        <th>หลักสูตร</th>
                        <th>กลุ่มวิชา</th>
                        <th>หลักฐานชำระเงิน</th>
                        <th>สถานะ</th>
                        <th>ยืนยันเริ่มเรียน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
                        SELECT 
                            st.student_id,
                            st.name_st,
                            st.lastname_st,
                            st.transfer_slip,
                            c.name_th_course,
                            m.name_th_modulecourse,
                            ss.statusstudent_id,
                            ss.namestatus_st
                        FROM student st
                        LEFT JOIN course c ON st.course_id = c.course_id
                        LEFT JOIN module_course m ON c.course_id = m.course_id
                        LEFT JOIN studentstatus ss ON st.student_id = ss.student_id
                        ORDER BY st.student_id ASC
                    ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $fullName = $row['name_st'] . " " . $row['lastname_st'];
                            $statusText = $row['namestatus_st'] ?? '';
                            $badgeClass = 'secondary';

                            if ($statusText === 'อนุมัติแล้ว') {
                                $badgeClass = 'success';
                                $statusDisplay = 'กำลังศึกษา';
                            } elseif ($statusText === 'ไม่อนุมัติ') {
                                $badgeClass = 'danger';
                                $statusDisplay = 'ไม่อนุมัติ';
                            } elseif ($row['transfer_slip']) {
                                $statusDisplay = 'ชำระแล้ว';
                            } else {
                                $statusDisplay = 'ยังไม่ได้ชำระ';
                            }

                            echo "<tr>";
                            echo "<td>{$fullName}</td>";
                            echo "<td>{$row['name_th_course']}</td>";
                            echo "<td>{$row['name_th_modulecourse']}</td>";

                            if (!empty($row['transfer_slip'])) {
                                echo "<td><a href='../uploads/{$row['transfer_slip']}' target='_blank' class='btn btn-outline-primary btn-sm'>ดูไฟล์</a></td>";
                            } else {
                                echo "<td><span class='text-muted'>ไม่มีไฟล์</span></td>";
                            }

                            echo "<td><span class='badge bg-{$badgeClass}'>{$statusDisplay}</span></td>";

                           echo "<td>";
                            if ($statusText === 'อนุมัติแล้ว') {
                                echo "<span class='badge bg-success'>กำลังศึกษา</span>";
                            } elseif ($statusText === 'ไม่อนุมัติ') {
                                echo "<span class='badge bg-danger'>ไม่อนุมัติ</span>";
                            } else {
                                echo "
                                <div class='d-flex justify-content-center gap-2'>
                                    <form method='POST' action='confirm-start-learning.php'>
                                        <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                        <input type='hidden' name='action' value='approve'>
                                        <input type='hidden' name='status' value='อนุมัติแล้ว'>
                                        <button type='submit' class='btn btn-success btn-sm'>
                                            <i class='bi bi-check-circle'></i> ยืนยัน
                                        </button>
                                    </form>
                                    <form method='POST' action='confirm-start-learning.php'>
                                        <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                        <input type='hidden' name='action' value='reject'>
                                        <input type='hidden' name='status' value='ไม่อนุมัติ'>
                                        <button type='submit' class='btn btn-danger btn-sm'>
                                            <i class='bi bi-x-circle'></i> ไม่อนุมัติ
                                        </button>
                                    </form>
                                </div>
                                ";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>ไม่มีข้อมูลนักเรียน</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
