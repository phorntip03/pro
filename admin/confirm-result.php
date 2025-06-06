<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

include '../backend/config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = intval($_POST['student_id']);
    $course_id = intval($_POST['course_id']);
    $modulecourse_id = intval($_POST['modulecourse_id']);
    $result = $_POST['result'];

    if (!in_array($result, ['pass', 'fail'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid result']);
        exit();
    }

   
    $check_sql = "SELECT * FROM confirm_academic_results 
                  WHERE student_id = ? AND course_id = ? AND modulecourse_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("iii", $student_id, $course_id, $modulecourse_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
  
        $update_sql = "UPDATE confirm_academic_results 
                       SET result_status = ? 
                       WHERE student_id = ? AND course_id = ? AND modulecourse_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("siii", $result, $student_id, $course_id, $modulecourse_id);
        $stmt->execute();
    } else {
        
        $insert_sql = "INSERT INTO confirm_academic_results 
                       (student_id, course_id, modulecourse_id, result_status) 
                       VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iiis", $student_id, $course_id, $modulecourse_id, $result);
        $stmt->execute();
    }

    echo json_encode(['success' => true]);
}
?>
