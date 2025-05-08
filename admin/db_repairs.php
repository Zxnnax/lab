<?php
$host = 'localhost';  // MySQL server
$dbname = 'lab';  // ชื่อฐานข้อมูล
$username = 'root';   // ชื่อผู้ใช้ (ใน XAMPP จะเป็น root)
$password = '';       // รหัสผ่าน (ใน XAMPP จะไม่มีรหัสผ่าน)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage();
}
?>
