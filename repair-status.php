<?php
// เชื่อมต่อฐานข้อมูล
require 'admin/db_repairs.php';

// ฟังก์ชันดึงชื่อแบรนด์
function getBrandName($brandColumn, $row) {
    $brands = [
        'brand_allen_heath' => 'Allen Heath',
        'brand_soundcraft' => 'Soundcraft',
        'brand_krk' => 'KRK',
        'brand_jbl' => 'JBL',
        'brand_turbosound' => 'Turbosound',
        'brand_marshall' => 'Marshall',
        'brand_yamaha' => 'Yamaha',
        'brand_behringer' => 'Behringer',
        'brand_midas' => 'Midas',
        'brand_ashly' => 'Ashly',
        'brand_dbx' => 'DBX',
        'brand_digico' => 'Digico',
        'brand_crown' => 'Crown',
    ];
    if ($row[$brandColumn] == 1) {
        return $brands[$brandColumn] ?? null;
    }
    return null;
}

// ตรวจสอบการส่งฟอร์ม
$repair = null;
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $repair_code = $_POST['repair_code'];

    $sql = "SELECT * FROM repair_requests WHERE serial_number = :repair_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':repair_code', $repair_code);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $repair = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = "ไม่พบงานซ่อมที่มีรหัสนี้";
        }
    } else {
        $message = "เกิดข้อผิดพลาดในการค้นหาข้อมูล";
    }
}

// สถานะทั้งหมดเรียงตามลำดับ
$statuses = ['รับงาน', 'รอซ่อม', 'รออะไหล่', 'กำลังซ่อม', 'ซ่อมเสร็จแล้ว', 'ซ่อมไม่คุ้ม'];
$current_status = $repair['repair_status'] ?? '';
?>

<?php include('header.php'); ?>

<style>
.container {
    background: #fff; 
    padding: 30px; 
    border-radius: 15px; 
    box-shadow: 0 0 10px rgba(0,0,0,0.1); 
    width: 90%;
    max-width: 1000px;
    margin: 50px auto;
    text-align: center;
}

.repair-timeline {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f0f0f0;
    padding: 30px 20px;
    border-radius: 20px;
    margin-top: 30px;
    position: relative;
    width: 100%;
    overflow: hidden;
}
.repair-timeline::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 5%;
    right: 5%;
    height: 4px;
    background: #ccc;
    z-index: 0;
}
.repair-step {
    position: relative;
    background: #ddd;
    padding: 20px 10px;
    border-radius: 50%;
    font-weight: bold;
    color: #555;
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin: 0 10px;
    z-index: 1;
}
.repair-step.completed {
    background: #4CAF50; /* สีเขียว */
    color: white;
}
.repair-step.current {
    background: #2196F3; /* สีฟ้า */
    color: white;
}
.repair-step.disabled {
    background: #ccc; /* สีเทา */
    color: #777;
}
.repair-step.error {
    background: #f44336; /* สีแดงสำหรับ "ซ่อมไม่คุ้ม" */
    color: white;
}
.repair-step-number {
    font-size: 18px;
    font-weight: bold;
}
.repair-step-label {
    font-size: 12px;
    margin-top: 5px;
}

.status-time {
    font-size: 14px;
    color: #333;
    margin-top: 5px;
    margin-bottom: 10px;
    text-align: center;
}
</style>

<div class="container">
    <h2 style="margin-bottom: 20px; font-weight: bold;">ค้นหาสถานะงานซ่อม</h2>

    <form method="POST" action="repair-status.php" style="margin-bottom: 20px;">
        <label for="repair_code">กรอกรหัสงานซ่อม:</label><br>
        <input type="text" name="repair_code" required style="width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <button type="submit" style="width: 100%; padding: 12px; background-color: #2D3A41; color: #fff; font-weight: bold; border: none; border-radius: 8px; cursor: pointer;">ค้นหาสถานะ</button>
    </form>

    <?php if ($repair): ?>
        <div class="result" style="text-align: left; font-size: 16px;">
            <strong>รหัสงานซ่อม:</strong> <?= htmlspecialchars($repair['serial_number']) ?><br>
            <strong>ชื่อผู้ส่งซ่อม:</strong> <?= htmlspecialchars($repair['full_name']) ?><br>
            <strong>แบรนด์:</strong>
            <?php
            $brandNames = [];
            $columns = [
                'brand_allen_heath', 'brand_soundcraft', 'brand_krk', 'brand_jbl',
                'brand_turbosound', 'brand_marshall', 'brand_yamaha', 'brand_behringer',
                'brand_midas', 'brand_ashly', 'brand_dbx', 'brand_digico', 'brand_crown'
            ];
            foreach ($columns as $column) {
                $brandName = getBrandName($column, $repair);
                if ($brandName) {
                    $brandNames[] = $brandName;
                }
            }
            echo !empty($brandNames) ? implode(", ", $brandNames) : "ไม่มีแบรนด์ที่เลือก";
            ?><br>
            <strong>อุปกรณ์ที่มากับเครื่อง:</strong> <?= htmlspecialchars($repair['accessories']) ?><br>
            <strong>สถานะการซ่อม:</strong> <?= htmlspecialchars($repair['repair_status']) ?><br>
            <strong>วันที่รับงาน:</strong> <?= htmlspecialchars($repair['receive_date']) ?><br>
            <strong>หมายเหตุ:</strong> <?= htmlspecialchars($repair['note']) ?><br>
        </div>

        <!-- Timeline -->
        <div class="repair-timeline">
            <?php foreach ($statuses as $index => $status): ?>
                <?php
                $stepClass = '';
                $statusUpdatedTime = $repair['updated_at'] ?? ''; // ดึงเวลาที่อัพเดตจากฐานข้อมูล

                // กรณี "ซ่อมไม่คุ้ม" เป็นสถานะปัจจุบัน
                if ($status == 'ซ่อมไม่คุ้ม' && $status == $current_status) {
                    $stepClass = 'error'; // สีแดงสำหรับ "ซ่อมไม่คุ้ม"
                } 
                // กรณีสถานะที่เสร็จสมบูรณ์ (ก่อนหน้านี้)
                elseif (array_search($status, $statuses) < array_search($current_status, $statuses) && $current_status != 'ซ่อมไม่คุ้ม') {
                    $stepClass = 'completed'; // สีเขียวสำหรับสถานะก่อนหน้านี้
                }
                // กรณีสถานะที่ยังไม่ได้ดำเนินการ
                elseif ($status == $current_status) {
                    $stepClass = 'current'; // สีฟ้าสำหรับสถานะที่กำลังดำเนินการ
                } 
                // กรณีสถานะที่ยังไม่ได้ดำเนินการและไม่ใช่ "ซ่อมไม่คุ้ม"
                elseif ($status !== 'ซ่อมไม่คุ้ม' && array_search($status, $statuses) > array_search($current_status, $statuses)) {
                    $stepClass = 'disabled'; // สีเทาสำหรับสถานะที่ยังไม่ได้ดำเนินการ
                }
                ?>
                <div class="repair-step <?= $stepClass ?>">
                    <div class="repair-step-number"><?= $index + 1 ?></div>
                    <div class="repair-step-label"><?= htmlspecialchars($status) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- เวลาแสดงแยกจากวงกลม -->
        <div class="status-time">
            <?php if ($statusUpdatedTime): ?>
                <div>เวลาอัพเดตล่าสุด: <?= date("d/m/Y H:i", strtotime($statusUpdatedTime)) ?></div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="generate_pdf.php?serial_number=<?= urlencode($repair['serial_number']) ?>" target="_blank"
               style="display: inline-block; padding: 10px 30px; background-color:rgb(35, 136, 80); color: #fff; border-radius: 8px; text-decoration: none; font-weight: bold;">
               ดูใบรับซ่อม
            </a>
        </div>

    <?php elseif ($message): ?>
        <div class="error" style="color: red; margin-top: 10px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
