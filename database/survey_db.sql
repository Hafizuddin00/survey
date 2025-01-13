-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 11:55 AM
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
-- Database: `survey_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `order_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `qty_product` int(11) NOT NULL,
  `staff_id` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `starteddate` varchar(50) NOT NULL,
  `enddate` varchar(20) NOT NULL,
  `hours` int(6) NOT NULL,
  `status` text NOT NULL,
  `quality_test` text NOT NULL,
  `comment` text NOT NULL,
  `ingredients_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`order_id`, `id`, `product_id`, `recipe_name`, `qty_product`, `staff_id`, `created_at`, `starteddate`, `enddate`, `hours`, `status`, `quality_test`, `comment`, `ingredients_data`) VALUES
(11, 205, 104, 'White bread', 2147483647, '100005', '2025-01-12 20:12:19', '2025-01-13', '2025-01-31', 2, 'Unfinished', 'Good', '', '[{\"ingredient\":\"Flour (kg)\",\"mass\":\"8.9318888888889E+44\",\"unit\":\"\"},{\"ingredient\":\"Egg (U)\",\"mass\":\"2.6795666666667E+44\",\"unit\":\"\"}]'),
(0, 206, 103, 'Fix Croissant', 11, '100002', '2025-01-12 20:26:10', '2025-01-13', '2025-01-14', 0, 'Unfinished', '', '', '[\"Flour - 5.5 kg\",\"Egg - 22 unit\"]'),
(19, 208, 104, 'roti bakor', 2147483647, '100001', '2025-01-13 09:53:30', '2025-01-13', '2025-01-14', 1, 'Unfinished', '', '', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Message` varchar(2555) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ID`, `Name`, `Email`, `Message`, `created_at`) VALUES
(8, 'Thilo', 'thiloshinii99@gmail.com', 'Test2', '2023-02-23 10:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_details`
--

CREATE TABLE `equipment_details` (
  `spec_id` varchar(11) NOT NULL,
  `eq_id` varchar(11) NOT NULL,
  `eq_description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `eq_used` int(11) DEFAULT NULL,
  `eq_not_used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_details`
--

INSERT INTO `equipment_details` (`spec_id`, `eq_id`, `eq_description`, `qty`, `eq_used`, `eq_not_used`) VALUES
('B105', 'E102', 'Proofing Baskets', 35, 0, 0),
('B106', 'E103', 'Loaf Pans', 30, 0, 0),
('B107', 'E103', 'Baguette Trays', 50, 0, 0),
('B108', 'E103', 'Cooling Racks', 20, 6, 14),
('C105', 'E102', 'Palette Knives', 10, 0, 0),
('C106', 'E102', 'Cake Leveler', 4, 0, 0),
('C107', 'E102', 'Turntable for Decorating', 5, 0, 0),
('C108', 'E102', 'Decorating Nozzles and Bags', 6, 0, 0),
('C109', 'E103', 'Cake Tins (Round, Square, Rectangular)', 10, 0, 0),
('C110', 'E103', 'Springform Pans', 10, 0, 0),
('CR105', 'E102', 'Rolling Pins', 5, 0, 0),
('CR106', 'E102', 'Bench Scrapers', 5, 0, 0),
('CR107', 'E102', 'Dough Cutters', 3, 0, 0),
('CR108', 'E103', 'Baking Sheets', 20, 0, 0),
('M105', 'E103', 'Muffin Trays', 50, 0, 0),
('M106', 'E103', 'Silicone Muffin Cups', 300, 0, 0),
('M107', 'E103', 'Cooling Racks', 5, 0, 0),
('P103', 'E102', 'Pizza Peel', 2, 0, 2),
('P104', 'E102', 'Pizza Cutter', 3, 0, 3),
('P105', 'E102', 'Dough Dockers', 3, 0, 3),
('P106', 'E103', 'Pizza Pans', 5, 0, 0),
('P107', 'E103', 'Pizza Stones', 5, 0, 0),
('PA105', 'E102', 'Pasta Rolling Pin', 2, 0, 0),
('PA106', 'E102', 'Ravioli Cutter', 2, 0, 0),
('PA107', 'E101', 'Pasta Extruder Machine', 1, 0, 0),
('PA108', 'E101', 'Pasta Cutter', 1, 0, 0),
('SH105', 'E101', 'Planetary Mixer', 3, 0, 0),
('SH106', 'E101', 'Dough Sheeter', 1, 1, 0),
('SH107', 'E101', 'Proofer Cabinet', 2, 0, 0),
('SH108', 'E101', 'Bread Slicer', 1, 0, 0),
('SH109', 'E101', 'Convection Oven (Big Size)', 3, 0, 0),
('SH110', 'E101', 'Refrigerator/Chiller', 2, 0, 0),
('SH111', 'E101', 'Blast Freezer', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_list`
--

CREATE TABLE `equipment_list` (
  `eq_id` varchar(11) NOT NULL,
  `eq_list` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_list`
--

INSERT INTO `equipment_list` (`eq_id`, `eq_list`) VALUES
('E101', 'Machines & Utility'),
('E102', 'Tools'),
('E103', 'Bakeware');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_record`
--

CREATE TABLE `equipment_record` (
  `id` int(11) NOT NULL,
  `spec_id` varchar(11) NOT NULL,
  `eq_used` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_record`
--

INSERT INTO `equipment_record` (`id`, `spec_id`, `eq_used`) VALUES
(205, 'B108', 3),
(205, 'SH106', 1),
(206, 'B108', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ing_list`
--

CREATE TABLE `ing_list` (
  `recipe_id` int(11) NOT NULL,
  `ing_type` text NOT NULL,
  `ing_mass` double NOT NULL,
  `Unit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ing_list`
--

INSERT INTO `ing_list` (`recipe_id`, `ing_type`, `ing_mass`, `Unit`) VALUES
(2, 'roti', 10, ''),
(1, 'Flour (kg)', 10, ''),
(1, 'Egg (U)', 3, ''),
(4, 'Flour (kg)', 15, ''),
(4, 'Egg (U)', 10, ''),
(4, 'Butter (kg)', 2, ''),
(3, 'flour', 10, 'kg'),
(8, 'Flour', 10, 'kg'),
(8, 'Egg', 5, 'unit'),
(9, 'Flour', 10, 'kg'),
(9, 'Egg', 5, 'unit'),
(10, 'Flour', 5, 'kg'),
(10, 'Egg', 20, 'unit'),
(12, 'sugar', 10, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `ing_list_record`
--

CREATE TABLE `ing_list_record` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `ing_type` text NOT NULL,
  `ing_mass` double NOT NULL,
  `unit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `spec_id` varchar(11) NOT NULL,
  `model_id` varchar(11) NOT NULL,
  `model_brand` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`spec_id`, `model_id`, `model_brand`) VALUES
('SH105', 'SP-7001', 'Hobart'),
('SH105', 'SP-7002', 'KitchenAid'),
('SH105', 'SP-7003', 'Vollrath'),
('SH106', 'SP-7004', 'Somerset'),
('SH107', 'SP-7005', 'Winholt'),
('SH107', 'SP-7006', 'Delfield'),
('SH108', 'SP-7007', 'Berkel'),
('SH109', 'SP-7008', 'Blodgett'),
('SH109', 'SP-7009', 'Rational'),
('SH109', 'SP-7010', 'Unox'),
('SH110', 'SP-7011', 'True Refrigeration'),
('SH110', 'SP-7012', 'Turbo Air'),
('SH111', 'SP-7013', 'Irinox'),
('SH111', 'SP-7014', 'Alto-Shaam'),
('SH111', 'SP-7015', 'Hoshizaki');

-- --------------------------------------------------------

--
-- Table structure for table `order_customer`
--

CREATE TABLE `order_customer` (
  `order_id` int(11) NOT NULL,
  `recipe_name` text NOT NULL,
  `customer_name` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_customer`
--

INSERT INTO `order_customer` (`order_id`, `recipe_name`, `customer_name`, `quantity`, `order_date`, `status`) VALUES
(11, 'Strawberry Cake', 'Pn. Halijah', 5, '2025-01-15', 'Ordered'),
(12, 'Chocolate Croissant', 'En. Amin', 10, '2025-01-17', 'Unfinished'),
(13, 'Whole Wheat Bread', 'James Wong', 3, '2025-01-20', 'Unfinished'),
(14, 'Margherita Pizza', 'En. Bajuri', 8, '2025-01-22', 'Ordered'),
(15, 'Red Velvet Cake', 'En. Windara', 7, '2025-01-25', 'Ordered'),
(16, 'Almond Croissant', 'En. Gentar', 12, '2025-01-28', 'Ordered'),
(17, 'Sourdough Bread', 'En. Saad', 6, '2025-02-01', 'Ordered'),
(18, 'Pepperoni Pizza', 'Pn. Saodah', 4, '2025-02-04', 'Ordered'),
(19, 'Carrot Cake', 'En. Amin ', 9, '2025-02-07', 'Ordered'),
(20, 'Pesto Croissant', 'En. Amirul', 11, '2025-02-10', 'Ordered');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `ID` int(11) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(20) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About Us', '<div style=\"text-align: start;\"><font color=\"#7b8898\"><span style=\"font-size: 15px; background-color: rgb(255, 255, 255);\">\r\nWelcome to our Bakery Production Management System! We are a team of dedicated software developers who have designed a platform to streamline the entire bakery production process. Our goal is to provide an efficient, easy-to-use system that simplifies production planning, inventory management, and order tracking. With our system, bakery managers can seamlessly schedule production, manage inventory levels, track batch progress, and ensure timely delivery of baked goods. The platform also allows for real-time monitoring of production status, giving you complete visibility over your operations. We understand the importance of quality control and have integrated features to ensure consistency and accuracy in every batch. Our team is committed to supporting your bakery’s success, providing exceptional customer service, and ensuring that your production runs smoothly. Thank you for choosing our Bakery Production Management System – we are here to help you enhance your bakery operations and achieve your production goals!</span></font></div>', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `frm_option` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `order_by` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `frm_option`, `type`, `order_by`, `survey_id`, `date_created`) VALUES
(1, 0, 'Sample Survey Question using Radio Button', '{\"cKWLY\":\"Option 1\",\"esNuP\":\"Option 2\",\"dAWTD\":\"Option 3\",\"eZCpf\":\"Option 4\"}', 'radio_opt', 3, 1, '2020-11-10 12:04:46'),
(2, 0, 'Question for Checkboxes', '{\"qCMGO\":\"Checkbox label 1\",\"JNmhW\":\"Checkbox label 2\",\"zZpTE\":\"Checkbox label 3\",\"dOeJi\":\"Checkbox label 4\"}', 'check_opt', 2, 1, '2020-11-10 12:25:13'),
(4, 0, 'Sample question for the text field', '', 'textfield_s', 1, 1, '2020-11-10 13:34:21'),
(5, 0, 'What is Your Name', '', 'textfield_s', 0, 3, '2023-01-08 13:46:10'),
(6, 0, 'Whats My name', '{\"rAiwW\":\"Nishalini\",\"UzLcW\":\"Sarvess\",\"ehyTa\":\"Gopal\",\"OqMGP\":\"Sitha\"}', 'radio_opt', 0, 6, '2023-02-20 21:58:03'),
(7, 0, 'When is New Year', '{\"fMLzB\":\"31 December 2022\",\"cOSEU\":\"30 December 2022\",\"ocZtA\":\"29 December 2022\"}', 'radio_opt', 0, 7, '2023-02-21 00:24:03'),
(8, 0, 'Which Day New Year will be', '{\"xrBJw\":\"Saturday\",\"dviTM\":\"Sunday\",\"PEtDL\":\"Monday\"}', 'radio_opt', 0, 7, '2023-02-21 00:25:06'),
(9, 0, 'My Age', '{\"tOqIg\":\"23\",\"AngZt\":\"24\",\"WdKyV\":\"25\"}', 'radio_opt', 0, 8, '2023-02-23 18:43:36'),
(11, 0, 'Where I lived?', '{\"NjEGP\":\"Penang\",\"BYuOP\":\"Pahang\",\"siWht\":\"KL\"}', 'radio_opt', 0, 8, '2023-02-23 18:45:21'),
(13, 0, 'What is your name', '{\"aKRGW\":\"No Name\",\"xiJVI\":\"Hello\"}', 'radio_opt', 0, 15, '2023-04-23 21:18:57'),
(14, 0, 'What is your age ?', '', 'textfield_s', 0, 15, '2023-04-23 21:19:17'),
(15, 0, 'Hai', '{\"akxVj\":\"Anweer\",\"qsxbD\":\"Answer\"}', 'check_opt', 0, 16, '2023-04-23 22:12:24'),
(16, 0, 'What is Your Name ?', '', 'textfield_s', 0, 19, '2023-05-01 22:02:09'),
(17, 0, 'How Old Are You?', '', 'textfield_s', 0, 19, '2023-05-01 22:02:26'),
(18, 0, 'What is your gender ?', '{\"hQxbA\":\"Male\",\"uYciC\":\"Female\"}', 'radio_opt', 0, 19, '2023-05-01 22:03:23'),
(19, 0, 'What is my name?', '', 'textfield_s', 0, 21, '2023-05-01 22:23:57'),
(20, 0, 'When is Labour Day', '{\"MWCAH\":\"1 May\",\"kDtSW\":\"2 May\"}', 'check_opt', 0, 22, '2023-05-01 22:27:15'),
(21, 0, 'What is Your NAme', '', 'textfield_s', 0, 23, '2023-05-01 22:53:30'),
(22, 0, 'How old are you', '', 'textfield_s', 0, 24, '2023-05-01 23:20:00'),
(23, 0, 'How old are you', '', 'textfield_s', 0, 35, '2023-05-02 02:06:12'),
(24, 0, 'How are you', '{\"SqhNv\":\"Im Fine\",\"lpjxy\":\"Not fine\"}', 'radio_opt', 0, 50, '2023-05-02 03:44:31'),
(25, 0, 'What is your name', '', 'textfield_s', 0, 52, '2023-05-13 16:07:59'),
(26, 0, 'How old are you?', '{\"bThdQ\":\"21\",\"lBrKo\":\"23\"}', 'check_opt', 0, 52, '2023-05-13 16:08:25'),
(27, 0, 'Where do you live?', '', 'textfield_s', 0, 52, '2023-05-13 16:08:40'),
(28, 0, 'What is your naame', '{\"lQZNt\":\"\",\"olFib\":\"\"}', 'check_opt', 0, 53, '2023-05-13 16:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `receipe`
--

CREATE TABLE `receipe` (
  `recipe_id` int(11) NOT NULL,
  `recipe_name` text NOT NULL,
  `recipe_step` text NOT NULL,
  `equipment` varchar(11) NOT NULL,
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipe`
--

INSERT INTO `receipe` (`recipe_id`, `recipe_name`, `recipe_step`, `equipment`, `product_id`) VALUES
(1, 'White bread', 'Bake on the oven for 14 minutes', 'E102', 104),
(2, 'roti bakor', 'bakor\nbakor', 'E101', 104),
(3, 'Fruit Croissant', 'Bake in the oven for 13 minutes', 'E102', 103),
(4, 'Classic Muffin', 'Bake muffin for 15 minutes', 'E101', 102),
(8, 'Garlic Bread', 'Bake for 15 minutes', '[{\"specId\":', 104),
(9, 'roti bakor', 'wejoiq', '[{\"specId\":', 103),
(10, 'Fix Croissant', '1. Bake for 13 minutes', '[{\"specId\":', 103),
(12, 'Orange Juice', 'Shake for 15 minutes', '[{\"specId\":', 105);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_equipment`
--

CREATE TABLE `recipe_equipment` (
  `recipe_id` int(11) NOT NULL,
  `spec_id` varchar(11) NOT NULL,
  `eq_description` varchar(200) NOT NULL,
  `eq_used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_equipment`
--

INSERT INTO `recipe_equipment` (`recipe_id`, `spec_id`, `eq_description`, `eq_used`) VALUES
(8, '0', '\n                                                B105 - Proofing Baskets                                            ', 0),
(8, '0', '\n                                                B107 - Baguette Trays                                            ', 0),
(7, 'P107', 'P107 - Pizza Stones', 0),
(9, 'B108', 'B108 - Cooling Racks', 0),
(9, 'CR107', 'CR107 - Dough Cutters', 0),
(10, 'B108', 'B108 - Cooling Racks', 161),
(10, 'SH106', 'SH106 - Dough Sheeter', 151),
(12, 'B106', 'B106 - Loaf Pans', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_information`
--

CREATE TABLE `staff_information` (
  `staff_id` int(11) NOT NULL,
  `staff_name` text NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_information`
--

INSERT INTO `staff_information` (`staff_id`, `staff_name`, `user_id`) VALUES
(100001, 'Baker 1', 94),
(100002, 'Baker 2', 80),
(100003, 'Baker 3', 91),
(100004, 'Baker 4', 95),
(100005, 'Supervisor', 81);

-- --------------------------------------------------------

--
-- Table structure for table `survey_set`
--

CREATE TABLE `survey_set` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `respondent` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typeproduct`
--

CREATE TABLE `typeproduct` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typeproduct`
--

INSERT INTO `typeproduct` (`product_id`, `product_name`) VALUES
(101, 'Cake'),
(102, 'Muffin'),
(103, 'Croissant'),
(104, 'Bread'),
(105, 'Juice'),
(106, 'Drinking Water'),
(107, 'Pizza'),
(108, 'pasta');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2 = Researcher, 3= Respondent',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `contact`, `address`, `email`, `password`, `type`, `date_created`, `staff_id`) VALUES
(1, 'Administrator', '+123456789', 'Sample address', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, '2020-11-10 08:43:06', 0),
(80, 'Halim', '', '', 'baker1@gmail.com', '$2y$10$SyTCddh7Zm5l0G493nWDreqD3CIOBjH/9dM8b/c6Am6g0YLJyKI5a', 3, '2024-12-29 04:52:22', 100002),
(81, 'Ahza', '', '', 'super@gmail.com', '$2y$10$470tdwuxusQDuo1AmsLW1.ocetuvRtroanzMuKPylfgw01ZI0/RMu', 2, '2024-12-29 04:53:08', 100005),
(89, 'saad', '', '', 'baker2@gmail.com', '$2y$10$uH60TCa2dlXCimxe99yO3.NL4ghDDSLfct/r3m4Df/Xe38fcNnJbO', 3, '2025-01-11 21:06:26', 100004),
(91, 'hafizuddin', '', '', 'baker4@gmail.com', '$2y$10$.vRYn4V147JRHVpGolnGoe9BDX4.q6TPXuCzew3VVrCDX7JyBmRDe', 3, '2025-01-13 16:31:38', 100003),
(94, 'najib', '', '', 'baker3@gmail.com', '$2y$10$q8MccWhTNmjGdgbAYYY.tey472m4jgE.QDZzB2BmRCuUZNaAx8DIi', 3, '2025-01-13 17:04:44', 100001);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `equipment_details`
--
ALTER TABLE `equipment_details`
  ADD PRIMARY KEY (`spec_id`),
  ADD KEY `fk_eq_id` (`eq_id`);

--
-- Indexes for table `equipment_list`
--
ALTER TABLE `equipment_list`
  ADD PRIMARY KEY (`eq_id`);

--
-- Indexes for table `ing_list`
--
ALTER TABLE `ing_list`
  ADD KEY `fk_recipe_id` (`recipe_id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD KEY `fk_model_spec_id` (`spec_id`);

--
-- Indexes for table `order_customer`
--
ALTER TABLE `order_customer`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipe`
--
ALTER TABLE `receipe`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `staff_information`
--
ALTER TABLE `staff_information`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `survey_set`
--
ALTER TABLE `survey_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typeproduct`
--
ALTER TABLE `typeproduct`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_customer`
--
ALTER TABLE `order_customer`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `survey_set`
--
ALTER TABLE `survey_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment_details`
--
ALTER TABLE `equipment_details`
  ADD CONSTRAINT `fk_eq_id` FOREIGN KEY (`eq_id`) REFERENCES `equipment_list` (`eq_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ing_list`
--
ALTER TABLE `ing_list`
  ADD CONSTRAINT `fk_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `receipe` (`recipe_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_model_spec_id` FOREIGN KEY (`spec_id`) REFERENCES `equipment_details` (`spec_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receipe`
--
ALTER TABLE `receipe`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `typeproduct` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
