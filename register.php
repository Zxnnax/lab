<link rel="stylesheet" href="css/style.css" />
<?php include "header.php"; ?>

  <!-- ส่วนของสมัครสมาชิก -->
  <div class="container">
    <div class="signup-section">
      <h2>สมัครสมาชิก</h2>
      <form action="register_process.php" method="POST">
        <label for="fullname">ชื่อ-นามสกุล</label>
        <input type="text" id="fullname" name="fullname" required placeholder="กรุณากรอกชื่อผู้ใช้">
      
        <label for="email">อีเมล</label>
        <input type="email" id="email" name="email" required placeholder="กรุณากรอกอีเมล">
      
        <label for="phone">เบอร์โทรศัพท์</label>
        <input type="tel" id="phone" name="phone" required placeholder="กรุณากรอกเบอร์โทรศัพท์" pattern="[0-9]{10}">
      
        <label for="address">ที่อยู่</label>
        <input type="text" id="address" name="address" required placeholder="กรุณากรอกที่อยู่">
      
        <label for="password">รหัสผ่าน</label>
        <input type="password" id="password" name="password" required placeholder="กรุณากรอกรหัสผ่าน">
      
        <label for="confirm-password">ยืนยันรหัสผ่าน</label>
        <input type="password" id="confirm-password" name="confirm-password" required placeholder="กรุณากรอกรหัสผ่านอีกครั้ง">
      
        <button type="submit">สมัครสมาชิก</button>
      </form>
      <p class="login-link">เป็นสมาชิกแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
  </div>
  
</body>
</html>

<?php include "footer.php"; ?>