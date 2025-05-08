<?php
// เชื่อมต่อกับฐานข้อมูล
require 'db_repairs.php'; // << เชื่อมต่อ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $serial_number = $_POST['serial_number'];
    $receive_date = $_POST['receive_date'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // ประเภทเครื่อง
    $type_mixer_processor = isset($_POST['type_mixer_processor']) ? 1 : 0;
    $type_power_active = isset($_POST['type_power_active']) ? 1 : 0;
    $type_musical = isset($_POST['type_musical']) ? 1 : 0;

    // ยี่ห้อ
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

    // รุ่น
    $model_line1 = $_POST['model_line1'];
    $model_line2 = $_POST['model_line2'];

    // อาการเสีย
    $symptom_1 = $_POST['symptom_1'];
    $symptom_2 = $_POST['symptom_2'];
    $symptom_3 = $_POST['symptom_3'];
    $symptom_4 = $_POST['symptom_4'];
    $symptom_5 = $_POST['symptom_5'];
    $symptom_6 = $_POST['symptom_6'];

    // อุปกรณ์ที่มากับเครื่อง
    $accessories = $_POST['accessories'];

    // หมายเหตุ (Note)
    $note = $_POST['note'];

    // SQL
    $sql = "INSERT INTO repair_requests (
        serial_number, receive_date, full_name, address, phone, email,
        type_mixer_processor, type_power_active, type_musical,
        brand_allen_heath, brand_soundcraft, brand_krk, brand_jbl, brand_turbosound,
        brand_marshall, brand_yamaha, brand_behringer, brand_midas, brand_ashly,
        brand_dbx, brand_digico, brand_crown, model_line1, model_line2,
        symptom_1, symptom_2, symptom_3, symptom_4, symptom_5, symptom_6, accessories,
        note
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = [
        $serial_number, $receive_date, $full_name, $address, $phone, $email,
        $type_mixer_processor, $type_power_active, $type_musical,
        $brand_allen_heath, $brand_soundcraft, $brand_krk, $brand_jbl, $brand_turbosound,
        $brand_marshall, $brand_yamaha, $brand_behringer, $brand_midas, $brand_ashly,
        $brand_dbx, $brand_digico, $brand_crown, $model_line1, $model_line2,
        $symptom_1, $symptom_2, $symptom_3, $symptom_4, $symptom_5, $symptom_6, $accessories,
        $note
    ];

    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            $success_message = "บันทึกข้อมูลเรียบร้อยแล้ว!";
            header('Location: admin_tablerepairs.php');
            exit;
        } else {
            $error_message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล!";
        }
    } catch (PDOException $e) {
        $error_message = "ข้อผิดพลาด: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="../css/style.css" />
<style>
input[type="text"],
input[type="email"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background: #fff;
    font-size: 16px;
}
button[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #2D3A41;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    cursor: pointer;
}
button[type="submit"]:hover {
    background-color: #1c2529;
}
</style>

<?php include('header_admin.php'); ?>

<div class="container" style="max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

    <h2 style="text-align: center; margin-bottom: 30px;">เพิ่มข้อมูลงานซ่อม</h2>

    <?php if (!empty($success_message)): ?>
        <div style="color: green; text-align: center; margin-bottom: 20px;"><?= htmlspecialchars($success_message) ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div style="color: red; text-align: center; margin-bottom: 20px;"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="POST" action="admin_repairs.php">

        <label>S/N:</label>
        <input type="text" name="serial_number" required><br>

        <label>วันที่รับ:</label>
        <input type="date" name="receive_date" required><br>

        <label>ชื่อ-นามสกุล:</label>
        <input type="text" name="full_name" required><br>

        <label>ที่อยู่:</label>
        <textarea name="address" required></textarea><br>

        <label>เบอร์โทร:</label>
        <input type="text" name="phone" required><br>

        <label>อีเมล:</label>
        <input type="email" name="email" required><br>

        <h4>ประเภท:</h4>
        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <label><input type="checkbox" name="type_mixer_processor"> Mixer/Processor</label>
            <label><input type="checkbox" name="type_power_active"> Power/Active</label>
            <label><input type="checkbox" name="type_musical"> Musical</label>
        </div>

        <h4>ยี่ห้อ:</h4>
        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <label><input type="checkbox" name="brand_allen_heath"> Allen Heath</label>
            <label><input type="checkbox" name="brand_soundcraft"> Soundcraft</label>
            <label><input type="checkbox" name="brand_krk"> KRK</label>
            <label><input type="checkbox" name="brand_jbl"> JBL</label>
            <label><input type="checkbox" name="brand_turbosound"> Turbosound</label>
            <label><input type="checkbox" name="brand_marshall"> Marshall</label>
            <label><input type="checkbox" name="brand_yamaha"> Yamaha</label>
            <label><input type="checkbox" name="brand_behringer"> Behringer</label>
            <label><input type="checkbox" name="brand_midas"> Midas</label>
            <label><input type="checkbox" name="brand_ashly"> Ashly</label>
            <label><input type="checkbox" name="brand_dbx"> DBX</label>
            <label><input type="checkbox" name="brand_digico"> Digico</label>
            <label><input type="checkbox" name="brand_crown"> Crown</label>
        </div>

        <label>รุ่น:</label>
        <input type="text" name="model_line1"><br>

        <label>รุ่นเสริม:</label>
        <input type="text" name="model_line2"><br>

        <h4>อาการเสีย:</h4>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <input type="text" name="symptom_<?= $i ?>" placeholder="อาการเสีย <?= $i ?>"><br>
        <?php endfor; ?>

        <label>อุปกรณ์ที่มากับเครื่อง:</label>
        <textarea name="accessories"></textarea><br>

        <label>หมายเหตุ (ถ้ามี):</label>
        <textarea name="note"></textarea><br>

        <button type="submit">บันทึกข้อมูล</button>
    </form>
</div>

<?php include('footer_admin.php'); ?>
