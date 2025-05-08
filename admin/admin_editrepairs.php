<?php
// เชื่อมต่อกับฐานข้อมูล
require 'db_repairs.php';  // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้ส่ง ID ของข้อมูลที่ต้องการแก้ไขมาใน URL หรือไม่
if (isset($_GET['id'])) {
    $repair_id = $_GET['id'];

    try {
        // ดึงข้อมูลจากฐานข้อมูลที่มี ID ตรงกับที่ส่งมา
        $sql = "SELECT * FROM repair_requests WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $repair_id]);
        $repair = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่าไม่พบข้อมูล
        if (!$repair) {
            echo "ไม่พบข้อมูลนี้ในฐานข้อมูล";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "ID ไม่ถูกต้อง";
    exit();
}

// ตรวจสอบว่าได้ส่งข้อมูลการแก้ไขมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $serial_number = $_POST['serial_number'];
    $receive_date = $_POST['receive_date'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $type_mixer_processor = isset($_POST['type_mixer_processor']) ? 1 : 0;
    $type_power_active = isset($_POST['type_power_active']) ? 1 : 0;
    $type_musical = isset($_POST['type_musical']) ? 1 : 0;
    $brand_allen_heath = isset($_POST['brand_allen_heath']) ? 1 : 0;
    $brand_soundcraft = isset($_POST['brand_soundcraft']) ? 1 : 0;
    $brand_krk = isset($_POST['brand_krk']) ? 1 : 0;
    $brand_jbl = isset($_POST['brand_jbl']) ? 1 : 0;
    $brand_turbosound = isset($_POST['brand_turbosound']) ? 1 : 0;
    $brand_marshall = isset($_POST['brand_marshall']) ? 1 : 0;
    $brand_yamaha = isset($_POST['brand_yamaha']) ? 1 : 0;
    $brand_behringer = isset($_POST['brand_behringer']) ? 1 : 0;
    $brand_midas = isset($_POST['brand_midas']) ? 1 : 0;
    $brand_ashly = isset($_POST['brand_ashly']) ? 1 : 0;
    $brand_dbx = isset($_POST['brand_dbx']) ? 1 : 0;
    $brand_digico = isset($_POST['brand_digico']) ? 1 : 0;
    $brand_crown = isset($_POST['brand_crown']) ? 1 : 0;

    try {
        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE repair_requests 
                SET serial_number = :serial_number, receive_date = :receive_date, full_name = :full_name, phone = :phone,
                    type_mixer_processor = :type_mixer_processor, type_power_active = :type_power_active, type_musical = :type_musical,
                    brand_allen_heath = :brand_allen_heath, brand_soundcraft = :brand_soundcraft, brand_krk = :brand_krk,
                    brand_jbl = :brand_jbl, brand_turbosound = :brand_turbosound, brand_marshall = :brand_marshall, 
                    brand_yamaha = :brand_yamaha, brand_behringer = :brand_behringer, brand_midas = :brand_midas, 
                    brand_ashly = :brand_ashly, brand_dbx = :brand_dbx, brand_digico = :brand_digico, brand_crown = :brand_crown
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'serial_number' => $serial_number,
            'receive_date' => $receive_date,
            'full_name' => $full_name,
            'phone' => $phone,
            'type_mixer_processor' => $type_mixer_processor,
            'type_power_active' => $type_power_active,
            'type_musical' => $type_musical,
            'brand_allen_heath' => $brand_allen_heath,
            'brand_soundcraft' => $brand_soundcraft,
            'brand_krk' => $brand_krk,
            'brand_jbl' => $brand_jbl,
            'brand_turbosound' => $brand_turbosound,
            'brand_marshall' => $brand_marshall,
            'brand_yamaha' => $brand_yamaha,
            'brand_behringer' => $brand_behringer,
            'brand_midas' => $brand_midas,
            'brand_ashly' => $brand_ashly,
            'brand_dbx' => $brand_dbx,
            'brand_digico' => $brand_digico,
            'brand_crown' => $brand_crown,
            'id' => $repair_id
        ]);

        // รีไดเร็กต์ไปที่หน้าหลักหลังจากการอัปเดต
        header("Location: admin_tablerepairs.php");
        exit();
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการซ่อม</title>
</head>
<body>
    <h2>แก้ไขข้อมูลการซ่อม</h2>

    <form method="POST" action="">
        <label for="serial_number">S/N: </label>
        <input type="text" name="serial_number" id="serial_number" value="<?= htmlspecialchars($repair['serial_number']) ?>" required><br><br>

        <label for="receive_date">วันที่รับ: </label>
        <input type="date" name="receive_date" id="receive_date" value="<?= htmlspecialchars($repair['receive_date']) ?>" required><br><br>

        <label for="full_name">ชื่อ-สกุล: </label>
        <input type="text" name="full_name" id="full_name" value="<?= htmlspecialchars($repair['full_name']) ?>" required><br><br>

        <label for="phone">เบอร์โทร: </label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($repair['phone']) ?>" required><br><br>

        <!-- ประเภท -->
        <label>ประเภท:</label><br>
        <input type="checkbox" name="type_mixer_processor" <?= $repair['type_mixer_processor'] ? 'checked' : '' ?>> Mixer/Processor<br>
        <input type="checkbox" name="type_power_active" <?= $repair['type_power_active'] ? 'checked' : '' ?>> Power/Active<br>
        <input type="checkbox" name="type_musical" <?= $repair['type_musical'] ? 'checked' : '' ?>> Musical<br>

        <!-- ยี่ห้อ -->
        <label>ยี่ห้อ:</label><br>
        <input type="checkbox" name="brand_allen_heath" <?= $repair['brand_allen_heath'] ? 'checked' : '' ?>> Allen & Heath<br>
        <input type="checkbox" name="brand_soundcraft" <?= $repair['brand_soundcraft'] ? 'checked' : '' ?>> Soundcraft<br>
        <input type="checkbox" name="brand_krk" <?= $repair['brand_krk'] ? 'checked' : '' ?>> KRK<br>
        <input type="checkbox" name="brand_jbl" <?= $repair['brand_jbl'] ? 'checked' : '' ?>> JBL<br>
        <input type="checkbox" name="brand_turbosound" <?= $repair['brand_turbosound'] ? 'checked' : '' ?>> Turbosound<br>
        <input type="checkbox" name="brand_marshall" <?= $repair['brand_marshall'] ? 'checked' : '' ?>> Marshall<br>
        <input type="checkbox" name="brand_yamaha" <?= $repair['brand_yamaha'] ? 'checked' : '' ?>> Yamaha<br>
        <input type="checkbox" name="brand_behringer" <?= $repair['brand_behringer'] ? 'checked' : '' ?>> Behringer<br>
        <input type="checkbox" name="brand_midas" <?= $repair['brand_midas'] ? 'checked' : '' ?>> Midas<br>
        <input type="checkbox" name="brand_ashly" <?= $repair['brand_ashly'] ? 'checked' : '' ?>> Ashly<br>
        <input type="checkbox" name="brand_dbx" <?= $repair['brand_dbx'] ? 'checked' : '' ?>> DBX<br>
        <input type="checkbox" name="brand_digico" <?= $repair['brand_digico'] ? 'checked' : '' ?>> Digico<br>
        <input type="checkbox" name="brand_crown" <?= $repair['brand_crown'] ? 'checked' : '' ?>> Crown<br>

        <br><br>
        <button type="submit">บันทึกการแก้ไข</button>
    </form>

    <a href="admin_tablerepairs.php">กลับไปหน้าหลัก</a>
</body>
</html>
