<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../admin/blackendlogin.php");
    exit();
}

include '../backend/config/connect.php';

$id = (int)$_GET['id'];
$stmt = $conn->prepare("DELETE FROM branch WHERE branch_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../admin/branch-manage.php");
exit();
?>
