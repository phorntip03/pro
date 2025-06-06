<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

include '../backend/config/connect.php';
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

<div class="d-flex">
    <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

    <div class="col-md-9 mt-5">
        <div class="card p-4">
            <h3 class="mb-4 text-primary"><i class="bi bi-journal-bookmark-fill"></i> รายชื่อนักเรียน</h3>

            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อผู้เรียน</th>
                        <th>หลักสูตร</th>
                        <th>โมดูล</th>
                        <th>ผลการศึกษา</th>
                        <th>ออกเกียรติบัตร</th>
                    </tr>
                </thead>
                <tbody>
                <?php
               $sql = "SELECT  s.student_id,s.name_st,s.lastname_st,s.course_id,s.modulecourse_id,c.name_th_course, 
            m.name_th_modulecourse,r.result_status
        FROM student s
        LEFT JOIN course c ON s.course_id = c.course_id
        LEFT JOIN module_course m ON s.modulecourse_id = m.modulecourse_id
        LEFT JOIN confirm_academic_results r 
            ON s.student_id = r.student_id 
            AND s.course_id = r.course_id
            AND s.modulecourse_id = r.modulecourse_id";
                $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $studentId = $row['student_id'];
                        $courseId = $row['course_id'];
                        $moduleId = $row['modulecourse_id'];
                        $resultStatus = $row['result_status'];
                        $resultText = $resultStatus === 'pass' ? "<span class='text-success'>ผ่าน</span>" :
                                    ($resultStatus === 'fail' ? "<span class='text-danger'>ไม่ผ่าน</span>" : "<span class='text-secondary'>รอประเมิน</span>");
                        echo "<tr id='row-$studentId'>
                            <td>{$row['name_st']} {$row['lastname_st']}</td>
                            <td>{$row['name_th_course']}</td>
                            <td>{$row['name_th_modulecourse']}</td>
                            <td id='result-cell-$studentId'>";

                        if (!$resultStatus) {
                            echo "<button class='btn btn-success btn-sm' 
                                    onclick=\"submitResult($studentId, $courseId, $moduleId, 'pass')\">ผ่าน</button>
                                <button class='btn btn-danger btn-sm' 
                                    onclick=\"submitResult($studentId, $courseId, $moduleId, 'fail')\">ไม่ผ่าน</button>
                                <div class='mt-2' id='status-text-$studentId'>$resultText</div>";
                        } else {
                            echo "<div class='mt-2'>$resultText</div>";
                        }

                        echo "</td>
                            <td id='cert-cell-$studentId'>";

                        if ($resultStatus === 'pass') {
                            echo "<a href='certificate-image.php?student_id=$studentId' target='_blank'>
                                    <img src='certificate-image.php?student_id=$studentId' class='img-fluid' style='max-height: 100px;'>
                                </a>";
                        } else {
                            echo "<button class='btn btn-secondary btn-sm' disabled>ยังไม่ผ่าน</button>";
                        }

                        echo "</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function submitResult(studentId, courseId, moduleId, result) {
    fetch('confirm-result.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `student_id=${studentId}&course_id=${courseId}&modulecourse_id=${moduleId}&result=${result}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const statusClass = result === 'pass' ? 'text-success' : 'text-danger';
            const statusText = result === 'pass' ? 'ผ่าน' : 'ไม่ผ่าน';
            document.getElementById('result-cell-' + studentId).innerHTML =
                `<div class='mt-2'><span class='${statusClass}'>${statusText}</span></div>`;

            if (result === 'pass') {
                document.getElementById('cert-cell-' + studentId).innerHTML =
                    `<a href="certificate-image.php?student_id=${studentId}" target="_blank">
                        <img src="certificate-image.php?student_id=${studentId}" class="img-fluid" style="max-height: 100px;">
                    </a>`;
            } else {
                document.getElementById('cert-cell-' + studentId).innerHTML =
                    `<button class="btn btn-secondary btn-sm" disabled>ยังไม่ผ่าน</button>`;
            }
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>