<?php
require_once '../backend/config/connect.php';

if (!isset($_GET['student_id'])) {
    die("Student ID required");
}

$student_id = intval($_GET['student_id']);

// ดึงข้อมูล
$sql = "SELECT 
            s.name_st, 
            s.lastname_st, 
            c.name_th_course, 
            m.name_th_modulecourse
        FROM student s
        LEFT JOIN course c ON s.course_id = c.course_id
        LEFT JOIN module_course m ON s.modulecourse_id = m.modulecourse_id
        WHERE s.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Student not found");
}

$data = $result->fetch_assoc();

$student_name = $data['name_st'] . " " . $data['lastname_st'];
$course_name = $data['name_th_course'];
$module_name = $data['name_th_modulecourse'];

<<<<<<< HEAD

=======
// สร้างภาพ
>>>>>>> 41b33e880676014d4837bb927cda69928271cac1
$image_path = '../assets/certificate/c1.png';
header('Content-Type: image/png');
$image = imagecreatefrompng($image_path);
$black = imagecolorallocate($image, 0, 0, 0);

<<<<<<< HEAD

=======
// โหลดฟอนต์ Sarabun จาก assets/fonts/
>>>>>>> 41b33e880676014d4837bb927cda69928271cac1
$font_path = '../assets/fonts/THSarabunNew.ttf';
if (!file_exists($font_path)) {
    die("Font file not found.");
}

<<<<<<< HEAD

=======
// วาดข้อความลงภาพ (กำหนดขนาด และตำแหน่ง)
>>>>>>> 41b33e880676014d4837bb927cda69928271cac1
imagettftext($image, 48, 0, 300, 340, $black, $font_path, $student_name);
imagettftext($image, 36, 0, 300, 410, $black, $font_path, $course_name);
imagettftext($image, 36, 0, 300, 480, $black, $font_path, $module_name);

<<<<<<< HEAD

=======
// ส่งภาพออกไป
>>>>>>> 41b33e880676014d4837bb927cda69928271cac1
imagepng($image);
imagedestroy($image);
?>
