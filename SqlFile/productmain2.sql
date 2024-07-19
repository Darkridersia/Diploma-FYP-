-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2021 at 01:39 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `startroopersproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `productmain2`
--

DROP TABLE IF EXISTS `productmain2`;
CREATE TABLE IF NOT EXISTS `productmain2` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(128) NOT NULL,
  `user_phone` varchar(128) NOT NULL,
  `p_des` varchar(2000) NOT NULL,
  `p_quantity` int(128) NOT NULL,
  `p_name` varchar(2000) NOT NULL,
  `p_condition` varchar(128) NOT NULL,
  `p_price` double(6,2) NOT NULL,
  `p_shipping` varchar(128) NOT NULL,
  `p_category` varchar(128) NOT NULL,
  `p_image` varchar(128) NOT NULL,
  `image2` varchar(128) DEFAULT NULL,
  `image3` varchar(128) DEFAULT NULL,
  `image4` varchar(128) DEFAULT NULL,
  `p_status` varchar(128) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productmain2`
--

INSERT INTO `productmain2` (`p_id`, `user_email`, `user_phone`, `p_des`, `p_quantity`, `p_name`, `p_condition`, `p_price`, `p_shipping`, `p_category`, `p_image`, `image2`, `image3`, `image4`, `p_status`) VALUES
(158, 'junxuan2020@hotmail.com', '01162129880', 'Processor:Intel(R) Core(TM) i3-7100 CPU @ 3.90GHz   3.91 GHz\r\n12GB RAM. Mouse, keyboard, and speaker are not included. Overall condition is still good. ViewSonic Monitor(28 Inches)', 1, 'CPU+Monitor(VIewSonic)', 'Used', 1000.00, 'NinjaVan', 'Electronic Device', '1636271565_WhatsApp Image 2021-11-07 at 3.34.51 PM.jpeg', '1636271565_WhatsApp Image 2021-11-07 at 3.33.17 PM.jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(159, 'junxuan2020@hotmail.com', '01162129880', 'Plug and Charge, Creative Watch Faces, Heart Rate Monitoring, Sleep Tracking, 9 workout modes, 50m water-resistant.\r\nNo warranty.\r\nUsed for 2 years', 0, 'Huawei Band 4 Sport Watch', 'Used', 120.00, 'PosLaju', 'Electronic Device', 'WhatsApp Image 2021-11-07 at 5.31.14 PM.jpeg', 'WhatsApp Image 2021-11-07 at 5.31.51 PM.jpeg', 'WhatsApp Image 2021-11-07 at 5.31.31 PM.jpeg', 'WhatsApp Image 2021-11-07 at 5.31.37 PM.jpeg', 'active'),
(164, 'junxuan2012@hotmail.com', '01162129880', 'Used 2 years\r\nRun-on Window 8\r\nStorage: 500GBHDD \r\nCPU: Intel Celeron processor 1019Y(1.0GHz), 2MB L3 cache\r\nMemory: 2GB DDR3 L Memory\r\nBattery: 3-cell Li-ion battery\r\nNo warranty', 1, 'Acer Laptop', 'Used', 500.00, 'NinjaVan', 'Electronic Device', '1636293088_WhatsApp Image 2021-11-07 at 6.08.38 PM.jpeg', '1636293088_WhatsApp Image 2021-11-07 at 6.08.39 PM.jpeg', '1636293088_WhatsApp Image 2021-11-07 at 6.17.44 PM.jpeg', '1636293088_WhatsApp Image 2021-11-07 at 6.17.45 PM.jpeg', 'active'),
(160, 'junxuan2020@hotmail.com', '01162129880', 'Never used, all are in good condition', 4, 'Note Book(Not Used)', 'New', 5.00, 'NinjaVan', 'Book', '1636272252_WhatsApp Image 2021-11-07 at 4.00.33 PM.jpeg', '1636272252_WhatsApp Image 2021-11-07 at 4.00.49 PM.jpeg', '1636272252_WhatsApp Image 2021-11-07 at 4.00.39 PM.jpeg', '1636272252_WhatsApp Image 2021-11-07 at 4.00.56 PM.jpeg', 'active'),
(161, 'junxuan2012@hotmail.com', '01162129880', 'Different kinds of storybooks, all are in good condition, covered with plastic covers.', 5, 'Story book', 'Used', 20.00, 'PosLaju', 'Book', '1636275513_books4.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(162, 'junxuan2012@hotmail.com', '01162129880', 'Intel Core i7-11700K (3.6 GHz / 5.0 GHz)\r\n8.0GB RAM\r\nNVIDIA GTX 1060\r\nkeyboard and mouse included\r\nused for one year', 1, 'Hp Deskstop', 'Used', 2850.00, 'PosLaju', 'Electronic Device', '1636275723_computer4.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(163, 'junxuan2012@hotmail.com', '01162129880', 'fx-350MS casio calculator.\r\nAll functions are working fine.\r\nA bit blurry on the screen, but still able to see.', 1, 'Casio calculator fx-350MS', 'Used', 30.00, 'J&T', 'Electronic Device', '1636275989_WhatsApp Image 2021-11-07 at 5.04.07 PM.jpeg', '1636275989_WhatsApp Image 2021-11-07 at 5.04.08 PM.jpeg', '1636275989_WhatsApp Image 2021-11-07 at 5.04.08 PM (1).jpeg', 'No_Image_Available.jpg', 'active'),
(165, 'junxuan2012@hotmail.com', '01162129880', 'Small and convenient wireless mouse\r\nUse AA battery\r\nUsed for one years', 1, 'HP Wireless Mouse', 'Used', 20.00, 'J&T', 'Electronic Device', '1636293211_WhatsApp Image 2021-11-07 at 6.08.39 PM (2).jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(166, 'junxuan2012@hotmail.com', '01162129880', 'Wired Mouse that is suitable for the desktop user.\r\nUsed for one year.', 2, 'Wired Mouse', 'Used', 15.00, 'PosLaju', 'Electronic Device', '1636293278_WhatsApp Image 2021-11-07 at 6.08.39 PM (1).jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(167, 'junxuan2012@hotmail.com', '01162129880', 'A dictionary that is suitable for college students.\r\nOverall condition is still good.', 1, 'Oxford Dictionary', 'Used', 40.00, 'PosLaju', 'Book', '1636293862_WhatsApp Image 2021-11-07 at 8.16.37 PM.jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(168, 'junxuan2020@hotmail.com', '01162129880', 'PRE-INTERMEDIATE MARKET LEADER ENGLISH COURSEBOOK, suitable for anyone who takes Business courses, used only few months.', 1, 'Pre-intermediate Market Leader English Course Book', 'Used', 30.00, 'PosLaju', 'Book', '1636294079_WhatsApp Image 2021-11-07 at 8.16.55 PM.jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active'),
(169, 'junxuan2020@hotmail.com', '01162129880', 'Condition is good, inner space is quite big, durable, and comfortable.', 1, 'Converse Beg(Red)', 'Used', 30.00, 'PosLaju', 'Others', '1636294386_WhatsApp Image 2021-11-07 at 10.09.28 PM.jpeg', '1636294386_WhatsApp Image 2021-11-07 at 10.09.12 PM.jpeg', '1636294386_WhatsApp Image 2021-11-07 at 10.09.20 PM.jpeg', '1636294386_WhatsApp Image 2021-11-07 at 10.09.04 PM.jpeg', 'active'),
(170, 'junxuan2020@hotmail.com', '01162129880', 'Suitable for students to put folders, convenient and small, easy to carry.', 1, 'Small Folder beg(black)', 'Used', 10.00, 'PosLaju', 'Others', '1636294549_WhatsApp Image 2021-11-07 at 10.09.42 PM.jpeg', '1636294549_WhatsApp Image 2021-11-07 at 10.09.35 PM.jpeg', 'No_Image_Available.jpg', 'No_Image_Available.jpg', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
