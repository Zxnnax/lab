<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "lab");

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = $_POST['password'];
$confirm = $_POST['confirm-password'];

// ตรวจสอบรหัสผ่านตรงกัน
if ($password !== $confirm) {
    echo "รหัสผ่านไม่ตรงกัน";
    exit();
}

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// บันทึกลงฐานข้อมูล
$stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, address, password, role) VALUES (?, ?, ?, ?, ?, 'user')");
$stmt->bind_param("sssss", $fullname, $email, $phone, $address, $hashed_password);

if ($stmt->execute()) {
    // สมัครสำเร็จ → เด้งไปหน้า login
    header("Location: login.php?register=success");
    exit();
} else {
    echo "เกิดข้อผิดพลาดในการสมัคร: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>