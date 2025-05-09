<?php 
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
?>
<header>
    <span class="text-white fw-semibold">👋 ยินดีต้อนรับ</span>
    
    <div class="dropdown ms-auto">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="../assets/img/i2.jpg" alt="Profile" width="32" height="32" class="rounded-circle me-2">
            <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
            <li><a class="dropdown-item" href="../admin/add-group.php">➕ เพิ่มกลุ่มวิชา</a></li>
            <li><a class="dropdown-item" href="../admin/add-subject.php">📘 เพิ่มรายวิชา</a></a></li>
            <li><a class="dropdown-item" href="../user/edit-profile.php">👤 โปรไฟล์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../auth/logout.php">🚪 ออกจากระบบ</a></li>
        </ul>
    </div>
</header>

