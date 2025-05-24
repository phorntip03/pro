<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}

include '../backend/config/connect.php';

// รับค่า student_id จาก GET
$student_id = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;

// ดึงข้อมูลนักเรียน + คอร์ส + โมดูล
$sql = "SELECT 
            s.name_st, s.lastname_st,
            c.name_th_course,
            m.name_th_modulecourse,
            c.start_course, c.close_course
        FROM student s
        LEFT JOIN course c ON s.course_id = c.course_id
        LEFT JOIN module_course m ON s.modulecourse_id = m.modulecourse_id
        WHERE s.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "ไม่พบนักเรียนในระบบ";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เกียรติบัตร</title>
    <style>
        body {
            font-family: 'TH Sarabun New', sans-serif;
            background-color: #fdf6e3;
            padding: 50px;
            text-align: center;
        }
        .certificate {
            border: 10px solid #666;
            padding: 40px;
            background: white;
            width: 90%;
            margin: auto;
        }
        h1 {
            font-size: 48px;
            color: #333;
        }
        .name {
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
        }
        .details {
            font-size: 20px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            font-size: 18px;
            color: #666;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="certificate">
    <h1>ใบประกาศนียบัตร</h1>
    <p>ขอมอบเกียรติบัตรนี้ให้แก่</p>
    <div class="name"><?= htmlspecialchars($row['name_st'] . ' ' . $row['lastname_st']) ?></div>
    <div class="details">
        ได้สำเร็จการอบรมในหลักสูตร<br>
        <strong><?= htmlspecialchars($row['name_th_course']) ?></strong><br>
        หมวดวิชา: <?= htmlspecialchars($row['name_th_modulecourse']) ?><br>
        ระหว่างวันที่ <?= date("d/m/Y", strtotime($row['start_course'])) ?> 
        ถึง <?= date("d/m/Y", strtotime($row['close_course'])) ?>
    </div>

    <div class="footer">
        ลงนามโดย<br>
        <em>ผู้รับผิดชอบหลักสูตร</em>
    </div>
</div>

<br>
<button onclick="window.print()" class="btn btn-primary">พิมพ์เกียรติบัตร</button>

</body>
</html>
