<link rel="stylesheet" href="../css/style.css" /> 
<?php include "header_admin.php"; ?>

<?php
include 'db_repairs.php';  // ใช้สำหรับเชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial_number = $_POST['serial_number'];
    $repair_status = $_POST['repair_status'];
    $note = $_POST['note'];  // รับหมายเหตุจากฟอร์มด้วย

    if (!empty($serial_number) && !empty($repair_status)) {
        // กรณีซ่อมไม่คุ้ม แต่ไม่มีการใส่หมายเหตุ
        if ($repair_status === "ซ่อมไม่คุ้ม" && empty(trim($note))) {
            echo "<div class='error-message'>กรุณากรอกหมายเหตุเมื่อเลือกสถานะ 'ซ่อมไม่คุ้ม'</div>";
        } else {
            try {
                $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM repair_requests WHERE serial_number = ?");
                $checkStmt->execute([$serial_number]);
                $serialExists = $checkStmt->fetchColumn();
        
                if ($serialExists == 0) {
                    echo "<div class='error-message'>ไม่พบ Serial Number นี้ในระบบ</div>";
                } else {
                    // อัพเดตสถานะและเวลาที่อัพเดต
                    $updateStmt = $pdo->prepare("UPDATE repair_requests SET repair_status = ?, note = ?, updated_at = CURRENT_TIMESTAMP WHERE serial_number = ?");
                    if ($updateStmt->execute([$repair_status, $note, $serial_number])) {
                        echo "<div class='success-message'>สถานะงานซ่อมถูกอัพเดตสำเร็จ</div>";
                    } else {
                        echo "<div class='error-message'>เกิดข้อผิดพลาดในการอัพเดตสถานะ</div>";
                    }
                }
            } catch (PDOException $e) {
                echo "<div class='error-message'>เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $e->getMessage() . "</div>";
            }
        }
        
    } else {
        echo "<div class='error-message'>กรุณากรอกข้อมูลให้ครบถ้วน</div>";
    }
}

?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>อัพเดตสถานะงานซ่อม</title>
</head>
<body>
    <div class="container">
        <h1>อัพเดตสถานะงานซ่อม</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="serial_number">รหัสเครื่อง (Serial Number): </label>
                <input type="text" id="serial_number" name="serial_number" required class="input-field">
            </div>
            
            <div class="form-group">
                <label for="repair_status">สถานะการซ่อม: </label>
                <select name="repair_status" id="repair_status" required class="input-field">
                    <option value="รอซ่อม">รอซ่อม</option>
                    <option value="รออะไหล่">รออะไหล่</option>
                    <option value="กำลังซ่อม">กำลังซ่อม</option>
                    <option value="ซ่อมเสร็จแล้ว">ซ่อมเสร็จแล้ว</option>
                    <option value="ซ่อมไม่คุ้ม">ซ่อมไม่คุ้ม</option>
                </select>
            </div>

            <div class="form-group">
                <label for="note">หมายเหตุ (กรณีซ่อมไม่คุ้ม โปรดระบุเหตุผล):</label>
                <textarea id="note" name="note" class="input-field" rows="4"></textarea>
            </div>

            <button type="submit" class="submit-btn">อัพเดตสถานะ</button>
        </form>
    </div>

    <style>
        /* CSS คงเดิม ไม่เปลี่ยนเพิ่มเติมแค่รองรับ textarea */
        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        textarea.input-field {
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #2D3A41;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #3b4d58;
        }

        .error-message, .success-message {
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</body>
</html>

<?php include "footer_admin.php"; ?>
