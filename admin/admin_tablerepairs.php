<link rel="stylesheet" href="../css/style.css" /> 
<?php include "header_admin.php"; ?>

<?php
// เชื่อมต่อกับฐานข้อมูล
require 'db_repairs.php';  // เชื่อมต่อฐานข้อมูล

// ลบข้อมูล
if (isset($_POST['delete_id']) && isset($_POST['confirmation_code'])) {
    $delete_id = $_POST['delete_id'];
    $confirmation_code = $_POST['confirmation_code'];

    // รหัสยืนยันการลบ
    $correct_code = '1987*';

    // ตรวจสอบรหัสที่กรอก
    if ($confirmation_code === $correct_code) {
        try {
            $sql = "DELETE FROM repair_requests WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $delete_id]);

            // Redirect หลังจากลบสำเร็จ
            header("Location: admin_tablerepairs.php");
            exit();
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
        }
    } else {
        echo "รหัสยืนยันไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง.";
    }
}

// เริ่มต้นการค้นหา
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

try {
    // ดึงข้อมูลทั้งหมดจากตาราง repair_requests ตามคำค้นหาที่กรอกในฟอร์ม
    $sql = "SELECT * FROM repair_requests WHERE serial_number LIKE :searchTerm OR full_name LIKE :searchTerm OR phone LIKE :searchTerm";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    $repair_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการข้อมูลซ่อม</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Style for the confirmation form */
        #confirmationForm {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }


        thead th {
    box-shadow: inset 0 -1px 0 #ccc;
}



    </style>
</head>
<body>
    <h2>รายการข้อมูลซ่อม</h2>

    <!-- ฟอร์มค้นหาข้อมูล -->
<div style="text-align: center; margin-top: 10px;">
    <form method="get" action="">
        <label for="search">ค้นหา (S/N, ชื่อ, เบอร์โทร): </label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">ค้นหา</button>
    </form>
</div>



    <div class="table-container">
    <!-- ตารางแสดงข้อมูล -->
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>วันที่รับ</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เบอร์โทร</th>
                <th>ประเภท</th>
                <th>ยี่ห้อ</th>
                <th>รุ่น</th>
                <th>อาการเสีย 1</th>
                <th>อาการเสีย 2</th>
                <th>อาการเสีย 3</th>
                <th>อาการเสีย 4</th>
                <th>อาการเสีย 5</th>
                <th>อาการเสีย 6</th>
                <th>ใบรับซ่อม</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repair_requests as $repair): ?>
            <tr>
                <td><?= htmlspecialchars($repair['serial_number']) ?></td>
                <td><?= htmlspecialchars($repair['receive_date']) ?></td>
                <td><?= htmlspecialchars($repair['full_name']) ?></td>
                <td><?= htmlspecialchars($repair['phone']) ?></td>
                <td>
                    <?php
                        $types = [];
                        if ($repair['type_mixer_processor']) $types[] = 'Mixer/Processor';
                        if ($repair['type_power_active']) $types[] = 'Power/Active';
                        if ($repair['type_musical']) $types[] = 'Musical';
                        echo implode(", ", $types);
                    ?>
                </td>
                <td>
                    <?php
                        $brands = [];
                        if ($repair['brand_allen_heath']) $brands[] = 'Allen & Heath';
                        if ($repair['brand_soundcraft']) $brands[] = 'Soundcraft';
                        if ($repair['brand_krk']) $brands[] = 'KRK';
                        if ($repair['brand_jbl']) $brands[] = 'JBL';
                        if ($repair['brand_turbosound']) $brands[] = 'Turbosound';
                        if ($repair['brand_marshall']) $brands[] = 'Marshall';
                        if ($repair['brand_yamaha']) $brands[] = 'Yamaha';
                        if ($repair['brand_behringer']) $brands[] = 'Behringer';
                        if ($repair['brand_midas']) $brands[] = 'Midas';
                        if ($repair['brand_ashly']) $brands[] = 'Ashly';
                        if ($repair['brand_dbx']) $brands[] = 'DBX';
                        if ($repair['brand_digico']) $brands[] = 'Digico';
                        if ($repair['brand_crown']) $brands[] = 'Crown';
                        echo implode(", ", $brands);
                    ?>
                </td>
                <td>
                    <?= htmlspecialchars($repair['model_line1']) . ' ' . htmlspecialchars($repair['model_line2']) ?>
                </td>
                <td><?= htmlspecialchars($repair['symptom_1']) ?></td>
                <td><?= htmlspecialchars($repair['symptom_2']) ?></td>
                <td><?= htmlspecialchars($repair['symptom_3']) ?></td>
                <td><?= htmlspecialchars($repair['symptom_4']) ?></td>
                <td><?= htmlspecialchars($repair['symptom_5']) ?></td>
                <td><?= htmlspecialchars($repair['symptom_6']) ?></td>
                <td>
                    <a href="../generate_pdf.php?serial_number=<?= urlencode($repair['serial_number']) ?>" target="_blank"
                        style="display: inline-block; padding: 5px 15px; background-color: rgb(35, 136, 80); color: #fff; border-radius: 5px; text-decoration: none;">
                        ดูใบรับซ่อม
                    </a>
                </td>
                <td>
                    <a href="admin_editrepairs.php?id=<?= $repair['id'] ?>" 
                        style="display: inline-block; padding: 5px 15px; background-color:rgb(233, 180, 33); color: #fff; border-radius: 5px; text-decoration: none; margin-right: 5px;">
                        แก้ไข
                    </a>
                    <a href="javascript:void(0)" 
                        onclick="showConfirmationForm(<?= $repair['id'] ?>, '<?= htmlspecialchars($repair['serial_number']) ?>')" 
                        style="display: inline-block; padding: 5px 15px; background-color: #e74c3c; color: #fff; border-radius: 5px; text-decoration: none;">
                        ลบ
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    </div>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    margin-top: 30px;
}

.table-container {
    max-width: 95%;
    margin: 0 auto;
    padding-left: 10px;
    padding-right: 10px;
    overflow-x: auto;
}

</style>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }

    /* ✅ เพิ่มตรงนี้เข้าไป */
    thead th {
        background-color:rgb(82, 82, 82);
        color: white;
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    /* Style for the confirmation form */
    #confirmationForm {
        display: none;
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
    }
</style>



    <!-- ฟอร์มยืนยันการลบ -->
    <div id="confirmationForm">
        <h3>กรุณากรอกรหัสยืนยันการลบสำหรับ S/N <span id="serial_number_to_delete"></span></h3>
        <form method="post" action="">
            <input type="hidden" name="delete_id" id="delete_id">
            <label for="confirmation_code">กรอกรหัสยืนยัน: </label>
            <!-- ใช้ type="password" เพื่อไม่ให้รหัสการลบมองเห็น -->
            <input type="password" name="confirmation_code" id="confirmation_code" required>
            <button type="submit">ยืนยันการลบ</button>
        </form>
    </div>

    <script>
        // ฟังก์ชันแสดงฟอร์มยืนยันการลบ พร้อมแสดง S/N ที่จะลบ
        function showConfirmationForm(id, serial_number) {
            // กำหนด ID ที่จะลบในฟอร์ม
            document.getElementById('delete_id').value = id;
            // แสดง S/N ที่จะลบ
            document.getElementById('serial_number_to_delete').innerText = serial_number;
            // แสดงฟอร์มยืนยัน
            document.getElementById('confirmationForm').style.display = 'block';
        }
    </script>
</body>
</html>
