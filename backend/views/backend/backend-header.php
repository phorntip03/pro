<?php 
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['username'])) {
    header("Location: blackendlogin.php");
    exit();
}
?>

<header class="d-flex align-items-center justify-content-between px-3 py-2 bg-dark">
    <span class="text-white fw-semibold">👋 ยินดีต้อนรับ</span>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end text-small shadow">
            <li><a class="dropdown-item" href="../admin/add-module.php">➕ เพิ่มกลุ่มวิชา</a></li>
            <li><a class="dropdown-item" href="../admin/add-subject.php">📘 เพิ่มรายวิชา</a></li>
            <li><a class="dropdown-item" href="../user/edit-profile.php">👤 โปรไฟล์</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../auth/logout.php">🚪 ออกจากระบบ</a></li>
        </ul>
    </div>
</header>
