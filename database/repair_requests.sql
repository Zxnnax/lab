-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 12:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `repair_requests`
--

CREATE TABLE `repair_requests` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `receive_date` date NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_mixer_processor` tinyint(1) DEFAULT NULL,
  `type_power_active` tinyint(1) DEFAULT NULL,
  `type_musical` tinyint(1) DEFAULT NULL,
  `brand_allen_heath` tinyint(1) DEFAULT NULL,
  `brand_soundcraft` tinyint(1) DEFAULT NULL,
  `brand_krk` tinyint(1) DEFAULT NULL,
  `brand_jbl` tinyint(1) DEFAULT NULL,
  `brand_turbosound` tinyint(1) DEFAULT NULL,
  `brand_marshall` tinyint(1) DEFAULT NULL,
  `brand_yamaha` tinyint(1) DEFAULT NULL,
  `brand_behringer` tinyint(1) DEFAULT NULL,
  `brand_midas` tinyint(1) DEFAULT NULL,
  `brand_ashly` tinyint(1) DEFAULT NULL,
  `brand_dbx` tinyint(1) DEFAULT NULL,
  `brand_digico` tinyint(1) DEFAULT NULL,
  `brand_crown` tinyint(1) DEFAULT NULL,
  `model_line1` varchar(255) DEFAULT NULL,
  `model_line2` varchar(255) DEFAULT NULL,
  `symptom_1` varchar(255) DEFAULT NULL,
  `symptom_2` varchar(255) DEFAULT NULL,
  `symptom_3` varchar(255) DEFAULT NULL,
  `symptom_4` varchar(255) DEFAULT NULL,
  `symptom_5` varchar(255) DEFAULT NULL,
  `symptom_6` varchar(255) DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `repair_status` varchar(255) NOT NULL DEFAULT 'รับงาน',
  `note` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `repair_requests`
--

INSERT INTO `repair_requests` (`id`, `serial_number`, `receive_date`, `full_name`, `address`, `phone`, `email`, `type_mixer_processor`, `type_power_active`, `type_musical`, `brand_allen_heath`, `brand_soundcraft`, `brand_krk`, `brand_jbl`, `brand_turbosound`, `brand_marshall`, `brand_yamaha`, `brand_behringer`, `brand_midas`, `brand_ashly`, `brand_dbx`, `brand_digico`, `brand_crown`, `model_line1`, `model_line2`, `symptom_1`, `symptom_2`, `symptom_3`, `symptom_4`, `symptom_5`, `symptom_6`, `accessories`, `repair_status`, `note`, `updated_at`) VALUES
(1, '12345678', '2025-04-25', 'admin na', '123456', '0123456789', 'adminna@gmail.com', 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'xxxx', '', 'อ๊อง', '', '', '', '', '', 'กล่อง', 'ซ่อมเสร็จแล้ว', '', '2025-05-05 06:26:42'),
(2, '12345', '2025-04-25', 'aomsin king', '69/4', '0123456789', 'adminking@gmail.com', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'xxxxxxx', '', 'เด๋อด๋า', '', '', '', '', '', 'กล่อง', 'กำลังซ่อม', NULL, NULL),
(4, '654281014', '2025-04-26', 'เกวลิน สุโชติรัตนกุล', '88/191 สิวารัตน์10 บางแขม ', '0967246265', 'zinnboogeyman@gmail.com', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'XXXXX', '', 'เสียงบี้', 'สัญญาณ', 'บางช่องไม่ดัง', 'เสียงเบา', 'โอห์มขาด', '', 'กล่อง สาย บลาๆๆๆๆๆๆๆๆๆๆ', 'รอซ่อม', '', NULL),
(5, '555', '2025-04-28', 'SOMPONG APIROM', 'AAAAAAAAAAAAAAAA', '0888888888', 'userSOMPONGG@gmail.com', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'SDGSGAG', '', 'เสียงแตก ', 'เชื่อมไม่ได้', 'ASD', 'ZXC', 'QWE', 'ERT', 'ASDFGGHJJLL', 'รับงาน', NULL, NULL),
(7, '254625', '2003-11-18', 'king Boogeyman', '69/4 ถ.ต้นสน ซ.4 อ.เมือง จ.นครปฐม', '0944599746', 'jakkapatlove123@gmail.com', 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'rx-0', '', 'เปิดไม่ติด ', 'ไฟไหม้', 'สปริงเด้ง', 'ปุ่มหลุด', 'น๊อตหาย', 'จอดำ', 'กล่อง ใส่ข้าว', 'ซ่อมไม่คุ้ม', 'ไปซื้อใหม่เถอะถ้าจะขนาดนั้นนะ', NULL),
(9, '200347', '2025-04-28', 'Zinn Boogeyman', '88/191 สิวารัตน์10 ซ.3 ต.บางแขม', '0967246265', 'zinnboogeyman@gmail.com', 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'M10', '', 'เสียงแตก', 'เชื่อมไม่ได้', 'ช็อต', '', '', '', 'กล่อง', 'กำลังซ่อม', '', '2025-05-05 06:38:58'),
(11, '200700', '2025-04-17', 'aum kub', '6831 ', '09458438311', 'asdawdzxawsad@gmail.com', 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 'rox', '', 'เสียงไม่ออก', '', '', '', '', '', 'กล่อง', 'รอซ่อม', '', NULL),
(12, '123457', '2025-04-18', 'นายสมจิต สายรุ่ง', '65', '0888635865', 'sadadgwaef@gmail.com', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 'raas', '', 'เปิดไม่ติด', '', '', '', '', '', '', 'รับงาน', '', NULL),
(13, '13222', '2025-02-09', 'sawew nefjwtj', '13 หมู่ 7 ต.ร่พ่้ร่ จ.าเหกสาวเดไ ', '02156876637', 'fgklsgkoadhlp\'@gmail.com', 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'sAHJ', '', 'เสียงไม่ดัง', '', '', '', '', '', 'ฟำัพรีนนส', 'รับงาน', '', NULL);

--
-- Triggers `repair_requests`
--
DELIMITER $$
CREATE TRIGGER `update_repair_status_time` BEFORE UPDATE ON `repair_requests` FOR EACH ROW BEGIN
    IF OLD.repair_status <> NEW.repair_status THEN
        SET NEW.updated_at = CURRENT_TIMESTAMP;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `repair_requests`
--
ALTER TABLE `repair_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
