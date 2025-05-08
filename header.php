<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LAB Electronics</title>
  <link rel="icon" href="/LAB/image/Logo.jpg">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; }

    header.top-nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #2D3A41;
      color: white;
      padding: 10px 20px;
      flex-wrap: wrap;
    }

    .logo-section {
      display: flex;
      align-items: center;
    }

    .logo {
      height: 50px;
      margin-right: 10px;
    }

    .brand-name {
      font-size: 20px;
      font-weight: bold;
      color: white;
      text-decoration: none;
    }

    .main-menu ul {
      display: flex;
      list-style: none;
      gap: 20px;
    }

    .main-menu a {
      color: white;
      text-decoration: none;
      font-size: 16px;
    }

    .search-wrapper {
      display: flex;
      align-items: center;
      position: relative;
    }

    .search-wrapper input {
      width: 200px;
      padding: 6px;
      font-size: 16px;
    }

    .search-wrapper button {
      padding: 6px 10px;
      margin-left: 5px;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      border: none;
      background: transparent;
    }

    .search-wrapper button img {
      height: 20px; /* ปรับขนาดไอคอนตามต้องการ */
      width: 20px;
    }

    .user-section {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .login-wrapper {
      position: relative;
    }

    .login-link {
      color: white;
      cursor: pointer;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 25px;
      right: 0;
      background: white;
      color: black;
      border-radius: 5px;
      padding: 10px;
      min-width: 180px;
      z-index: 999;
    }

    .login-wrapper:hover .dropdown {
      display: block;
    }

    .dropdown-button,
    .signup-link,
    .order-history-link {
      display: block;
      padding: 5px 0;
      color: #2D3A41;
      text-decoration: none;
    }

    .cart-link {
      color: white;
      text-decoration: none;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 4px;
      cursor: pointer;
    }

    .hamburger span {
      width: 25px;
      height: 3px;
      background: white;
    }

    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }

      .main-menu {
        display: none;
        width: 100%;
      }

      .main-menu.active {
        display: block;
        background-color:rgb(34, 46, 53);
        padding: 15px;
        border-radius: 10px;
      }

      .main-menu ul {
        flex-direction: column;
        gap: 10px;
      }

      .search-wrapper {
        display: none;
      }

      .user-section {
        display: none;
      }

      .mobile-extra {
        display: block;
        margin-top: 10px;
        color: white;
      }

      .mobile-extra a {
        color: #ccc;
        display: block;
        margin-top: 5px;
      }
    }

    @media (min-width: 769px) {
      .mobile-extra {
        display: none;
      }

      .search-wrapper {
        display: flex;
        align-items: center;
      }
    }

    .main-menu.active {
      margin-top: 15px;  /* เพิ่มระยะห่างที่ต้องการ */
    }


    .dropdown.show {
      display: block;
    }

  </style>
</head>
<body>

<header class="top-nav">
  <div class="logo-section">
    <a href="/LAB/index.php" style="display: flex; align-items: center; text-decoration: none;">
      <img src="/LAB/image/Logo.jpg" alt="โลโก้บริษัท" class="logo"/>
      <span class="brand-name">LAB ELECTRONICS</span>
    </a>
  </div>

  <div class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <nav class="main-menu" id="mainMenu">
    <ul>
      <li><a href="/LAB/index.php">หน้าแรก</a></li>
      <li><a href="contact.php">เกี่ยวกับเรา</a></li>
      <li><a href="repair-status.php">ติดตามงานซ่อม</a></li>
      <li><a href="#">ช่วยเหลือ</a></li>
    </ul>

    <!-- Mobile-only extra section -->
    <div class="mobile-extra">
      <form class="search-wrapper" style="margin-bottom: 10px;" onsubmit="handleSearch(event)">
        <button type="submit">
          <img src="/lab/image/icon6.png" alt="Search Icon">
        </button>
      </form>
      
      <?php if (isset($_SESSION['user'])): ?>
        <div style="color: white; margin-bottom: 10px;">ยินดีต้อนรับ, <?php echo $_SESSION['user']; ?></div>
        <a href="/LAB/logout.php" style="color: white;">ออกจากระบบ</a>
      <?php else: ?>
        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-bottom: 10px;">
          <a href="login.php" style="color: white;">เข้าสู่ระบบ</a>
          <span style="color: white;"> </span>
          <a href="register.php" style="color: white;">สมัครสมาชิก</a>
          <span style="color: white;"> </span>
          <a href="cart.php" style="color: white;">Cart</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Desktop Search + User Section -->
  <div class="search-wrapper">
    <input type="text" placeholder="ค้นหาสินค้า..." id="searchInput">
    <button onclick="handleSearch(event)">
      <img src="/lab/image/icon6.png" alt="Search Icon">
    </button>
  </div>

  <div class="user-section">
    <?php if (isset($_SESSION['user'])): ?>
      <span>ยินดีต้อนรับ, <?php echo $_SESSION['user']; ?></span>
      <a href="/LAB/logout.php">ออกจากระบบ</a>
    <?php else: ?>
      <div class="login-wrapper">
      <a href="javascript:void(0);" class="login-link" onclick="toggleLoginMenu()">Login</a>
        <div class="dropdown">
          <a href="login.php" class="dropdown-button">เข้าสู่ระบบ</a>
          <hr>
          <a href="register.php" class="signup-link">ลูกค้ารายใหม่ เริ่มต้นที่นี่</a>
          <hr>
          <a href="order-history.php" class="order-history-link">ประวัติคำสั่งซื้อ</a>
        </div>
      </div>
    <?php endif; ?>
    <a href="cart.php" class="cart-link">Cart</a>
  </div>
</header>

<script>
  function toggleMenu() {
    document.getElementById("mainMenu").classList.toggle("active");
  }

  // Function to handle the search
  function handleSearch(event) {
    event.preventDefault(); // Prevent form submission
    const query = document.getElementById("searchInput") ? document.getElementById("searchInput").value : "";
    if (query) {
      window.location.href = `search-results.php?q=${encodeURIComponent(query)}`; // Redirect to the search results page
    }
  }

    // Function to toggle the login dropdown
    function toggleLoginMenu() {
    const dropdown = document.querySelector(".dropdown");
    dropdown.classList.toggle("show");
  }

  // Close the dropdown if clicked outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.login-link') && !event.target.matches('.dropdown') && !event.target.matches('.dropdown *')) {
      const dropdown = document.querySelector(".dropdown");
      if (dropdown.classList.contains("show")) {
        dropdown.classList.remove("show");
      }
    }
  };

</script>

</body>
</html>
