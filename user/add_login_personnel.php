<?php
require_once '../backend/config/connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_ps = $_POST['name_ps'];
    $lastname_ps = $_POST['lastname_ps'];
    $email = $_POST['email'];
    $branch_id = intval($_POST['branch_id']);
    $position_id = intval($_POST['position_id']);
    $personnelstatus_id = intval($_POST['personnelstatus_id']);

    $img_ps = '';
    if (isset($_FILES['img_ps']) && $_FILES['img_ps']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['img_ps']['name']);
        $img_tmp = $_FILES['img_ps']['tmp_name'];
        $img_path = '../uploads/' . $img_name;

        if (!file_exists('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        if (move_uploaded_file($img_tmp, $img_path)) {
            $img_ps = $img_name;
        } else {
            $_SESSION['msg'] = 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ';
            header("Location: personnel_list.php");
            exit();
        }
    }

    // เพิ่มข้อมูล personnel
    $sql = "INSERT INTO personnel (name_ps, lastname_ps, branch_id, position_id, personnelstatus_id, email, img_ps) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiss", $name_ps, $lastname_ps, $branch_id, $position_id, $personnelstatus_id, $email, $img_ps);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "✅ เพิ่มข้อมูลบุคลากรเรียบร้อยแล้ว";
        header("Location: ../user/personnel_list.php");
        exit();
    } else {
        $_SESSION['msg'] = "❌ เกิดข้อผิดพลาดในการเพิ่มข้อมูลบุคลากร: " . $stmt->error;
        header("Location: personnel_list.php");
        exit();
    }
}
?>
