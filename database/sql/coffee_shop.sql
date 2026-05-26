-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th5 26, 2026 lúc 05:09 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-05-25 07:56:59', '2026-05-25 07:56:59'),
(2, 2, '2026-05-26 04:31:15', '2026-05-26 04:31:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `toppings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`toppings`)),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_item_options`
--

CREATE TABLE `cart_item_options` (
  `cart_item_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_item_toppings`
--

CREATE TABLE `cart_item_toppings` (
  `cart_item_id` int(11) NOT NULL,
  `topping_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `is_active`) VALUES
(1, 'Cà phê', 'ca-phe', 1),
(2, 'Trà sữa', 'tra-sua', 1),
(3, 'Americano', 'americano', 1),
(4, 'Espresso', 'espresso', 1),
(5, 'Matcha', 'matcha', 1),
(6, 'Trà trái cây', 'tra-trai-cay', 1),
(7, 'Sinh tố', 'sinh-to', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `option_groups`
--

CREATE TABLE `option_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_type` enum('radio','checkbox') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `option_groups`
--

INSERT INTO `option_groups` (`id`, `name`, `display_type`) VALUES
(1, 'Kích cỡ', 'radio'),
(2, 'Nhiệt độ', 'radio'),
(3, 'Độ ngọt', 'radio'),
(4, 'Mức đá', 'radio');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `option_values`
--

CREATE TABLE `option_values` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price_adjustment` decimal(10,2) DEFAULT 0.00,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `option_values`
--

INSERT INTO `option_values` (`id`, `group_id`, `name`, `price_adjustment`, `is_default`) VALUES
(1, 1, 'Size S', 0.00, 1),
(2, 1, 'Size M', 5000.00, 0),
(3, 1, 'Size L', 10000.00, 0),
(4, 2, 'Đá', 0.00, 1),
(5, 2, 'Nóng', 0.00, 0),
(6, 3, 'Bình thường', 0.00, 1),
(7, 3, 'Ít ngọt', 0.00, 0),
(8, 3, 'Không đường', 0.00, 0),
(9, 4, 'Bình thường', 0.00, 1),
(10, 4, 'Ít đá', 0.00, 0),
(11, 4, 'Đá để riêng', 0.00, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT 'cod',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(500) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `options` text DEFAULT NULL,
  `toppings` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `allow_topping` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1,
  `is_bestseller` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `base_price`, `image_url`, `allow_topping`, `is_active`, `is_bestseller`) VALUES
(1, 2, 'Trà Sữa Sương Sáo', 'tra-sua-suong-sao', 35000.00, 'http://127.0.0.1:8000/img/products/trasua_suong-sao.png', 1, 1, 0),
(2, 6, 'Trà Đào Cam Sả', 'tra-dao-cam-sa', 39000.00, 'http://127.0.0.1:8000/img/products/tra-dao-cam-sa_400x400.png', 1, 1, 1),
(3, 1, 'Cà Phê Đen Đá', 'ca-phe-den-da', 22000.00, 'http://127.0.0.1:8000/img/products/cafe-den-da.jpg', 0, 1, 0),
(4, 4, 'Espresso Đá', 'ca-phe-latte-may', 45000.00, 'http://127.0.0.1:8000/img/products/espresso_da.jpg.png', 0, 1, 0),
(5, 2, 'Trà Sữa Hồng Trà', 'tra-sua-hong-tra', 45000.00, 'http://127.0.0.1:8000/img/products/trasua_hongtra_nong.jpg.png', 1, 1, 0),
(6, 2, 'Trà Sữa Bassic', 'tra-sua-bassic', 43000.00, 'http://127.0.0.1:8000/img/products/tra_sua.jpg', 1, 1, 0),
(7, 6, 'Trà Đào', 'tra-dao', 23000.00, 'http://127.0.0.1:8000/img/products/tra_dao.jpg', 1, 1, 1),
(8, 6, 'Trà Vải', 'tra-vai', 22000.00, 'http://127.0.0.1:8000/img/products/tra-vai.png', 1, 1, 1),
(9, 6, 'Trà Vải Dâu', 'tra-vai-dau', 34000.00, 'http://127.0.0.1:8000/img/products/tra-vai-dau.png', 1, 1, 0),
(10, 6, 'Trà Phúc Kiến Sen', 'tra-phuc-kien-sen', 23000.00, 'http://127.0.0.1:8000/img/products/tra-phuc-kien-sen_400x400.png', 1, 1, 0),
(11, 6, 'Trà Dâu', 'tra-dau', 23000.00, 'http://127.0.0.1:8000/img/products/tra-dau.png', 1, 1, 0),
(12, 7, 'Sinh Tố Xoài', 'sinh-to-xoai', 45000.00, 'http://127.0.0.1:8000/img/products/sinh-to-xoai.png', 1, 1, 0),
(13, 7, 'Sinh Tố Mãn Cầu', 'sinh-to-man-cau', 45000.00, 'http://127.0.0.1:8000/img/products/sinh-to-man-cau.png', 1, 1, 0),
(14, 7, 'Sinh Tố Chuối', 'sinh-to-chuoi', 43000.00, 'http://127.0.0.1:8000/img/products/sinh-to-chuoi.png', 1, 1, 0),
(15, 7, 'Sinh Tố Bơ', 'sinh-to-bo', 45000.00, 'http://127.0.0.1:8000/img/products/sinh-to-bo.png', 1, 1, 0),
(16, 6, 'Ô Long Tứ Qúy Sen', 'o-long-tu-quy-sen', 23000.00, 'http://127.0.0.1:8000/img/products/oolong_tuquy_sen.jpg.png', 1, 1, 0),
(17, 7, 'Frappe Vanilla Mocha', 'frappe-vanilla-mocha', 45000.00, 'http://127.0.0.1:8000/img/products/new-frappe_vanilla_mocha.jpg.png', 1, 1, 0),
(18, 5, 'Matcha Latte Yến Mạch', 'matcha-latte-yen-mach', 34000.00, 'http://127.0.0.1:8000/img/products/matcha_latte_yenmach.jpg.png', 1, 1, 0),
(19, 5, 'Matcha Latte basic', 'matcha-latte-basic', 34000.00, 'http://127.0.0.1:8000/img/products/matcha_latte_tb_nong.jpg.png', 1, 1, 0),
(20, 5, 'Matcha Latte Đặc Biệt', 'matcha-latte-dac-biet', 31000.00, 'http://127.0.0.1:8000/img/products/matcha_latte_tb.jpg.png', 1, 1, 0),
(21, 5, 'Matcha Latte Dâu', 'matcha-latte-dau', 45000.00, 'http://127.0.0.1:8000/img/products/matcha-latte-dau.png', 1, 1, 0),
(22, 5, 'Frappe Matcha', 'frappe-matcha', 21000.00, 'http://127.0.0.1:8000/img/products/frappe_matcha.jpg.png', 1, 1, 0),
(23, 1, 'Frappe Bạc Xỉu', 'frappe-bac-xiu', 34000.00, 'http://127.0.0.1:8000/img/products/frappe_bacxiu.jpg.png', 1, 1, 0),
(24, 4, 'Espresso Basic', 'espresso-basic', 25000.00, 'http://127.0.0.1:8000/img/products/espresso_nong.jpg.png', 0, 1, 0),
(25, 1, 'Chocolate', 'chocolate', 31000.00, 'http://127.0.0.1:8000/img/products/chocolate.jpg', 0, 1, 0),
(26, 1, 'Chocolate Muối', 'chocolate-muoi', 30000.00, 'http://127.0.0.1:8000/img/products/choco_nong.jpg.png', 0, 1, 0),
(27, 1, 'Chocolate Đá', 'chocolate-da', 43000.00, 'http://127.0.0.1:8000/img/products/choco_da.jpg.png', 0, 1, 0),
(28, 1, 'Caramel', 'caramel', 23000.00, 'http://127.0.0.1:8000/img/products/caramel.jpg', 0, 1, 0),
(29, 1, 'Bạc Xỉu Foam Dừa', 'bac-xiu-foam-dua', 34000.00, 'http://127.0.0.1:8000/img/products/bacxiu_foamdua.png', 0, 1, 0),
(30, 1, 'Bạc Xỉu Caramel Muối', 'bac-xiu-caramel-muoi', 31000.00, 'http://127.0.0.1:8000/img/products/bacxiu_caramelmuoi.png', 0, 1, 1),
(31, 1, 'Bạc Xỉu', 'bac-xiu-3', 39000.00, 'http://127.0.0.1:8000/img/products/bacxiu.png', 0, 1, 1),
(32, 3, 'Ame Mơ', 'ame-mo', 29000.00, 'http://127.0.0.1:8000/img/products/ame_mo.png', 0, 1, 1),
(33, 3, 'Ame Đào', 'ame-dao', 42000.00, 'http://127.0.0.1:8000/img/products/ame_dao.png', 0, 1, 0),
(34, 3, 'Ame Classic', 'ame-classic', 23000.00, 'http://127.0.0.1:8000/img/products/ame_classic.png', 0, 1, 0),
(35, 3, 'Americano Chanh Leo', 'americano-chanh-leo', 32000.00, 'http://127.0.0.1:8000/img/products/1779086774_americano-chanh-leo_400x400.png', 0, 1, 0),
(36, 5, 'Matcha Latte Xoài', 'matcha-latte-xoai', 34000.00, 'http://127.0.0.1:8000/img/products/1776006288_new-matcha-latte-xoai_400x400.png', 0, 1, 0),
(37, 5, 'Matcha Latte Đào Dưa Lưới', 'matcha-latte-dao-dua-luoi', 22000.00, 'http://127.0.0.1:8000/img/products/1776006020_new-matcha-latte-dao-dua-luoi_400x400.png', 0, 1, 0),
(38, 1, 'So Co La Đá', 'so-co-la-da', 34000.00, 'http://127.0.0.1:8000/img/products/1751597730_so-co-la-da_400x400.png', 0, 1, 0),
(39, 1, 'Shan Tuyết Choco', 'shan-tuyet-choco', 23000.00, 'http://127.0.0.1:8000/img/products/1767189135_shan-tuyet-choco-tchk_400x400.png', 0, 1, 0),
(40, 6, 'Trà Shan TuyếtCheese Foam', 'tra-shan-tuyetcheese-foam', 43000.00, 'http://127.0.0.1:8000/img/products/1767189249_shan-tuyet-cheese-foam_400x400.png', 0, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_option_groups`
--

CREATE TABLE `product_option_groups` (
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_option_groups`
--

INSERT INTO `product_option_groups` (`product_id`, `group_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(4, 1),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(7, 1),
(7, 3),
(7, 4),
(8, 1),
(8, 3),
(8, 4),
(9, 1),
(9, 3),
(9, 4),
(10, 1),
(10, 3),
(10, 4),
(11, 1),
(11, 3),
(11, 4),
(12, 1),
(12, 3),
(12, 4),
(13, 1),
(13, 3),
(13, 4),
(14, 1),
(14, 3),
(14, 4),
(15, 1),
(15, 3),
(15, 4),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(17, 1),
(17, 3),
(17, 4),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(21, 1),
(21, 3),
(21, 4),
(22, 1),
(22, 3),
(22, 4),
(23, 1),
(23, 3),
(23, 4),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(26, 1),
(26, 2),
(26, 3),
(26, 4),
(27, 1),
(27, 3),
(27, 4),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(32, 1),
(32, 3),
(32, 4),
(33, 1),
(33, 3),
(33, 4),
(34, 1),
(34, 3),
(34, 4),
(35, 1),
(35, 3),
(35, 4),
(36, 1),
(36, 3),
(36, 4),
(37, 1),
(37, 3),
(37, 4),
(38, 1),
(38, 3),
(38, 4),
(39, 1),
(39, 2),
(39, 3),
(39, 4),
(40, 1),
(40, 2),
(40, 3),
(40, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8LryEkOPUgSLauB8h3uq6YJF5QG1sCjF7clfNi9s', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0Y2ZThudVU0cVoyT1BZempzN0lsQklkbEI1bVRsblhWalNGRFdDbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wIjt9fQ==', 1779807502),
('mFMgeDX1YjAbK7v5j4W3HtYGu7IylcvIcXBe77QC', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN1o4VjBHUGpyVHZSdEFVdW1Ib0ZIVm40V3BZUkswUHRDRk0zWDNtcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbmZvP3RhYj1hZGRyZXNzZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1779800854);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `toppings`
--

CREATE TABLE `toppings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `toppings`
--

INSERT INTO `toppings` (`id`, `name`, `price`, `is_available`) VALUES
(1, 'Hạt nổ', 5000.00, 1),
(2, 'Kem cheese', 5000.00, 1),
(3, 'Kem muối', 5000.00, 1),
(4, 'Kem trứng', 5000.00, 1),
(5, 'Thạch phô mai', 5000.00, 1),
(6, 'Trân châu đen', 5000.00, 1),
(7, 'Trân châu trắng', 5000.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cart_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cart_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`, `cart_data`) VALUES
(1, 'Admin User', 'admin@example.com', '0123456789', '$2y$12$502M7WDLZMIrx9xpS7FOYuZ0yYSMuQwYtYRNzfqX7ACa4MGUoZi2i', 'admin', 1, NULL, '2026-04-25 06:56:14', '2026-05-25 00:04:17', NULL),
(2, 'Trial User', 'user@example.com', '0987654321', '$2y$12$/waX4DpPyDd0M1qbAwhRjOxsoO0x2CJnT0dLy3G58LzaL1doNb1Gm', 'user', 1, NULL, '2026-04-25 06:56:14', '2026-05-25 06:57:24', '{\"30_f6383428b86fcf5dd16653be0ee5ff67\":{\"product_id\":\"30\",\"quantity\":1,\"options\":[],\"toppings\":[]}}'),
(3, 'Test User', 'testuser@example.com', NULL, '$2y$12$scoAuTENqETxOLCaN6lje.ZxGFxhTmzwLiIuqp/c4z9bnv4ROmdLa', 'user', 1, NULL, '2026-04-25 00:05:32', '2026-05-25 00:05:32', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(15) NOT NULL,
  `address_line` text NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `recipient_name`, `recipient_phone`, `address_line`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 2, 'Nguyen Van A', '0912345678', '123 Duong Le Loi, TP. HCM', 1, '2026-05-26 05:50:32', '2026-05-26 06:08:04');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `cart_item_options`
--
ALTER TABLE `cart_item_options`
  ADD PRIMARY KEY (`cart_item_id`,`option_value_id`),
  ADD KEY `option_value_id` (`option_value_id`);

--
-- Chỉ mục cho bảng `cart_item_toppings`
--
ALTER TABLE `cart_item_toppings`
  ADD PRIMARY KEY (`cart_item_id`,`topping_id`),
  ADD KEY `topping_id` (`topping_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `option_groups`
--
ALTER TABLE `option_groups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `option_values`
--
ALTER TABLE `option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_option_groups`
--
ALTER TABLE `product_option_groups`
  ADD PRIMARY KEY (`product_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Chỉ mục cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `option_groups`
--
ALTER TABLE `option_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `option_values`
--
ALTER TABLE `option_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `toppings`
--
ALTER TABLE `toppings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_item_options`
--
ALTER TABLE `cart_item_options`
  ADD CONSTRAINT `cart_item_options_ibfk_1` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_options_ibfk_2` FOREIGN KEY (`option_value_id`) REFERENCES `option_values` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_item_toppings`
--
ALTER TABLE `cart_item_toppings`
  ADD CONSTRAINT `cart_item_toppings_ibfk_1` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_toppings_ibfk_2` FOREIGN KEY (`topping_id`) REFERENCES `toppings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `option_values`
--
ALTER TABLE `option_values`
  ADD CONSTRAINT `option_values_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `product_option_groups`
--
ALTER TABLE `product_option_groups`
  ADD CONSTRAINT `product_option_groups_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_option_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
