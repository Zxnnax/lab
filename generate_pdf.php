<?php
require('fpdf186/fpdf.php');

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่า serial_number
$serial_number = $_GET['serial_number'];
$sql = "SELECT * FROM repair_requests WHERE serial_number = '$serial_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
    $pdf->SetFont('THSarabunNew', '', 16);

    // เพิ่มโลโก้
    $pdf->Image('image/logo1.jpg', 0, -3, 200, 250);

    // หัวฟอร์ม
    $pdf->Cell(350, 30, iconv('UTF-8', 'cp874', ''), 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Line(10, 30, 200, 30);
    
    // Serial และ วันที่
    $pdf->SetXY(15, 35);
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'S/N:'), 0, 0);
    $pdf->Cell(65, 8, iconv('UTF-8', 'cp874', $row['serial_number']), 'B', 0);
    $pdf->Cell(10, 10, iconv('UTF-8', 'cp874', 'วันที่:'), 0, 0);
    $pdf->Cell(60, 8, iconv('UTF-8', 'cp874', $row['receive_date']), 'B', 1);

    // กั้นเส้นแนวตั้งตรงกลาง
    $pdf->Line(115, 45, 115, 86);

    // ข้อมูลผู้ส่งซ่อม (ฝั่งซ้าย)
    $startY = 45;
    $pdf->SetXY(15, $startY);
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'ชื่อ นามสกุล:'), 0, 0);
    $pdf->Cell(65, 8, iconv('UTF-8', 'cp874', $row['full_name']), 'B', 1);

    $pdf->SetXY(15, $startY + 10);
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'ที่อยู่:'), 0, 0);
    $pdf->MultiCell(65, 8, iconv('UTF-8', 'cp874', $row['address']), 'B');

    $currentY = $pdf->GetY();
    $pdf->SetXY(15, $currentY);
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'เบอร์โทร:'), 0, 0);
    $pdf->Cell(65, 8, iconv('UTF-8', 'cp874', $row['phone']), 'B', 1);

    $pdf->SetX(15);
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'อีเมล:'), 0, 0);
    $pdf->Cell(65, 8, iconv('UTF-8', 'cp874', $row['email']), 'B', 1);



    // ประเภทสินค้า (ฝั่งขวา)
$pdf->SetXY(120, $startY);
$pdf->Cell(30, 7, iconv('UTF-8', 'cp874', 'ประเภท:'), 0, 1);

$types = ['Mixer/Processor', 'Power/Active', 'Musical'];
$startTypeY = $startY + 10;
foreach ($types as $type) {
    $pdf->SetXY(120, $startTypeY);
    if ($row['type_' . strtolower(str_replace('/', '_', $type))] == 1) {
        $pdf->Cell(10, 7, '   /', 'B', 0);  // แสดงเครื่องหมาย /
    } else {
        $pdf->Cell(10, 7, '', 'B', 0);  // ว่างเปล่า
    }
    $pdf->Cell(50, 7.5, iconv('UTF-8', 'cp874', $type), 0, 1);
    $startTypeY += 10;
}

// ยี่ห้อ
$pdf->Ln(5);
$pdf->SetX(10);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'ยี่ห้อ:'), 0, 0);

$brands = ['Allen Heath', 'Soundcraft', 'KRK', 'JBL', 'Turbosound', 'Marshall', 'Yamaha', 'Behringer', 'Midas', 'Ashly', 'DBX', 'Digico', 'Crown'];
$colPerRow = 4;
$count = 0;
$pdf->SetX(20);
foreach ($brands as $brand) {
    $pdf->Cell(10, 8, '', 'B', 0);
    $brandKey = 'brand_' . strtolower(str_replace(' ', '_', $brand));  // สร้างชื่อฟิลด์ในฐานข้อมูล

    if ($row[$brandKey] == 1) {
        // แสดงเครื่องหมาย / และทำให้มันอยู่ตรงกลางของช่อง
        $pdf->Cell(1, 8, '/        ', 0, 0, 'C');  // แสดงเครื่องหมาย /
    }
    $pdf->Cell(35, 8, iconv('UTF-8', 'cp874', $brand), 0, 0);  // แสดงชื่อยี่ห้อ

    $count++;
    if ($count % $colPerRow == 0) {
        $pdf->Ln();
        $pdf->SetX(20);
    }
}
$pdf->Ln(10);






    
    // รุ่น Model
    $pdf->SetX(20);
    $pdf->Cell(15, 15, iconv('UTF-8', 'cp874', 'Model:'), 0);
    $pdf->Cell(140, 10, iconv('UTF-8', 'cp874', $row['model_line1']), 'B', 1);
    $pdf->SetX(20);
    $pdf->Cell(15, 15, iconv('UTF-8', 'cp874', ''), 0);
    $pdf->Cell(140, 8, iconv('UTF-8', 'cp874', $row['model_line2']), 'B', 1);

    // อาการเสีย
    $pdf->Ln(5);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell(190, 10, iconv('UTF-8', 'cp874', 'อาการเสีย'), 0, 1, 'C', true);

    for ($i = 1; $i <= 6; $i++) {
        $symptomField = 'symptom_' . $i;
        $pdf->SetX(20);
        $pdf->Cell(20, 13, iconv('UTF-8', 'cp874', "อาการที่ $i:"), 0, 0);
        $pdf->Cell(150, 9, iconv('UTF-8', 'cp874', $row[$symptomField]), 'B', 1);
    }

    // อุปกรณ์ที่มากับเครื่อง
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'อุปกรณ์ที่มากับเครื่อง:'), 0, 0);
    $pdf->SetX(45);
    $pdf->MultiCell(145, 8, iconv('UTF-8', 'cp874', $row['accessories']), 'B');

      // หมายเหตุ 
// หมายเหตุ 
$pdf->Ln(5);
$pdf->SetX(10);
$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', 'หมายเหตุ:'), 0, 0);
$pdf->SetX(30);
$pdf->MultiCell(160, 8, iconv('UTF-8', 'cp874', $row['note']), 'B');  // ดึงข้อมูลจากคอลัมน์ note


$pdf->Ln(18);
$pdf->SetX(40);
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', $row['full_name']), 0, 0, 'C'); // ใช้ 70
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', 'หจก.แล็บ อิเล็กทรอนิกส์'), 0, 0, 'C'); // ใช้ 70 เช่นกัน

// ลายเซ็น
$pdf->Ln(3); // ปรับระยะห่างเล็กน้อย
$pdf->SetX(40);
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', ' _______________________________'), 0, 0, 'C');
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', ' _______________________________'), 0, 1, 'C');

$pdf->Ln(-2);
$pdf->SetX(40);
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', 'ผู้ส่งงานซ่อม'), 0, 0, 'C');
$pdf->Cell(70, 10, iconv('UTF-8', 'cp874', 'ผู้รับงานซ่อม'), 0, 1, 'C');


    $conn->close();
    $pdf->Output();
} else {
    echo "ไม่พบข้อมูลรหัสงานนี้";
}
?>
