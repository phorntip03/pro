<?php
$student_id = $_GET['student_id'] ?? 0;
$path = __DIR__ . \"a/certificates/certificate_{$student_id}.jpg\";

header(\"Content-Type: image/jpeg\");
if (file_exists($path)) {
    readfile($path);
} else {
    readfile(__DIR__ . \"/certificates/default.jpg\"); // กรณีไม่มีรูป
}
?>
