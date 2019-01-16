-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2019 at 07:38 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kawasaki`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_gallery`
--

CREATE TABLE `about_gallery` (
  `aid` int(11) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Display, 0 = Hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `about_gallery`
--

INSERT INTO `about_gallery` (`aid`, `image`, `img_order`, `status`) VALUES
(1, '1.jpg', 0, 1),
(2, '2.jpg', 0, 1),
(3, '3.jpg', 0, 1),
(4, '4.jpg', 0, 1),
(5, '5.jpg', 0, 1),
(6, '6.jpg', 0, 1),
(7, '7.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

CREATE TABLE `accessory` (
  `acs_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_des` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `long_des` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = hidden',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Accessory, 2 = Part, 3 = Merchandise',
  `wish_list` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Normal, 1= Wishlist'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`acs_id`, `model_id`, `title`, `price`, `thumbnail`, `short_des`, `long_des`, `is_new`, `status`, `type`, `wish_list`) VALUES
(1, 9, 'Z300', '60.00', '4.jpg', 'SHROUD,RH,M.S.GREEN', NULL, 0, 1, 2, 0),
(2, 10, 'Z250', '60.00', '3.jpg', 'SHROUD,RH,M.F.S.GRAY', '<p><br />\r\n&nbsp;</p>', 0, 1, 2, 0),
(5, 9, 'Z300', '60.00', '5.jpg', 'SHROUD,RH,M.S.YELLO', NULL, 0, 1, 2, 0),
(6, 3, 'NINJA 300', '118.20', '6.jpg', 'COWLING,CNT,RH,P.S.YELLO', NULL, 0, 1, 2, 0),
(7, 3, 'NINJA 300', '118.20', '7..jpg', 'COWLING,CNT,RH,P.S.GREEN', NULL, 0, 1, 2, 0),
(8, 3, 'NINJA 300', '118.20', '8.jpg', 'COWLING,CNT,RH,P.S.RED', NULL, 0, 1, 2, 0),
(3, 10, 'Z250', '60.00', '2.jpg', 'SHROUD,RH,M.F.S.GREEN', NULL, 0, 1, 2, 0),
(4, 10, 'Z250', '60.00', '1(1).jpg', 'SHROUD,RH,M.F.S.ORANG', NULL, 0, 1, 2, 0),
(9, 4, 'NINJA250& 300', '30.40', '9.jpg', 'FENDER-FRONT,P.RED', NULL, 0, 1, 2, 0),
(10, 9, 'Z250 & 300', '30.40', '10.jpg', 'FENDER-FRONT,P.YELLO', NULL, 0, 1, 2, 0),
(11, 10, 'Z250 & 300', '125', '11.jpg', 'LENS-COMP', NULL, 0, 1, 2, 0),
(12, 3, 'NINJA250& 300', '125.00', '12.jpg', 'LENS-COMP', NULL, 0, 1, 2, 0),
(13, 10, 'Z250', '170.00', '13.jpg', 'LENS-COMP', NULL, 0, 1, 2, 0),
(14, 10, 'Z250', '17.00', '14.jpg', 'LAMP-ASSY-SIGNAL', NULL, 0, 1, 2, 0),
(15, 11, 'Z125', '15.00', '15.jpg', 'LAMP-ASSY-SIGNAL', NULL, 0, 1, 2, 0),
(16, 3, 'NINJA 300', '50.00', '16.jpg', 'STAY-COMP,COWLING,F.S.BLACK', NULL, 0, 1, 2, 0),
(17, 11, 'Z125', '15.00', '17.jpg', 'BRACKET,HEAD LAMP', NULL, 0, 1, 2, 0),
(18, 10, 'Z250', '15.00', '18.jpg', 'BRACKET,HEAD LAMP', NULL, 0, 1, 2, 0),
(19, 10, 'Z250', '65.80', '19.jpg', 'DISC,FR,BLACK', NULL, 0, 1, 2, 0),
(20, 10, 'NINJA250& 300', '37.00', '20.jpg', 'COWLING,UPP,L.GREEN', NULL, 0, 1, 2, 0),
(21, 3, 'NINJA250& 300', '35.00', '21.jpg', 'COWLING,UPP,M.M.GRAY', NULL, 0, 1, 2, 0),
(22, 4, 'NINJA250&300', '20.10', '22.jpg', 'COWLING,SIDE', NULL, 0, 1, 2, 0),
(23, 11, 'Z125', '25.00', '23.jpg', 'SHROUD,LH,C.B.ORANGE', NULL, 0, 1, 2, 0),
(24, 11, 'Z125', '25.00', '24.jpg', 'SHROUD,LH,C.B.GRAY', NULL, 0, 1, 2, 0),
(25, 11, 'Z125', '25.00', '25.jpg', 'SHROUD,LH,C.B.GREEN', NULL, 0, 1, 2, 0),
(26, 11, 'Z125', '10.00', '26.jpg', 'COVER-TAIL,LH,C.B.GREEN', NULL, 0, 1, 2, 0),
(27, 11, 'Z125', '10.00', '27.jpg', 'COVER-TAIL,LH,C.B.ORANGE', NULL, 0, 1, 2, 0),
(28, 11, 'Z125', '10.00', '28.jpg', 'COVER-TAIL,LH,C.B.GRAY', NULL, 0, 1, 2, 0),
(29, 10, 'Z250', '25.00', '29.jpg', 'FLAP', NULL, 0, 1, 2, 0),
(30, 10, 'Z250', '55.00', '30.jpg', 'TIRE,FR,110X70-17 54S,RX-01F', NULL, 0, 1, 2, 0),
(31, 8, 'Z650', '190.00', '31.jpg', 'TIRE,RR,160/60ZR17(69W),R', NULL, 0, 1, 2, 0),
(32, 9, 'Z250 & 300', '30.00', '32.jpg', 'COVER-COMP,MUFFLER', NULL, 0, 1, 2, 0),
(33, 10, 'Z250 & 300', '40.00', '33.jpg', 'COWLING,LWR,LH,P.S.WHITE', NULL, 0, 1, 2, 0),
(34, 11, 'Z125', '15.00', '34.jpg', 'FLAP', NULL, 0, 1, 2, 0),
(35, 9, 'Z250 & 300', '15.00', '35.jpg', 'STEP,FR', NULL, 0, 1, 2, 0),
(36, 10, 'Z250 & 300', '55.00', '36.jpg', 'STAY,STEP HOLDER,RR', NULL, 0, 1, 2, 0),
(37, 9, 'Z250 & 300', '8.00', '37.jpg', 'LEVER-GRIP,CLUTCH', NULL, 0, 1, 2, 0),
(38, 12, 'KLX', '11.50', '38.jpg', 'LEVER-GRIP,FRONT BRAKE', NULL, 0, 1, 2, 0),
(39, 9, 'Z250 & 300', '55.00', '39.jpg', 'STAY STEP', NULL, 0, 1, 2, 0),
(40, 10, 'Z205&300', '6.00', '40.jpg', 'GRIP,HANDLE,LH', NULL, 0, 1, 2, 0),
(41, 3, 'Z250&300', '8.00', '41.jpg', 'GRIP-ASSY,THROTTLE', NULL, 0, 1, 2, 0),
(42, 3, 'NINJA250&300', '25.00', '42.jpg', 'HANDLE-COMP,RH,BLACK', NULL, 0, 1, 2, 0),
(43, 9, 'Z250 & 300', '8.50', '43.jpg', 'FILTER-ASSY-OIL', NULL, 0, 1, 2, 0),
(44, 11, 'Z125', '12.00', '44.jpg', 'COVER-SIDE,LH,F.BLACK', NULL, 0, 1, 2, 0),
(45, 0, 'KSR', '4.00', '45.jpg', 'LENS-SIGNAL LAMP,FR,LH&RR', NULL, 0, 1, 2, 0),
(46, 9, 'Z250 & 300', '15.00', '46.jpg', 'COVER,INNER,LH', NULL, 0, 1, 2, 0),
(47, 11, 'Z125', '12.00', '47.jpg', 'COWLING,LWR,F.BLACK', NULL, 0, 1, 2, 0),
(48, 11, 'Z125', '40.00', '48.jpg', 'HOUSING-ASSY-CONTROL,LH', NULL, 0, 1, 2, 0),
(49, 11, 'Z125', '110.00', '49.jpg', 'METER-ASSY,COMBINATION', NULL, 0, 1, 2, 0),
(50, 11, 'Z125', '52.00', '50.jpg', 'SWITCH-ASSY-IGNITION', NULL, 0, 1, 2, 0),
(51, 11, 'Z125', '80.00', '51.jpg', 'TANK-COMP-FUEL', NULL, 0, 1, 2, 0),
(52, 10, 'Z250', '8.00', '52.jpg', 'GASKET,OIL PAN', NULL, 0, 1, 2, 0),
(53, 0, 'KSR', '10.00', '53.jpg', 'GASKET,CLUTCH COVER', NULL, 0, 1, 2, 0),
(54, 12, 'KLX', '15.00', '54.jpg', 'BOOT,FORK,BLACK', NULL, 0, 1, 2, 0),
(55, 11, 'Z125', '4.50', '55.jpg', 'ELEMENT-OIL-FILTER', NULL, 0, 1, 2, 0),
(56, 11, 'z125', '20.00', '56.jpg', 'PAD-ASSY-BRAKE', NULL, 0, 1, 2, 0),
(57, 10, 'Z250 & 300', '40.00', '57.jpg', 'RESERVOIR', NULL, 0, 1, 2, 0),
(58, 10, 'Z250 & 300', '190.00', '58.jpg', 'RADIATOR', NULL, 0, 1, 2, 0),
(59, 9, 'Z250&300', '30.40', '59.jpg', 'FENDER-FRONT,F.EBONY', NULL, 0, 1, 2, 0),
(60, 9, 'Z250& 300', '20.00', '60.jpg', 'COVER SEAT,TAIL,,C.F.B.GREEN', NULL, 0, 1, 2, 0),
(61, 10, 'Z250 & 300', '48.00', '61.jpg', 'SEAT,RR,LEATHER BLK+BAND BLK', NULL, 0, 1, 2, 0),
(62, 11, 'Z125', '18.00', '62.jpg', 'COVER-HEAD LAMP,LWR,C.B.ORG', NULL, 0, 1, 2, 0),
(63, 11, 'Z125', '26.00', '63.jpg', 'BATTERY,FTZ4V,12V 3.5AH', NULL, 0, 1, 2, 0),
(64, 10, 'Z250&300', '78.00', '64.jpg', 'BATTERY,FTX9-BS,12V 8AH', NULL, 0, 1, 2, 0),
(65, 10, 'Z250&300', '35.00', '65.jpg', 'COWLING,LWR,RH,C.F.B.GREEN', NULL, 0, 1, 2, 0),
(66, 11, 'Z125', '232.17', '66.jpg', 'DAMPER-ASSY,FORK,LH,C.GOLD', NULL, 0, 1, 2, 0),
(67, 9, 'Z250 & 300', '75.50', '67.jpg', 'COVER-CLUTCH', NULL, 0, 1, 2, 0),
(68, 10, 'Z250 & 300', '45.00', '68.jpg', 'PAN-OIL', NULL, 0, 1, 2, 0),
(69, 11, 'Z125', '35.00', '69.jpg', 'FENDER-REAR', NULL, 0, 1, 2, 0),
(70, 11, 'Z125', '15.00', '70.jpg', 'COVER,PIVOT,LH,F.BLACK', NULL, 0, 1, 2, 0),
(71, 9, 'Z250 &300', '7.00', '71.jpg', 'COVER,INNER,RH', NULL, 0, 1, 2, 0),
(72, 11, 'Z125', '8.00', '72.jpg', 'COVER-HEAD LAMP,UPP', NULL, 0, 1, 2, 0),
(73, 11, 'Z125', '15.00', '73.jpg', 'COVER TANK,F.BLACK', NULL, 0, 1, 2, 0),
(74, 10, 'Z250 & 300', '15.00', '74.jpg', 'COVER,VISOR', NULL, 0, 1, 2, 0),
(75, 11, 'Z125', '9.00', '75.jpg', 'CABLE-CLUTCH', NULL, 0, 1, 2, 0),
(76, 11, 'Z125', '18.00', '76.jpg', 'COVER-HEAD LAMP,LWR,C.B.GRAY', NULL, 0, 1, 2, 0),
(77, 4, 'NINJA250', '95.00', '77.jpg', 'COWLING,CNT,RH,P.S.ORANG', NULL, 0, 1, 2, 0),
(78, 4, 'NINJA250', '95.00', '78.jpg', 'COWLING,CNT,RH,P.S.GREEN', NULL, 0, 1, 2, 0),
(79, 9, 'Z250 & 300', '18.00', '79.jpg', 'BRACE-ASSY,FRONT FENDER', NULL, 0, 1, 2, 0),
(80, 10, 'Z250 & 300', '25.00', '80.jpg', 'HANDLE,F.S.BLACK', NULL, 0, 1, 2, 0),
(81, 3, 'NINJA250 & 300', '40.00', '81.jpg', 'MIRROR ASSY', NULL, 0, 1, 2, 0),
(82, 10, 'Z250 & 300', '25.00', '82.jpg', 'MIRROR ASSY', NULL, 0, 1, 2, 0),
(83, 11, 'Z125', '98.00', '83.jpg', 'CONTROL UNIT-ELECTRONIC', NULL, 0, 1, 2, 0),
(84, 10, 'Z250 & 300', '20.00', '84.jpg', 'COVER SEAT,CNT,M.F.S.BLACK', NULL, 0, 1, 2, 0),
(85, 11, 'Z125', '18.00', '85.jpg', 'COVER-HEAD LAMP,LWR,C.B.GREEN', NULL, 0, 1, 2, 0),
(86, 11, 'Z125', '50.70', '86.jpg', 'LAMP-HEAD', NULL, 0, 1, 2, 0),
(87, 10, 'Z250 & 300', '15.60', '87.jpg', 'COWLING,UPP,RH,C.F.B.GRAY', NULL, 0, 1, 2, 0),
(88, 9, 'Z250 & 300', '15.60', '88.jpg', 'COWLING,UPP,RH,C.F.B.ORANG', NULL, 0, 1, 2, 0),
(89, 11, 'Z125', '18.00', '89.jpg', 'FENDER-FRONT,M.G.GRAY', NULL, 0, 1, 2, 0),
(90, 11, 'Z125', '18.00', '90.jpg', 'FENDER-FRONT,M.G.GREEN', NULL, 0, 1, 2, 0),
(91, 10, 'Z250 & 300', '18.20', 'lastest.jpg', 'COVER SEAT,SIDE,RH,M.S.BLACK', NULL, 0, 1, 2, 0),
(92, 10, 'Z250 & 300', '52.00', 'imag.jpg', 'PLATE-FRICTION', NULL, 0, 1, 2, 0),
(94, 0, 'Men', '$91.43', '45(1).jpg', 'SPORTS SWEATSHIRT (M L XLBlack / Lime Green)', NULL, 0, 1, 1, 0),
(95, 0, 'N/A', '7.71', '2(1).jpg', 'KAWASAKI LANYARD', NULL, 0, 1, 1, 0),
(96, 0, 'N/A', '51.43', '47(1).jpg', 'SPORTS SHIRT SHORT SLEEVE (M L XL Black / Lime Green)', NULL, 0, 1, 1, 0),
(97, 0, 'N/A', '74.29', '3(1).jpg', 'SPORTS SHIRT SHORT SLEEVE (M L XL Black / Lime Green)', NULL, 0, 1, 1, 0),
(98, 0, 'BELT EMBOSSED', '31.43', '5(1).jpg', 'BELT EMBOSSED KAWASAKI (115cm -120cm Black leather)', NULL, 0, 1, 1, 0),
(99, 0, 'TSHIRT', '102.57', '6.png', 'SWEATSHIRT BLACK/WHITE', NULL, 0, 1, 1, 0),
(100, 0, 'T-SHIRT', '85.43', '7.png', 'T-SHIRT SBK REPLICA FEMALE BLACK SIZE S/M', NULL, 0, 1, 1, 0),
(101, 0, 'RACING HOODY', '91.14', '8.png', 'KAWASAKI RACING HOODY SIZE M/L\r\nL/XL', NULL, 0, 1, 1, 0),
(102, 0, 'POLO SBK', '54.00', '9.png', 'POLO SBK REPLICA GP SIZE L/XL', NULL, 0, 1, 1, 0),
(103, 0, 'SBK REPLICA', '42.57', '7.jpg', 'SBK REPLICA GP T-SHIRT SIZE M/L', NULL, 0, 1, 1, 0),
(104, 0, 'MAN T-SHIRT', '32.57', '11.png', 'KAWASAKI RACING TEAM MAN T-SHIRT SIZE M/L', NULL, 0, 1, 1, 0),
(105, 0, 'BEANIE', '21.14', '12.png', 'BEANIE KAWASAKI RACING BLACK', NULL, 0, 1, 1, 0),
(106, 0, 'CAP TEAM', '32.57', '13.png', 'CAP TEAM 65 SBK REPLICA X BLACK', NULL, 0, 1, 1, 0),
(107, 0, 'POLO SHORT', '56.86', '14.png', 'KRT SBK REPLICA POLO SHORT SLEEVES SIZE M/L and L/XL', NULL, 0, 1, 1, 0),
(108, 0, 'T-SHIRT SHORT', '48.29', '15.png', 'KRT SBK REPLICA T-SHIRT SHORT SLEEVES SIZE M/L L/XL', NULL, 0, 1, 1, 0),
(109, 0, 'REA #65', '32.57', '8(1).jpg', 'KAWASAKI BEANIE JONATHAN REA #65', NULL, 0, 1, 1, 0),
(110, 0, 'SYKES #66', '32.57', '10(1).jpg', 'KAWASAKI BEANIE TOM SYKES #66', NULL, 0, 1, 1, 0),
(111, 0, 'SWEATSHIRT', '102.57', '18.png', 'KRT SBK REPLICA SWEATSHIRT SIZE M/L\r\nL/XL', NULL, 0, 1, 1, 0),
(112, 0, 'KRT', '14.00', '20.png', 'KRT SBK REPLICA WRIST BAND', NULL, 0, 1, 1, 0),
(113, 0, 'UMBRELLA', '14.00', '11(1).jpg', 'KAWASAKI UMBRELLA', NULL, 0, 1, 1, 0),
(114, 0, 'HOODY', '51.14', '22.png', 'KAWASAKI HOODY (SIZE M SIZE L)', NULL, 0, 1, 1, 0),
(115, 0, 'BAG', '42.57', '12(1).jpg', 'KAWASAKI BAG', NULL, 0, 1, 1, 0),
(116, 0, 'GLOVE', '58.57', '24.png', 'MESH PROTECTION GLOVE BLK- L XL', NULL, 0, 1, 1, 0),
(118, 0, 'GLOVE', '44.29', '25.png', 'MESH PROTECTION HALF FINGER GLOVE BLK-XL and L', NULL, 0, 1, 1, 0),
(119, 0, 'PACK', '98.57', '26.png', 'WP BACK PACK', NULL, 0, 1, 1, 0),
(120, 0, 'WAIST', '82.86', '27.png', 'WAIST BAG (M)', NULL, 0, 1, 1, 0),
(121, 0, 'WATCH MODEL 01', '160', '14(1).jpg', 'KAWASAKI WATCH MODEL 01', NULL, 0, 1, 1, 0),
(122, 0, 'WATCH MODEL 02', '160', '13(1).jpg', 'KAWASAKI WATCH MODEL 02', NULL, 0, 1, 1, 0),
(123, 0, 'SHIRT', '24.00', '15(1).jpg', 'KAWASAKI POLO-SHIRT WHT/M L', NULL, 0, 1, 1, 0),
(124, 0, 'Mug', '12.57', '19(1).jpg', 'Kawasaki Mug', NULL, 0, 1, 1, 0),
(125, 0, 'BALACLAVA', '14.00', '21(1).jpg', 'BALACLAVA,MODEL: AIR2', NULL, 0, 1, 1, 0),
(126, 0, 'ARMSLEEVES', '12.57', '20(1).jpg', 'ARMSLEEVES UV A/B UPF50+', NULL, 0, 1, 1, 0),
(127, 0, 'MULTI-TUBE', '12.57', '38.png', 'MULTI-TUBE,MULTIFUNCTION HEADWEAR', NULL, 0, 1, 1, 0),
(128, 0, 'HELMET', '342.86', '33(1).jpg', 'SHARK-HELMET(KAWASAKI)BLK/GRN/WHT(L)', NULL, 0, 1, 1, 0),
(129, 0, 'HELMET MODEL', '282.85', '22(1).jpg', 'SHARK-HELMET MODEL SYKES REPLICA SIZE L', NULL, 0, 1, 1, 0),
(130, 10, 'Z 250', '35', '1(2).jpg', 'SPROCKET-HUB,44T', NULL, 0, 1, 2, 0),
(131, 10, 'Z 250', '126', '2(2).jpg', 'CHAIN,DRIVE,EK520SR-O2X108L', NULL, 0, 1, 2, 0),
(132, 10, 'Z250 & 300', '18.5', '3(2).jpg', 'SPROCKET-OUTPUT,14T', NULL, 0, 1, 2, 0),
(133, 9, 'Z300', '25', '4(1).jpg', 'SPROCKET-HUB,42T', NULL, 0, 1, 2, 0),
(134, 9, 'Z300', '92.2', '5(2).jpg', 'CHAIN,DRIVE,EK520SR-O2X106L', NULL, 0, 1, 2, 0),
(135, 11, 'Z125 Pro', '12', '6(1).jpg', 'CHAIN,DRIVE,DID420AD', NULL, 0, 1, 2, 0),
(136, 11, 'Z125 Pro', '7', '7.(1).jpg', 'SPROCKET-HUB,30T', NULL, 0, 1, 2, 0),
(137, 11, 'Z125 Pro', '4', '3(3).jpg', 'SPROCKET-OUTPUT', NULL, 0, 1, 2, 0),
(138, 6, 'Z1000', '60', '22222222.jpg', 'CABLE-CLUTCH', NULL, 0, 1, 2, 0),
(139, 6, 'Z1000', '47', 'sprocket-output-15t_medium131440554-01_190c.jpg', 'SPROCKET-OUTPUT,15T', NULL, 0, 1, 2, 0),
(140, 6, 'Z1000', '195', '357-1571.jpg', 'CHAIN,DRIVE,EK525ZX-112L', NULL, 0, 1, 2, 0),
(141, 6, 'Z1000', '75', 's-l300.jpg', 'SPROCKET-HUB,43T', NULL, 0, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `add_to_cart`
--

CREATE TABLE `add_to_cart` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `item_price` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `item_size` varchar(5) NOT NULL,
  `item_amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Pending, 1= Processing,2=Paid,3=Unpaid'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_to_cart`
--

INSERT INTO `add_to_cart` (`id`, `item_id`, `user_id`, `created_at`, `item_price`, `item_code`, `item_size`, `item_amount`, `status`) VALUES
(175, 141, 11, '2018-12-28 04:54:06', 75, 'PT0003', 's', 1, 1),
(176, 141, 12, '2019-01-02 06:04:36', 75, 'PT0003', 's', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`userid`, `username`, `password`, `email`, `phone_number`) VALUES
(1, '@dmin', 'K@W@_admin', NULL, NULL),
(2, 'test', '12345', 'sreyleak@hgbgroup.com', NULL),
(3, 'sreyleak', '202cb962ac59075b964b07152d234b70', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_loan`
--

CREATE TABLE `bank_loan` (
  `id` int(11) NOT NULL,
  `logo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rate` float NOT NULL,
  `term_condition` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `b_order` tinyint(4) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_loan`
--

INSERT INTO `bank_loan` (`id`, `logo`, `name`, `rate`, `term_condition`, `b_order`, `create_date`) VALUES
(1, '1.png', 'ពិភពថ្មី', 0.2, 'ពិភពថ្មី \r\n<br/>ID card, passport, family book, residential book, birth certificate, civil servant ID, or employment ID\r\n<br/>Employment contract\r\n<br/>Land title, land certificate or term deposit certificate\r\n<br/>Other documents on incomes and expenses of family or business', 0, '2018-01-17 09:23:17'),
(2, '2.png', 'CIMB', 0.25, 'CIMB\n<br/>If the string begins with "0x", the radix is 16 (hexadecimal)\n<br/>If the string begins with "0", the radix is 8 (octal). This feature is deprecated\n<br/>If the string begins with any other value, the radix is 10 (decimal)', 0, '2018-01-17 09:23:17'),
(3, '3.png', 'AEON', 0.27, 'AEON\n<br/>If the string begins with "0x", the radix is 16 (hexadecimal)\n<br/>If the string begins with "0", the radix is 8 (octal). This feature is deprecated\n<br/>If the string begins with any other value, the radix is 10 (decimal)', 0, '2018-01-17 09:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `cid` int(11) NOT NULL,
  `position` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `closing_date` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Display; 0 = Hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`cid`, `position`, `description`, `create_date`, `closing_date`, `status`) VALUES
(1, 'Accountant', '<h3>Job Description</h3>\r\n\r\n<table border="0" class="main-job-tab main-job-w" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<th style="width:20px">&nbsp;</th>\r\n			<td>- Well manage accounting documents in file<br />\r\n			- Issue all accounting documents (Invoice, debit note...)<br />\r\n			- Prepare the Account Receivable and Account Payable<br />\r\n			- Bank Reconciliation<br />\r\n			- check and verify on payment suppliers<br />\r\n			- check unit price of material and spear part<br />\r\n			- Monitor and follow up checking stock in and out<br />\r\n			- Monthly and yearly tax declaration<br />\r\n			- Daily and monthly report to supervisor or manager<br />\r\n			- Perform other duties as assigned by manager</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h3>Job Requirements</h3>\r\n\r\n<table border="0" class="main-job-tab main-job-w" style="width:100%">\r\n	<tbody>\r\n		<tr>\r\n			<th style="width:20px">&nbsp;</th>\r\n			<td>- Bachelor&rsquo;s degree or equivalent<br />\r\n			- Tax Agent Certification<br />\r\n			- Two to four years working experience with taxation<br />\r\n			- Knowledge of Microsoft Office Suite including Outlook, Word, Excel and Explorer Internet software; QuickBooks or Peachtree software.<br />\r\n			- Ability to solve practical problems and deal with general tax department<br />\r\n			- Ability to read, analyze and interpret general business periodicals, professional journals, technical procedures or governmental regulations.<br />\r\n			- Ability to effectively present information and respond to questions from groups of managers, clients, customers and the general public.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '2017-08-09 17:00:00', '10/25/2017', 1),
(2, 'Admin/HR Officer', '<p>&nbsp;</p>\r\n<h3 class="main-job-title-h3-2 main-job-w">Job Description</h3>\r\n<table class="main-job-w main-job-tab" border="0" width="100%">\r\n    <tbody>\r\n        <tr>\r\n            <th style="width:20px">&nbsp;</th>\r\n            <td>-	Recruitment strategy and management<br />\r\n            -	Staff payroll &amp; compensation management<br />\r\n            -	HR strategy and policies<br />\r\n            -	Manage company general administration and company security<br />\r\n            -	Deal with relevant local authorities/institutions for work related issues<br />\r\n            -	Perform daily checklist for General Administration Support, and solve the problems properly.<br />\r\n            -	Assist the work for general support to the whole office building <br />\r\n            -	Prepare all kind of administrative letter in and out for the company <br />\r\n            -	Prepare expense report in assisting to Accounting Department<br />\r\n            -	Perform any other tasks assigned by the manager.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<h3 class="main-job-title-h3-2 main-job-w">Job Requirements</h3>\r\n<table class="main-job-w main-job-tab" border="0" width="100%">\r\n    <tbody>\r\n        <tr>\r\n            <th style="width:20px">&nbsp;</th>\r\n            <td>-	Bachelor Degree in Business Administration or related fields<br />\r\n            -	At least one year experiences in Admin / HR position.<br />\r\n            -	Good at English communication <br />\r\n            -	Excellent interpersonal skill and communication skills<br />\r\n            -	Male only.<br />\r\n            -	Able to use computer literate (Ms. Words, Ms. Excel, Internet &amp; E-mail)<br />\r\n            -	Positive attitude, and Critical thinking<br />\r\n            -	Willing to Work under pressure</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '2017-08-10 04:11:18', '30/09/2017', 1),
(3, 'Stock Controller', '<p>&nbsp;</p>\r\n<h3 class="main-job-title-h3-2 main-job-w">Job Description</h3>\r\n<table class="main-job-w main-job-tab" border="0" width="100%">\r\n    <tbody>\r\n        <tr>\r\n            <th style="width:20px">&nbsp;</th>\r\n            <td>- Prepare quote for service advisor from the Technicians &lsquo;Estimated Sheet.<br />\r\n            - Prepare purchase request for stock refill and customers &lsquo;order.<br />\r\n            - Assist any inquiries from customer.<br />\r\n            - Prepare price list update for service advisor (new stock arrival).<br />\r\n            - As a stock controller for maintaining the warehouse (location &amp; condition of spare parts)<br />\r\n            - Stock reporting daily/weekly/monthly.<br />\r\n            - Able to work independent - Work hard, Friendly, motivate and flexible.<br />\r\n            - Perform other duties as assigned by manager.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<h3 class="main-job-title-h3-2 main-job-w">Job Requirements</h3>\r\n<table class="main-job-w main-job-tab" border="0" width="100%">\r\n    <tbody>\r\n        <tr>\r\n            <th style="width:20px">&nbsp;</th>\r\n            <td>- Bachelor Degree in Management or relevant fields.<br />\r\n            - At least 2 year experience<br />\r\n            - From 22 to 35 year old. - Body is strong enough to carry heavy items.<br />\r\n            - Can operate computer with Microsoft Offices.<br />\r\n            - Good in English both speaking and writing. - Good appearance and hard working. - Able to work under pressure.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '2017-08-10 04:11:53', '30/09/2017', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `cid` int(11) NOT NULL,
  `company_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `full_name`, `phone`, `email`, `message`, `send_date`) VALUES
(1, 'sdf', 'sdf', 'sreyeak@gmail.com', 'sdf', '2017-07-17 04:00:06'),
(2, '', '', '', '', '2018-01-13 02:29:05'),
(3, '', '', '', '', '2018-01-17 01:51:12'),
(4, '', '', '', '', '2018-01-17 02:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `dealer`
--

CREATE TABLE `dealer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dealer`
--

INSERT INTO `dealer` (`id`, `name`, `phone`, `email`, `address`, `link`, `create_date`, `status`) VALUES
(5, 'ទូត សីហា', '012 76 38 61', NULL, 'ផ្ទះលេខ262 ផ្លូវព្រះសីហនុ សង្កាត់វាល់វង្ស ខណ្ឌ7មករា', NULL, '2018-08-04 03:05:13', 1),
(4, 'ទីក្រុង ម៉ូតូ ទំនើប', '098 525 202', NULL, 'ផ្ទះលេខEo ផ្លូវព្រះសីហនុ សង្កាត់វាល់វង្ស ខណ្ឌ7មករា', NULL, '2018-08-04 03:02:06', 1),
(3, 'អីុវ ភារុណ', '012 91 23 01', 'sreyleak@hgbgroup.com', 'ផ្ទះលេខ81CEo ផ្លូវ182 សង្កាត់អូរឬស្សី ខណ្ឌចំការមន', NULL, '2018-08-04 02:45:13', 1),
(6, 'ជានចំណាប់', '012 230 777', NULL, 'ផ្ទះលេខ284Eo ផ្លូវព្រះសីហនុ សង្កាត់អូឡាំពិច ខណ្ឌចំការមន', NULL, '2018-08-04 03:05:46', 1),
(7, 'តែ ឈិន', '011 611 311', NULL, 'ផ្ទះលេខEo ផ្លូវ274 សង្កាត់អូឡាំពិច ខណ្ឌចំការមន', NULL, '2018-08-04 03:06:35', 1),
(8, 'ហេងសុខលី', '096 6 111 140', NULL, 'ផ្ទះលេខ302Eo ផ្លូវ274 សង្កាត់អូឡាំពិច ខណ្ឌចំការមន', NULL, '2018-08-04 03:07:09', 1),
(9, 'សេង សុខឃីម', '012 661 063', NULL, 'ផ្ទះលេខ326Eo ផ្លូវព្រះសីហនុ សង្កាត់អូឡាំពិច ខណ្ឌចំការមន', NULL, '2018-08-04 03:07:41', 1),
(10, 'អ៊ុយ សាខន', '012 855 567', NULL, 'ផ្ទះលេខ 113-115 Eo ផ្លូវព្រះសីហនុ សង្កាត់បឹងព្រលឹត ខណ្ឌ7មករា', NULL, '2018-08-04 03:08:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE `feature` (
  `feature_id` int(11) NOT NULL,
  `top_title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_des` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `f_order` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feature`
--

INSERT INTO `feature` (`feature_id`, `top_title`, `title`, `model_id`, `thumbnail`, `long_des`, `f_order`) VALUES
(1, 'STYLING', 'SHARP NINJA STYLING', 1, '1000-04.jpg', '<p>All-new bodywork includes a much sharper front cowl with a decidedly  closer resemblance to Kawasaki&rsquo;s Ninja supersport models. The more  aggressive visage is complemented by fierce new LED headlamps. The  dynamic and sporty bodywork reflects the Ninja 1000&rsquo;s exciting street  riding potential. Supersport-style full-fairing bodywork gives the Ninja  1000 a distinct, head-turning look. The sleek styling also offers a  good measure of wind protection, facilitating short touring runs.</p>', 0),
(2, 'ENGINE', 'EXHILARATING IN-LINE FOUR ENGINE', 1, '1000-003.jpg', '<p>Powerful 1,043 cm3 liquid-cooled, 4-stroke In-line Four engine pulls  strongly from all rpm and does not let up before the redline. Adding to  rider exhilaration, the engine delivers superb response, a strong  mid-range hit and an intoxicating intake howl. Revised engine settings  offer even smoother power delivery, facilitating control and  contributing to rider comfort and confidence. Engine tuning focused on  the feeling the rider gets when opening the throttle. Strong torque is  complemented by direct throttle response. Revised engine settings offer  even smoother power delivery and cleaner emissions. And Revised ECU  settings contribute to even smoother power delivery, facilitating  control and contributing to rider comfort and confidence, and deliver  cleaner emissions, ensuring various market regulations (including Euro  4) are cleared.</p>', 0),
(3, 'ELECTRONICS', 'ELECTRONICS', 1, 'kw-product-feature-3.jpg', '<p><strong>NEW</strong> <strong>KCMF (Kawasaki Cornering Management Function): Total Engine &amp; Chassis Management Package</strong><br />\r\nUsing the latest evolution of Kawasaki&rsquo;s advanced modelling software and  feedback from a compact Bosch IMU (Inertial Measurement Unit) that  gives an even clearer real-time picture of chassis orientation, KCMF  monitors engine and chassis parameters throughout the corner &ndash; from  entry, through the apex, to corner exit &ndash; modulating brake force and  engine power to facilitate smooth transition from acceleration to  braking and back again, and to assist riders in tracing their intended  line through the corner.&nbsp;</p>\r\n<p><strong>NEW</strong> <strong>KTRC (Kawasaki TRaction Control)</strong><br />\r\nThree modes cover a wide range of riding conditions, offering either  enhanced sport riding performance or the peace of mind to negotiate  slippery surfaces with confidence.&nbsp; Feedback from the IMU enables more  precise control. &nbsp;</p>\r\n<p><strong>NEW</strong> <strong>KIBS (Kawasaki Intelligent anti-lock Brake System)</strong><br />\r\nKawasaki&rsquo;s supersport-grade high-precision brake management system take  into account the particular handling characteristics of supersport  motorcycles, ensuring highly efficient braking with minimal intrusion  during sport riding. KIBS also incorporates corner braking control,  modulating brake force to counter the tendency of the bike to stand up  when braking mid-corner.</p>\r\n<p><strong>Power Mode selection</strong><br />\r\nA choice of Full Power or Low Power modes allows riders to set power delivery to suit preference and conditions.</p>', 0),
(4, 'INSTRUMENTS', 'STYLISH MULTI-FUNCTIONAL INSTRUMENTATION', 1, 'kw-product-feature-5.jpg', '<div class="nano-content" style="right: -17px;">\r\n<p>All-new instrument panel layout features a large analogue tachometer  flanked by warning lamps on one side, and a gear position indicator and  multi-function LCD screen on the other.&nbsp;<br />\r\n<br />\r\n1. Complementing a new shift-up indicator lamp, the tachometer&rsquo;s needle  changes colour (from white to pink to red) to indicate the  rider-selectable shift-up timing.&nbsp;<br />\r\n<br />\r\n2. The Economical Riding Indicator appears on the LCD screen to indicate  favourable fuel consumption. Paying attention to conditions that result  in the mark appearing can assist riders to maximise their fuel  efficiency. This handy feature is active all the time, although to be  effective, the rider must ride in a gentle manner: less than 6,000  min-1, less than 30% throttle, under 140 km/h.</p>\r\n</div>', 0),
(5, 'STYLING', 'SHARP NINJA STYLING', 2, 'ninja_650_kawasaki_cambodia.jpg', '<p>Sleek bodywork includes a sharp front cowl with a strong resemblance to  Kawasaki&rsquo;s Ninja supersport models. The aggressive visage is  complemented by slim, close-fitting bodywork designed to give the bike a  light, nimble image that reflects its sporty performance.&nbsp;<br />\r\n<br />\r\nLight weight, nimble handlingredesigned chassis, the new Ninja 650  weighs in at 193 kg (ABS Model). Designed using Kawasaki&rsquo;s new in-house  analysis technology, the lightweight trellis frame and swingarm were the  key to the Ninja 650&rsquo;s ultra-light handling.&nbsp;<br />\r\n<br />\r\nRelaxed, sporty ergonomicsSeparate handles contribute to the Ninja 650&rsquo;s  relatively upright position. Designed to both inspire rider confidence  as well as put the rider in the ideal position for control, the  comfortable and natural position is suitable for a wide range of riders.</p>', 0),
(6, 'ENGINE', 'ENGINE', 2, 'ninja_650_kawasaki_cambodia(1).jpg', '<p>Parallel-Twin Engine Tuned for Low-Mid Range Power &amp; Torque.Exciting  Parallel Twin engine offers quick response, strong low-mid range  performance and excellent fuel economy. Performance and feel were  optimised for the mid-range (3,000-6,000 min-1). However, in the low-rpm  range (below 3,000 min-1) power delivery is very smooth, and even above  6,000 min-1 power and torque curves continue on without dropping off  suddenly.&nbsp;<br />\r\n<br />\r\nThe new engine settings also contribute to improved fuel efficiency:WMTC  mode mileage is 6.8%* better than that of the EX650E/F. In particular,  fuel consumption at normal running velocity (between 50-100 km/h) is  remarkably improved. (*Measured at Kawasaki test centre under WMTC mode  conditions. Actual mileage varies depending on riding style, riding  conditions and vehicle maintenance.)</p>', 0),
(7, 'CHASSIS', 'CHASSIS', 2, 'ninja_650_kawasaki_cambodia(2).jpg', '<p>One of the key components to realising the new Ninja 650&rsquo;s lighter  weight (noticeable as soon as the bike is lifted off its side-stand),  the all-new frame weighs only 15 kg and contributes significantly to the  bike&rsquo;s light, nimble handling. Kawasaki&rsquo;s new in-house analysis  technology was used to precisely determine the necessary pipe diameter,  length and wall thickness to deliver the ideal lateral and torsional  rigidity. This allowed unnecessary material to be trimmed, resulting in  an extremely lightweight frame: the new frame weighs only 15 kg, a key  to the new Ninja 650&rsquo;s light, nimble handling.</p>', 0),
(8, 'SUSPENSION', 'TELESCOPIC FRONT FORK &AM; HORIZONTAL BACK-LINK RE', 2, 'ninja_650_kawasaki_cambodia(3).jpg', '<p>&oslash;41 mm telescopic front fork handles suspension duties up front.  Horizontal Back-link rear suspension offers a progressive character.  Compared to link-less type suspension, it delivers a better balance of  sporty performance and ride comfort. Rear suspension positions the shock  unit and linkage above the swing arm. This arrangement contributes to  mass centralisation, while ensuring that the suspension is located far  enough from the exhaust that operation is not affected by heat.</p>', 0),
(9, 'INSTRUMENTS', 'STYLISH MULTI-FUNCTION INSTRUMENTATION', 2, 'ninja_650_kawasaki_cambodia(4).jpg', '<p>When engine speed is within 500 min-1 of the selected shift-up timing,  the shift indicator lamp flashes, and the tachometer needle turns pink.  When the chosen engine speed is reached, the shift indicator lamp  flashes rapidly, and the tachometer needle turns red. And Riders can set  the shift-up timing between 5,000 and 11,000 min-1 in 250 min-1  increments. The shift indicator function may also be turned OFF.</p>', 0),
(11, 'ENGINE', 'ENGINE', 3, 'ninja_300_kawasaki_cambodia(1).jpg', '<p>Designed for rider-friendly response, the Ninja 300&rsquo;s fuel-injected  Parallel Twin engine delivers smooth,responsive torque at low and medium  rpm and hard-hitting acceleration at high rpm. Now displacing 296 cm3,  the engine offers significantly stronger torque and power at all rpm,  putting the Ninja 300 in a class of its own. The new engine is fitted  with a sleeveless, plated, die-cast aluminium cylinder. New cylinder  head, lighter pistons, new crankcases and oil pan (offering increased  engine cooling) are just some of the new engine parts.Complementing the  enhanced engine performance, racing-derived clutch technology offers a  lighter clutch lever pull and a back-torque limiting function, while  heat management technology like the new radiator fan cover directs heat  away from the rider, significantly improving rider comfort.</p>', 0),
(12, 'TECHNOLOGY', 'HEAT MANAGEMENT TECHNOLOGY', 3, 'ninja_300_kawasaki_cambodia(2).jpg', '<p>Innovative Kawasaki technology like the new radiator fan cover (patent  pending) located behind the radiator directs hot air down and away from  the rider, significantly increasing comfort when stuck in heavy traffic.  Redirecting the air also helps keep the tank, frame and other parts  that contact the rider cooler, further increasing rider comfort.</p>', 0),
(13, 'STYLING', 'RACY BODYWORK AND HIGH-QUALITY', 3, 'ninja_300_kawasaki_cambodia(4).jpg', '<p>Touches Aggressive new design follows the latest Ninja series trends.  Like the Ninja ZX-10R, the new Ninja 300 features a &ldquo;mass-forward,  minimalist-tail&rdquo; design. Like the Ninja ZX-10R, the new Ninja 300 uses a  floating-style windscreen with a gap between the cowl and the  windscreen. Mounting the screen using only the bolts from the mirror  stays contributes to a very clean and elegant design. Fin design and  large ventilation holes in the fairing have a design similar to that of  the Ninja ZX-14R. The design contributes to the Ninja 300&rsquo;s excellent  heat management.</p>', 0),
(14, 'SUPER LIGHTWEIGHT', 'RACY SUPER LIGHTWEIGHT NINJA', 4, 'ninja_250_kawasaki_cambodia.jpg', '<p>Kawasaki&rsquo;s newest entry into the 250cc full-fairing sport arena is the  Ninja 250SL. Powered by a 4-stroke Single mounted in an original trellis  frame, the newest Ninja offers sporty performance in a slim,  lightweight and compact package. With competitive performance, quick,  nimble handling, and aggressive ergonomics, it is a lighter, racier  alternative to the Ninja 250.</p>', 0),
(15, 'ENGINE', 'ENGINE', 4, 'ninja_250_kawasaki_cambodia(1).jpg', '<p>The Ninja 250SL&rsquo;s 4-stroke single-cylinder engine offers sporty  performance in a slim, lightweight and compact package. It delivers a  robust mid-range, and its quick-revving character allows the engine to  spin up quickly to the high-rpm range, where the engine really sings.  The top end delivers strong power and extends well into the over-rev  without dropping off suddenly. On the Ninja 250SL, every twist of the  throttle produces a satisfying surge of acceleration that propels the  bike and rider forward.</p>', 0),
(16, 'FUEL-INJECTED', 'FUEL-INJECTED 249 CM3 4-STROKE SINGLE ENGINE', 4, 'ninja_250_kawasaki_cambodia(2).jpg', '<p>Kawasaki&rsquo;s liquid-cooled, DOHC, 4-valve Single delivers smooth,  responsive power at low and medium rpm and hard-hitting power at high  rpm. Maximum power is 20.6 kW (28 PS). 4-valve DOHC cylinder head  provides maximum valve area for optimum flow. Low reciprocating weight  (thanks to the use of a cam lobe for each valve with shim- under tappet  arrangement) contributes to higher efficiency at high rpm. Compact air  cleaner design contributes to the bike&rsquo;s slim package. The air cleaner  structure was designed with consideration to optimising airflow and  adding to the bike&rsquo;s sporty performance. Intake funnel length and  diameter enhance the 4-stroke characteristics: ultra low-rpm tenacity  (which facilitates to low-rpm control), strong low-mid range torque and  pick up, and a high-revving top end.</p>', 0),
(17, 'TECHNOLOGY', 'HEAT MANAGEMENT TECHNOLOGY', 4, 'ninja_250_kawasaki_cambodia(3).jpg', '<p>Innovative Kawasaki technology like the patented radiator fan cover  located behind the radiator directs hot air down and away from the  rider, significantly increasing comfort when stuck in heavy traffic.  Redirecting the air also helps keep the tank, frame and other parts that  contact the rider cooler, further increasing rider comfort.</p>', 0),
(18, 'STYLING', 'STYLING & CRAFTSMANSHIP', 5, 'ninja_h2_kawasaki_cambodia.jpg', '<p>Wanting to ensure a bold design worthy of a model that carried both the  &ldquo;Ninja&rdquo; and &ldquo;H2&rdquo; names, the prime styling concept chosen for the Ninja  H2 was &ldquo;Intense Force Design.&rdquo; As a flagship for the Kawasaki brand, it  required presence, and a styling that reflected its incredible  performance. But the design is much more than cosmetic. While its edged  styling certainly looks the part, the Ninja H2 also possesses a  functional beauty: each piece of its bodywork was aerodynamically  sculpted to enhance stability at high speeds; the cowling design also  maximises cooling performance and heat dissipation, aiding in achieving  the engine&rsquo;s incredible output; and the Ram Air duct is ideally  positioned to bring fresh air to the supercharger. More than any  motorcycle Kawasaki has built to date, the Ninja H2 is a showcase of  craftsmanship, build quality and superb fit and finish&mdash; right down to  the high-tech mirrored-finish black chrome paint specially developed for  this model.</p>', 0),
(19, 'SUPERCHARGED', 'SUPERCHARGED', 5, 'ninja_h2_kawasaki_cambodia(1).jpg', '<p>The supercharger used in the Ninja H2 was designed by Kawasaki  motorcycle engine designers with assistance from other companies within  the KHI Group, namely the Gas Turbine &amp; Machinery Company, Aerospace  Company, and Corporate Technology Division. Designing the supercharger  in-house allowed it to be developed to perfectly match the engine  characteristics of the Ninja H2. The highly efficient, motorcycle-  specific supercharger was the key to achieving the maximum power and the  intense acceleration that engineers wanted to offer.</p>', 0),
(20, 'HANDLING', 'HIGH-SPEED STABILITY & LIGHT HANDLING', 5, 'ninja_h2_kawasaki_cambodia(2).jpg', '<p>Designed for the performance parameters of the closed-course Ninja H2R  and shared with the street-going Ninja H2, the objectives for the  chassis were to ensure unflappable composure at ultra-high speeds, offer  cornering performance to be able to enjoy riding on a circuit, and  finally to have a highly accommodating character. Ordinarily, high-speed  stability can easily be achieved with a long wheelbase, but a shorter  wheelbase was selected to achieve the compact overall package and sharp  handling that were also desired. The frame needed not only to be stiff,  but also to be able to absorb external disturbances, which, when  encountered while riding at high speeds, could easily unsettle the  chassis. A new trellis frame provided both the strength to harness the  incredible power of the supercharged engine, and the balanced flex to  achieve the stability and pliability for high-speed riding.</p>', 0),
(21, 'INTERFACE', 'MAN-MACHINE INTERFACE', 5, 'ninja_h2_kawasaki_cambodia(3).jpg', '<p>Although the Ninja H2&rsquo;s high performance cannot be denied, since it was  not intended to be a race bike designed to turn quick lap times as  efficiently as possible, it did not need the spartan accommodation found  on most purpose-built supersport models. The man-machine interface  enables riders to enjoy the bike&rsquo;s performance with a modicum of  comfort. While the riding position, ergonomics and cockpit layout were  all designed first and foremost to put the rider in the best position to  control this amazing machine, the impression from the rider&rsquo;s  perspective is one not of austerity, but rather plush quality, high-tech  control, and an impeccable fit and finish.</p>', 0),
(22, 'POWER', 'POWER UNIT DESIGNED TO WITHSTAND THE 300 PS OUTPU', 5, 'ninja_h2_kawasaki_cambodia(4).jpg', '<p>Despite it&rsquo;s familiar In-Line Four configuration, the Ninja H2 power  unit is loaded with technology developed specifically for this  supercharged engine: some new, others with know-how from the Kawasaki  Group. Every component of the engine was chosen to achieve a certain  function. In order to accommodate the higher air pressure from the  supercharger as well as ensure a high reliability with the over 300 PS  output of the closed-course Ninja H2R, the whole engine was designed to  be able to handle stresses 1.5x to 2x greater than on a naturally  aspirated litre-class engine. In fact, aside from its camshafts, head  gaskets and clutch, the engine unit is exactly the same as the unit  designed for the Ninja H2R.</p>', 0),
(23, 'DESIGN', 'SUGOMI DESIGN', 6, 'kawasaki_z-1000_kawasaki_cambodia2.png', '<p>The new Z1000&rsquo;s sugomi design takes the mass-forward crouching concept  of its predecessor even further. A key visual component is the new  headlamp cowl which was positioned as low as possible, extending the  line running down from the top of the tank to create the image of a  crouching predator&rsquo;s muscular shoulders and dropped head. The new LED  headlamp design also borrows from the image of a predator on the hunt,  its slim shape and dark, reflector-less construction creating an  intense, glaring visage, much like a predator whose eyes have locked  onto its prey. The condensed, dynamic form is reinforced by all-new  bodywork that fits much closer to the engine and frame. As before mass  is concentrated at the front, with the light tail cowl a mere wisp, as  if drawn with the flick of a pen. The dichotomy creates a dynamic design  with all lines, and the viewer&rsquo;s eye, drawn to the front.</p>', 0),
(24, 'ENGINE', 'EXCITING ENGINE', 6, 'kawasaki_z-1000_kawasaki_cambodia2.jpg', '<p>Engine tuning focused on the feeling the rider gets when opening the  throttle. The strong torque feeling and mid-range hit of the previous  model remains, but changes made to the engine and ECU settings result in  a more direct throttle response. Combined with the shorter gearing,  acceleration feels noticeably stronger.</p>', 0),
(25, 'HEADLAMP', 'LED HEADLAMP', 6, 'kawasaki_z-1000_kawasaki_cambodia.jpg', '<p>The thin, compact headlamp cowl was positioned as low as possible,  extending the line that starts from the top of the tank. This is first  time for Kawasaki to use the reflector-less LED headlamp design. Using  LED lamps allows the design to be thin, the shape contributing to the  more intense glare of the new Z1000&rsquo;s face, and the reflector-less  design further enhances its predatory appearance. There are four  long-life, low-energy LED bulbs: two low-beam (centre), two high-beam  (outside). All four bulbs light up when the high-beams are on. A  separate LED position lamp is located on the meter cove.</p>', 0),
(26, 'BRAKES', 'BRAKES', 6, 'kawasaki_z-1000_kawasaki_cambodia2(1).png', '<p>The new Z1000 features Tokicomonobloc calipers and larger 310 mm front  petal discs. Achieving the new braking characteristics required a  redefinition of what Kawasaki&rsquo;s &ldquo;ideal&rdquo; braking for a Supernaked was to  be. The new brakes offer a stronger initial bite, and a smooth brake  force application &ndash; a perfect match for the Z1000&rsquo;s quick handling  chassis and responsive throttle.</p>', 0),
(27, 'SUSPENSION', 'SEPARATE FUNCTION FORK - BIG PISTON (SFF-BP)', 6, 'kawasaki_z-1000_kawasaki_cambodia(1).jpg', '<p>The more direct handling of the new Z1000 can be largely attributed to  its new suspension. The new SFF-BP achieves both comfort and sport  potential ideal for street riding. Combining the concepts of Showa SFF  and BPF, the new fork features springs on both sides, with preload  adjustability in the left tube and damping duties in the right tube</p>', 0),
(28, 'styling', 'Aggressive Z styling', 7, 'kawasaki_z-900_kawasaki_cambodia.jpg', '<p>Designed to make viewers fall in love at first sight, the Z900&rsquo;s  aggressive Z styling is inspired by the sugomi design of the Z1000.  &nbsp;Elegant bodywork flowing from head to tail is combined with minimalist  cover in the engine area devised to draw attention to its functional  beauty. &nbsp;A condensed appearance emphasised by slim, close-fitting  bodywork gives the bike a light, agile image that reflects its sporty  performance.</p>', 0),
(29, 'handling', 'Light weight, agile handling', 7, 'kawasaki_z-900_kawasaki_cambodia(1).jpg', '<p>Benefitting from a chassis comprised of lightweight components, the Z900  weighs in at 210.5 kg (208.5 kg for non-ABS models) &ndash; even after  clearing Euro 4. &nbsp;Its lightweight trellis frame and swingarm were the  key to the Z900&rsquo;s nimble handling.&nbsp;The Z900&rsquo;s low weight and low seat  height (794 mm) both contribute to manoeuvrability, whether walking  beside the bike, or foot peddling in a parking lot.&nbsp; The easy-to-manage  engine response and wide steering angle further facilitate low-speed  manoeuvring.</p>', 0),
(30, 'ENGINE', 'ENGINE', 7, 'kawasaki_z-900_kawasaki_cambodia(3).jpg', '<p>Powerful 948 cm3 liquid-cooled, 4-stroke In-line Four engine has a  quick-revving character and a strong mid-range hit that pulls strongly  to the redline. Adding to rider exhilaration, a distinct intake note  encourages you to twist the throttle. Silky smooth power delivery  facilitates control while contributing to rider comfort and confidence.  Power delivery is quite linear, but the engine spins up noticeably  faster from about 6,000 min<sup>-1</sup> onwards.&nbsp; Silky smooth response  from mid-high rpm ensures excellent driveability. Lightweight and  rigid, the pistons are formed using a unique casting process (similar to  forging process) that sees unnecessary material removed and hollows  created to achieve the ideal thickness (the same process used to form  the Ninja H2/H2R pistons).&nbsp; This enables a light weight on par with  forged pistons.</p>', 0),
(31, 'INSTRUMENTATION', 'INSTRUMENTATION', 7, 'kawasaki_z-900_kawasaki_cambodia(4).jpg', '<p>Stacked instrument cluster features an easy-to-read layout.  Analogue-style tachometer features a gear position indicator at its  centre and sits atop a large multi-function LCD screen. The tachometer&rsquo;s  three rider-selectable display modes add a visual element to riding  enjoyment. Hairline finish on the tachometer dial, and  carbon-fibre-style panelling contribute high-quality touches.</p>', 0),
(32, 'CHASSIS', 'CHASSIS', 7, 'kawasaki_z-900_kawasaki_cambodia(5).jpg', '<p>One of the key components to the new Z900&rsquo;s light weight (noticeable as  soon as the bike is lifted off its side-stand), the all-new frame weighs  only 13.5 kg and contributes significantly to the bike&rsquo;s light, nimble  handling.</p>', 0),
(33, 'STYLING', 'Z STYLING', 8, 'kawasaki_z-560_kawasaki_cambodia.jpg', '<p>The Z650&rsquo;s aggressive Z Supernaked styling, inspired by the <em>sugomi</em>  design of the Z1000, is tempered by its slim, light-looking package,  resulting in a head-turning design that conveys both excitement and  approachability.&nbsp; From its front cowl adorned with meter cover to its  compact tail cowl, the Z650&rsquo;s head-turning design exudes a functional  beauty.&nbsp; Inspired by the <em>sugomi</em> design of the Z1000, its  condensed appearance is emphasised by slim, close-fitting bodywork  designed to give the bike a light, nimble image that reflects its sporty  performance. Stacked instrument cluster features a large analogue-style  tachometer with a gear position indicator at its centre, sitting atop a  multi-function LCD screen. Compact, upswept tail cowl contributes to  the Z650&rsquo;s dynamic, sporty image.&nbsp; The strong Supernaked design can be  further emphasised with an accessory single-seat cover. Ensuring the  Z650 is not mistaken for anything other than Kawasaki Supernaked when  viewed from behind, its sharp LED taillight lights up in &ldquo;Z&rdquo; pattern,  contributing to the sporty image and the strong Z identity.</p>', 0),
(34, 'ENGINE', 'EXCITING PARALLEL TWIN ENGINE', 8, 'kawasaki_z-560_kawasaki_cambodia(1).jpg', '<p>Tuning of the 649 cm3 Parallel Twin engine focused on achieving a  throttle response that balanced a powerful feeling and a quick-revving  character. To optimise performance for everyday riding, care was taken  to maximise low-mid range torque. When opening the throttle, riders will  notice an extremely smooth and powerful engine character that offers  both a high level of control when making minute throttle adjustments and  a gratifying rush of acceleration in the lower rpm ranges. This tuning  also benefits fuel economy.</p>\r\n<p>&nbsp;</p>\r\n<p>Liquid-cooled, DOHC, 8-valve 649 cm3&nbsp;Parallel Twin with fuel  injection delivers smooth, responsive performance, especially in the low  and medium rpm ranges. The strong low-end focus lends itself to sporty  riding, but also translates to rider-friendly power characteristics that  facilitate control and inspire confidence in new riders.</p>', 0),
(35, 'CHASSIS', 'CHASSIS', 8, 'kawasaki_z-560_kawasaki_cambodia(2).jpg', '<p>One of the key components realising Z650&rsquo;s light weight (noticeable as  soon as the bike is lifted off its side-stand), the all-new frame weighs  only 15 kg and contributes significantly to the bike&rsquo;s light, nimble  handling.&nbsp;Kawasaki&rsquo;s new in-house analysis technology was used to  precisely determine the necessary pipe diameter, length and wall  thickness to deliver the ideal lateral and torsional rigidity.&nbsp; This  allowed unnecessary material to be trimmed, resulting in an extremely  lightweight frame: the new frame weighs only 15 kg, a key to the new  Z650&rsquo;s light, nimble handling.&nbsp;Kawasaki&rsquo;s new in-house analysis  technology was also used in the swingarm. &nbsp;Similar to the frame, the  line from the pivot to rear axle was made as straight as possible.&nbsp; The  lightweight design of swingarm (4.8 kg) contributes to the bike&rsquo;s light,  natural handling.</p>', 0),
(36, 'ERGONOMICS', 'RELAXED, SPORTY ERGONOMICS', 8, 'kawasaki_z-560_kawasaki_cambodia(3).jpg', '<p>Wide, flat handlebar and a relaxed, sporty riding position allows riders  to fully capitalise on the Z650&rsquo;s sporty street riding potential.  Thanks to the low seat height and the bike&rsquo;s slim overall design, it&rsquo;s  easy to keep both feet firmly on the ground when stopped, an important  consideration for many riders. 790 mm seat height accommodates riders  spanning a wide range of heights, enabling them to ride with confidence.</p>', 0),
(37, 'Slipper Clutch', 'Assist & Slipper Clutch', 8, 'kawasaki_z-560_kawasaki_cambodia(4).jpg', '<p>Assist &amp; Slipper Clutch was developed based on feedback from  racing activities.&nbsp; The clutch uses two types of cams (an assist cam and  a slipper cam), offering two new functions not available on a standard  clutch.</p>\r\n<p>&nbsp;</p>\r\n<p>When the engine is operating at normal rpm the assist cam functions  as a self-servo mechanism, pulling the clutch hub and operating plate  together to compress the clutch plates.&nbsp; This allows the total clutch  spring load to be reduced, resulting in a lighter clutch lever pull when  operating the clutch.</p>\r\n<p>&nbsp;</p>\r\n<p>When excessive engine braking occurs &ndash; as a result of quick  downshifts (or an accidental downshift) &ndash; the slipper cam comes into  play, forcing the clutch hub and operating plate apart.&nbsp; This relieves  pressure on the clutch plates to reduce back-torque and help prevent the  rear tyre from hopping and skidding.</p>', 0),
(38, 'DESIGN', 'Z STYLE: THE DESIGN', 9, 'z300-Kawasaki-Cambodia-08(1).jpg', '<p>Inspired by the Supernaked image of its Z Series brethren, the Z300 also features a &ldquo;mass-forward, minimalist-tail&rdquo; design. Its muscular, athletic bodywork hints at the bike&rsquo;s performance, while accentuating the engine and curved exhaust headers. Aggressive-looking whether on the move or standing still, the Z300 has a big-bike presence and an instantly recognisable silhouette that says, at-a-glance, that this is no ordinary &ldquo;naked&rdquo; bike.</p>', 0),
(39, 'BODYWORK', 'MUSCULAR BODYWORK AND HIGH-QUALITY TOUCHES', 9, 'z300-Kawasaki-Cambodia-08.jpg', '<p>Compact headlamp cowl with mini meter visor is one of the key styling elements of the Z300&rsquo;s aggressive design. Multi-reflector headlamp from the Z800 reinforces the strong family resemblance. Adding to the aggressive Supernaked design, the fuel tank is flared at the top edges and slants forward. The flared design enables a large 17 litre fuel capacity. Cruising range is on par with large-displacement models.</p>', 0),
(40, 'ENGINE', 'ENGINE', 9, 'kawasaki_z-300_kawasaki_cambodia.jpg', '<p>Designed for rider-friendly response, the Z300&rsquo;s fuel-injected Parallel  Twin engine delivers smooth, responsive torque at low and medium rpm,  and hard-hitting acceleration at high rpm. Displacing 296 cm3, the  engine offers significantly stronger torque and power at all rpm,  putting the Z300 in a class of its own. Like the Ninja 300, the engine  is fitted with a sleeveless, plated, die-cast aluminium cylinder,  lightweight coated pistons, and numerous features to ensure Kawasaki&rsquo;s  famous reliability. With the same sporty engine performance found on the  Ninja 300, one twist of the throttle will clearly distinguish the Z300  from lesser naked models.</p>', 0),
(41, 'INJECTORS', 'FINE-ATOMISING INJECTORS + DUAL THROTTLE VALVES', 9, 'kawasaki_z-300_kawasaki_cambodia(1).jpg', '<p>All Z300 models are fuel-injected. This ensures stable fuel delivery  regardless of temperature or air pressure, as well as excellent starting  characteristics. Similar to our Ninja supersport models, dual throttle  valves give precise control of intake air, resulting in linear throttle  response across the rpm range. Dual throttle valves also contribute to  high performance, good combustion efficiency, and favourable fuel  consumption. The main throttle valves are &oslash;32 mm in diameter, but  sub-throttle valves measure &oslash;40.2 mm to help flow a greater volume of  air, which allows the engine to pull strongly right to the rev limit.  Thai models are fitted with an Evaporative Emission Control System to  ensure emissions regulations are met.</p>', 0),
(42, 'CLASS', 'Z IS CLASS', 10, 'kawasaki_z-250_kawasaki_cambodia.jpg', '<p>Not to be confused with the commuters of the masses, the Z250 possesses a  level of fit and finish that sets it apart from standard naked models.  Seamlessly integrated bodywork, gorgeous high-quality paint and a high  attention to detail ensure the Z250 is equally impressive up close as it  is from afar. The Z300 retains the nimble handling character of the  Ninja 300, but a more upright riding position and wider handlebar put  the rider in the ideal position for active control, facilitating  dynamic, sporty riding. Backed by Ninja-based engine and chassis  performance, the skilled Z300 rider will dominate the urban jungle.</p>', 0),
(43, 'PERFORMANCE', 'PERFORMANCE', 10, 'kawasaki_z-250_kawasaki_cambodia(1).jpg', '<p>Nothing earns street cred like performance. With the same dominant  Parallel Twin engine and circuit-developed chassis as the new Ninja 250,  the Z250 offers a proven performance package. One twist of the throttle  will clearly distinguish the Z250 from lesser naked models, putting  pretenders firmly in your rear-view.</p>', 0),
(44, 'FUEL TANK', 'FLARED FUEL TANK', 10, 'kawasaki_z-250_kawasaki_cambodia(2).jpg', '<p>Adding to the bike&rsquo;s dynamic design, the fuel tank is flared at the top  edges and slants forward. The flared design enables a large 17-litre  fuel capacity and contributes to the superb ergonomic fit between rider  and machine.</p>', 0),
(45, 'COCKPIT', 'STREET-FIGHTER COCKPIT', 10, 'kawasaki_z-250_kawasaki_cambodia(3).jpg', '<p>The Z250&rsquo;s sporty instrument package combines a large, analogue-style  tachometer with a multi-function LCD screen. Its numerous features  include a clock, fuel gauge and dual trip meters. Amber LED backlighting  contributes to the street-fighter image and ensures clear meter  visibility at night.</p>', 0),
(46, 'STYLE', 'STYLE', 11, 'Z125-Pro-Kawasaki-Cambodia-10.jpg', '<p>In the Z125 and Z125 PRO, riders will find both the looks and quality of a much larger bike. Styling emulates the aggressive design of Kawasaki&rsquo;s other Z models, creating an eye-catching package that appears ready to launch into action even when sitting still. Compact engine shrouds contribute to the bike&rsquo;s hourglass figure as well as its overall aggressive Supernaked design. The shrouds also offer a degree of mud protection. Sporty, single headlamp design contributes to the bikes&rsquo; slim image. The multi-reflector headlamp throws a clear beam of light, facilitating night-time visibility. Instrument console combines a race analogue-style tachometer with a multi-function LCD screen.</p>', 0),
(47, 'PERFORMANCE', 'PERFORMANCE', 11, 'kawasaki_z-125_kawasaki_cambodia(1).jpg', '<p>Whether navigating city traffic or simply riding for fun, the Z125 and  Z125 PRO are sure to satisfy with their sporty engine character and  light, nimble handling chassis. A compact package adds to both  manoeuvrability and easy access, making them highly accommodating bikes  for both new riders and those with more experience. Fuel-injected 125  cm3 4-stroke Single Designed to have a sporty character, the  quick-revving engine pulls smoothly right to its redline.</p>', 0),
(48, 'FORK', 'FORK', 11, 'kawasaki_z-125_kawasaki_cambodia(2).jpg', '<p>&oslash;30 mm inverted front fork offers excellent rigidity while keeping  unsprung weight low for sporty riding potential. It features a  lightweight aluminium upper triple clamp and has a long 100 mm stroke.  Settings contribute to the Z125&rsquo;s nimble handling. The inverted fork  also contributes to sporty looks. Offset laydown rear suspension enables  a compact package while contributing to sporty handling. The linkage  ratios and shock&rsquo;s mounting angle were optimised for this model to  ensure superb shock action and excellent ride comfort.</p>', 0),
(49, 'WHEEL', '12” CAST WHEELS & ROAD TYRES', 11, 'kawasaki_z-125_kawasaki_cambodia(3).jpg', '<p>Cast wheels with road tyres offering good grip in dry and wet conditions  not only give the Z125 the look of larger-displacement Supernaked  models, the combination contributes to a balance of light, sporty  handling and reassuring stability.</p>', 0),
(50, 'CHASSIS', 'COMPACT CHASSIS', 11, 'kawasaki_z-125_kawasaki_cambodia(4).jpg', '<p>The compact chassis, along with sporty suspension and tyres, enables  riders to enjoy the light, nimble handling one would expect from a  Supernaked model. Frame pipe diameter ensures sufficient strength to  enable tandem riding. &oslash;48.6 mm backbone pipe is supported by &oslash;25.4 mm  lateral pipes; rear frame pipes are &oslash;22.2 mm.</p>', 0),
(51, 'styling', 'Racy MX styling', 12, 'kawasaki_klx-150_kawasaki_cambodia.jpg', '<p>Styling inspired by KX motocross racers gives the bike&rsquo;s aggressive,  sporty looks that reflect their off-road potential. The racy styling of  the new KLX150BF and KLX150 was inspired by the design of Kawasaki&rsquo;s KX  motocrossers, and in particular the KX450F. Their more aggressive design  is a reflection of their off-road prowess.</p>', 0),
(52, 'CHASSIS', 'LIGHTWEIGHT CHASSIS', 12, 'kawasaki_klx-150_kawasaki_cambodia(1).jpg', '<p>With the highly rigid perimeter frame of the KLX150L, plus updated  suspension settings (including an inverted fork for the KLX150BF), and  new brake discs (and pads for the KLX150), the KLX150BF and KLX150 offer  greater off-road performance for all-day bush rides. Both models also  deliver increased off-road riding comfort and reliability.</p>', 0),
(53, 'ENGINE', 'ENGINE', 12, 'kawasaki_klx-150_kawasaki_cambodia(2).jpg', '<p>The 4-stroke air-cooled single cylinder engine offers a lightweight  power plant with both reliability and strong performance. 5-speed  transmission ensures there is a gear for every situation, enabling quick  pick-up when accelerating from a stop, and relaxed cruising ability  when riding at higher speeds. 5-plate clutch uses three different types  of friction plates to ensure durability while reducing clutch noise.  Electric starter ensures quick, hassle-free starting. A kick starter is  also featured, providing a reliable back-up should battery power be low.</p>', 0),
(54, 'Wheels & Tyres', 'Wheels & Tyres', 12, 'kawasaki_klx-150_kawasaki_cambodia(3).jpg', '<p>All-round tyres offer excellent off-road traction as well as good on-road performance to allow riders to reach remote trails.</p>', 0),
(55, 'Suspension', 'Suspension', 12, 'kawasaki_klx-150_kawasaki_cambodia(4).jpg', '<p>Combined with the highly rigid frame, highly capable suspension ensures  excellent handling and feedback. On the KLX150, a &oslash;33 mm telescopic  front fork with 175 mm of wheel travel contributes to controllability  even on rough terrain. Revised settings help reduce bottoming when  riding off-road.</p>', 0),
(56, 'BODYWORK', 'Bodywork', 12, 'kawasaki_klx-150_kawasaki_cambodia(5).jpg', '<p>Radiator shrouds feature a two-piece design. Their minimalist design  means they are small and are slim where they come in contact with the  rider&rsquo;s legs. KX-inspired two-tone seat contributes to racy looks and  adds a high-quality image. Together with the shrouds, its pattern  creates a line that flows from the front to the rear of the bike.  Aggressive taillight design complements the bikes&rsquo; racy image. The long  rear flap integrates the rear turn signals for a compact, tidy design.</p>', 0),
(57, 'STYLING', 'SHARP SUPERMOTO STYLING', 13, 'kawasaki_d-tracker-150_kawasaki_cambodia.jpg', '<p>Complementing its new 17&rdquo; wheels, sharp new styling gives the D-Tracker  serious supermoto looks. The aggressive design is a reflection of the  bike&rsquo;s increased performance. Sharp new headlamp design features a 35/35  W halogen bulb. A new meter visor contributes to the aggressive looks.  Sharp front fender contributes to the bike&rsquo;s aggressive, sporty looks.  Radiator shrouds feature a two-piece design. And Aggressive taillight  design complements the bike&rsquo;s racy image. The long rear flap integrates  the rear turn signals for a compact, tidy design.</p>', 0),
(58, 'ENGINE', 'ENGINE', 13, 'kawasaki_d-tracker-150_kawasaki_cambodia(1).jpg', '<p>144 CM3 AIR-COOLED, 4-STROKE SINGLE The simple, air-cooled  single-cylinder engine offers an easy-to-use and highly reliable power  plant. Longer gearing results in engine performance focused in the  mid-high range, offering a sportier engine character. Response is quick,  and once in the high-rpm range the engine continues to pull strongly.  Electric start ensures starting is as easy as a quick push of the  button.</p>', 0),
(59, 'WHEELS', 'WHEELS', 13, 'kawasaki_d-tracker-150_kawasaki_cambodia(2).jpg', '<p>With the same highly rigid perimeter frame as the KLX150BF, new  larger-diameter wheels and a larger-diameter front brake, the D-Tracker  boasts increased stability and bump absorption performance along with  its full-size supermoto looks. Larger-diameter wheels (14&rdquo; &gt;&gt; 17&rdquo;)  contribute to increased straight-line stability. They are also better  able to handle obstacles and rough sections of road that riders may  encounter.</p>', 0),
(60, 'SUSPENSION', 'SUSPENSION', 13, 'kawasaki_d-tracker-150_kawasaki_cambodia(3).jpg', '<p>Combined with the highly rigid frame, highly capable suspension ensures  excellent handling and feedback. Long travel allows riders to actively  use pitching motion as part of the controlling the bike. Single rear  shock absorber with pressurised nitrogen gas is 5-way adjustable for  preload, allowing riders to set the bike up for their weight.  Large-diameter 17&rdquo; front and rear wheels with road tyres contribute to  increased straight-line stability and full-size supermoto looks. Rims  are aluminium to help minimise unsprung weight.</p>', 0),
(61, 'BRAKES', 'BRAKES', 13, 'kawasaki_d-tracker-150_kawasaki_cambodia(4).jpg', '<p>Larger-diameter brake offers increased stopping power and excellent  controllability. Petal discs front and rear contribute to the sharp,  sporty image. Petal disc brakes front and rear, just like Kawasaki&rsquo;s  high-performance models, contribute to strong braking performance. A  semi-floating &oslash;300 mm front disc gripped by a twin-piston caliper offers  strong, easy-to-control braking. Slowing the rear, a single-piston  caliper operates a &oslash;220 mm disc.</p>', 0),
(62, 'STYLING', 'HIGH-CLASS & FUTURISTIC', 14, 'styling400.jpg', '<p>Head-turning looks have always been a forte of Ninja models, regardless of displacement. The new Ninja 400 boasts futuristic new Ninja styling inspired by the mighty Ninja H2. The large-volume bodywork attracts attention, and gives the impression of a larger machine. This impression is reinforced by the high-class design and superb fit and finish, which are comparable to bikes from a larger-displacement class.In addition to contributing to the Ninja 400&rsquo;s sharper looks, slim LED headlamps (each featuring low and high beams, as well as a LED position lamp) are highly visible and offer significantly increased brightness.</p>', 0),
(63, 'ENGINE', 'HIGH PERFORMANCE & HIGH CONTROLLABILITY', 14, 'nn400.jpg', '<p>Displacing 399 cm3, the new engine delivers significantly increased performance compared to its predecessor: 33.4 kW for the Ninja 400 The higher performance can largely be credited to the new downdraft intake, which is accompanied by a larger airbox offering increased intake efficiency. The increased&nbsp;performance is complemented by a rider-friendly character; the smooth response and abundant low-end torque facilitate throttle control for new and experienced riders alike.</p>', 0),
(64, 'CLUTCH', 'NEW ASSIST & SLIPPER CLUTCH', 14, 'ninja400-feature-clutch.jpg', '<p>More compact clutch (&oslash;139 mm &gt;&gt; &oslash;125 mm) with less rigid operating plates offers a 20% lighter lever pull. Complementing the extremely light feel at the lever, the new clutch has a wider engagement range, facilitating control.</p>', 0),
(65, 'FRONT FORK', 'MORE RIGID FRONT FORK', 14, 'FRONFORK.jpg', '<p>More rigid &oslash;41 mm telescopic fork delivers better suspension action. The front wheel feels really planted, direction changes are made easily (even when the bike is fairly upright &ndash; handy when navigating traffic jams), and overall the suspension offers the plushness of a larger displacement bike.</p>', 0),
(66, 'COCKPIT', 'HIGH-GRADE COCKPIT', 14, 'ninja400-feature-cockpit.jpg', '<p>The Ninja 400 is equipped with the same instrument cluster as the Ninja 650, contributing to the high-grade feel of the tidy cockpit. The sophisticated instrument design features a large analogue tachometer flanked by warning lamps on one side, and a gear position indicator and multi-function LCD screen on the other.</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `form_request`
--

CREATE TABLE `form_request` (
  `fr_id` int(11) NOT NULL,
  `fullname` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `date_submit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `home_slide`
--

CREATE TABLE `home_slide` (
  `sid` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkto` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Display, 0 = Hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_slide`
--

INSERT INTO `home_slide` (`sid`, `name`, `image`, `linkto`, `s_order`, `status`) VALUES
(7, 'z1000, Kawasaki Cambodia', 'kawasaki-cambodia-z1000-2018.jpg', NULL, 0, 1),
(5, 'Kawasaki ninja 400 2018 , Kawasaki Cambodia', 'kawasaki_cambodia_motorcycle_cambodia.png', NULL, 0, 1),
(6, 'Kawasaki cambodia, ninja 400 2018', 'kawasaki_ninja400_kawasak-cambodia.png', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_year` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_price` float NOT NULL,
  `down_payment` float DEFAULT NULL,
  `loan_term` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `other` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `bank_id`, `model_id`, `model_year`, `full_price`, `down_payment`, `loan_term`, `name`, `email`, `phone`, `other`, `create_at`) VALUES
(1, 1, 1, '2017', 4000, 10, '6 Months', 'sreyleak', 'sreyela@gmail.com', '069979838', 'test', '2018-01-19 02:37:45'),
(2, 1, 1, '2017', 4000, 20, '18 Months', 'sreyleak', 'sreyela@gmail.com', '069979838', 'test', '2018-01-19 02:47:10'),
(3, 1, 5, '2016', 4200, 50, '12 Months', 'sreyleak', 'sreyela@gmail.com', '069979838', 'test', '2018-01-19 02:52:38');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `model_id` int(11) NOT NULL,
  `is_feature` tinyint(1) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `model_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `displacement` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_logo` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_year` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `icon_menu` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_image` varchar(150) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `youtube_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `m_order` tinyint(4) NOT NULL DEFAULT '0',
  `seo_description` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keyword` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`model_id`, `is_feature`, `is_available`, `model_name`, `displacement`, `url_slug`, `model_logo`, `model_year`, `price`, `icon_menu`, `thumbnail`, `full_image`, `description`, `youtube_url`, `category_id`, `m_order`, `seo_description`, `seo_keyword`, `status`) VALUES
(1, 1, 0, 'NINJA® 1000 ABS', '1,043 cc', 'kawasaki-ninja-1000', 'ninja1000.png', '2018', 4000, 'NINJA-1000-01.png', 'NINJA-1000-Cambodia-03.png', NULL, '<div class="kw-product-color-head">Refined sport tourer with advanced electronics offers dream combination: Ninja + Touring continues to offer the comfort and convenience to enable sport riding enthusiasts to take their seductively styled machines touring. Complementing the even smoother power delivery and extremely composed handling, the new model features increased touring performance care of improved wind protection, greater comfort and the clean-mount pannier system. All-new Ninja family styling deepens its sporty image. And loaded with the latest electronics technology that Kawasaki has to offer, the new Ninja 1000 is even better equipped to meet a wide range of rider needs.</div>', NULL, 1, 7, 'Refined sport tourer with advanced electronics offers dream combination: Ninja + Touring continues to offer the comfort and convenience to enable sport ridi', 'Ninja 1000 2018, Kawasaki Ninja 1000, Ninja 650 2017, motorcycle phnom penh, kawasaki cambodia, Motorcycle in Cambodia, motor for sell in cambodia, Scoopy 2018', 1),
(2, 1, 1, 'NINJA® 650 ABS', '649 cc', 'kawasaki-ninja-650', 'ninja650(2).png', '2018', 5000, 'Ninja-650.png', 'Ninja-650-cambodia.png', NULL, '<p>Superbly balanced and extremely exciting, the new Ninja 650 features a 600cc Parallel Twin engine with a strong low-mid range focus and a remarkably lightweight chassis in a slim, middleweight package. Supersport-like nimble handling, direct feel and strong acceleration are complemented by easy-to-manage power delivery and rider-friendly manoeuvrability, offering an ideal blend of sporty performance and everyday versatility sure to satisfy everyone from new to more experienced riders. Sharp styling strengthens its Ninja family image, reflecting its highly evocative character.</p>', NULL, 1, 5, 'Ninja 650 features a 600cc Parallel Twin engine with a strong low-mid range focus and a remarkably lightweight chassis in a slim, middleweight package', 'Ninja 650 2018, Kawasaki Ninja 650, Ninja 650 2017, motor shop in phnom penh, kawasaki ninja cambodia, Motorcycle in Cambodia, motor for sell in cambodia', 1),
(3, 1, 1, 'NINJA® 300 ABS', '296 cc', 'kawasaki-NINJA-300-ABS', 'ninja300(1).png', '2017', 4500, 'NINJA-300-ABS-01.png', 'NINJA-300-ABS-02.png', NULL, '<p>Like its predecessor, the new Ninja 300 has styling that would not be out of place on our larger-displacement Ninja supersport models. Just like the other machines in the Ninja series, it features a sporty new &ldquo;mass-forward, minimalist-tail&rdquo; design. From its aggressive new dual headlights to its new screen and wheels, the new Ninja 300 shares numerous styling cues and design elements from other machines in the Ninja family. One look tells you that this bike is pure Ninja.</p>', NULL, 1, 1, 'Ninja 300 has styling that would not be out of place on our larger-displacement Ninja supersport models.', 'Ninja 300 2018, Kawasaki Ninja, kawasaki price in cambodia, motor shop in phnom penh, kawasaki ninja, Motorcycle in Cambodia, second hand motor cambodia', 1),
(4, 1, 1, 'Ninja 250SL ABS', NULL, 'kawasaki-ninja-250sl-abs', 'call-png-image-77414.png', '2018', 5320, 'ninja_250.png', 'ninja_250.png', 'kwcv_ninja250sl.jpg', '<p>New Ninja 250SL WSB Edition is styled like a race-winning Kawasaki Superbike with custom graphics and special features such as distinctive green wheel rim tapes.</p>', NULL, 1, 6, NULL, NULL, 0),
(5, 1, 0, 'NINJA H2™', '998 cc', 'kawasaki-ninja-h2', NULL, '2016', 4200, 'Ninja-H2.png', 'ninja_h2(1).png', 'kwcv_ninjah2.jpg', '<p>The launching point for the development of the Ninja H2 was a strong desire to offer riders something they had never before experienced.Convinced that a truly extraordinary riding experience would not be found on a motorcycle that merely built on the performance of existingmodels, the design team committed to developing the &ldquo;ultimate&rdquo; motorcycle from a clean slate. The bike needed to deliver intense acceleration and an ultra-high top speed, coupled with supersport-level circuit performance. To realise this goal, help was enlisted from other companies in the Kawasaki Heavy Industries (KHI) Group, precipitating an unprecedented level of inter-company collaboration.</p>', NULL, 6, 3, 'Official info for the 2016 NINJA H2™ - specs, photos, reviews.  Find NINJA H2 at Kawasaki Camboida.', 'Ninja H2 2016, Ninja H2 Cambodia, Kawasaki Ninja H2, kawasaki ninja h2 price, Motorcycle in Phnom Penh, Motorcyle shop in cambodia', 1),
(6, 1, 1, 'Z 1000', '1,043 cc', 'kawasaki-z1000', 'z1000(2).png', '2018', 12000, 'z-1000-kawasaki-cambodia-02.png', 'z-1000-kawasaki-cambodia-04.png', 'kwcv_z1000.jpg', '<p>In a significant departure from the concealing plastic bodywork of its predecessor, the new Z1000 strips off all unnecessary flourishes to boldly highlight the functionality of its parts. The sculpted bodywork was carefully crafted to bring the aggressive Z design to the next level. But the changes to the new Z1000 are more than skin deep. Kawasaki engineers were also determined to further enhance the riding impact offered by the dynamic Supernaked. The new engine and chassis settings deliver a stiffer, more direct ride feel sure to please experienced riders. This significant step forward, in both looks and feel, transforms the Z1000 into the market&rsquo;s most radical Supernaked. Its appearance and performance can be expressed by the word sugomi</p>', NULL, 2, 8, 'In a significant departure from the concealing plastic bodywork of its predecessor, the new Z1000 strips off all unnecessary flourishes to boldly highlight', 'z 1000,2018 z1000, z 900 2018, kawasaki z1000, z1000 motors second hand, motorcyle second hand, second hand motorcyle, motor shop in phnom penh, motorcyle price', 1),
(7, 1, 1, 'Z900 ABS', '948 cc', 'kawasaki-z-900', NULL, '2018', 0, 'Z900-Kawasaki-Cambodia-01.png', 'Z900-Kawasaki-Cambodia-02.png', 'kwcv_z900.jpg', '<p>For over four decades riders who know have relied on Z to deliver the thrill of motorcycling at its most intense and elemental. The no-compromise spirit of Z continues to evolve undiminished in every supernaked Z.<br />\r\nKawasaki Z, Refined Raw.</p>', NULL, 2, 7, 'For over four decades riders who know have relied on Z to deliver the thrill of motorcycling at its most intense and elemental. The no-compromise spirit of', 'z 900,2018 z900, z 900 2018, kawasaki z900, z900 motors second hand, motorcyle second hand, second hand motorcyle, motor shop in phnom penh, motorcyle price in', 1),
(8, 1, 1, 'Z650 ABS', '649 cc', 'kawasaki-z-650', 'z650(1).png', '2018', 0, 'Z650-Kawasaki-Cambodia-01.png', 'Z650-Kawasaki-Cambodia-02.png', NULL, '<p>The Z650&rsquo;s aggressive Z Supernaked styling, inspired by the sugomi design of the Z1000, is tempered by its slim, light-looking package, resulting in a head-turning design that conveys both excitement and approachability.</p>', NULL, 2, 6, 'The Z650’s aggressive Z Supernaked styling, inspired by the sugomi design of the Z1000, is tempered by its slim, light-looking package, resulting in a head-', 'z 650, z 650 2018, kawasaki z650, z650 motors second hand, motorcyle second hand, second hand motorcyle, motor shop in phnom penh', 1),
(9, 1, 1, 'Z 300', '296 cc', 'kawasaki-z-300', 'z300(9).png', '2018', 0, 'Z-300-kawasaki-cambodia-01.png', 'z-300-kawasaki-cambodia-05.png', 'kwcv_z300.jpg', '<p>The Z300, the latest addition to the Z Series line-up, is a stylish entry-level model for Europe, or a larger-displacement alternative to the Z250. Its aggressive Supernaked design is inspired by larger models from the popular Z Series, the Z1000 and Z800. Muscular bodywork hints at the bike&rsquo;s performance, while ensuring that the Z300 stands out from the crowd. And the superb level of fit and finish further separates it from ordinary &ldquo;naked&rdquo; models. Sharing the high-performance engine and chassis of the acclaimed Ninja 300, the Z300 offers the acceleration and handling to dominate the 250cc class. Its powerful 296 cm3 Parallel Twin engine and circuit-developed frame deliver a high level of riding excitement. Coupled with a relaxed, upright riding position and wide handlebar enabling active rider control, urban riding excitement increases exponentially. In both looks and performance, the Z300 has what it takes to get noticed.</p>', NULL, 2, 5, 'The Z300, the latest addition to the Z Series line-up, is a stylish entry-level model for Europe, or a larger-displacement alternative to the Z250', 'z 300, z 300 2018, kawasaki z 300, kawasaki motors in cambodia, motorcyle second hand, second hand motorcyle', 1),
(10, 1, 1, 'Z 250', '249 cc', 'kawasaki-z-250', 'z250(3).png', '2018', 0, 'z-250-kawasaki-motor-cambodia-01.png', 'z-250-kawasaki-cambodia-06.png', 'kwcv_z250.jpg', '<p>In the hustle and bustle of the city, just getting to next light can seem like all-out war. Vying for position, being the first through that hole between the four-wheeled cages, leaving rivals behind&hellip; Surviving in the combative city arena requires power, agility and the confidence that comes from total control. To stand out among the urban gladiators, Kawasaki offers the first 250cc street-fighter: the Z250. Where supersport models were designed to rule on the circuit, street-fighters are urban assault vehicles. The Z250 combines Ninja-based performance, bodywork paired down to aggressive essentials, and a rider interface designed to maximise rider control while deftly navigating through city traffic: the ideal package for both getting noticed and thriving in the concrete jungle. Let the repli-racer boys have their trackdays &ndash; when it comes to urban domination, the streets belong to Z.</p>', NULL, 2, 4, 'Z250 In the hustle and bustle of the city, just getting to next light can seem like all-out war. Vying for position, being the first through that hole betwe', 'Z,Z250,Z250 : METALLIC SPARK BLACK ,Z250 : GRAY,Z250 : METALLIC SPARK ORANGE,CLASS,PERFORMANCE,FAN COVER,FUEL TANK,COCKPIT', 1),
(11, 1, 1, 'Z125 PRO', '125 cc', 'kawasaki-z-125-pro', 'z125(5).png', '2018', 0, 'Z125-Pro-Kawasaki-Cambodia-01.png', 'Z125-Pro-Kawasaki-Cambodia-02.png', NULL, '<p>The Z125 PRO are Kawasaki&rsquo;s nimblest Supernaked models to date. Ideal for navigating the urban jungle, they come equipped with features like an inverted front fork, offset laydown rear suspension, and front and rear petal disc brakes &ndash; a clear indication of the high level of riding performance intended for these models. Two variations offer riders a choice of manual clutch (Z125 PRO). Both models have aggressive styling worthy of the &ldquo;Z&rdquo; name, reflecting their sharp, sporty performance. The Z125 PRO offer an exciting taste of the Z world.</p>', NULL, 2, 1, 'Official info for the 2018 Z125 PRO KRT EDITION', 'motorcycle for sale,  Z,Z250,Z250 : METALLIC SPARK BLACK ,Z250 : GRAY,Z250 : METALLIC SPARK', 1),
(12, 1, 1, 'KLX 150', '144 cc', 'kawasaki-klx-150', 'klx.png', '2018', 0, 'KLX-150.png', 'klx-150-2018-kawasaki-cambodia.png', 'kwcv_klx150.jpg', '<p>The new KLX150, successors to the KLX150L and KLX150 respectively, offer riders serious off-road performance for riding in the jungle and on other off-road trails. A simple, yet reliable air-cooled single-cylinder engine and highly rigid, box-section perimeter frame are complemented by large-diameter wheels. Riders have two wheel sizes to choose from. The KLX150 uses 19&rdquo; front and 16&rdquo; rear to overcome obstacles encountered on the trail.</p>', NULL, 4, 0, 'The new KLX150, successors to the KLX150L and KLX150 respectively, offer riders serious off-road performance for riding in the jungle and on other off-road', 'KLX 150, KLX150 , KLX-150 2018, 2017 KLX 150, Kawasaki KLX, Motors Phnom Penh, Khmer motors, Motor shop in cambodia', 1),
(13, 1, 1, 'D-TRACKER 150', '144 cc', 'kawasaki-d-tracker-150', 'd-tracker.png', '2018', 5000, 'D-Tracker-150-cambodia.png', 'd-tracker-150-motorcyle-cambodia.png', 'kwcv_dtracker150.jpg', '<p>A full sized machine boasting 17inch wheels, with a refined and sturdy single cylinder air-cooled and engine and advanced perimeter style frame, the D-Tracker represents a stylish, practical ergonomic package ready for any type of road.</p>\r\n\r\n<p>&nbsp;</p>', NULL, 5, 0, 'A full sized machine boasting 17inch wheels, with a refined and sturdy single cylinder air-cooled and engine and advanced perimeter style frame, the D-Track', 'D-Tracker 150, DTracker150 , D-Tracker-150 2018, 2017 D-Tracker 150, Kawasaki D-Tracker, Motors Phnom Penh, Khmer motors, Motor shop in cambodia', 1),
(14, 1, 1, 'NINJA® 400 KRT EDITION', '399 cc', 'kawasaki-ninja-400', NULL, '2018', 0, 'Ninja-400-Kawasaki-Cambodia.png', 'Ninja-400-Kawasaki-Cambodia-01.png', 'kawasaki_ninja400_kawasak-cambodia.png', '<p>Kawasaki proudly introduces a new sport model into this highly competitive arena. Clad in sharp new Ninja styling, the new Ninja 400 delivers greater performance than its predecessor care of all-new engine and chassis that are more powerful and significantly lighter. But like the Ninja 300 that preceded it, this new Ninja model possesses much more than high performance. Not only does the Ninja 400 offer stunning, high-quality looks, its stronger engine performance, light, predictable handling and relaxed, sporty riding position make it both fun and easy to ride.</p>', NULL, 1, 4, 'Ninja 400 delivers greater performance than its predecessor care of all-new engine and chassis that are more powerful and significantly lighter', 'Ninja 400 , kawasaki cambodia price, motor shop in phnom penh, Kawasaki Motors Cambodia, Motorcycle in Cambodia, second hand motor cambodia', 1),
(15, 0, 0, 'NINJA H2 SX', '998cc', 'Ninja-h2-sx', '18ZX1002A_40RGY1DRS3CG_A.png', '2018', 0, '18ZX1002A_40RGY1DRS3CG_A.png', 'Ninja-h2.png', NULL, NULL, NULL, 6, 1, NULL, NULL, 1),
(16, 0, 0, 'NINJA H2™ SX SE', '998cc', 'Ninja-H2-SX-SE', NULL, '2018', 0, 'Ninja-SX-SE.png', 'Ninja-SX-SE_thumbnail.png', NULL, NULL, NULL, 6, 2, NULL, NULL, 1),
(17, 0, 0, 'NINJA® 650 ABS KRT EDITION', '649cc', 'NINJA650-ABS-KRT', NULL, '2018', 0, 'Ninja-650-ABS-KRT-Edition-Cambodia-02.png', 'Ninja-650-ABS-KRT-Edition-Cambodia-01.png', NULL, NULL, NULL, 1, 6, NULL, NULL, 1),
(18, 0, 1, 'Z125 PRO KRT EDITION', '125 cc', 'Z125-PRO-KRT-EDITION', NULL, '2018', 0, 'Z125-Pro-Kawasaki-Cambodia-11.png', 'Z125-Pro-Kawasaki-Cambodia-12.png', NULL, NULL, NULL, 2, 2, NULL, NULL, 1),
(19, 0, 1, 'Z125 PRO SE', '125 cc', 'Z125-PRO-SE', NULL, '2018', 0, 'Z125-Pro-SE-Kawasaki-Cambodia-16.png', 'Z125-Pro-Kawasaki-Cambodia-15.png', NULL, NULL, NULL, 2, 3, NULL, NULL, 1),
(20, 0, 1, 'NINJA® 400 ABS', '399cc', 'Ninja-400-ABS', NULL, '2018', 0, 'Ninja-400-kawasaki-motors-cambodia-01.png', 'Ninja-400-kawasaki-motors-cambodia-02.png', NULL, NULL, NULL, 1, 3, NULL, NULL, 1),
(21, 0, 1, 'NINJA® 300 ABS KRT EDITION', '296cc', 'Ninja-300-abs-krt', NULL, '2017', 0, 'NINJA-300-ABS-KRT-01.png', 'NINJA-300-ABS-KRT-02.png', NULL, NULL, NULL, 1, 2, NULL, NULL, 1),
(22, 0, 0, 'KLX®110', '112cc', 'KLX-110-2019', NULL, '2019', 0, 'KLX-110-Kawasaki-Motors-Cambodia.png', 'KLX-110-Kawasaki-Motors-Cambodia-02.png', NULL, NULL, NULL, 4, 1, NULL, NULL, 1),
(23, 0, 0, 'KLX®140', '144cc', 'KLX-140-2019', NULL, '2019', 0, 'KLX-140-kawasaki-motors-cambodia-01.png', 'KLX-140-kawasaki-motors-cambodia-02.png', NULL, NULL, NULL, 4, 2, NULL, NULL, 1),
(24, 0, 0, 'KLX®140L', '144cc', 'KLX-140L-2019', NULL, '2019', 0, 'KLX-140-L-kawasaki-motors-cambodia-01.png', 'KLX-140-L-kawasaki-motors-cambodia-02.png', NULL, NULL, NULL, 4, 3, NULL, NULL, 1),
(25, 0, 0, 'KLX®140G', NULL, 'KLX-140G-2019', NULL, '2019', 0, 'KLX-140-G-kawasaki-motors-cambodia-01.png', 'KLX-140-G-kawasaki-motors-cambodia-03.png', NULL, NULL, NULL, 4, 4, NULL, NULL, 1),
(26, 0, 0, 'KX™65', '64cc', 'KX-65-2019', NULL, '2019', 0, 'KX-65-Kawasaki-Cambodia-01.png', 'KX-65-Kawasaki-Cambodia-02.png', NULL, NULL, NULL, 7, 0, NULL, NULL, 1),
(27, 0, 0, 'KX™85', NULL, 'KX-85-2019', NULL, '2019', 0, 'KX-85-Kawasaki-Cambodia-01.png', 'KX-85-Kawasaki-Cambodia-02.png', NULL, NULL, NULL, 7, 0, NULL, NULL, 1),
(28, 0, 0, 'KX™100', '99cc', 'KX-100-2019', NULL, '2019', 0, 'KX-100-Kawasaki-Cambodia-01.png', 'KX-100-Kawasaki-Cambodia-02.png', NULL, NULL, NULL, 7, 0, NULL, NULL, 1),
(29, 0, 0, 'KX™250', '249cc', 'KX-250-2019', NULL, '2019', 0, 'KX-250-Kawasaki-Cambodia-01.png', 'KX-250-Kawasaki-Cambodia-02.png', NULL, NULL, NULL, 7, 0, NULL, NULL, 1),
(30, 0, 0, 'KX™450', '449cc', 'KX-450-2019', NULL, '2019', 0, 'KX-450-Kawasaki-Cambodia-01.png', 'KX-450-Kawasaki-Cambodia-02.png', NULL, NULL, NULL, 7, 0, NULL, NULL, 1),
(31, 0, 0, 'NINJA H2™ CARBON', '998cc', 'NINJA-H2-CARBON', NULL, '2018', 0, 'NINJA-H2-CARBON.png', 'NINJA-H2-CARBON-02.png', NULL, NULL, NULL, 6, 4, NULL, NULL, 1),
(32, 0, 0, 'NINJA H2™R', '998cc', '2018-Ninja-H2R', NULL, '2018', 0, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-01.png', 'NINJA-H2-R-Kawasaki-Motors-Cambodia-02.png', NULL, NULL, NULL, 6, 5, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_category`
--

CREATE TABLE `model_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `c_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_category`
--

INSERT INTO `model_category` (`category_id`, `category_name`, `c_order`, `status`) VALUES
(1, 'SPORT', 1, 1),
(2, 'Z', 3, 1),
(3, 'KSR', 0, 0),
(4, 'OFF-ROAD', 4, 1),
(5, 'D-TRACKER', 5, 1),
(6, 'NINJA H2', 2, 1),
(7, 'MOTOCROSS', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_color`
--

CREATE TABLE `model_color` (
  `mc_id` int(11) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `color_code` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_order` tinyint(4) NOT NULL DEFAULT '0',
  `m_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_color`
--

INSERT INTO `model_color` (`mc_id`, `image`, `model_id`, `color_code`, `m_order`, `m_status`) VALUES
(36, 'NINJA-1000-Cambodia-04.jpg', 1, '#000000', 2, 1),
(2, 'NINJA-1000-Cambodia-05.jpg', 1, '#bac1b8', 0, 1),
(39, 'Ninja-650-ABS-Cambodia.jpg', 2, '#0429ce', 0, 1),
(40, 'Ninja-650-ABS-Cambodia_01.jpg', 2, '#666666', 0, 1),
(5, 'Ninja-300-kawasaki-motors-cambodia-03.jpg', 3, '#FFFFFF', 0, 1),
(6, 'Ninja-300-kawasaki-motors-cambodia-02.jpg', 3, '#1A4D9E', 0, 1),
(7, 'kawasaki_ninja_250.jpg', 4, '#A0988D', 0, 1),
(8, 'kawasaki_ninja_250(1).jpg', 4, '#56B801', 0, 1),
(9, 'kawasaki_ninja_h2.jpg', 5, '#616C72', 0, 1),
(10, 'kawasaki_ninja_h2(1).jpg', 5, '#616C72', 0, 1),
(11, 'kawasaki_z-1000.jpg', 6, '#303030', 0, 1),
(12, 'kawasaki_z-1000(1).jpg', 6, '#5C676D', 0, 1),
(13, 'Z900-Kawasaki-Cambodia-04.jpg', 7, '#737E84', 0, 1),
(14, 'Z900-Kawasaki-Cambodia-06.jpg', 7, '#000000', 0, 1),
(15, 'Z900-Kawasaki-Cambodia-05.jpg', 7, '#E13131', 0, 1),
(16, 'kawasaki_z-650.jpg', 8, '#DBDBDB', 0, 0),
(17, 'kawasaki_z-650(1).jpg', 8, '#5CBA3E', 0, 0),
(20, 'z300-Kawasaki-Cambodia-02.jpg', 9, '#5F6A70', 0, 1),
(21, 'z300-Kawasaki-Cambodia-01.jpg', 9, '#576268', 0, 1),
(54, 'KLX-110-Kawasaki-Motors-Cambodia-03.jpg', 22, '#29A93A', 0, 1),
(53, 'z250-black-01.jpg', 10, '#000000', 0, 1),
(26, 'kawasaki_z-125.jpg', 11, '#006FB1', 0, 0),
(27, 'kawasaki_z-125(1).jpg', 11, '#35A100', 0, 0),
(28, 'kawasaki_z-125(2).jpg', 11, '#5F6A70', 0, 0),
(29, 'kawasaki_z-125(3).jpg', 11, '#E74F0E', 0, 0),
(30, 'kawasaki_z-125(4).jpg', 11, '#57B600', 0, 0),
(31, 'kawasaki_klx-150.jpg', 12, '#313131', 0, 1),
(32, 'kw-product-color-2-1(2).jpg', 13, '#BAAD2A', 0, 1),
(33, 'kw-product-color-1-1(1).jpg', 13, '#4DA300', 0, 1),
(34, 'ninja400-green-01.jpg', 14, '#66cc33', 0, 1),
(35, 'ninja400-green-03.jpg', 14, '#66cc33', 0, 1),
(37, 'Ninja-H2-SX.jpg', 15, 'black', 0, 1),
(38, 'Ninja-H2-SX_02.jpg', 15, 'black', 0, 1),
(41, 'Ninja-650-ABS-KRT-Edition-Cambodia-03.png', 17, '#6c3', 0, 1),
(42, 'Z125-Pro-Kawasaki-Cambodia-04.jpg', 11, '#5B6254', 0, 1),
(43, 'Z125-Pro-Kawasaki-Cambodia-05.jpg', 11, '#BB292A', 0, 1),
(44, 'Z125-Pro-Kawasaki-Cambodia-06.jpg', 11, '#000000', 0, 1),
(45, 'Z125-Pro-Kawasaki-Cambodia-13.jpg', 18, '#69AD24', 0, 1),
(46, 'Z125-Pro-Kawasaki-Cambodia-17.jpg', 19, '#0266B1', 0, 1),
(47, 'Z650-Kawasaki-Cambodia-03.jpg', 8, '#000000', 0, 1),
(48, 'Z650-Kawasaki-Cambodia-04.jpg', 8, '#4A4E3D', 0, 1),
(49, 'Ninja-400-kawasaki-motors-cambodia-03.jpg', 20, '#ED9100', 0, 1),
(50, 'Ninja-400-kawasaki-motors-cambodia-04.jpg', 20, '#004D9D', 0, 1),
(51, 'Ninja-400-kawasaki-motors-cambodia-05.jpg', 20, '#000000', 0, 1),
(52, 'NINJA-300-ABS-KRT-04.jpg', 21, '#70B21C', 0, 1),
(55, 'KLX-140-kawasaki-motors-cambodia-03.jpg', 23, '#29A93A', 0, 1),
(56, 'KLX-140-L-kawasaki-motors-cambodia-04.jpg', 24, '#29A93A', 0, 1),
(57, 'KLX-140-G-kawasaki-motors-cambodia-04.jpg', 25, '#29A93A', 0, 1),
(58, 'kawasaki-cambodia-ninja-h2-sx-se.jpg', 16, '#29A93A', 0, 1),
(59, 'KX-65-Kawasaki-Cambodia-04.jpg', 26, '#29A93A', 0, 1),
(60, 'KX-85-Kawasaki-Cambodia-03.jpg', 27, '#29A93A', 0, 1),
(61, 'KX-100-Kawasaki-Cambodia-03.jpg', 28, '#29A93A', 0, 1),
(62, 'KX-250-Kawasaki-Cambodia-03.jpg', 29, '#29A93A', 0, 1),
(63, 'KX-450-Kawasaki-Cambodia-03.jpg', 30, '#29A93A', 0, 1),
(64, 'NINJA-H2-CARBON-03.jpg', 31, '#929FA7', 0, 1),
(65, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-03.jpg', 32, '#929FA7', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_gallery`
--

CREATE TABLE `model_gallery` (
  `gallery_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_gallery`
--

INSERT INTO `model_gallery` (`gallery_id`, `model_id`, `image`, `img_order`, `status`) VALUES
(51, 1, 'r0zemzet.45y.jpg', 0, 1),
(52, 1, 'agajxwcj.ccc.jpg', 0, 1),
(55, 2, 'NINJA-650-Kawasaki-Motor-Cambodia_03.jpg', 0, 1),
(53, 2, 'NINJA-650-Kawasaki-Motor-Cambodia_03(1).jpg', 0, 1),
(54, 2, 'NINJA-650-Kawasaki-Motor-Cambodia_02.jpg', 0, 1),
(36, 5, 'kawasaki-ninja-h2-2018-cambodia.jpg', 0, 1),
(37, 5, 'ninja-H2-2018-Kawasaki-Cambodia.jpg', 0, 1),
(38, 5, 'Ninja-H2-2018-Kawasaki-Cambodia-2.jpg', 0, 1),
(39, 5, 'Ninja-H2-2018-Kawasaki-Cambodia(1).jpg', 0, 1),
(15, 6, 'kawasaki_ninja-z1000_kawasaki_cambodia.jpg', 0, 1),
(16, 6, 'kawasaki_ninja-z1000_kawasaki_cambodia(1).jpg', 0, 1),
(17, 6, 'kawasaki_ninja-z1000_kawasaki_cambodia(2).jpg', 0, 1),
(18, 6, 'kawasaki_ninja-z1000_kawasaki_cambodia(3).jpg', 0, 1),
(19, 6, 'kawasaki_ninja-z1000_kawasaki_cambodia(4).jpg', 0, 1),
(80, 23, 'KLX-140-kawasaki-motors-cambodia-04.jpg', 0, 1),
(21, 7, 'kawasaki_z900_kawasaki_cambodia(1).jpg', 0, 1),
(22, 7, 'kawasaki_z900_kawasaki_cambodia(2).jpg', 0, 1),
(23, 7, 'kawasaki_z900_kawasaki_cambodia(3).jpg', 0, 1),
(24, 7, 'kawasaki_z900_kawasaki_cambodia(4).jpg', 0, 1),
(70, 20, 'Ninja-400-kawasaki-motors-cambodia-06.jpg', 0, 1),
(71, 20, 'Ninja-400-kawasaki-motors-cambodia-07.jpg', 0, 1),
(28, 9, 'kawasaki_z300_kawasaki_cambodia.jpg', 0, 1),
(29, 9, 'kawasaki_z300_kawasaki_cambodia(1).jpg', 0, 1),
(30, 9, 'kawasaki_z300_kawasaki_cambodia(2).jpg', 0, 1),
(59, 11, 'Z125-Pro-Kawasaki-Cambodia-07.jpg', 0, 1),
(60, 11, 'Z125-Pro-Kawasaki-Cambodia-08.jpg', 0, 1),
(61, 11, 'Z125-Pro-Kawasaki-Cambodia-09.jpg', 0, 1),
(123, 18, 'Z125-Kawasaki-Cambodia-01.jpg', 0, 1),
(41, 5, 'Ninja-H2-2018-Kawasaki-Cambodia-4.jpg', 0, 1),
(42, 14, 'Kawasaki-Ninja-400-motors-Cambodia.jpg', 0, 1),
(43, 14, 'Kawasaki-Ninja-400-motors-Cambodia-02.jpg', 0, 1),
(44, 14, 'Kawasaki-Ninja-400-motors-Cambodia-05.jpg', 0, 1),
(45, 14, 'Kawasaki-Ninja-400-motors-Cambodia-04.jpg', 0, 1),
(46, 14, 'Kawasaki-Ninja-400-motors-Cambodia-06.jpg', 0, 1),
(47, 14, 'Kawasaki-Ninja-400-motors-Cambodia-07.jpg', 0, 1),
(48, 15, '0ysr35nm.h04.jpg', 0, 1),
(49, 15, 'xbw2lzx4.2u5.jpg', 0, 1),
(50, 15, 'gtp1nqie.m2d.jpg', 0, 1),
(56, 17, 'Ninja-650-ABS-KRT-Edition-Cambodia-07.jpg', 0, 1),
(57, 17, 'Ninja-650-ABS-KRT-Edition-Cambodia-05.jpg', 0, 1),
(58, 17, 'Ninja-650-ABS-KRT-Edition-Cambodia-06.jpg', 0, 1),
(63, 19, 'Z125-Pro-Kawasaki-Cambodia-18.jpg', 0, 1),
(68, 8, 'Z650-Kawasaki-Cambodia-06(1).jpg', 0, 1),
(69, 8, 'Z650-Kawasaki-Cambodia-05.jpg', 0, 1),
(72, 20, 'Ninja-400-kawasaki-motors-cambodia-08.jpg', 0, 1),
(73, 21, 'NINJA-300-ABS-KRT-05.jpg', 0, 1),
(74, 21, 'NINJA-300-ABS-KRT-06.jpg', 0, 1),
(75, 21, 'NINJA-300-ABS-KRT-07.jpg', 0, 1),
(76, 22, 'KLX-110-Kawasaki-Motors-Cambodia-06.jpg', 0, 1),
(77, 22, 'KLX-110-Kawasaki-Motors-Cambodia-05.jpg', 0, 1),
(78, 22, 'KLX-110-Kawasaki-Motors-Cambodia-07.jpg', 0, 1),
(79, 22, 'KLX-110-Kawasaki-Motors-Cambodia-08.jpg', 0, 1),
(81, 23, 'KLX-140-kawasaki-motors-cambodia-05.jpg', 0, 1),
(82, 23, 'KLX-140-kawasaki-motors-cambodia-06.jpg', 0, 1),
(83, 23, 'KLX-140-kawasaki-motors-cambodia-07.jpg', 0, 1),
(84, 24, 'KLX-140-L-kawasaki-motors-cambodia-05.jpg', 0, 1),
(85, 24, 'KLX-140-L-kawasaki-motors-cambodia-06.jpg', 0, 1),
(86, 25, 'KLX-140-G-kawasaki-motors-cambodia-05.jpg', 0, 1),
(87, 25, 'KLX-140-G-kawasaki-motors-cambodia-07.jpg', 0, 1),
(88, 25, 'KLX-140-G-kawasaki-motors-cambodia-0.jpg', 0, 1),
(89, 25, 'KLX-140-G-kawasaki-motors-cambodia-08.jpg', 0, 1),
(90, 16, '4zboughb.ifo.jpg', 0, 1),
(91, 16, 'bhb0rypj.23d.jpg', 0, 1),
(92, 16, 'fgnd2gdu.wyw.jpg', 0, 1),
(93, 16, 'nrcy4lm5.lif.jpg', 0, 1),
(94, 26, 'KX-65-Kawasaki-Cambodia-05.jpg', 0, 1),
(95, 26, 'KX-65-Kawasaki-Cambodia-06.jpg', 0, 1),
(96, 26, 'KX-65-Kawasaki-Cambodia-07.jpg', 0, 1),
(97, 26, 'KX-65-Kawasaki-Cambodia-08.jpg', 0, 1),
(98, 27, 'KX-85-Kawasaki-Cambodia-04.jpg', 0, 1),
(99, 27, 'KX-85-Kawasaki-Cambodia-05.jpg', 0, 1),
(100, 27, 'KX-85-Kawasaki-Cambodia-06.jpg', 0, 1),
(101, 27, 'KX-85-Kawasaki-Cambodia-07.jpg', 0, 1),
(102, 28, 'KX-100-Kawasaki-Cambodia-04.jpg', 0, 1),
(103, 28, 'KX-100-Kawasaki-Cambodia-05.jpg', 0, 1),
(104, 28, 'KX-100-Kawasaki-Cambodia-06.jpg', 0, 1),
(105, 28, 'KX-100-Kawasaki-Cambodia-07.jpg', 0, 1),
(106, 29, 'KX-250-Kawasaki-Cambodia-04.jpg', 0, 1),
(107, 29, 'KX-250-Kawasaki-Cambodia-05.jpg', 0, 1),
(108, 29, 'KX-250-Kawasaki-Cambodia-06.jpg', 0, 1),
(109, 29, 'KX-250-Kawasaki-Cambodia-07.jpg', 0, 1),
(110, 30, 'KX-450-Kawasaki-Cambodia-04.jpg', 0, 1),
(111, 30, 'KX-450-Kawasaki-Cambodia-05.jpg', 0, 1),
(112, 30, 'KX-450-Kawasaki-Cambodia-06.jpg', 0, 1),
(113, 30, 'KX-450-Kawasaki-Cambodia-07.jpg', 0, 1),
(114, 31, 'NINJA-H2-CARBON-04.jpg', 0, 1),
(115, 31, 'NINJA-H2-CARBON-05.jpg', 0, 1),
(116, 31, 'NINJA-H2-CARBON-06.jpg', 0, 1),
(117, 31, 'NINJA-H2-CARBON-07.jpg', 0, 1),
(119, 32, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-04.jpg', 0, 1),
(120, 32, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-05.jpg', 0, 1),
(121, 32, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-06.jpg', 0, 1),
(122, 32, 'NINJA-H2-R-Kawasaki-Motors-Cambodia-07.jpg', 0, 1),
(124, 18, 'Z125-Kawasaki-Cambodia-02.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_slug` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_des` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `long_des` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `youtube_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `news_date` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = none'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `thumbnail`, `title`, `url_slug`, `short_des`, `long_des`, `youtube_url`, `news_date`, `status`) VALUES
(4, '160127113659_2_full(1).jpg', 'KAWASAKI CHARITY TOUR AT KOMPONG SPEU PROVINCE', 'kawasaki-charity-tour-kompong-speu', 'KAWASAKI CHARITY T 23-JAN-2016', '<h4>KAWASAKI CHARITY TOUR AT KOMPONG SPEU PROVINCE 23-JAN-2016</h4>', NULL, '01/23/2016', 1),
(3, '150813120002_8_full.jpg', 'KAWASAKI CAMBODIA - CITY DRIVE 2015', 'city-drive-phnom-penh-kawasaki', 'CITY DRIVE 2015 August 01, 2015', '<h4>KAWASAKI CAMBODIA - CITY DRIVE 2015 August 01, 2015</h4>', NULL, '01/08/2015', 1),
(5, 'Kawasaki-Racing-Cambodia-2016.jpg', 'Kawasaki Racing', 'Kawasaki-Racing-2016', 'Team Kawasaki racing event (26.03.2016 until 27.03.2016)', '<p>Team Kawasaki racing event (26.03.2016 until 27.03.2016)</p>', NULL, '03/25/2016', 1),
(6, 'kawasaki-event.jpg', 'CKF Member Trip to Koh Khong', 'ckf-member-trip-koh-kong', 'Trip to Koh Khong (13-14-05-2016).', '<p>CKF Member Trip to Koh Khong (13-14-05-2016).</p>', NULL, '05/14/2016', 1),
(7, 'Kawasaki-Event-paintball.jpg', 'Kawasaki CKC Paintball Tournament 2016', 'Kawasaki-CKC-Paintball', 'Kawasaki CKC Paintball Tournament 2016', NULL, NULL, '08/21/2016', 1),
(8, 'kawa-trip-team-01.jpg', 'Kawasaki Family Trip', 'kawasaki-family-trip-nov-2016', 'Kawasaki Family Trip November 2016', '<p>Kawasaki Family Trip November 2016</p>', NULL, '11/15/2016', 1),
(9, 'kawa-trip-team-06.jpg', 'Kawasaki Family Trip to Kampot', 'kawasaki-family-trip-to-kampot', 'Kawasaki Family Trip to Kampot', '<p>Kawasaki Family Trip to Kampot</p>', NULL, '01/07/2017', 1),
(10, 'kawa-trip-team-11.jpg', 'Kawasaki Family Trip to Bun Phum 2017', 'kawasaki-bun-phum-2017', 'Kawasaki Family Trip to Bun Phum 2017', '<p>Kawasaki Family Trip to Bun Phum 2017</p>', NULL, '04/08/2017', 1),
(12, 'kawasaki-trip-team-17.jpg', 'ដំណើរកំសាន្តសប្បុរសធម៏​ កំពង់ស្ពឺ', 'charity-trip-kampong-speu', 'Charity Trip to Kampong Speu 08/October/2017', '<p>Charity Trip to Kampong Speu 08/October/2017</p>', NULL, '10/08/2017', 1),
(13, 'kawasaki-trip-siem-reap-team-24.jpg', 'Angkor Wonderful Temple Trip 11-March-2018', 'trip-to-siem-reap--march2018', 'Angkor Wonderful Temple Trip 11-March-2018', '<p>Angkor Wonderful Temple Trip 11-March-2018</p>', NULL, '03/11/2018', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news_gallery`
--

CREATE TABLE `news_gallery` (
  `ng_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `g_order` tinyint(4) NOT NULL DEFAULT '0',
  `g_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display, 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news_gallery`
--

INSERT INTO `news_gallery` (`ng_id`, `news_id`, `image`, `g_order`, `g_status`) VALUES
(4, 3, 'kawasaki-motors-cambodia-01(1).jpg', 0, 1),
(44, 3, 'kawasaki-motors-cambodia-02.jpg', 0, 1),
(7, 4, '160127113659_9_full.jpg', 0, 1),
(8, 4, '160127113659_3_full.jpg', 0, 1),
(9, 4, 'kawasaki_cambodia.jpg', 0, 1),
(10, 4, '160127113659_5_full.jpg', 0, 1),
(11, 4, 'kawasi_cambodia.jpg', 0, 1),
(12, 5, 'kawasaki-racing-01.jpg', 0, 1),
(13, 5, 'kawasaki-racing-02.jpg', 0, 1),
(14, 6, 'kawasaki-event-01.jpg', 0, 1),
(15, 6, 'kawasaki-event-02.jpg', 0, 1),
(16, 6, 'kawasaki-event-03.jpg', 0, 1),
(17, 7, 'Kawasaki-Event-paintball-01.jpg', 0, 1),
(18, 7, 'Kawasaki-Event-paintball-02.jpg', 0, 1),
(19, 7, 'Kawasaki-Event-paintball-03.jpg', 0, 1),
(20, 7, 'Kawasaki-Event-paintball-04.jpg', 0, 1),
(21, 7, 'Kawasaki-Event-paintball-05.jpg', 0, 1),
(22, 8, 'kawa-trip-team-02.jpg', 0, 1),
(23, 8, 'kawa-trip-team-03.jpg', 0, 1),
(24, 8, 'kawa-trip-team-04.jpg', 0, 1),
(25, 8, 'kawa-trip-team-05.jpg', 0, 1),
(26, 9, 'kawa-trip-team-07.jpg', 0, 1),
(27, 9, 'kawa-trip-team-08.jpg', 0, 1),
(28, 9, 'kawa-trip-team-09.jpg', 0, 1),
(29, 9, 'kawa-trip-team-10.jpg', 0, 1),
(30, 10, 'kawa-trip-team-12.jpg', 0, 1),
(31, 10, 'kawa-trip-team-13.jpg', 0, 1),
(32, 10, 'kawa-trip-team-14.jpg', 0, 1),
(33, 10, 'kawasaki-trip-team-15.jpg', 0, 1),
(34, 12, 'kawasaki-trip-team-18.jpg', 0, 1),
(35, 12, 'kawasaki-trip-team-19.jpg', 0, 1),
(36, 12, 'kawasaki-trip-team-20.jpg', 0, 1),
(37, 12, 'kawasaki-trip-team-21.jpg', 0, 1),
(38, 12, 'kawasaki-trip-team-22.jpg', 0, 1),
(39, 12, 'kawasaki-trip-team-23.jpg', 0, 1),
(40, 13, 'kawasaki-trip-siem-reap-team-25.jpg', 0, 1),
(41, 13, 'kawasaki-trip-siem-reap-team-26.jpg', 0, 1),
(42, 13, 'kawasaki-trip-siem-reap-team-27.jpg', 0, 1),
(43, 13, 'kawasaki-trip-siem-reap-team-28.jpg', 0, 1),
(45, 3, 'kawasaki-motors-cambodia-03.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `proid` int(11) NOT NULL,
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pro_title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pro_des` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `pro_date` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1 = display, 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `social_community`
--

CREATE TABLE `social_community` (
  `id` int(11) NOT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `little` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkto` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_type` varchar(50) NOT NULL DEFAULT 'Facebook',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_community`
--

INSERT INTO `social_community` (`id`, `thumbnail`, `little`, `linkto`, `social_type`, `create_date`, `is_active`) VALUES
(3, 'kawasaki-motor-cambodia-siem-reap.jpg', 'facebook', 'https://www.facebook.com/kawasakimotorsKH/photos/pcb.1990950801157028/1990949017823873/?type=3&theater', 'Facebook', '2017-12-07 07:23:06', 1),
(4, 'kawasaki-cambodia-bun-phum.jpg', 'Facebook', 'https://www.facebook.com/kawasakimotorsKH/photos/pcb.2005102096408565/2005099553075486/', 'Facebook', '2017-12-07 07:31:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `special_offer`
--

CREATE TABLE `special_offer` (
  `id` int(11) NOT NULL,
  `title_small` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `linkto` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `special_offer`
--

INSERT INTO `special_offer` (`id`, `title_small`, `title`, `url_slug`, `thumbnail`, `description`, `linkto`, `is_active`, `create_date`) VALUES
(6, 'Special Promotion For Chinese New Year', 'Red Pocket $350', 'kawsaki-chinese-new-year-promotion-2018', '27972993_1977840309134744_6726662012760633684_n.jpg', '<p>ពិតជាពិសេសសម្រាប់លោកអ្នក! ដើម្បីអបអរសាទរ បុណ្យចូលឆ្នាំថ្មីប្រពៃណីចិន ទទួលបាន អាំង ប៉ាវ សំណាង ពីគាវ៉ាសាគី ចំនួន $350 ដុល្លារ ភ្លាមៗ ប្រញាប់ឡើង ចំនួន និង រយៈពេលមានកំណត់។​&nbsp;<br />\r\n===============================================<br />\r\n095 333 501/503 ឬ 069 333 501 សូមអរគុណ!</p>', NULL, 1, '2018-02-27 07:51:51'),
(7, 'Z125 Pro $2500', 'Limited time and stock!', 'z125-pro-promotion-2018', '29512520_1995359044049537_6734773238573826048_n.jpg', '<p>Z125 Pro $2500 Call 095 333 501/ 503 or 069 333 501 Limited time and stock! =======================================================</p>\r\n\r\n<p>&nbsp;</p>', NULL, 1, '2018-05-02 08:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE `specification` (
  `spec_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `s_order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = display , 0 = hidden'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`spec_id`, `model_id`, `title`, `description`, `s_order`, `status`) VALUES
(1, 5, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 4-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>998 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>DOHC, 16 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>76 x 55 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>8.5:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>6-speed, return, Dog-ring</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Fuel injection: &oslash;50 mm x 4 with dual injection</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc, manual</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>120/70ZR17M/C (58W)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>200/55ZR17M/C (78W)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>2,085 mm x 770 mm x 1,125 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,445 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>130 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>825 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>238 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>17 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(2, 5, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Dual semi-floating &oslash;330 mm discs caliper dual radial-mount</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;250 mm petal dice</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;43 mm inverted fork with rebound and compression damping</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>New Uni-Trak with gas-charged shock</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(3, 1, 'Engine - Power - Performance', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp; <strong>Engine</strong></td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 16-valve, liquid-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1,043cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>77.0 x 56.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 38mm Keihin throttle bodies (4) and oval sub-throttles</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Kawasaki Traction Control (KTRC), Kawasaki Intelligent anti-lock Brake System (KIBS), Power Mode, Kawasaki Corner Management Function (KCMF)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41mm inverted cartridge fork with stepless compression and rebound damping, adjustable spring preload/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Horizontal monoshock with stepless rebound damping, remotely adjustable spring preload/5.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>190/50 ZR17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual 300mm petal-type rotors with radial-mount 4-piston monobloc calipers and ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 250mm petal-type rotor with single-piston caliper and ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(4, 1, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Aluminum backbone</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake / Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.5&deg;/4.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>82.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>46.7 / 48.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>56.7 in</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(5, 2, 'Engine - Power - Performance', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>649cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>83.0 x 60.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with dual 36mm Keihin throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41mm hydraulic telescopic fork/4.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Horizontal back-link with adjustable spring preload/5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>160/60x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual 300mm petal-type discs and 2-piston calipers and ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal-type disc and single-piston caliper and ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(6, 2, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake / Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.0/3.9</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>80.9</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.7</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>55.5</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(7, 3, 'Power - Performance', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, liquid-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>296cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>62.0 x 49.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.6:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 32mm throttle bodies (2)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37mm hydraulic telescopic fork/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; with 5-way adjustable preload/5.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>110/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>140/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 290mm petal-type disc with 2-piston hydraulic caliper, ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal-type disc with 2-piston hydraulic caliper, ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(8, 3, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Semi-double cradle, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/3.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>79.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>28.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>55.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Pearl Blizzard White, Candy Plasma Blue</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(9, 4, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 1-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>249 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>DOHC, 4 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>72 x 61.2 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>11.3:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>6-speed, constant mesh, return shift</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Fuel injection: &oslash;38 mm x 1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>100/80-17M/C (52S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>130/70-17M/C (62S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>1,935 mm x 685 mm x 1,075 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,335 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>160 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>780 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>152 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>11 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(10, 4, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Single &oslash;290 mm petal dice, Dual-piston: ABS</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;220 mm petal dice, Dual-piston: ABS</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;37 mm telescopic fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Bottom-link Uni-Trak with gas-charged shock and 5-way adjustable preload</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0, 1),
(11, 6, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 4-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>1,043 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>DOHC, 16 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>71 x 56 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>11.8:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>6-speed, constant mesh, return shift</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Fuel injection: &oslash;38 mm x 4 (Keihin)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>120/70ZR17M/C (58W)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>190/50ZR17M/C (73W)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>2,240 mm x 790 mm x 1,055 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,435 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>125 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>815 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>221 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>17 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(12, 6, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Twin &oslash;310 mm petal dice Dual-piston</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;250 mm petal dice Dual-piston</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;41 mm telescopic fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Bottom-link Uni-trak with gas-charged shock</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(13, 7, 'Power - Performance', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 16-valve, liquid-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>948cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>73.4 x 56.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 36mm Keihin throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with electronic advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41mm inverted fork with rebound damping and spring preload adjustability/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Horizontal back-link, stepless rebound damping, adjustable spring preload/5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 Dunlop Sportmax D214F Z</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>180/55 ZR17 Dunlop Sportmax D214Z</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual 300mm petal-type rotors with four-piston calipers, ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 250mm petal-type rotor with single-piston caliper, ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(14, 7, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.5&deg;/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>81.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>57.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Pearl Mystic Gray/Metallic Flat Spark Black, Flat Ebony/Metallic Spark Black, Candy Persimmon Red/Metallic Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(15, 8, 'Engine - Power - Performance', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>649cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>83.0 x 60.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with Keihin 36mm Keihin throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with electronic advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Telescopic fork/4.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Horizontal back-link with adjustable preload, swingarm/5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 Dunlop Sportmax D214F Sportmax</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>160/60 ZR17 Dunlop Sportmax D214</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual 300mm petal-type rotors with two-piston calipers, ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal-style disc, ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(16, 8, 'DETAILS', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.0&deg;/3.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>81.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>42.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>55.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Metallic Spark Black/Metallic Flat Spark Black, Metallic Matte Covert Green/Metallic Flat Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(17, 9, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 2-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>296 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>DOHC, 8 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>62 x 49 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>10.6:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>6-speed, constant mesh, return shift</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Fuel injection: &oslash;32 mm x 2</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>110/70ZR17M/C (54S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>140/70ZR17M/C (66S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>2,015 mm x 750 mm x 1,025 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,405 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>145 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>785 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>170 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>17 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(18, 9, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Single &oslash;290 mm petal dice Dual-piston: ABS</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;220 mm petal dice Dual-piston: ABS</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;37 mm telescopic fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Bottom-link Uni-trak with shock and 5-way adjustable preload</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(19, 10, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 2-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>249 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>DOHC, 8 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>62 x 41.2 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>11.3:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>6-speed, constant mesh, return shift</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Fuel injection: &oslash;28 mm x 2</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>110/70ZR17M/C (54S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>140/70ZR17M/C (66S)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>2,015 mm x 750 mm x 1,025 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,415 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>145 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>785 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>168 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>17 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(20, 10, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Single &oslash;290 mm petal dice Dual-piston</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;220 mm petal dice Dual-piston</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;37 mm telescopic fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Uni-trak 5-way adjustable preload and 5-way adjustable preload</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(21, 11, 'Engine - Power - Performance', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1 cylinder, SOHC, 2-valve, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>125cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>56.0 x 50.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 24mm throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI w/electronic advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Telescopic fork/3.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Swingarm, single shock/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>100/90-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 200mm petal style disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 184mm petal-style disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(22, 11, 'DETAILS', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Backbone</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>26.0&deg;/2.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>66.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>39.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>46.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Metallic Courage Gray</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(23, 12, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Air-cooled, 4-stroke Single</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>144 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>SOHC, 2 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>58 x 54.4 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>9.5:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>5-speed, return</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>DC-CDI</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Carburettor: NCV24</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric / Kick</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc, manual</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>70/100-19M/C 42P</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>90/100-16M/C 51P</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>2,050&nbsp;mm x 840&nbsp;mm x 1,345&nbsp;mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,225 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>255&nbsp;mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>805 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>113&nbsp;kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>6.9&nbsp;litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(24, 12, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Single &oslash;240 mm petal disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;190 mm petal disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;33 mm telescopic fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Uni-Trak, with 5-way adjustable preload</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(25, 13, 'Engine - Power - Performance', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Engine type</td>\r\n            <td>Liquid-cooled, 4-stroke, 1-cylinder</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Displacement</td>\r\n            <td>144 cc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Valve system</td>\r\n            <td>SOHC, 2 valves</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Bore and stroke</td>\r\n            <td>58 x 54.4 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Compression ratio</td>\r\n            <td>9.5:1</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Transmission</td>\r\n            <td>5-speed, constant mesh, return shift</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ignition system</td>\r\n            <td>Battery and coil</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel system</td>\r\n            <td>Keihin NCV24</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Starting system</td>\r\n            <td>Electric</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Clutch</td>\r\n            <td>Wet multi-disc</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire front</td>\r\n            <td>100/80R14M/C</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Tire rear</td>\r\n            <td>120/80R14M/C</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Length x Width x Height</td>\r\n            <td>1,900 mm x 770 mm x 1,060 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Wheelbase</td>\r\n            <td>1,225 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Ground clearance</td>\r\n            <td>230 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Seat height</td>\r\n            <td>805 mm</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Curb mass</td>\r\n            <td>114 kg</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Fuel Tank Capacity</td>\r\n            <td>7 litres</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(26, 13, 'Brakes - Suspension', '<table>\r\n    <tbody>\r\n        <tr>\r\n            <td>Brakes: Front</td>\r\n            <td>Single &oslash;212 mm petal dice</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Brakes: Rear</td>\r\n            <td>Single &oslash;156 mm petal dice</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Front</td>\r\n            <td>&oslash;35 mm inverted fork</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Suspension: Rear</td>\r\n            <td>Uni-Trak, with 5-way&nbsp;adjustable preload</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 0, 1),
(27, 14, 'ENGINE - POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>Engine type</td>\r\n			<td>Liquid-cooled, 4-stroke, Parallel Twin</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Displacement</td>\r\n			<td>399 cc</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Valve system</td>\r\n			<td>DOHC, 8 valves</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bore and stroke</td>\r\n			<td>70 x 51.8 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Compression ratio</td>\r\n			<td>11.5:1</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Transmission</td>\r\n			<td>6-speed, return</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ignition</td>\r\n			<td>Digital</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Fuel system</td>\r\n			<td>Fuel injection: &oslash;32 mm x 2</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Starting system</td>\r\n			<td>Electric</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Clutch</td>\r\n			<td>Wet multi-disc,Manual</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Tire front</td>\r\n			<td>110/70R17M/C (54H)</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Tire rear</td>\r\n			<td>150/60R17M/C (66H)</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Length x Width x Height</td>\r\n			<td>1,990 mm x 710 mm x 1,150 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Wheelbase</td>\r\n			<td>1,370 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ground clearance</td>\r\n			<td>140 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Seat height</td>\r\n			<td>785 mm</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Curb mass</td>\r\n			<td>169 kg</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Fuel Tank Capacity</td>\r\n			<td>14 litres</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(28, 14, 'BRAKES - SUSPENSION', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>Brakes: Front</td>\r\n			<td>Single semi-floating&nbsp;&oslash;310 mm petal disc</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Brakes: Rear</td>\r\n			<td>Single &oslash;220 mm petal disc</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Suspension: Front</td>\r\n			<td>&oslash;41 mm telescopic fork</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Suspension: Rear</td>\r\n			<td>Bottom-link Uni-Trak,gas-charged shock with adjustable preload</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Caliper: Front</td>\r\n			<td>Single balance actuation dual piston</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Caliper: Rear</td>\r\n			<td>Dual piston</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(29, 15, 'POWER - PERFORMANCE', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 4-valve, liquid-cooled, supercharged</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>76.0 x 55.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>&oslash;41 mm telescopic fork</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.2:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 40mm throttle bodies (4) with dual injection</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return, dog-ring</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Kawasaki Corner Management Function (KCMF), Kawasaki Traction Control (KTRC), Kawasaki Intelligent anti-lock Brake System (KIBS), Kawasaki Engine Brake Control</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43mm inverted fork with rebound and compression damping, spring preload adjustability and top-out springs/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>New Uni-Trak&reg;, gas charged shock with piggyback reservoir, compression and rebound damping and spring preload adjustability, and top-out spring/5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 (58W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>190/55 ZR17 (75W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual radial-mount, opposed 4-piston monobloc calipers, dual semi-floating 320mm discs, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Opposed 2-piston calipers, single 250mm disc, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(32, 17, 'POWER - PERFORMANCE', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>649cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>83.0 x 60.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with dual 36mm Keihin throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41mm hydraulic telescopic fork/4.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Horizontal back-link with adjustable spring preload/5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>160/60x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual 300mm petal-type discs and 2-piston calipers and ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal-type disc and single-piston caliper and ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1);
INSERT INTO `specification` (`spec_id`, `model_id`, `title`, `description`, `s_order`, `status`) VALUES
(33, 17, 'DETAILS', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.0/3.9</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>80.9</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.7</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Curb Weight</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>425.6**</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>55.5</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green/Ebony</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(34, 18, 'POWER - PERFORMANCE', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1 cylinder, SOHC, 2-valve, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>125cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>56.0 x 50.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 24mm throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI w/electronic advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Telescopic fork/3.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Swingarm, single shock/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>100/90-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 200mm petal style disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 184mm petal-style disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(35, 18, 'DETAILS', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Backbone</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>26.0&deg;/2.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>66.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>39.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>46.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Metallic Courage Gray, Candy Persimmon Red, Metallic Flat Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(36, 19, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1 cylinder, SOHC, 2-valve, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>125cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>56.0 x 50.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.8:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 24mm throttle bodies</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI w/electronic advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Telescopic fork/3.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Swingarm, single shock/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>100/90-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 200mm petal style disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 184mm petal-style disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(37, 19, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Backbone</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>26.0&deg;/2.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>66.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>39.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>46.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Candy Plasma Blue/Metallic Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(38, 20, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>399cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>70.0 x 51.8mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 32mm throttle bodies (2)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41mm Telescopic fork/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Bottom-link Uni-Trak&reg;, swingarm adjustable preload/5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>110/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>150/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>310mm semi-floating single disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>220mm single disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(39, 20, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.7&deg;/3.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>78.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>28.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>3.7 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>53.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Pearl Solar Yellow/Pearl Storm Gray/Ebony, Metallic Spark Black, Candy Plasma Blue</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(31, 15, 'DETAILS', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel, with swingarm mounting plate</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.7/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>84.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>47.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Curb Weight</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>564.5 lb**</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Metallic Carbon Gray/Metallic Matte Carbon Gray</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', 0, 1),
(40, 21, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 2-cylinder, DOHC, liquid-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>296cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>62.0 x 49.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.6:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 32mm throttle bodies (2)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>TCBI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37mm hydraulic telescopic fork/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; with 5-way adjustable preload/5.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>110/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>140/70x17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 290mm petal-type disc with 2-piston hydraulic caliper, ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal-type disc with 2-piston hydraulic caliper, ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(41, 21, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Semi-double cradle, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/3.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>79.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>28.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>55.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green/Ebony</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(42, 22, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, SOHC, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>112cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>53.0 x 50.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PB18</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DC-CDI</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-speed, return shift, centrifugal clutch</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30mm hydraulic telescopic fork/4.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Swingarm with single hydraulic shock/4.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2.50x14</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>3.00x12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Mechanical Drum</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Mechanical Drum</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(43, 22, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Backbone frame, high-tensile steel</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.8&deg;/2.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>61.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>25.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>8.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>26.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>42.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(44, 23, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, SOHC, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>144cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.0 x 54.4mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PB20</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital DC-CDI</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Five-speed with wet multi-disc manual clutch</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33mm telescopic fork/7.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; linkage system and single shock with 5-way preload adjustability/7.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>70/100-17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>90/100-14</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal disc with a dual-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 186mm petal disc with single-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(45, 23, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>High-tensile steel, box-section perimeter</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/3.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>71.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>41.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>49.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(46, 24, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, SOHC, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>144cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.0 x 54.4mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PB20</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital DC-CDI</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5-speed with wet multi-disc manual clutch</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33mm telescopic fork/7.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; linkage system and single shock with piggyback reservoir, fully adjustable preload and 22-way rebound damping/7.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>70/100-19</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>90/100-16</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 220mm petal disc with a dual-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 186mm petal disc with single-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(47, 24, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>High-tensile steel, box-section perimeter</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/3.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>74.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>42.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>50.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(48, 25, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, SOHC, air-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>144cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.0 x 54.4mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>9.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PB20</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital DC-CDI</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5-speed with wet multi-disc manual clutch</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33mm telescopic fork/7.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; linkage system and single shock with piggyback reservoir, fully adjustable preload and 22-way rebound damping/7.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2.75x21</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.10x18</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(49, 25, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Tube, semi-double cradle</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/4.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>78.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>31.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>12.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>52.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(50, 16, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 4-valve, liquid-cooled, supercharged</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>998cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>76.0 x 55.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.2:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 40mm throttle bodies (4) with dual injection</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return, dog-ring</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Kawasaki Corner Management Function (KCMF), Kawasaki Traction Control (KTRC), Kawasaki Launch Control Mode (KLCM), Kawasaki Intelligent anti-lock Brake System (KIBS), Kawasaki Engine Brake Control, Kawasaki Quick Shifter (KQS) (upshift &amp; downshift), Cruise Control, LED Corning Lights</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43mm inverted fork with rebound and compression damping, spring preload adjustability and top-out springs/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>New Uni-Trak&reg;, gas charged shock with piggyback reservoir, compression and rebound damping and spring preload adjustability, and top-out spring/5.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 (58W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>190/55 ZR17 (75W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual radial-mount, opposed 4-piston monobloc calipers, dual semi-floating 320mm discs, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Opposed 2-piston calipers, single 250mm disc, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(51, 16, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel, with swingarm mounting plate</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.7/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>84.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>49.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Emerald Blazed Green/Metallic Diablo Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(52, 26, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2-stroke, 1-cylinder, piston reed valve, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>64cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>45.5 x 41.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>8.4:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Mikuni VM24SS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>CDI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33mm leading axle conventional fork with 4-way rebound damping/8.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; single shock system with 4-way rebound damping and fully adjustable spring preload/9.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>60/100-14</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>80/100-12</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(53, 26, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Tubular, semi-double cradle</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27&deg;/2.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>62.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>12.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29.9 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.0 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(54, 27, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2-stroke, 1-cylinder, piston reed, valve, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>84cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>48.5 x 45.8mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.9:1 (low speed) - 9.0:1 (high speed)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PWK28</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Electric CDI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>36mm inverted telescopic cartridge fork with 20-way compression damping/10.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; single shock system with 24-way compression and 21-way rebound damping, plus adjustable spring preload/10.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>70/100-17</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>90/100-14</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(55, 27, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>High-tensile steel perimeter design with subframe member</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29&deg;/3.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>72.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>11.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.32 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>49.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(56, 28, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>2-stroke, 1-cylinder, piston reed valve, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>99cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>52.5 x 45.8mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>10.2:1 (low speed) - 8.7:1 (high speed)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Keihin PWK28</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>CDI with digital advance</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>36mm inverted telescopic cartridge fork with 20-way compression damping/10.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; single shock system with 24-way compression and 21-way rebound damping plus adjustable spring preload/10.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>70/100-19</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>90/100-16</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Disc</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(57, 28, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>High-tensile steel perimeter design with subframe member</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>29&deg;/4.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>75.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>45.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>13.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>34.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.32 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>51.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1);
INSERT INTO `specification` (`spec_id`, `model_id`, `title`, `description`, `s_order`, `status`) VALUES
(58, 29, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>249cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>77.0 x 53.6mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>13.4:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 43mm Keihin throttle body and dual injectors</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital DC-CDI</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>48mm inverted Showa SFF telescopic fork with 40-way spring preload adjustability and 22-position compression and 20-position rebound damping adjustability/12.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Uni-Trak&reg; linkage system and Showa shock with 19-position low-speed and 4-turns high-speed compression damping, 22-position rebound damping, fully adjustable spring preload/12.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>80/100-21</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>100/90-19</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single semi-floating 270mm Braking&reg; petal disc with dual-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 240mm Braking&reg; petal disc with single-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(59, 29, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Aluminum perimeter</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>28.4&deg;/4.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>85.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>50.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>12.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.69 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(60, 30, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 1-cylinder, DOHC, water-cooled</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>449cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>96.0 x 62.1mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>12.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; with 44mm Keihin throttle body</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital CDI with electric start</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5-speed, return shift</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>49mm inverted coil-spring telescopic fork with adjustable compression and rebound damping/12.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>New Uni-Trak&reg; with adjustable dual-range (high/low-speed) compression damping, adjustable rebound damping and adjustable preload/12.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>80/100-21</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/80-19</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single semi-floating 270mm Braking&reg; petal disc with dual-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Single 250mm Braking&reg; petal disc with single-piston caliper</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(61, 30, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Aluminum perimeter</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>27.6&deg;/4.8 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>86.0 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>50.2 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>13.4 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>37.6 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>1.64 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>58.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Lime Green</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(62, 31, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 4-valve, liquid-cooled, supercharged</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>998cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>76.0 x 55.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>8.5:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; w/50mm throttle bodies (4) with dual injection</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return, dog-ring</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Electronic Rider Aids</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Kawasaki Corner Management Function (KCMF), Kawasaki Traction Control (KTRC), Kawasaki Launch Control Mode (KLCM), Kawasaki Intelligent anti-lock Brake System (KIBS), Kawasaki Engine Brake Control, Kawasaki Quick Shifter (KQS) (upshift &amp; downshift), &Ouml;hlins Electronic Steering Damper</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43mm inverted fork with rebound and compression damping, spring preload adjustability and top-out springs/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>New Uni-Trak, &Ouml;hlins TTX36 gas charged shock with piggyback reservoir, compression and rebound damping and spring preload adjustability, and top-out spring/5.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 (58W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>200/55 ZR17 (78W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual radial-mount, opposed 4-piston calipers, dual semi-floating 330mm discs, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Opposed 2-piston calipers, single 250mm disc, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(63, 31, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel, with swingarm mounting plate</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>24.5&deg;/4.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>82.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>30.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>44.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>57.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Mirror Coated Matte Spark Black/Mirror Coated Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(64, 32, 'POWER - PERFORMANCE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Engine</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4-stroke, 4-cylinder, DOHC, 4-valve, liquid-cooled, supercharged</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Displacement</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>998cc</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Bore x Stroke</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>76.0 x 55.0mm</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Compression Ratio</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>8.3:1</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel System</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>DFI&reg; w/50mm throttle bodies (4) with dual injection</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ignition</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Digital</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Transmission</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>6-speed, return, dog-ring</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Final Drive</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Sealed chain</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>43mm inverted fork with rebound and compression damping, spring preload adjustability and top-out springs/4.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Suspension / Wheel Travel</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>New Uni-Trak, &Ouml;hlins TTX36 gas charged shock with piggyback reservoir, compression and rebound damping and spring preload adjustability, and top-out spring/5.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>120/70 ZR17 (58W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Tire</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>190/65 ZR17 (78W)</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Front Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Dual radial-mount, opposed 4-piston calipers, dual semi-floating 330mm discs, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rear Brakes</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Opposed 2-piston calipers, single 250mm disc, KIBS ABS</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1),
(65, 32, 'DETAILS', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Frame Type</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Trellis, high-tensile steel, with swingarm mounting plate</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Rake/Trail</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>25.1&deg;/4.3 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Length</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>81.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Width</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>33.5 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Overall Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>45.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Ground Clearance</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>5.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Seat Height</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>32.7 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Fuel Capacity</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>4.5 gal</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Wheelbase</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>57.1 in</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Color Choices</strong></p>\r\n			</td>\r\n			<td>\r\n			<p>Mirror Coated Matte Spark Black</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `static_page`
--

CREATE TABLE `static_page` (
  `id` int(11) NOT NULL,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `page` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `static_page`
--

INSERT INTO `static_page` (`id`, `title`, `page`, `image`, `description`, `create_date`) VALUES
(1, 'ABOUT KAWASAKI', 'About', NULL, '<p>With its history of more than 100 years of innovation, Kawasaki has evolved as a leading technological enterprise. Now, our company is fully prepared to shape the 21st century with new innovations and looks forward to playing a leading role in the advancement of humankind.<br />\r\n<br />\r\nIt has been more than half a century since Kawasaki started full-scale production of motorcycles. Our first motorcycle engine was designed based on technical know-how garnered from the development and production of aircraft engines. Our entry into the motorcycle industry was driven by Kawasaki&rsquo;s constant effort to develop new technologies. Over the years we have released numerous new models that have helped shape the market, and in the process created many enduring legends based on the speed and power of our machines. As Kawasaki&rsquo;s commitment to performance and styling continues to redefine the standards of high performance and riding pleasure, our latest challenges will surely give birth to new legends...</p>', '2018-07-19 06:57:03'),
(2, 'MESSAGE FROM GM', 'About', NULL, '<p>&quot; Welcome to Kawasaki Motors Cambodia in Phnom Penh! Situated in Phnom Penh, at the heart of Cambodia, we offer the largest showroom in the Kingdom. We provide professional and friendly advice on motorcycles, clothing, and motorcycle components, as well as a comprehensive maintenance, checking and repairing services to our clients. We at Kawasaki Motors Cambodia in Phnom Penh are passionate about our brand and devote all our energy to it. Come to visit our Phnom Penh showroom that truly runs for customer satisfaction. &quot;<br />\r\n&nbsp;</p>\r\n\r\n<div class="clear">&nbsp;</div>\r\n\r\n<p><strong>BUILT BEYOND BELIEF</strong></p>\r\n\r\n<div class="clear">&nbsp;</div>\r\n\r\n<p><br />\r\n<strong>Email</strong> : info@kawasaki.com.kh<br />\r\n<strong>Phone Number </strong> : 095 333 501/503 , 069 333 501<br />\r\n<strong>Address </strong> : No 92, Confederation de la Russie (110), Sangkat Tek La Ork I, Khan Toul Kork, Phnom Penh</p>', '2018-07-19 06:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE `town` (
  `id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `post_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`id`, `state_name`, `post_code`) VALUES
(629, 'Banteay Mean Chey', 'N/A'),
(630, 'Bat Dambang', 'N/A'),
(631, 'Kampong Cham', 'N/A'),
(632, 'Kampong Chhnang', 'N/A'),
(633, 'Kampong Spoeu', 'N/A'),
(634, 'Kampong Thum', 'N/A'),
(635, 'Kampot', 'N/A'),
(636, 'Kandal', 'N/A'),
(637, 'Kaoh Kong', 'N/A'),
(638, 'Kracheh', 'N/A'),
(639, 'Krong Kaeb', 'N/A'),
(640, 'Krong Pailin', 'N/A'),
(641, 'Krong Preah Sihanouk', 'N/A'),
(642, 'Mondol Kiri', 'N/A'),
(643, 'Otdar Mean Chey', 'N/A'),
(644, 'Phnum Penh', '12100'),
(645, 'Pousat', 'N/A'),
(646, 'Preah Vihear', 'N/A'),
(647, 'Prey Veaeng', 'N/A'),
(648, 'Rotanak Kiri', 'N/A'),
(649, 'Siem Reab', 'N/A'),
(650, 'Stueng Traeng', 'N/A'),
(651, 'Svay Rieng', 'N/A'),
(652, 'Takaev', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `post_code` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `phone_number`, `address`, `country`, `post_code`, `town`, `status`) VALUES
(11, 'sophal', 'mao', '81c7581e45ebb212980031ae3c8b9188', 'sophalmao89@gmail.com', '10707262', 'Phnom Penh, Phnom Penh', 'Cambodia', '855', 'Phnom Penh', 0),
(12, 'sophal', 'sophal', '1816ac0b4bf213b0cfaacd48b6127f12', 'sophalmao855@gmail.com', '10707262', 'Phnom Penh, Phnom Penh', 'Cambodia', '855', 'Phnum Penh', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_gallery`
--
ALTER TABLE `about_gallery`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `accessory`
--
ALTER TABLE `accessory`
  ADD PRIMARY KEY (`acs_id`);

--
-- Indexes for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `bank_loan`
--
ALTER TABLE `bank_loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `dealer`
--
ALTER TABLE `dealer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature`
--
ALTER TABLE `feature`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `form_request`
--
ALTER TABLE `form_request`
  ADD PRIMARY KEY (`fr_id`);

--
-- Indexes for table `home_slide`
--
ALTER TABLE `home_slide`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `model_category`
--
ALTER TABLE `model_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `model_color`
--
ALTER TABLE `model_color`
  ADD PRIMARY KEY (`mc_id`);

--
-- Indexes for table `model_gallery`
--
ALTER TABLE `model_gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `news_gallery`
--
ALTER TABLE `news_gallery`
  ADD PRIMARY KEY (`ng_id`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`proid`);

--
-- Indexes for table `social_community`
--
ALTER TABLE `social_community`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_offer`
--
ALTER TABLE `special_offer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`spec_id`);

--
-- Indexes for table `static_page`
--
ALTER TABLE `static_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_gallery`
--
ALTER TABLE `about_gallery`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `accessory`
--
ALTER TABLE `accessory`
  MODIFY `acs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bank_loan`
--
ALTER TABLE `bank_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dealer`
--
ALTER TABLE `dealer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `feature`
--
ALTER TABLE `feature`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `form_request`
--
ALTER TABLE `form_request`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `home_slide`
--
ALTER TABLE `home_slide`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `model_category`
--
ALTER TABLE `model_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `model_color`
--
ALTER TABLE `model_color`
  MODIFY `mc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `model_gallery`
--
ALTER TABLE `model_gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `news_gallery`
--
ALTER TABLE `news_gallery`
  MODIFY `ng_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `proid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_community`
--
ALTER TABLE `social_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `special_offer`
--
ALTER TABLE `special_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `specification`
--
ALTER TABLE `specification`
  MODIFY `spec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `static_page`
--
ALTER TABLE `static_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `town`
--
ALTER TABLE `town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=653;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
