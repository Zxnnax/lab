<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// เช็คว่าผู้ใช้เป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  // ถ้าไม่ใช่ admin ให้ redirect กลับหน้าหลัก หรือหน้าที่เหมาะสม
  header("Location: ../admin_dashboard.php"); 
  exit();
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LAB Electronics</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="image/Logo.jpg">
</head>
<body>

<header class="top-nav">
<div class="logo-section">
  <a href="admin_dashboard.php">
      <img src="/LAB/image/Logo.jpg" alt="โลโก้บริษัท" class="logo"/>
      <span class="brand-name">LAB ELECTRONICS</span>
  </a>
</div>


  <nav class="main-menu">
    <ul>
      <li><a href="admin_dashboard.php">หน้าแรก</a></li>
      <li><a href="admin_repairs.php">เพิ่มข้อมูลงานซ่อม</a></li>      
      <li><a href="admin_tablerepairs.php">ตารางงานซ่อม</a></li>
      <li><a href="admin_repairs_status.php">อัพเดตสถานะงานซ่อม</a></li>
    </ul>
  </nav>

  <div style="display: flex; align-items: center; position: relative;">
    <div style="position: relative; width: 250px;">
        <input type="text" id="searchBox" placeholder="ค้นหาสินค้า..." style="width: 100%; padding: 8px; font-size: 16px;">
        <ul id="historyList"></ul>
    </div>
    <button id="searchButton" style="margin-left: 5px; padding: 8px 15px;">ค้นหา</button>
  </div>

  <div class="user-section">
  <?php if (isset($_SESSION['user'])): ?>
    <span style="color: white;"> ยินดีต้อนรับ, <?php echo $_SESSION['user']; ?></span>
    <a href="/LAB/logout.php">ออกจากระบบ</a>
  <?php else: ?>
    <div class="login-wrapper" id="loginWrapper">
      <a href="javascript:void(0);" class="login-link" id="loginToggle">Login</a>
      <div class="dropdown" id="loginDropdown">
       <a href="login.php" class="dropdown-button">เข้าสู่ระบบ</a>
        <hr>
        <a href="register.php" class="signup-link">ลูกค้ารายใหม่ เริ่มต้นที่นี่</a>
        <hr>
      </div>
    </div>
  <?php endif; ?>

  <script src="js/script.js" defer></script>
  </body>
</div>
</header>