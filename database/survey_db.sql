-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 06:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `survey_id`, `user_id`, `answer`, `question_id`, `date_created`) VALUES
(1, 1, 2, 'Sample Only', 4, '2020-11-10 14:46:07'),
(2, 1, 2, '[JNmhW],[zZpTE]', 2, '2020-11-10 14:46:07'),
(3, 1, 2, 'dAWTD', 1, '2020-11-10 14:46:07'),
(4, 1, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in tempus turpis, sed fermentum risus. Praesent vitae velit rutrum, dictum massa nec, pharetra felis. Phasellus enim augue, laoreet in accumsan dictum, mollis nec lectus. Aliquam id viverra nisl. Proin quis posuere nulla. Nullam suscipit eget leo ut suscipit.', 4, '2020-11-10 15:59:43'),
(5, 1, 3, '[qCMGO],[JNmhW]', 2, '2020-11-10 15:59:43'),
(6, 1, 3, 'esNuP', 1, '2020-11-10 15:59:43'),
(7, 6, 4, 'UzLcW', 6, '2023-02-20 21:59:57'),
(8, 7, 4, 'fMLzB', 7, '2023-02-21 00:30:48'),
(9, 7, 4, 'xrBJw', 8, '2023-02-21 00:30:48'),
(10, 8, 13, 'LfmKN', 9, '2023-02-23 18:45:57'),
(11, 8, 13, '24', 10, '2023-02-23 18:45:57'),
(12, 8, 13, 'NjEGP', 11, '2023-02-23 18:45:57'),
(13, 15, 16, 'xiJVI', 13, '2023-04-23 21:32:31'),
(14, 15, 16, 'j', 14, '2023-04-23 21:32:32'),
(15, 16, 1, '[akxVj]', 15, '2023-04-23 22:12:43'),
(16, 15, 1, 'xiJVI', 13, '2023-04-23 22:12:58'),
(17, 15, 1, '', 14, '2023-04-23 22:12:58'),
(18, 23, 12, 'Sarvess', 21, '2023-05-01 22:53:52'),
(19, 24, 12, '24', 22, '2023-05-01 23:20:17'),
(20, 35, 12, '24', 23, '2023-05-02 02:10:09'),
(21, 50, 12, 'SqhNv', 24, '2023-05-02 03:44:47'),
(22, 50, 17, 'lpjxy', 24, '2023-05-02 03:45:11'),
(23, 52, 17, 'nishalini', 25, '2023-05-13 16:09:22'),
(24, 52, 17, '[lBrKo]', 26, '2023-05-13 16:09:22'),
(25, 52, 17, 'Batu Caves', 27, '2023-05-13 16:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
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
  `comment` text NOT NULL,
  `quality_test` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `product_id`, `recipe_name`, `qty_product`, `staff_id`, `created_at`, `starteddate`, `enddate`, `hours`, `status`, `comment`, `quality_test`) VALUES
(124, 108, 'Pesto Pasta', 30, '100002', '2025-01-01 17:04:39', '2025-01-02', '2025-01-02', 1, 'Unfinished', '', 'Good'),
(125, 103, 'Chocolate Croissant', 150, '100002', '2025-01-01 17:13:52', '2025-01-05', '2025-01-05', 1, 'Unfinished', '', ''),
(126, 101, 'Red Velvet Cake', 5, '100002', '2025-01-01 17:15:53', '2025-01-03', '2025-01-03', 1, 'Unfinished', '', ''),
(127, 107, 'Mushroom Pizza', 10, '100004', '2025-01-01 17:18:31', '2025-01-02', '2025-01-03', 2, 'Finished', '8 Over cooked 2 Well Cooked', 'Medium');

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
  `recipe_ing` text NOT NULL,
  `recipe_step` text NOT NULL,
  `equipment` text NOT NULL,
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipe`
--

INSERT INTO `receipe` (`recipe_id`, `recipe_name`, `recipe_ing`, `recipe_step`, `equipment`, `product_id`) VALUES
(500, 'Classic Vanilla Cake', '1. Flour\r\n2. Sugar\r\n3. Eggs\r\n4. Butter', '1. Preheat oven\r\n2. Mix ingredients\r\n3. Bake for 30 minutes', 'Oven', 101),
(501, 'Chocolate Cake', '1. Cocoa powder\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 25 minutes', 'Oven', 101),
(502, 'Red Velvet Cake', '1. Flour\n2. Cocoa powder\n3. Sugar\n4. Buttermilk', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 30 minutes', 'Oven', 101),
(503, 'Lemon Cake', '1. Flour\n2. Sugar\n3. Lemons\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 30 minutes', 'Oven', 101),
(504, 'Carrot Cake', '1. Carrots\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 40 minutes', 'Oven', 101),
(505, 'Cheesecake', '1. Cream cheese\n2. Sugar\n3. Eggs\n4. Biscuit base', '1. Prepare crust\n2. Mix filling\n3. Bake for 50 minutes', 'Oven', 101),
(506, 'Pineapple Upside-Down Cake', '1. Pineapples\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Arrange pineapples\n3. Mix batter and bake', 'Oven', 101),
(507, 'Black Forest Cake', '1. Cocoa powder\n2. Cherries\n3. Sugar\n4. Whipped cream', '1. Bake layers\n2. Layer with cherries and cream\n3. Decorate', 'Oven', 101),
(508, 'Fruit Cake', '1. Dried fruits\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 50 minutes', 'Oven', 101),
(509, 'Coffee Cake', '1. Coffee\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 30 minutes', 'Oven', 101),
(510, 'Blueberry Muffin', '1. Flour\n2. Sugar\n3. Blueberries\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(511, 'Banana Muffin', '1. Flour\n2. Sugar\n3. Bananas\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(512, 'Chocolate Chip Muffin', '1. Flour\n2. Sugar\n3. Chocolate chips\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(513, 'Apple Cinnamon Muffin', '1. Apples\n2. Flour\n3. Sugar\n4. Cinnamon', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(514, 'Raspberry Muffin', '1. Raspberries\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(515, 'Corn Muffin', '1. Cornmeal\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(516, 'Pumpkin Muffin', '1. Pumpkin puree\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(517, 'Lemon Poppy Seed Muffin', '1. Lemon zest\n2. Flour\n3. Sugar\n4. Poppy seeds', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(518, 'Carrot Muffin', '1. Carrots\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(519, 'Zucchini Muffin', '1. Zucchini\n2. Flour\n3. Sugar\n4. Butter', '1. Preheat oven\n2. Mix ingredients\n3. Bake for 20 minutes', 'Oven', 102),
(520, 'Classic Butter Croissant', '1. Flour\n2. Butter\n3. Yeast\n4. Salt', '1. Knead dough\n2. Fold with butter\n3. Bake for 15 minutes', 'Oven', 103),
(521, 'Chocolate Croissant', '1. Flour\n2. Butter\n3. Chocolate\n4. Yeast', '1. Knead dough\n2. Fill with chocolate\n3. Bake for 15 minutes', 'Oven', 103),
(522, 'Almond Croissant', '1. Flour\n2. Butter\n3. Almond paste\n4. Yeast', '1. Knead dough\n2. Fill with almond paste\n3. Bake for 15 minutes', 'Oven', 103),
(523, 'Cheese Croissant', '1. Flour\n2. Butter\n3. Cheese\n4. Yeast', '1. Knead dough\n2. Fill with cheese\n3. Bake for 15 minutes', 'Oven', 103),
(524, 'Ham and Cheese Croissant', '1. Flour\n2. Butter\n3. Ham\n4. Cheese', '1. Knead dough\n2. Add ham and cheese\n3. Bake for 15 minutes', 'Oven', 103),
(525, 'Spinach Croissant', '1. Flour\n2. Butter\n3. Spinach\n4. Yeast', '1. Knead dough\n2. Fill with spinach\n3. Bake for 15 minutes', 'Oven', 103),
(526, 'Pesto Croissant', '1. Flour\n2. Butter\n3. Pesto\n4. Yeast', '1. Knead dough\n2. Fill with pesto\n3. Bake for 15 minutes', 'Oven', 103),
(527, 'Raspberry Croissant', '1. Flour\n2. Butter\n3. Raspberry jam\n4. Yeast', '1. Knead dough\n2. Fill with raspberry jam\n3. Bake for 15 minutes', 'Oven', 103),
(528, 'Nutella Croissant', '1. Flour\n2. Butter\n3. Nutella\n4. Yeast', '1. Knead dough\n2. Fill with Nutella\n3. Bake for 15 minutes', 'Oven', 103),
(529, 'Honey Croissant', '1. Flour\n2. Butter\n3. Honey\n4. Yeast', '1. Knead dough\n2. Glaze with honey\n3. Bake for 15 minutes', 'Oven', 103),
(532, 'Sourdough Bread', '1. Flour\n2. Water\n3. Salt\n4. Starter', '1. Mix ingredients\n2. Ferment overnight\n3. Bake for 45 minutes', 'Oven', 104),
(533, 'Rye Bread', '1. Rye flour\n2. Water\n3. Yeast\n4. Salt', '1. Knead dough\n2. Let rise\n3. Bake for 40 minutes', 'Oven', 104),
(534, 'French Baguette', '1. Flour\n2. Water\n3. Yeast\n4. Salt', '1. Shape dough\n2. Let rise\n3. Bake for 25 minutes', 'Oven', 104),
(535, 'Ciabatta', '1. Flour\n2. Water\n3. Yeast\n4. Olive oil', '1. Knead dough\n2. Let rise\n3. Bake for 30 minutes', 'Oven', 104),
(536, 'Brioche', '1. Flour\n2. Eggs\n3. Butter\n4. Yeast', '1. Knead dough\n2. Let rise\n3. Bake for 35 minutes', 'Oven', 104),
(537, 'Focaccia', '1. Flour\n2. Olive oil\n3. Salt\n4. Rosemary', '1. Knead dough\n2. Top with rosemary\n3. Bake for 20 minutes', 'Oven', 104),
(538, 'Multigrain Bread', '1. Whole grain flour\n2. Seeds\n3. Yeast\n4. Salt', '1. Mix ingredients\n2. Let rise\n3. Bake for 40 minutes', 'Oven', 104),
(539, 'Pita Bread', '1. Flour\n2. Water\n3. Yeast\n4. Salt', '1. Knead dough\n2. Let rise\n3. Bake for 10 minutes', 'Oven', 104),
(540, 'Garlic Naan', '1. Flour\n2. Garlic\n3. Yogurt\n4. Yeast', '1. Mix ingredients\n2. Cook on stovetop', 'Stove', 104),
(541, 'Onion Bread', '1. Flour\n2. Onion\n3. Yeast\n4. Salt', '1. Mix ingredients\n2. Let rise\n3. Bake for 35 minutes', 'Oven', 104),
(542, 'Grape Juice', '1. Grapes\n2. Sugar\n3. Water', '1. Blend grapes\n2. Strain\n3. Add sugar and water', 'Blender', 105),
(543, 'Pineapple Juice', '1. Pineapple\n2. Sugar\n3. Water', '1. Blend pineapple\n2. Strain\n3. Add sugar and water', 'Blender', 105),
(544, 'Watermelon Juice', '1. Watermelon\n2. Sugar\n3. Ice', '1. Blend watermelon\n2. Strain\n3. Add sugar and serve', 'Blender', 105),
(545, 'Mango Juice', '1. Mangoes\n2. Sugar\n3. Water', '1. Blend mangoes\n2. Add sugar and water\n3. Stir well', 'Blender', 105),
(546, 'Guava Juice', '1. Guavas\n2. Sugar\n3. Water', '1. Blend guavas\n2. Strain\n3. Add sugar and water', 'Blender', 105),
(547, 'Carrot Juice', '1. Carrots\r\n2. Sugar\r\n3. Water', '1. Blend carrots\r\n2. Strain\r\n3. Add sugar and water', 'Juicer', 105),
(548, 'Lemonade', '1. Lemons\n2. Sugar\n3. Water', '1. Squeeze lemons\n2. Add sugar and water\n3. Stir well', 'Juicer', 105),
(549, 'Pomegranate Juice', '1. Pomegranates\n2. Sugar\n3. Water', '1. Extract juice\n2. Add sugar and water\n3. Stir well', 'Juicer', 105),
(550, 'Strawberry Juice', '1. Strawberries\n2. Sugar\n3. Water', '1. Blend strawberries\n2. Strain\n3. Add sugar and water', 'Blender', 105),
(551, 'Cranberry Juice', '1. Cranberries\n2. Sugar\n3. Water', '1. Blend cranberries\n2. Strain\n3. Add sugar and water', 'Blender', 105),
(552, 'Vitamin Water', '1. Filtered water\n2. Vitamins\n3. Flavoring', '1. Filter water\n2. Add vitamins and flavor\n3. Package', 'Filter', 106),
(553, 'Electrolyte Water', '1. Filtered water\n2. Electrolytes', '1. Filter water\n2. Add electrolytes\n3. Package', 'Filter', 106),
(554, 'Herbal Infused Water', '1. Filtered water\n2. Herbs', '1. Filter water\n2. Add herbs\n3. Package', 'Infuser', 106),
(555, 'Lemon Infused Water', '1. Filtered water\n2. Lemon slices', '1. Filter water\n2. Add lemon slices\n3. Package', 'Infuser', 106),
(556, 'Cucumber Infused Water', '1. Filtered water\n2. Cucumber slices', '1. Filter water\n2. Add cucumber slices\n3. Package', 'Infuser', 106),
(557, 'Mint Infused Water', '1. Filtered water\n2. Mint leaves', '1. Filter water\n2. Add mint leaves\n3. Package', 'Infuser', 106),
(558, 'Fruit Infused Water', '1. Filtered water\n2. Mixed fruits', '1. Filter water\n2. Add fruits\n3. Package', 'Infuser', 106),
(559, 'Sparkling Citrus Water', '1. Sparkling water\n2. Citrus zest', '1. Prepare sparkling water\n2. Add citrus zest\n3. Package', 'Carbonator', 106),
(560, 'Berry Infused Water', '1. Filtered water\n2. Berries', '1. Filter water\n2. Add berries\n3. Package', 'Infuser', 106),
(561, 'Rose Infused Water', '1. Filtered water\n2. Rose petals', '1. Filter water\n2. Add rose petals\n3. Package', 'Infuser', 106),
(562, 'Veggie Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Mixed vegetables', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(563, 'BBQ Chicken Pizza', '1. Dough\n2. BBQ sauce\n3. Cheese\n4. Chicken', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(564, 'Hawaiian Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Pineapple and ham', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(565, 'Buffalo Chicken Pizza', '1. Dough\n2. Buffalo sauce\n3. Cheese\n4. Chicken', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(566, 'White Sauce Pizza', '1. Dough\n2. White sauce\n3. Cheese\n4. Spinach', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(567, 'Mushroom Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Mushrooms', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(568, 'Four Cheese Pizza', '1. Dough\n2. Tomato sauce\n3. Mozzarella\n4. Parmesan\n5. Blue cheese\n6. Cheddar', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(569, 'Spinach and Feta Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Spinach and feta', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(570, 'Sausage Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Sausage', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(571, 'Seafood Pizza', '1. Dough\n2. Tomato sauce\n3. Cheese\n4. Mixed seafood', '1. Prepare dough\n2. Add toppings\n3. Bake for 15 minutes', 'Oven', 107),
(572, 'Fettuccine Alfredo', '1. Fettuccine\n2. Cream\n3. Cheese\n4. Butter', '1. Boil pasta\n2. Prepare sauce\n3. Mix and serve', 'Stove', 108),
(573, 'Pasta Carbonara', '1. Spaghetti\n2. Eggs\n3. Cheese\n4. Bacon', '1. Boil pasta\n2. Cook bacon\n3. Mix with eggs and cheese\n4. Serve', 'Stove', 108),
(574, 'Pesto Pasta', '1. Pasta\n2. Basil\n3. Garlic\n4. Parmesan', '1. Boil pasta\n2. Blend pesto\n3. Mix and serve', 'Stove', 108),
(575, 'Lasagna', '1. Lasagna sheets\n2. Tomato sauce\n3. Cheese\n4. Minced meat', '1. Layer ingredients\n2. Bake for 30 minutes', 'Oven', 108),
(576, 'Mac and Cheese', '1. Macaroni\n2. Cheese\n3. Milk\n4. Butter', '1. Boil pasta\n2. Prepare sauce\n3. Mix and bake', 'Stove', 108),
(580, 'Fettuccine Carbonara', '1. Fettuccine\r\n2. Egg yolks\r\n3. Parmesan cheese\r\n4. Pancetta', '1. Cook pasta\r\n2. Prepare sauce with pancetta and egg yolks\r\n3. Mix pasta with sauce and serve', 'Stove', 108),
(581, 'Mac and Cheese', '1. Macaroni\r\n2. Cheese\r\n3. Milk\r\n4. Butter', '1. Boil macaroni\r\n2. Prepare cheese sauce\r\n3. Mix macaroni with sauce and serve', 'Stove', 108),
(582, 'Pesto Pasta', '1. Pasta of choice\r\n2. Basil\r\n3. Garlic\r\n4. Olive oil', '1. Cook pasta\r\n2. Blend basil, garlic, and olive oil into pesto\r\n3. Mix pasta with pesto and serve', 'Blender', 108),
(583, 'Linguine with Clam Sauce', '1. Linguine\r\n2. Clams\r\n3. Garlic\r\n4. White wine', '1. Cook pasta\r\n2. Prepare clam sauce with garlic and wine\r\n3. Combine pasta with sauce and serve', 'Stove', 108),
(584, 'Spaghetti Aglio e Olio', '1. Spaghetti\r\n2. Garlic\r\n3. Olive oil\r\n4. Red chili flakes', '1. Boil spaghetti\r\n2. Sauté garlic in olive oil\r\n3. Toss spaghetti with garlic oil and serve', 'Stove', 108),
(585, 'Vegetarian Lasagna', '1. Lasagna noodles\r\n2. Tomato sauce\r\n3. Ricotta cheese\r\n4. Vegetables', '1. Layer noodles, sauce, and vegetables\r\n2. Bake for 40 minutes\r\n3. Serve hot', 'Oven', 108),
(586, 'Seafood Alfredo', '1. Pasta of choice\r\n2. Cream\r\n3. Shrimp and scallops\r\n4. Parmesan cheese', '1. Cook pasta\r\n2. Prepare Alfredo sauce with seafood\r\n3. Combine pasta with sauce and serve', 'Stove', 108),
(587, 'Pasta Primavera', '1. Pasta of choice\r\n2. Mixed vegetables\r\n3. Olive oil\r\n4. Parmesan cheese', '1. Cook pasta\r\n2. Sauté vegetables\r\n3. Toss pasta with vegetables and serve', 'Stove', 108),
(588, 'Baked Ziti', '1. Ziti pasta\r\n2. Tomato sauce\r\n3. Mozzarella cheese\r\n4. Ricotta cheese', '1. Boil pasta\r\n2. Layer pasta, sauce, and cheeses\r\n3. Bake for 25 minutes and serve', 'Oven', 108),
(589, 'Penne Arrabbiata', '1. Penne\r\n2. Tomato sauce\r\n3. Garlic\r\n4. Red chili peppers', '1. Cook penne\r\n2. Prepare spicy tomato sauce\r\n3. Mix penne with sauce and serve', 'Stove', 108);

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
(100001, 'Baker 1', 79),
(100002, 'Baker 2', 80),
(100003, 'Baker 3', 88),
(100004, 'Baker 4', 83),
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

--
-- Dumping data for table `survey_set`
--

INSERT INTO `survey_set` (`id`, `title`, `description`, `category`, `user_id`, `respondent`, `start_date`, `end_date`, `date_created`) VALUES
(50, 'dddd', 'ddd', 'User Testing Templates  ', 16, '12,17', '2023-05-02', '2023-05-18', '2023-05-02 03:32:03'),
(51, 'Hello', 'helo2', 'Assessment-Quizzes  ', 10, '12,17', '2023-05-03', '2023-05-06', '2023-05-03 00:36:15'),
(52, 'Latest', 'Latest', 'Education Templates  ', 16, '17', '2023-05-12', '2023-05-20', '2023-05-13 16:07:38'),
(53, 'Report Errors', 'sdsfsds', 'Education Templates  ', 16, '12,17', '2023-05-13', '2023-05-20', '2023-05-13 16:26:01');

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
(79, 'Adib', '', '', 'ztebqlux@gmail.com', '25f9e794323b453885f5181f1b624d0b', 3, '2024-12-29 04:51:27', 100001),
(80, 'Halim', '', '', 'ztebqlux@gmail.com', 'e13dd027be0f2152ce387ac0ea83d863', 3, '2024-12-29 04:52:22', 100002),
(81, 'Ahza', '', '', 'ztebqlux@gmail.com', 'e82c4b19b8151ddc25d4d93baf7b908f', 2, '2024-12-29 04:53:08', 100005),
(83, 'Najmi', '', '', 'ztebqlux@gmail.com', '9519bc1bbb643029053f051d004ce283', 3, '2024-12-29 04:55:17', 100004),
(88, 'mirul', '', '', 'danielhkl118@gmail.com', 'cdffdceff32344176683f363ec285e54', 3, '2024-12-29 15:31:17', 100003);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receipe`
--
ALTER TABLE `receipe`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `typeproduct` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
