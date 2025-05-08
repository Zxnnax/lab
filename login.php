<link rel="stylesheet" href="css/style.css" />
<?php include "header.php"; ?>

<div class="container">
  <div class="login-section">
    <h2>เข้าสู่ระบบ</h2>

    <?php
      if (isset($_GET['error'])) {
        echo "<p style='color: red;'>".htmlspecialchars($_GET['error'])."</p>";
      }
    ?>

    <form action="login_process.php" method="POST">

      <label for="email">อีเมล</label>
      <input type="email" name="email" id="email" required placeholder="กรอกอีเมล">

      <label for="password">รหัสผ่าน</label>
      <input type="password" name="password" id="password" required placeholder="กรอกรหัสผ่าน">


      <button type="submit">เข้าสู่ระบบ</button>

    </form>

    <p class="signup-link">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
  </div>
</div>

<?php include "footer.php"; ?>