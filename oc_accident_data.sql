-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-12-03 07:15:26
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `accident`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `oc_accident_data`
--

CREATE TABLE `oc_accident_data` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `record_date` date DEFAULT NULL,
  `occurrence_date` date DEFAULT NULL,
  `recorder_name` varchar(255) DEFAULT NULL,
  `target_name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `oc_accident_data`
--

INSERT INTO `oc_accident_data` (`id`, `title`, `record_date`, `occurrence_date`, `recorder_name`, `target_name`, `details`) VALUES
(16, '工事現場での転倒', '2024-11-26', '2024-11-26', '島田太郎', '清水太郎', '転んだ'),
(17, '工事現場での転倒', '2024-11-26', '2024-11-26', '島田太郎', '清水太郎', '転んだ'),
(18, '工事現場での転倒', '2024-11-26', '2024-11-26', '山田太郎', '山田太郎', '転んだ');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `oc_accident_data`
--
ALTER TABLE `oc_accident_data`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `oc_accident_data`
--
ALTER TABLE `oc_accident_data`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
