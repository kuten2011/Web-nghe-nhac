-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 23, 2023 lúc 03:32 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `music_db`
--

CREATE DATABASE music_db;
USE music_db;
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `album_title` varchar(255) NOT NULL,
  `release_date` date DEFAULT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `albums`
--

INSERT INTO `albums` (`album_id`, `album_title`, `release_date`, `artist_id`) VALUES
(1000001, 'Sky Tour', '2020-06-12', 2000001),
(1000002, '22', '2022-08-18', 2000002),
(1000003, 'Wings', '2016-10-10', 2000003),
(1000004, 'Born Pink', '2022-09-16', 2000004),
(1000005, 'Youth', '2016-09-07', 2000003),
(1000006, 'More & More', '2020-06-01', 2000011),
(1000007, 'ME', '2023-03-31', 2000012),
(1000008, 'Nine Track Mind', '2016-01-29', 2000007),
(1000009, 'Love Yourself', '2018-07-16', 2000003),
(1000010, 'Stand Up', '2008-08-08', 2000009),
(1000011, 'SƠN TÙNG M-TP', '2017-04-01', 2000001),
(1000012, 'LOVER', '2019-08-23', 2000008),
(1000013, 'Wild Dreams', '2021-11-26', 2000013),
(1000014, 'The Best', '2021-06-16', 2000003);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(255) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `artists`
--

INSERT INTO `artists` (`artist_id`, `artist_name`, `genre`, `nationality`) VALUES
(2000001, 'Sơn Tùng M-TP', 'POP', 'Vietnam'),
(2000002, 'Mono', 'POP', 'Vietnam'),
(2000003, 'BTS', 'POP', 'Korean'),
(2000004, 'BLACKPINK', 'POP', 'Korean'),
(2000005, 'Hòa Minzy', 'POP', 'Vietnam'),
(2000006, 'Đen Vâu', 'POP', 'Vietnam'),
(2000007, 'Charlie Puth', 'POP', 'Europe'),
(2000008, 'Taylor Swift', 'POP', 'Europe'),
(2000009, 'BIGBANG', 'POP', 'Korean'),
(2000010, 'Ngọt Band', 'POP', 'Vietnam'),
(2000011, 'TWICE', 'POP', 'Korean'),
(2000012, 'Jisoo', 'POP', 'Korean'),
(2000013, 'Westlife', 'POP', 'Europe'),
(2000014, 'T-ara', 'POP', 'Korean');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookmark`
--

CREATE TABLE `bookmark` (
  `song_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookmark`
--

INSERT INTO `bookmark` (`song_id`, `user_id`) VALUES
(4000001, 5000001),
(4000001, 5000003),
(4000002, 5000001),
(4000002, 5000002),
(4000002, 5000003),
(4000003, 5000001),
(4000005, 5000002),
(4000005, 5000003),
(4000006, 5000003),
(4000009, 5000002),
(4000010, 5000003),
(4000011, 5000001),
(4000011, 5000003),
(4000016, 5000001),
(4000016, 5000002),
(4000016, 5000003),
(4000017, 5000001),
(4000018, 5000003),
(4000019, 5000002),
(4000019, 5000003),
(4000020, 5000003),
(4000021, 5000003),
(4000022, 5000003),
(4000023, 5000002),
(4000024, 5000002),
(4000026, 5000003),
(4000032, 5000002),
(4000033, 5000002),
(4000034, 5000002),
(4000038, 5000003),
(4000041, 5000003),
(4000044, 5000001),
(4000045, 5000001),
(4000046, 5000002),
(4000046, 5000003),
(4000047, 5000002),
(4000047, 5000003),
(4000048, 5000003),
(4000049, 5000002),
(4000050, 5000001),
(4000051, 5000001),
(4000052, 5000001);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `song_id`, `content`, `created_at`) VALUES
(1, 5000001, 4000009, 'Cháy thế nhờ ^0^', '2023-04-12 18:20:53'),
(2, 5000020, 4000019, 'Nhạc hay đấy!', '2023-01-10 15:32:48'),
(3, 5000011, 4000032, 'Hay quá nghe đi nghe lại vẫn hay', '2023-03-19 10:50:51'),
(4, 5000011, 4000001, 'Cháy thế nhờ ^0^', '2023-03-01 12:01:21'),
(5, 5000012, 4000042, 'XDXDXDXD', '2023-02-14 18:12:53'),
(6, 5000004, 4000050, 'Cháy thế nhờ ^0^', '2023-04-12 15:20:04'),
(7, 5000007, 4000029, 'Nghe cuốn ghê', '2023-04-14 18:20:53'),
(8, 5000006, 4000017, 'Cháy thế nhờ ^0^', '2023-04-15 12:45:20'),
(9, 5000006, 4000018, 'Đỉnh thế XDXD', '2023-03-15 10:20:53'),
(10, 5000017, 4000029, 'Nghe hay quá đi <3 cảm ơn chủ thớt <3 <3', '2023-03-16 17:49:53'),
(12, 5000016, 4000035, 'Nhạc hay quá', '2023-02-12 15:52:53'),
(13, 5000015, 4000027, 'Cháy thế nhờ ^0^', '2023-01-13 12:42:02'),
(14, 5000008, 4000021, 'Nhạc hay quá nghe nghiện luôn', '2023-01-17 18:43:53'),
(15, 5000002, 4000033, 'Nghe hoài không chán XD', '2023-02-18 18:17:14'),
(16, 5000002, 4000044, 'Phải like thôi,  tuyệt quá mà ^0^', '2023-03-19 22:18:53'),
(17, 5000015, 4000006, 'Nghe riết bị ghiền lun ^0^', '2023-04-20 15:20:04'),
(18, 5000016, 4000020, 'Thích bài này quá', '2023-01-21 10:20:02'),
(19, 5000015, 4000002, 'Chất lượng thật sự ^0^', '2023-02-23 08:11:51'),
(20, 5000005, 4000041, 'Lời hay thật sự', '2023-03-07 15:38:50'),
(21, 5000005, 4000047, 'Bài này hay quá', '2023-03-08 18:29:03'),
(22, 5000020, 4000036, 'Nghe lâu rồi vẫn thích', '2023-04-09 07:20:05'),
(23, 5000012, 4000038, 'Cháy thế nhờ ^0^', '2023-04-01 18:26:53'),
(24, 5000018, 4000021, 'Cuối cùng cũng tìm được bài này.', '2023-04-10 08:33:11'),
(25, 5000001, 4000010, 'Hay quá à!!', '2023-03-25 12:44:02'),
(26, 5000002, 4000030, '100đ cho bài hát này <3', '2023-03-26 10:55:53'),
(27, 5000001, 4000022, 'Tui nghe nghiện luôn rồi', '2023-02-27 18:20:22'),
(28, 5000007, 4000012, 'Nghe hay thật sự đặc biệt là nghe bằng headphone', '2023-02-28 12:11:04'),
(29, 5000008, 4000011, 'Ume ngay từ lần đầu nghe', '2023-01-30 08:19:53'),
(30, 5000008, 4000046, 'Bài này hay qá ạ <3 <3', '2023-01-31 10:32:44'),
(31, 5000002, 4000022, 'sdsdsd', '0000-00-00 00:00:00'),
(32, 5000002, 4000022, 'aaaaaa', '0000-00-00 00:00:00'),
(33, 5000002, 4000022, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '0000-00-00 00:00:00'),
(34, 5000002, 4000016, 'aaaaaaaaaaaaaaaaaaaaaaaaa', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `playlists`
--

CREATE TABLE `playlists` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `last_modified` date DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `playlists`
--

INSERT INTO `playlists` (`playlist_id`, `playlist_name`, `last_modified`, `user_id`) VALUES
(3000001, 'chill_songs', '2023-04-16', 5000001),
(3000002, 'korea_songs', '2023-04-15', 5000002),
(3000003, 'vietnam_songs', '2022-09-12', 5000003);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `playlist_songs`
--

CREATE TABLE `playlist_songs` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `playlist_songs`
--

INSERT INTO `playlist_songs` (`playlist_id`, `song_id`) VALUES
(3000002, 4000007),
(3000001, 4000002),
(3000001, 4000042),
(3000001, 4000043),
(3000002, 4000004),
(3000002, 4000006);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`rating_id`, `user_id`, `song_id`, `rating`, `created_at`) VALUES
(1, 5000001, 4000009, 4, '2023-04-12 18:26:20'),
(2, 5000002, 4000005, 1, '2023-04-12 18:29:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `song_title` varchar(255) NOT NULL,
  `duration` time DEFAULT NULL,
  `listens` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `songs`
--

INSERT INTO `songs` (`song_id`, `song_title`, `duration`, `listens`, `album_id`, `artist_id`) VALUES
(4000001, 'Chạy Ngay Đi', '00:04:33', 10, 1000001, 2000001),
(4000002, 'Lạc Trôi', '00:04:33', 6, 1000001, 2000001),
(4000003, 'Waiting For You', '00:04:26', 2, 1000002, 2000002),
(4000004, 'Do You', '00:03:42', 2, 1000002, 2000002),
(4000005, 'Interlude : Wings', '00:02:25', 1, 1000003, 2000003),
(4000006, '2! 3!', '00:04:33', 0, 1000003, 2000003),
(4000007, 'Shut Down', '00:03:01', 8, 1000004, 2000004),
(4000008, 'Yeah Yeah Yeah', '00:02:59', 1, 1000004, 2000004),
(4000009, 'Bật Tình Yêu Lên', '00:03:40', 0, NULL, 2000005),
(4000010, 'Thị Mầu', '00:04:12', 1, NULL, 2000005),
(4000011, 'Not Today', '00:03:52', 2, 1000013, 2000003),
(4000012, 'Ready For Love', '00:03:06', 0, 1000004, 2000004),
(4000013, 'Hard to Love', '00:02:45', 0, 1000004, 2000004),
(4000014, 'Typa Girl', '00:03:00', 0, 1000004, 2000004),
(4000015, 'Tally', '00:03:05', 1, 1000004, 2000004),
(4000016, 'Chúng ta không thuộc về nhau', '00:04:08', 23, 1000001, 2000001),
(4000017, 'Remember Me', '00:03:23', 3, 1000001, 2000001),
(4000018, 'Em Của Ngày Hôm Qua', '00:04:06', 2, 1000001, 2000001),
(4000019, 'Hãy Trao Cho Anh', '00:04:13', 2, 1000001, 2000001),
(4000020, 'Chắc Ai Đó Sẽ Về', '00:04:44', 4, 1000001, 2000001),
(4000021, 'Buông', '00:02:29', 0, 1000002, 2000002),
(4000022, 'Em Là', '00:03:17', 9, 1000002, 2000002),
(4000023, 'Kill Me', '00:03:49', 0, 1000002, 2000002),
(4000024, 'Quên Anh Đi', '00:04:06', 1, 1000002, 2000002),
(4000025, 'Begin', '00:04:06', 0, 1000003, 2000003),
(4000026, 'First Love', '00:03:12', 2, 1000003, 2000003),
(4000027, 'Reflection', '00:03:55', 0, 1000003, 2000003),
(4000028, 'Fire', '00:04:55', 3, 1000005, 2000003),
(4000029, 'Dope', '00:04:17', 1, 1000005, 2000003),
(4000030, 'I Need U', '00:03:32', 1, 1000005, 2000003),
(4000031, 'More & More', '00:03:20', 0, 1000006, 2000011),
(4000032, 'Oxygen', '00:03:45', 0, 1000006, 2000011),
(4000033, 'Firework', '00:03:13', 0, 1000006, 2000011),
(4000034, 'Flower', '00:03:07', 0, 1000007, 2000012),
(4000035, 'DNA', '00:03:42', 0, 1000009, 2000003),
(4000036, 'Mic Drop', '00:04:04', 1, 1000009, 2000003),
(4000037, 'Paradise', '00:03:29', 0, 1000009, 2000003),
(4000038, 'Haru Haru', '00:04:16', 2, 1000010, 2000009),
(4000039, 'My Heaven', '00:03:53', 1, 1000010, 2000009),
(4000040, 'A Good Man', '00:03:26', 2, 1000010, 2000009),
(4000041, 'Nơi Này Có Anh', '00:04:20', 2, 1000011, 2000001),
(4000042, 'Chúng Ta Không Thuộc Về Nhau', '00:03:53', 2, 1000011, 2000001),
(4000043, 'Cơn Mưa Ngang Qua', '00:03:54', 2, 1000011, 2000001),
(4000044, 'Nắng Ấm Xa Dần', '00:03:11', 1, 1000011, 2000001),
(4000045, 'Không Phải Dạng Vừa Đâu', '00:04:06', 3, 1000011, 2000001),
(4000046, 'I Forgot That You Existed', '00:02:50', 2, 1000012, 2000008),
(4000047, 'Lover', '00:03:41', 1, 1000012, 2000008),
(4000048, 'The Man', '00:03:10', 1, 1000012, 2000008),
(4000049, 'Sexy Love', '00:03:46', 2, 1000013, 2000013),
(4000050, 'Sugar Free', '00:03:56', 0, NULL, 2000014),
(4000051, 'Roly Poly', '00:03:34', 0, NULL, 2000014),
(4000052, 'Lovey Dovey', '00:03:12', 0, NULL, 2000014);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(7) NOT NULL,
  `admin_rights` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `date_of_birth`, `gender`, `admin_rights`) VALUES
(5000001, 'username1', 'Username1@', 'user1@gmail.com', '1970-01-01', 'female', 0),
(5000002, 'username2', 'Username2@', 'user2@gmail.com', '2015-04-08', 'female', 0),
(5000003, 'username3', 'Username3@', 'user3@gmail.com', '2003-04-18', 'male', 0),
(5000004, 'username4', 'Username4@', 'user4@gmail.com', '2002-04-19', 'female', 0),
(5000005, 'username5', 'Username5@', 'user5@gmail.com', '2000-02-12', 'male', 0),
(5000006, 'username6', 'Username6@', 'user6@gmail.com', '2023-04-10', 'male', 0),
(5000007, 'username7', 'Username7@', 'user7@gmail.com', '2015-09-08', 'female', 0),
(5000008, 'username8', 'Username8@', 'user8@gmail.com', '2005-01-01', 'male', 0),
(5000009, 'username9', 'Username9@', 'user9@gmail.com', '2002-04-11', 'female', 0),
(5000010, 'username10', 'Username@10', 'user110@gmail.com', '2000-02-12', 'male', 0),
(5000011, 'username11', 'Username11@', 'user11@gmail.com', '2007-01-21', 'male', 0),
(5000012, 'username12', 'Username12@', 'user12@gmail.com', '2001-02-24', 'female', 0),
(5000013, 'username13', 'Username13@', 'user13@gmail.com', '2013-03-18', 'male', 0),
(5000014, 'username14', 'Username14@', 'user14@gmail.com', '2007-04-19', 'female', 0),
(5000015, 'username15', 'Username15@', 'user15@gmail.com', '2010-07-12', 'male', 0),
(5000016, 'username16', 'Username16@', 'user16@gmail.com', '2023-04-10', 'male', 0),
(5000017, 'username17', 'Username17@', 'user17@gmail.com', '2015-09-30', 'female', 0),
(5000018, 'username18', 'Username18@', 'user18@gmail.com', '2003-10-08', 'male', 0),
(5000019, 'username19', 'Username19@', 'user19@gmail.com', '2007-11-19', 'female', 1),
(5000020, 'admin', '123456', 'user20@gmail.com', '2009-12-12', 'male', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Chỉ mục cho bảng `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Chỉ mục cho bảng `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`song_id`,`user_id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Chỉ mục cho bảng `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD KEY `playlist_id` (`playlist_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Chỉ mục cho bảng `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_unique` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000015;

--
-- AUTO_INCREMENT cho bảng `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2000015;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `playlists`
--
ALTER TABLE `playlists`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3000004;

--
-- AUTO_INCREMENT cho bảng `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4000053;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5000021;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`);

--
-- Các ràng buộc cho bảng `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Các ràng buộc cho bảng `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD CONSTRAINT `playlist_songs_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`),
  ADD CONSTRAINT `playlist_songs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  ADD CONSTRAINT `songs_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
