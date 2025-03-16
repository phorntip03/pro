<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image: url('img/i1.jpg'); 
      background-size: cover; /* ปรับให้เต็มหน้าจอ */
      background-position: center; /* จัดตำแหน่งกึ่งกลาง */
      background-repeat: no-repeat; /* ไม่ให้ภาพซ้ำ */
      margin: 0;
    }
    .form-signin {
      max-width: 400px;
      width: 100%;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-signin img {
      display: block;
      margin: 0 auto 20px;
    }
    .form-signin h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }
    .form-floating input {
      border-radius: 0.375rem;
    }
    .form-check {
      margin-top: 10px;
    }
    /* Media query สำหรับหน้าจอขนาดเล็ก (มือถือ) */
    @media (max-width: 576px) {
      .form-signin {
        padding: 15px;
        max-width: 90%; /* ปรับให้กรอบฟอร์มใช้พื้นที่หน้าจอมากขึ้น */
      }
      .form-signin h1 {
        font-size: 20px; /* ลดขนาดข้อความหัวเรื่อง */
      }
      .form-signin img {
        width: 80px; /* ปรับขนาดรูป logo */
        height: auto;
      }
    }
  </style>
</head>
<body>
  <main class="form-signin">
    <form action="login.php" method="post">
      <img src="img/logo1.gif" alt="Logo" width="100" height="150">
      <h1 class="h3 mb-3 fw-normal">เข้าสู่ระบบ</h1>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="ชื่อผู้ใช้งาน" required>
        <label for="floatingUsername">ชื่อผู้ใช้งาน</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="รหัสผ่าน" required>
        <label for="floatingPassword">รหัสผ่าน</label>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit">เข้าสู่ระบบ</button>
      <p class="mt-5 mb-3 text-body-secondary text-center">© 2025 คณะเกษตรศาสตร์และเทคโนโลยี มทร.อีสาน วข.สุรินทร์</p>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Y1J3zn4=" crossorigin="anonymous">
  </script>
  <script>
    document.getElementById('cancelButton').addEventListener('click', function() {
      window.location.href = 'blackendhome.php'; 
    });
  </script>
</body>
</html>
