-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 11:52 AM
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
  `estimationduration` varchar(20) NOT NULL,
  `hours` int(6) NOT NULL,
  `status` text NOT NULL,
  `comment` text NOT NULL,
  `quality_test` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `product_id`, `recipe_name`, `qty_product`, `staff_id`, `created_at`, `starteddate`, `estimationduration`, `hours`, `status`, `comment`, `quality_test`) VALUES
(104, 103, 'Almond Croissant', 50, '100001', '2024-12-27 05:26:13', '2024-12-28', '13:26', 3, 'Finished', 'DANIEL TERLALU HENSEM', 'Medium'),
(110, 102, 'Blueberry Muffin', 9, '100003', '2024-12-28 21:03:43', '2024-12-27', '05:03', 9, 'In-Progress', '', ''),
(112, 102, 'Banana Muffin', 30, '100002', '2025-01-01 10:15:25', '2025-01-01', '', 4, 'Unfinished', '', ''),
(117, 103, 'Almond Croissant', 70, '100002', '2025-01-01 10:43:44', '2025-01-03', '', 9, 'Unfinished', '', ''),
(118, 102, 'Banana Muffin', 20, '100002', '2025-01-01 10:48:49', '2024-12-13', '', 3, 'Unfinished', '', '');

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
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipe`
--

INSERT INTO `receipe` (`recipe_id`, `recipe_name`, `recipe_ing`, `recipe_step`, `product_id`) VALUES
(300, 'pasta cheese', 'tepung', 'masak', 500),
(500, 'croissant bakor', 'tepung, gula, minyak', 'goreng', 103),
(503, 'Red Velvet Cake', 'Flour, Sugar, Cocoa powder, Buttermilk, Red food coloring', 'Preheat the oven to 180°C. In a bowl, mix the flour, sugar, and cocoa powder. Add the buttermilk, oil, and eggs, and mix well. Add the red food coloring until you achieve the desired color. Pour the batter into a greased cake pan and bake for 30 minutes. Allow to cool and frost with cream cheese frosting.', 101),
(504, 'Carrot Victus Cake', 'Flour, Sugar, Carrots, Eggs, Butter', 'Preheat oven to 180°C. In a large bowl, whisk together flour, sugar, and spices. Add eggs, grated carrots, and melted butter. Mix until well combined. Pour batter into a greased pan and bake for 35 minutes. Allow to cool and top with cream cheese frosting.', 101),
(505, 'Lemon Cake', 'Flour, Sugar, Lemon zest, Eggs, Butter', 'Preheat the oven to 180°C. In a bowl, cream together butter and sugar. Add eggs, one at a time, and stir in lemon zest. Gradually mix in flour and milk, alternating, until the batter is smooth. Pour into a greased tin and bake for 30 minutes. Once cool, drizzle with lemon glaze or serve plain.', 101),
(506, 'Blueberry Muffin', 'Flour, Sugar, Blueberries, Eggs, Butter', 'Preheat oven to 180°C. In a mixing bowl, combine flour, sugar, and baking powder. Add eggs and melted butter and stir until well combined. Gently fold in fresh blueberries. Scoop batter into a muffin tin and bake for 20 minutes or until golden brown. Let cool before serving.', 102),
(507, 'Banana Muffin', 'Flour, Sugar, Bananas, Eggs, Butter', 'Preheat oven to 180°C. Mash the bananas in a bowl until smooth. In another bowl, whisk together flour, sugar, and baking powder. Add the eggs and melted butter to the banana mixture and stir until combined. Gradually add the dry ingredients to the wet ingredients and mix until just combined. Scoop the batter into muffin tins and bake for 20 minutes. Let cool and enjoy.', 102),
(508, 'Chocolate Chip Muffin', 'Flour, Sugar, Chocolate chips, Eggs, Butter', 'Preheat oven to 180°C. In a large bowl, combine flour, sugar, and baking soda. Add eggs and melted butter, and mix until smooth. Gently fold in chocolate chips. Spoon batter into muffin tin and bake for 20 minutes or until golden brown. Cool slightly before serving.', 102),
(509, 'Cinnamon Muffin', 'Flour, Sugar, Cinnamon, Eggs, Butter', 'Preheat the oven to 180°C. In a bowl, mix together the dry ingredients: flour, sugar, baking powder, and cinnamon. In a separate bowl, whisk together eggs and melted butter. Combine the wet and dry ingredients and stir until smooth. Pour the batter into muffin tins and bake for 20 minutes. Sprinkle with cinnamon sugar before serving.', 102),
(510, 'Pumpkin Muffin', 'Flour, Sugar, Pumpkin, Eggs, Butter', 'Preheat oven to 180°C. In a bowl, combine flour, sugar, baking soda, and cinnamon. In another bowl, mix together pumpkin puree, eggs, and melted butter. Gradually add the dry ingredients to the wet ingredients and mix until smooth. Spoon batter into muffin tin and bake for 20 minutes. Let cool before serving.', 102),
(511, 'Classic Croissant', 'Flour, Butter, Yeast, Sugar, Salt', 'In a bowl, dissolve yeast in warm water with a pinch of sugar. Let it sit for 5 minutes. In another bowl, combine flour and salt. Gradually add the yeast mixture and knead the dough until smooth. Let it rise for 2 hours. Roll out the dough, fold in the butter, and refrigerate. After 30 minutes, roll the dough again, fold, and repeat. Finally, shape the croissants and bake at 200°C for 15 minutes until golden brown.', 103),
(512, 'Almond Croissant', 'Flour, Butter, Almond paste, Sugar, Salt', 'Prepare dough as for classic croissants, but before shaping, spread a layer of almond paste in the center. Roll the dough and shape it into croissants. Let them rise for 1 hour, then bake at 200°C for 15 minutes. After baking, brush with syrup and serve warm.', 103),
(513, 'Chocolate Croissant', 'Flour, Butter, Chocolate, Sugar, Salt', 'Follow the steps for making classic croissants, but before rolling, place a piece of chocolate inside each croissant. Shape the croissants and allow them to rise for 1 hour. Bake at 200°C for 15 minutes. Once baked, serve warm with a dusting of powdered sugar.', 103),
(514, 'Cheese Croissant', 'Flour, Butter, Cheese, Sugar, Salt', 'Prepare dough for croissants as usual. Before rolling, add a slice of cheese in the center. Shape into croissants and let rise for 1 hour. Bake at 200°C for 15 minutes until golden and crispy. Serve warm with a light salad.', 103),
(515, 'Ham Croissant', 'Flour, Butter, Ham, Cheese, Sugar, Salt', 'Prepare the dough for croissants. After rolling the dough, add slices of ham and cheese in the center. Shape the croissants and allow them to rise for 1 hour. Bake at 200°C for 15 minutes. Serve hot as a savory breakfast or snack.', 103),
(516, 'White Bread', 'Flour, Yeast, Sugar, Salt, Butter', 'Combine flour, yeast, sugar, and salt in a bowl. Add warm water and mix until the dough comes together. Knead the dough for about 10 minutes until smooth. Let it rise for 1 hour. Shape the dough and let it rise again for 30 minutes. Bake at 180°C for 25 minutes until golden brown and hollow when tapped.', 104),
(517, 'Whole Wheat Bread', 'Whole wheat flour, Yeast, Sugar, Salt, Butter', 'Combine whole wheat flour, yeast, sugar, and salt in a bowl. Gradually add warm water and knead the dough for 10 minutes. Let the dough rise for 1 hour, then punch it down. Shape the dough into a loaf and let it rise again for 30 minutes. Bake at 180°C for 25 minutes or until the loaf sounds hollow when tapped.', 104),
(518, 'Sourdough Bread', 'Flour, Water, Yeast, Salt', 'Mix flour and water to form a dough. Add a small amount of yeast and salt. Knead the dough for 10 minutes and let it rise overnight. Punch the dough down, then shape it into a loaf and let it rise for several hours. Bake at 200°C for 30 minutes until crusty and golden.', 104),
(519, 'Rye Bread', 'Rye flour, Yeast, Sugar, Salt, Butter', 'Combine rye flour, yeast, sugar, and salt in a bowl. Gradually add water and knead the dough. Let the dough rise for 1 hour, then punch it down. Shape into a loaf and allow it to rise for 30 minutes. Bake at 180°C for 25 minutes until golden and firm.', 104),
(520, 'Multigrain Bread', 'Flour, Mixed grains, Yeast, Sugar, Salt, Butter', 'Combine flour and mixed grains in a bowl. Add yeast, sugar, salt, and warm water. Knead the dough until smooth. Let it rise for 1 hour, then punch it down and shape it. Let the dough rise again before baking at 180°C for 25 minutes until golden brown and crusty.', 104),
(622, 'efa', 'efaf', 'fqe', 103),
(632, 'hbf', 'srg', 'sfw', 104),
(710, 'Cake Taik', 'wdac', 'efsdv', 101),
(910, 'Fiz', 'gsdf', 'rgdsfvd', 104);

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
(150, 'PIZZA'),
(500, 'pasta');

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
(21, 'MUHAMMAD DANIEL HAIKAL BIN WAZI', '', '', 'danielhkl118@gmail.com', 'cdffdceff32344176683f363ec285e54', 2, '2024-12-16 17:29:45', 0),
(26, 'miruk', '', '', 'ztebqlux@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '2024-12-26 13:45:57', 0),
(79, 'Adib', '', '', 'ztebqlux@gmail.com', '25f9e794323b453885f5181f1b624d0b', 3, '2024-12-29 04:51:27', 100001),
(80, 'Halim', '', '', 'ztebqlux@gmail.com', 'e13dd027be0f2152ce387ac0ea83d863', 3, '2024-12-29 04:52:22', 100002),
(81, 'Syah', '', '', 'ztebqlux@gmail.com', 'e82c4b19b8151ddc25d4d93baf7b908f', 2, '2024-12-29 04:53:08', 100005),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

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
