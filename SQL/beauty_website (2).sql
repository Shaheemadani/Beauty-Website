-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 05:01 PM
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
-- Database: `beauty_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `username`, `password`, `profile_image`, `created_at`) VALUES
(1, 'Lustra Admin', 'admin@gmail.com', 'admin', '1234', '', '2025-06-11 08:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Face'),
(2, 'Lip'),
(3, 'Eye'),
(4, 'Nail'),
(5, 'tools');

-- --------------------------------------------------------

--
-- Table structure for table `featured_products`
--

CREATE TABLE `featured_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `featured_products`
--

INSERT INTO `featured_products` (`id`, `product_name`, `image_path`) VALUES
(1, 'Matte Lipstick', 'images/home matte Lipstick.jpg'),
(2, 'Liquid Foundation', 'images/homeLiquid Foundation.jpg'),
(3, 'Makeup Tools', 'images/hometools.jpg'),
(4, 'Nail Polish', 'images/homenail-polish.jpg'),
(5, 'Mascara', 'images/homemascara.jpg'),
(6, 'Lip Stain', 'images/homelip-stain1.jpg'),
(7, 'Eyeshadow Palette', 'images/homeEyeshadow Palette.jpg'),
(8, 'Lip Liner', 'images/homeip-liner.jpg'),
(9, 'Eye Lashes', 'images/homeeye-lashes.jpg'),
(10, 'Compact Powder', 'images/homeCompact Powder.jpg'),
(11, 'Glossy Nail Polish', 'images/homeGlossy Nail Polish.jpg'),
(12, 'Setting Powder', 'images/homesetting-powder.avif'),
(13, 'Nail Remover', 'images/homenail-remover.jpg'),
(14, 'Blush', 'images/homeblush.jpg'),
(15, 'Makeup Remover', 'images/homemakeup-remover.jpg'),
(16, 'Foundation', 'images/homeFoundation1.jpg'),
(17, 'Setting Sprays', 'images/home  spray.jpg'),
(18, 'Red Lipstick', 'images/home redlipstic.avif');

-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `login_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login_activity`
--

INSERT INTO `login_activity` (`id`, `username`, `login_time`) VALUES
(1, 'admin', '2025-06-11 14:07:09'),
(2, 'user', '2025-06-11 14:46:48'),
(3, 'user', '2025-06-11 14:54:47'),
(4, 'user', '2025-06-11 15:14:50'),
(5, 'shahee', '2025-06-12 20:35:18'),
(6, 'shahee', '2025-06-12 22:18:04'),
(7, 'shahee', '2025-06-12 22:38:28'),
(8, 'shahee', '2025-06-12 23:24:37'),
(9, 'admin', '2025-06-12 23:32:58'),
(10, 'admin', '2025-06-12 23:33:08'),
(11, 'shahee', '2025-06-12 23:36:38'),
(12, 'shahee', '2025-06-13 00:53:31'),
(13, 'shahee', '2025-06-13 00:54:04'),
(14, 'shahee', '2025-06-13 01:06:47'),
(15, 'admin', '2025-06-13 02:30:44'),
(16, 'admin', '2025-06-13 02:44:00'),
(17, 'lee', '2025-08-09 16:12:23'),
(18, 'admin', '2025-08-09 16:13:49'),
(19, 'lee', '2025-08-09 16:46:46'),
(20, 'admin', '2025-08-09 19:11:48'),
(21, 'lee', '2025-08-09 19:56:16'),
(22, 'admin', '2025-08-09 20:00:03'),
(23, 'admin', '2025-08-09 20:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `full_name`, `city`, `district`, `street`, `phone`, `email`, `payment_method`, `total_amount`, `order_date`, `created_at`) VALUES
(1, 'shahee', 'shaheema', 'ruwanwella', 'Kegalle', '92/A paranawaththa kannaththoya', ' 0777508739', 'shaheema@gmail.com', 'Cash on Delivery', 0.00, '2025-06-12 19:24:31', '2025-06-12 19:31:53'),
(2, 'lee', 'lee', 'keglle', 'Kegalle', 'main road kegalle', '0776842795', 'lee2@gmail.com', 'Cash on Delivery', 2850.00, '2025-08-09 14:28:54', '2025-08-09 14:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 'hat', 1, 450.00),
(2, 2, 'Lipstic', 3, 550.00),
(3, 2, 'Mascara', 1, 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `subcategory_id`, `image`) VALUES
(3, 'Lipstic', 550.00, 2, 6, 'lipssttiic.jpg'),
(4, 'Foundatioo', 900.00, 1, 1, 'pruduct foundation1.jpg'),
(5, 'Mascara', 1200.00, 3, 12, 'Mascara.webp'),
(6, 'Lip Stain', 700.00, 2, 8, 'lip_stain.webp'),
(7, 'Eye Shadow', 2500.00, 3, 11, 'eyeshadow2.jpg'),
(8, 'Nail polish', 600.00, 4, 15, 'product nail-polish.jpg'),
(9, 'Matte Lipstick', 760.00, 2, 6, 'liipsstiic10.jpg'),
(10, 'Blush', 900.00, 1, 5, 'img60.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `username`, `profile_image`, `message`, `created_at`) VALUES
(3, 'lee', 'AI-Profile-Picture.jpg', 'It’s really glossy so it doesn’t leave my lips dry. It’s a really pretty red color… the smell… I sort of smells like chocolates.', '2025-08-09 11:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `sold_products`
--

CREATE TABLE `sold_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sold_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold_products`
--

INSERT INTO `sold_products` (`id`, `product_name`, `quantity`, `price`, `sold_date`) VALUES
(1, 'hat', 1, 450.00, '2025-06-12 19:24:31'),
(2, 'Lipstic', 3, 550.00, '2025-08-09 14:28:54'),
(3, 'Mascara', 1, 1200.00, '2025-08-09 14:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Foundation'),
(2, 1, 'Primer'),
(3, 1, 'Setting Powder'),
(4, 1, 'Makeup Remover'),
(5, 1, 'Blush'),
(6, 2, 'Lipstick'),
(7, 2, 'Lip Liner'),
(8, 2, 'Lip Stain'),
(9, 2, 'Lip Balm'),
(10, 2, 'Lip Gloss'),
(11, 3, 'Eye Shadow'),
(12, 3, 'Mascara'),
(13, 3, 'Eye Lashes'),
(14, 3, 'Eye Liner'),
(15, 4, 'Nail Polish'),
(16, 4, 'Nail Remover');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `profile_image`, `created_at`) VALUES
(1, 'user', 'user@gmail.com', 'user', '$2y$10$P36e395PFHIfNl0KHdNA7eBE.IQdJAeEEz7LLEdG9BgQVNZ7TtCTS', 'aslam.avif', '2025-06-11 08:22:31'),
(2, 'shaheema', 'shaheema@gmail.com', 'shahee', '$2y$10$TrxQzM/DA.Gg89XDmgM/4O0bzW7GSoM2gejqxqZXfYjbSvBmeqdMu', 'profilehakee.jpg', '2025-06-12 15:04:59'),
(3, 'Lee', 'lee2@gmail.com', 'lee', '$2y$10$BNxLUP2K9HpXcNvctOM6PeWraejtvl0GiK1A6xi4vmju5dIKspP8q', 'AI-Profile-Picture.jpg', '2025-08-09 10:42:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_products`
--
ALTER TABLE `featured_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sold_products`
--
ALTER TABLE `sold_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `featured_products`
--
ALTER TABLE `featured_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sold_products`
--
ALTER TABLE `sold_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
