<?php
session_start(); // เริ่ม session ก่อน
session_unset(); // ล้างตัวแปรทั้งหมดใน session
session_destroy(); // ทำลาย session

// ส่งกลับไปหน้า login หรือ index แล้วแต่ต้องการ
header("Location: index.php");
exit();
?>