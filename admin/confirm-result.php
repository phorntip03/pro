<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false]);
    exit();
}
include '../backend/config/connect.php';

$student_id = $_POST['student_id'] ?? 0;
$result = $_POST['result'] ?? '';

if (!$student_id || !in_array($result, ['pass', 'fail'])) {
    echo json_encode(['success' => false]);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM confirm_academic_results WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $update = $conn->prepare("UPDATE confirm_academic_results SET result_status = ? WHERE student_id = ?");
    $update->bind_param("si", $result, $student_id);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO confirm_academic_results (student_id, result_status) VALUES (?, ?)");
    $insert->bind_param("is", $student_id, $result);
    $insert->execute();
}

echo json_encode(['success' => true]);
?>
