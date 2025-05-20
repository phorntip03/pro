<?php
session_start();
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/css/backend-style.css" rel="stylesheet">

</head>
<body class="bg-light">

    <!-- Header -->
    <?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

    <div class="d-flex">
        <!-- Sidebar -->
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>
        <div class="col-md-9 mt-5">
            <div class="card p-4">
                <h3 class="mb-4 text-primary"><i class="bi bi-journal-bookmark-fill"></i> รายชื่อนักเรียนลงทะเบียน</h3>

                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ชื่อผู้ลงทะเบียน</th>
                            <th>หลักสูตร</th>
                            <th style="width: 140px;">หลักฐานการชำระเงิน</th>
                            <th style="width: 140px;">สถานะของการยืนยัน</th>
                        </tr>
                    </thead>
                    </tbody>
                    </table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
