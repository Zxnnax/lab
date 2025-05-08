<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lab");

if ($conn->connect_error) {
  die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// ตรวจสอบว่ามี user นี้ในระบบไหม
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // ตรวจสอบรหัสผ่าน
  if (password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['fullname'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['user_id'] = $user['id']; // จะใช้ในหน้าอื่นได้สะดวก

    if ($user['role'] === 'admin') {
      header("Location: admin/admin_dashboard.php");
    } else {
      header("Location: user/user_home.php");
    }
    exit();
  } else {
    header("Location: login.php?error=รหัสผ่านไม่ถูกต้อง");
    exit();
  }
} else {
  header("Location: login.php?error=ไม่พบบัญชีผู้ใช้นี้");
  exit();
}

$stmt->close();
$conn->close();
?>