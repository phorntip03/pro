<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
include '../backend/config/connect.php';

// ดึงรายรับรายวิชา
$sqlCourse = "
    SELECT 
        c.name_th_course AS name,
        (c.price_course * COUNT(s.student_id)) AS income
    FROM course c
    LEFT JOIN student s ON c.course_id = s.course_id
    GROUP BY c.course_id
";
$resultCourse = $conn->query($sqlCourse);
$courseLabels = [];
$courseData = [];

while ($row = $resultCourse->fetch_assoc()) {
    $courseLabels[] = $row['name'];
    $courseData[] = $row['income'];
}

// ดึงรายรับกลุ่มวิชา
$sqlModule = "
    SELECT 
        m.name_th_modulecourse AS name,
        (m.price_module * COUNT(s.student_id)) AS income
    FROM module_course m
    LEFT JOIN student s ON m.modulecourse_id = s.modulecourse_id
    GROUP BY m.modulecourse_id
";
$resultModule = $conn->query($sqlModule);
$moduleLabels = [];
$moduleData = [];

while ($row = $resultModule->fetch_assoc()) {
    $moduleLabels[] = $row['name'];
    $moduleData[] = $row['income'];
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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <link href="../assets/css/backend-style.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header -->
    <?php include(__DIR__ . '/../backend/views/backend/backend-header.php'); ?>

    <div class="d-flex">
        <!-- Sidebar -->
        <?php include(__DIR__ . '/../backend/views/backend/backend-sidebar.php'); ?>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            <div class="container-fluid">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-primary">📊 ยินดีต้อนรับสู่ระบบจัดการฐานข้อมูลหลักสูตร</h2>
                    <p class="text-muted">สามารถจัดการข้อมูลและดูรายงานได้จากหน้านี้</p>
                </div>

                <!-- Carousel -->
                <div class="carousel slide mb-5 shadow-lg rounded" id="carouselExampleIndicators" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../assets/img/i1.jpg" class="d-block w-100 rounded" alt="สไลด์ 1">
                        </div>
                        <div class="carousel-item">
                            <img src="../assets/img/i2.jpg" class="d-block w-100 rounded" alt="สไลด์ 2">
                        </div>
                        <div class="carousel-item">
                            <img src="../assets/img/i3.jpg" class="d-block w-100 rounded" alt="สไลด์ 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <!-- Bottom Section -->
                <div class="row g-4">
                    <!-- ข่าวสาร -->
                    <div class="col-12 col-md-6">
                        <div class="card shadow h-100 border-0">
                            <div class="card-body">
                                <h4 class="card-title text-primary">📰 ข่าวสาร</h4>
                                <div class="carousel slide mt-3" id="newsCarousel" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="../assets/img/i1.jpg" class="d-block w-100 rounded" alt="ข่าว 1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../assets/img/i2.jpg" class="d-block w-100 rounded" alt="ข่าว 2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="../assets/img/i3.jpg" class="d-block w-100 rounded" alt="ข่าว 3">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- รายงานสถิติ -->
                    <div class="col-12 col-md-6">
                        <div class="card shadow h-100 text-center border-0">
                            <div class="card-body">
                                <h4 class="card-title text-primary">📈 รายงานสถิติรายรับ</h4>
                                <canvas id="incomeChart" height="200" class="mt-3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('incomeChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_merge($courseLabels, $moduleLabels)); ?>,
                datasets: [{
                    label: 'รายรับ (บาท)',
                    data: <?php echo json_encode(array_merge($courseData, $moduleData)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' บาท';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw.toLocaleString() + ' บาท';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
