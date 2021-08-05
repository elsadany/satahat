-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2021 at 05:12 AM
-- Server version: 10.3.30-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pomacinf_satahat`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `description_ar` text COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `description_en` text COLLATE utf8_general_mysql500_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title_ar`, `title_en`, `description_ar`, `description_en`) VALUES
(4, 'uploads/banners/08-2021/1628077754NIwVCAqORke4fjR.png', 'Maxime dicta et ut i', 'Velit labore ipsum t', 'Consectetur non quo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `image` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name_ar`, `name_en`, `image`) VALUES
(1, 'بى ام دابليو', 'BMW', NULL),
(2, 'مرسيدس', 'mercedes', 'uploads/banners/08-2021/1628080502qHAScqAFDjwFsBG.png'),
(3, 'At enim reprehenderi', 'Accusamus odio qui v', 'uploads/banners/08-2021/1628080663iS0XU3nTKW7b7tD.jpg'),
(5, 'بببببببببببب', 'aaaaaaa', 'uploads/banners/08-2021/1628080874q9QsoRBKJercBF8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`) VALUES
(2, 'riad', 'الرياض 22');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`user_id`, `job_id`) VALUES
(2, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` int(11) NOT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `secondary_specialist_id` int(11) NOT NULL,
  `id_image` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `car_number` varchar(30) COLLATE utf8_general_mysql500_ci NOT NULL,
  `driving_licence` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `insurance_number` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `authorize_image` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `bank_name` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `iban_id` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`user_id`, `city_id`, `main_specialist_id`, `secondary_specialist_id`, `id_image`, `brand_id`, `model`, `car_number`, `driving_licence`, `insurance_number`, `authorize_image`, `bank_name`, `iban_id`) VALUES
(4, 2, 1, 1, 'uploads/users/1624903239hh3MhZn7bOISpjE.png', 1, 2019, '1234', 'uploads/users/1624903239bZcyYXz2HPMTmdm.png', '24444', NULL, 'الرياض', '123'),
(21, 2, 1, 1, 'uploads/users/1627301166hWffIniv15jFC8U.jpeg', 1, 2011, '1234', 'uploads/users/1627301166KQTPGkuo8kjbiTr.jpeg', '33333', 'uploads/users/1627301166Oe5oTBmYXC2UZRK.jpeg', 'cib', '134'),
(22, 2, 1, 1, 'uploads/users/1627305272JfG1Ac9nNn5y1B1.jpeg', 1, 0, '1994', 'uploads/users/162730527298ibi5pA5TDu679.jpeg', '123123', 'uploads/users/1627305272lAC4dwWUoSemRCD.jpeg', 'sdasd', '123123a'),
(23, 2, 1, 1, 'uploads/users/1627305443NnkfRpqT1HwaarJ.jpeg', 1, 2019, '121212', 'uploads/users/1627305443HAofVYsUbpFiiGe.jpeg', '123123', NULL, 'asdasd666', '123123666'),
(24, 2, 1, 1, 'uploads/users/1627305986xJgVo3RLWCzOViZ.jpeg', 1, 2011, '1234', 'uploads/users/1627305986EX3LmVZ0DQwjbd9.jpeg', '33333', 'uploads/users/1627305986uT5cqYuaYj1DcQx.jpeg', 'cib', '1343'),
(33, 2, 1, 1, 'uploads/users/1627819323KrUTleCYlrCUZjE.png', 1, 2011, '1234', 'uploads/users/1627819323yIUnMCYUDw2hIDm.png', '33333', 'uploads/users/1627819323fbb73dfjqwA3zvY.png', 'الرياض', '123c'),
(34, 2, 1, 1, 'uploads/users/1627823481uTtL5ffDt1IrEZa.png', 1, 2011, '1234', 'uploads/users/1627823481hKi7AHM1mtacudo.png', '33333', 'uploads/users/1627823481NBRrY0alEglAtvf.png', 'البنك العربي', '1234567897'),
(40, 2, 1, 1, 'uploads/users/1627928580SNkckW1l2cGdnUV.jpg', 1, 0, 'ونون', 'uploads/users/1627928580rLwE4VS4iGakUd6.jpg', 'ن ن ن', 'uploads/users/1627928580Gsd2ByTh655XoTB.jpg', 'ةغعو', 'غةعة'),
(41, 2, 1, 1, 'uploads/users/1627944424X5jBfVEBrm3JuUb.png', 1, 2011, '1234', 'uploads/users/1627944424MpEv2hcdpkrjESD.png', '33333', NULL, 'ttt', '111');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name_ar`, `name_en`) VALUES
(1, 'مهندس مدنى', 'civil engineer');

-- --------------------------------------------------------

--
-- Table structure for table `main_specialists`
--

CREATE TABLE `main_specialists` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `main_specialists`
--

INSERT INTO `main_specialists` (`id`, `name_ar`, `name_en`) VALUES
(1, 'سطحات', 'surfaces'),
(3, 'Ginger Dillon', 'Aspen Leach'),
(4, 'سسسسسسسسسس222', 'ب'),
(5, 'سيارات', 'cars');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2020_12_13_161507_create_users_table', 1),
(7, '2021_01_10_202422_add_column_to_users_table', 1),
(8, '2021_02_01_170530_add_remmember_token_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'ttttt', 33, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0149740706473c3245cb1008492c87601318dc933f030cac8aa702d80a45fb899872b5d47a7cfd57', 6, 1, 'Personal Access Token', '[]', 0, '2021-07-13 17:16:53', '2021-07-13 17:16:53', '2022-07-13 12:16:53'),
('07287efdf9e92ae2b1ad2f0e1a8ae36edd4f5a319cba5b37fd1f693d7931db2aa6cde9310762bf2e', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-03 15:12:02', '2021-08-03 15:12:02', '2022-08-03 10:12:02'),
('07877e5e2e2d25833218ed7fefe823e7188db56b6dfc1ff5089b41e6861674e7a8911dad833c6037', 38, 1, 'Personal Access Token', '[]', 0, '2021-08-02 19:27:19', '2021-08-02 19:27:19', '2022-08-02 14:27:19'),
('0af6f8cb03b626f69dc87b2dc9dd1f48e0ad7d8812376409cad32133a191e58259df8f674e87aeaa', 26, 1, 'Personal Access Token', '[]', 0, '2021-07-28 17:13:45', '2021-07-28 17:13:45', '2022-07-28 12:13:45'),
('0b403b161091e1f49a02f1ddb4144698c57d6e8017a66f77e3d35ed0ac84cb6954a0df31e1740552', 5, 1, 'Personal Access Token', '[]', 0, '2021-08-04 16:35:17', '2021-08-04 16:35:17', '2022-08-04 11:35:17'),
('0ff8cf36574fc7bae8f13905e167924d047509de3f96b9849a8c1ef91ae0d688bda079a2e0d43679', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:38:33', '2021-07-15 15:38:33', '2022-07-15 10:38:33'),
('11e44d472fa4fc8d9b3b3883f7810d63ff59cc433484d56fe1427423a64636551a269508f08058d2', 2, 1, 'Personal Access Token', '[]', 0, '2021-08-02 19:53:52', '2021-08-02 19:53:52', '2022-08-02 14:53:52'),
('122caaa7fa2a3839bc6f674387bb89f171312a760c374029739f49e71cd0f69a90cbda729920549c', 34, 1, 'Personal Access Token', '[]', 0, '2021-08-01 18:11:21', '2021-08-01 18:11:21', '2021-08-15 13:11:21'),
('13dee7049dfec46f06736aff429243dcc8dcee444b6dbc7b3d14c57548cdb87097017a5d6e28c4e5', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:39:13', '2021-08-04 18:39:13', '2022-08-04 13:39:13'),
('13f43d808b13c3b93cc04411350ac9cda93fdcaf96bd7b2f694bee838ee4cde2b470e7a4b1ddd48d', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:39:26', '2021-08-02 16:39:26', '2022-08-02 11:39:26'),
('15a9e5e7147b715a2d43e5161a882faca6b993eb00b4027216d4c909c2581071a24bc3e745b575b7', 49, 1, 'Personal Access Token', '[]', 0, '2021-08-03 20:23:48', '2021-08-03 20:23:48', '2022-08-03 15:23:48'),
('16cba9dc7672c6a7fda6e09e6c34e7f6fc0b666dd1a373cb85849e07a6a6ffc504e414be57b49c0c', 54, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:21:41', '2021-08-04 19:21:41', '2022-08-04 14:21:41'),
('16e1c9a79b64a2cfd0ff0afd21ea185c13b9e49e29a3b494b9ed6040adace85fd36acc61d3c11153', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:41:49', '2021-08-04 18:41:49', '2022-08-04 13:41:49'),
('181e6cde40a52dc8ab15e5bc89e8e16c31a6b71d8d1ae3da6bcf1945ab39bdcbf1965fc5ea0cc618', 32, 1, 'Personal Access Token', '[]', 0, '2021-08-01 16:58:09', '2021-08-01 16:58:09', '2022-08-01 11:58:09'),
('185f8ca1733771c68edd06ec2241c61c329773b2f95d006080ba82edb9dd99e0497661c14cb8f7f9', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:07:18', '2021-08-04 19:07:18', '2022-08-04 14:07:18'),
('19e3c727289be15a3da0783cfe30773c195247a9abf224b9eb8f4c5ee4271acc9c6a24e1959fae95', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:16:14', '2021-07-15 15:16:14', '2022-07-15 10:16:14'),
('1db792242df6f50dbe25b5e4de8045571ecff3012368c5f4a36a25455357d8cc065ae17160293f97', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:24:28', '2021-08-02 16:24:28', '2022-08-02 11:24:28'),
('1e09231126e6e812dbf01a5286cfc646d52eef4f7bbc273a36f50856a956e586a634eae70433c7e1', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-01 18:10:17', '2021-08-01 18:10:17', '2022-08-01 13:10:17'),
('201e8a3204382313293b4c833ededc88fedbd038a92ae7bf8910507dc235bda8cf094c7de404afa1', 40, 1, 'Personal Access Token', '[]', 0, '2021-08-02 23:23:00', '2021-08-02 23:23:00', '2021-08-16 18:23:00'),
('201fb7896485b30a7516f42afcbf28dd3def3ee5eac68fa14abec3cc084c4eb33b85671db6939f9f', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:54:13', '2021-08-04 20:54:13', '2022-08-04 15:54:13'),
('23d5299277e93e4066d3ca70c10b6f55bc7e3c93527ad647b1eab37240316743d65f17798802f4e4', 23, 1, 'Personal Access Token', '[]', 0, '2021-07-26 18:17:23', '2021-07-26 18:17:23', '2021-08-09 13:17:23'),
('24813ee4c4abb914baac12dfc67dc93aa7da9cc7549ee495690b97deeacac5d2111a3cf7dcb7d6f1', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:49:55', '2021-08-04 20:49:55', '2022-08-04 15:49:55'),
('256b05316171ec90707cdb00721abb3c949bb2fdb0204158f10fa8364d847dc9e0204659d4f70e0f', 5, 1, 'Personal Access Token', '[]', 0, '2021-08-04 17:33:56', '2021-08-04 17:33:56', '2022-08-04 12:33:56'),
('26849da43f16743d28ea79567fc76bcbe83603d95d9653063391d10955ad3b719b1940222e9db779', 5, 1, 'Personal Access Token', '[]', 0, '2021-06-29 11:06:38', '2021-06-29 11:06:38', '2022-06-29 13:06:38'),
('298325da6f26ab7925b0bf9061f41318a9c575b1507e8598e2047edbe3c2187862d4afb39be63203', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-02 20:58:53', '2021-08-02 20:58:53', '2022-08-02 15:58:53'),
('29a85bc4c037700d5e39759d707ff6791909e29d9239d8335e6c12d4382652b128c16b7d3341bf9c', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:41:49', '2021-08-04 18:41:49', '2022-08-04 13:41:49'),
('29d3bdad32af07bcd6962c69ab39b0d8512ce286167d4f6181796a751add48cb1ab6b5e81830c789', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 15:28:42', '2021-08-04 15:28:42', '2022-08-04 10:28:42'),
('2ceb5ee06ffa32043f10ecf50e27a1b815d980d2a2a12ed064fabb4a6a27a5456edcb87a59247013', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:53:46', '2021-08-04 18:53:46', '2022-08-04 13:53:46'),
('2d64989b69ce11ef05ede4da1417d2033b8664304ed678fa63418e2905cfb09958c56cf7a7e51958', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:12:46', '2021-07-15 15:12:46', '2022-07-15 10:12:46'),
('2ebc8b9534eb3df7418c3699296df3586705d1485e48ce4c798cbd8c84b7fb083ec62deffb92e78e', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:35:31', '2021-08-04 18:35:31', '2022-08-04 13:35:31'),
('320d6b12e5c43d50591e7a78a563153c6a2308728b7053a27270ff01a967acb8c821da2dfb5f107a', 25, 1, 'Personal Access Token', '[]', 0, '2021-07-28 16:50:29', '2021-07-28 16:50:29', '2022-07-28 11:50:29'),
('32c4040208230cc6085c46b8dbca1332894078bfed5a68b8b3c3b79156df50377f9195f6a9099f57', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:44:10', '2021-08-04 20:44:10', '2022-08-04 15:44:10'),
('32ee16a6bc7e2a0ed8441659be72a91bb614e13582f10c9deab6c2ba8dc4c340967b358861334fe8', 16, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:37:27', '2021-07-15 15:37:27', '2022-07-15 10:37:27'),
('36a313641d22a5f3e00424475dfe0705057fe61caee9aa35060bda2f0642ebd34b3a975c37b720aa', 8, 1, 'Personal Access Token', '[]', 0, '2021-07-14 16:30:03', '2021-07-14 16:30:03', '2022-07-14 11:30:03'),
('37277c1095e32f16f4858224ceea5c7c6afa81b387fc060d723215403b246e61c8ae31f232545f7f', 23, 1, 'Personal Access Token', '[]', 0, '2021-07-26 18:20:29', '2021-07-26 18:20:29', '2022-07-26 13:20:29'),
('380e40ff794774810dcdf0f8f16d2aab934fec79bd2b53bd5190bcdf9a6df66a0b041ecdce6a5c74', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:39:24', '2021-08-04 19:39:24', '2022-08-04 14:39:24'),
('3851c6ffe3b5d58b6222327e20ac73156d3dcb3c7566c7a04d07e4ab018551d8bcb69e9219b862a5', 44, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:13:02', '2021-08-03 19:13:02', '2022-08-03 14:13:02'),
('389dd91432bd0c86cb3e9854d7e9ce7ae39b97c038e1369799c241c2b819979a6f9f049c2310f852', 41, 1, 'Personal Access Token', '[]', 0, '2021-08-03 03:47:04', '2021-08-03 03:47:04', '2021-08-16 22:47:04'),
('39c8b2e78e8321075b0d19fd080358bf6a737ae53cd0f57985cebcdf8197bc238507ef789236ad5a', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-03 15:16:33', '2021-08-03 15:16:33', '2022-08-03 10:16:33'),
('3b3ab928f300d3f69e38267a6c638635d5337f9ba4167add2439e05bd91592b67a0bb83702b62a1e', 24, 1, 'Personal Access Token', '[]', 0, '2021-07-26 18:26:26', '2021-07-26 18:26:26', '2021-08-09 13:26:26'),
('3d58f2e039d5d5a6336aea8ceebc39f10213cb34b6ae672d33ed74fc1d0af000cb50e5a15f116008', 46, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:22:37', '2021-08-03 19:22:37', '2022-08-03 14:22:37'),
('3dd2d1868a6c6c2adc598691123bf6fc03782c2794fbc4752b685a817dc3a851cd7202fe583f2daf', 55, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:22:20', '2021-08-04 19:22:20', '2022-08-04 14:22:20'),
('41cd89a1067dd8debb3386c75e398d3f1f69b3dd1cf4289826bbd50c769c6dda00c1d433b12140ea', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-03 17:57:03', '2021-08-03 17:57:03', '2022-08-03 12:57:03'),
('41d41d561474bdf4016c70045659af8d490058abc85b6b0e633bebf2d1435b52b413b91dfb3bb463', 10, 1, 'Personal Access Token', '[]', 0, '2021-07-14 17:00:11', '2021-07-14 17:00:11', '2022-07-14 12:00:11'),
('43256118571bfe2607369f83a201a2c63dfcd5fc329ae5c1cfc178e9860e66785107dcc30e803231', 17, 1, 'Personal Access Token', '[]', 0, '2021-07-15 16:08:19', '2021-07-15 16:08:19', '2022-07-15 11:08:19'),
('44a1b4f3807a333e11faf4d57531a27381f326dae0ce81f8c22b3583fe56b0c42307c29477e2c95f', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-03 16:26:00', '2021-08-03 16:26:00', '2022-08-03 11:26:00'),
('472a2c53aa32443d5ecf05654ca12e3ad6548cfac67b3f51c5aec1c39af08c2cddb3ea5e853e5530', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:23:56', '2021-08-02 16:23:56', '2022-08-02 11:23:56'),
('48140c0858f53eddae8bdb0abf584ab7adb0398e34a946d278cda93499e6e1c0f7708b045c8f7727', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 15:42:11', '2021-06-28 15:42:11', '2022-06-28 17:42:11'),
('485d61088380afe3e8622ee303b24362eeec6c8b8084cde5115d7ea3aa88f916e114b3d2c67d09c6', 45, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:19:10', '2021-08-03 19:19:10', '2022-08-03 14:19:10'),
('4fc0b18b364c0adffb26ca6e955ddf9a0e00313602ef4353e82cbc1132c2afc0ce07f1397fa00846', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 15:44:43', '2021-08-04 15:44:43', '2022-08-04 10:44:43'),
('4fef77bf73f727faed326b08d311db4e7a1e5f4ba8ae8e86ef826cdaaccece3b69ade95d4a3bf2f7', 14, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:08:25', '2021-07-15 15:08:25', '2022-07-15 10:08:25'),
('542e527f087eabc7563b34bda8d5213e4077a1b2532bde9690ec2bd3f61f2cef4034845c556381cc', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-03 17:42:37', '2021-08-03 17:42:37', '2022-08-03 12:42:37'),
('596aaa1fbd00278bae7ee66b620d6c3fcc715dfa0e014dd4de1af71b410d5fab9fb5ca717deaccb8', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:04:29', '2021-08-04 19:04:29', '2022-08-04 14:04:29'),
('5de0f3cd15d3d99b93ffa1ffb68fdde12dc02d2029561211511e7ac2ecaa4d7f76b2113cdbce9da9', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:47:20', '2021-08-04 20:47:20', '2022-08-04 15:47:20'),
('5e6cfae9f2ed394096f4c8cf7ed7cbbb7831c8b11ff4173b0339aa58d6a2818be5d9f1b3ae8627c1', 39, 1, 'Personal Access Token', '[]', 0, '2021-08-02 20:45:44', '2021-08-02 20:45:44', '2022-08-02 15:45:44'),
('5eb83f71b8c1fcf0af329c85601d9b39e60b2ef55b8875468d9c46ef50f7e3f260c60d7db6480518', 5, 1, 'Personal Access Token', '[]', 0, '2021-08-04 16:34:53', '2021-08-04 16:34:53', '2022-08-04 11:34:53'),
('616b127ef40be1e92fd077d287d3837a21d3098586c6577b979b65ffa53326a8b61104290750168c', 19, 1, 'Personal Access Token', '[]', 0, '2021-07-15 16:28:59', '2021-07-15 16:28:59', '2022-07-15 11:28:59'),
('6341461bd49c905f55fc0d3a108849e96f8f95052e82b617e97b858024f1e6c47bc3de98cf3dc00f', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:37:47', '2021-08-02 16:37:47', '2022-08-02 11:37:47'),
('64cbaf5b79a39a11e5369b3403b7d8e9ae824ab1d7ee088f9221f943cf93f1baefc33ba837f04cab', 47, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:26:36', '2021-08-03 19:26:36', '2022-08-03 14:26:36'),
('6beca2b9bc601fd4b6bd904dc72a469c16d8d72311c5d1116829c238b8978c2b6683cc171e6bec09', 5, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:21:11', '2021-07-15 15:21:11', '2022-07-15 10:21:11'),
('6c9d5d457044cd794c8b21c22ecbafbbb86bd577687160766c240357903bcd397cab1b529bc589da', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:12:20', '2021-08-04 19:12:20', '2022-08-04 14:12:20'),
('6cbf810b903d8e40f57e0996fb58365dd0e4156ad0399406a2a766cfaa47b5f81da422d4b15de737', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:22:33', '2021-08-04 19:22:33', '2022-08-04 14:22:33'),
('6d6ad8714bf9dcd6c13ea860ff96aadd675d0200e52e94c606ec09468a630025f910253e22faba2d', 5, 1, 'Personal Access Token', '[]', 0, '2021-08-04 15:33:38', '2021-08-04 15:33:38', '2022-08-04 10:33:38'),
('74e3a62ccb19805a2eeb4e7194da5c252341a26e4f6c38171600b665020db8fb0b726f9a3f314686', 41, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:09:45', '2021-08-03 19:09:45', '2022-08-03 14:09:45'),
('7585e37cac23bb1f4047ebf3f12052eb3fe6489183cb6ed15fc1fea513785bb0b68e83e128c8ef4f', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-15 13:00:31', '2021-07-15 13:00:31', '2022-07-15 08:00:31'),
('75ef62ce162046928e23c102b30dd90a107412f10c84816a419e7c18a5249c552dd5b790a23026de', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:31:20', '2021-08-04 18:31:20', '2022-08-04 13:31:20'),
('76d27a16388690b222862c6d273bac3c14c5ad4f1939bd66a160fff5c0479cf5faace6dea531d79a', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:37:16', '2021-08-04 19:37:16', '2022-08-04 14:37:16'),
('76eeebbf7dbbeac61f9c23485a63589ab2bd2f5839738757b11e59b7344d3191448b77daa3ae130f', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-02 17:54:09', '2021-08-02 17:54:09', '2022-08-02 12:54:09'),
('778786678e7e1008d072e8798feb73d1d30fc5a7445d28a36cec0ed8de2ede7b693bdae9b96e9363', 50, 1, 'Personal Access Token', '[]', 0, '2021-08-03 20:24:14', '2021-08-03 20:24:14', '2022-08-03 15:24:14'),
('7a0376d9cf881f03b8ce094f73f9c8824614da9453d940aefd18d7c3a4f443e6aa3c5fdeb19beafe', 9, 1, 'Personal Access Token', '[]', 0, '2021-07-14 16:33:41', '2021-07-14 16:33:41', '2022-07-14 11:33:41'),
('7b3efc486b929736dbf0d92c24539c8b247589dcbfa80e9d768ce0ad98125836cfe807568f028d32', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 17:10:34', '2021-08-04 17:10:34', '2022-08-04 12:10:34'),
('7bc81eb0627496845e29feca48172171e03b6b08c8e862bbfc7057f5084c44678d9a9ede171b5770', 27, 1, 'Personal Access Token', '[]', 0, '2021-07-28 17:22:55', '2021-07-28 17:22:55', '2022-07-28 12:22:55'),
('7db317a35a2d9fc44586bb0b0451bb32509c3c022d006bb3d379e318abcac8c4a115e7bc54a52782', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 16:44:09', '2021-08-04 16:44:09', '2022-08-04 11:44:09'),
('7df5bea11acb8f09119a6bd82b3a95856665d27784c52299efb1c803e920227302053f0fe4c44182', 23, 1, 'Personal Access Token', '[]', 0, '2021-07-27 20:51:16', '2021-07-27 20:51:16', '2022-07-27 15:51:16'),
('83d796b8be553efd220d9c296ff3466b40e57839f7a0ea689166cc987146dcb05ac56144e991709c', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-27 20:33:45', '2021-07-27 20:33:45', '2022-07-27 15:33:45'),
('844d406c317448ff0cf8e7470a5d84fc62486473b508b302296a099d21a3cc35c154d3c47778eed9', 23, 1, 'Personal Access Token', '[]', 0, '2021-07-27 13:45:37', '2021-07-27 13:45:37', '2022-07-27 08:45:37'),
('85670f4156f2d7c4831b0d807f9949f32de8000f4b6170515d319d4f655e6ad8fba767156e1f48bb', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:19:28', '2021-08-04 19:19:28', '2022-08-04 14:19:28'),
('85fe37575e1281c9e16b81b0ba1b9f0eaa26b0bd593da97bbbcc3739f4c714692ebce62aab9fa662', 21, 1, 'Personal Access Token', '[]', 0, '2021-07-26 17:06:06', '2021-07-26 17:06:06', '2021-08-09 12:06:06'),
('89d106467d1c64252fe8f86bde39eb44756ebcfa89efacb89ccbd3e6d1e7b6b0643aa7853548da60', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:48:32', '2021-08-04 20:48:32', '2022-08-04 15:48:32'),
('8e200027fc1077ef60ab0a610621ca4e14983ad36d41840c3d4461a1920448b63236d7b7d0d06e1d', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:57:32', '2021-08-04 18:57:32', '2022-08-04 13:57:32'),
('8e5dfad82e78d24c88e42ce87ea0a1715a5a4736e752e6c4536085a0bb03a28728a3403686313415', 5, 1, 'Personal Access Token', '[]', 0, '2021-08-04 15:59:14', '2021-08-04 15:59:14', '2022-08-04 10:59:14'),
('8e824a9584998e60fa1c77083b3d4c134928229cc9d4f095651dc61cf3b3af49652cd9cec9ebb71c', 4, 1, 'Personal Access Token', '[]', 0, '2021-06-29 10:52:23', '2021-06-29 10:52:23', '2022-06-29 12:52:23'),
('945d923d07067ac4c6bd4d7e02e6c6a66de7214bff89a7423869e51fd6b6f6966c1777ea7acda0c5', 18, 1, 'Personal Access Token', '[]', 0, '2021-07-15 16:24:53', '2021-07-15 16:24:53', '2022-07-15 11:24:53'),
('96d4a12510510606f835e3de9e3beff3ef547f90227ad273e43e8ba1bcde2933f4ea4a5c14a9256c', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:59:18', '2021-08-04 20:59:18', '2022-08-04 15:59:18'),
('97fabf32a7035aebe3d592ff9e36bdd3e08f94ec85ab2ce0c159b8f50c114f62cd1758d6fb8ea67c', 7, 1, 'Personal Access Token', '[]', 0, '2021-07-14 16:18:25', '2021-07-14 16:18:25', '2022-07-14 11:18:25'),
('9971ab852f358e12a1bdbe98a862724baa1c4f3132c279a3e73c6f37fdcc2103af686a18c42abcc9', 11, 1, 'Personal Access Token', '[]', 0, '2021-08-03 20:21:23', '2021-08-03 20:21:23', '2022-08-03 15:21:23'),
('9fa65562b5843f2f0d73de0282117b505faf0530b4cbee7e30dde100a591b4944ccd6911cfb7466b', 42, 1, 'Personal Access Token', '[]', 0, '2021-08-03 13:28:27', '2021-08-03 13:28:27', '2022-08-03 08:28:27'),
('a27ceddc1334364f51601e679cd4c3ce91fa759a2719aa80701bae35eeaee6e476e89fa5c44c6c54', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:52:18', '2021-08-04 20:52:18', '2022-08-04 15:52:18'),
('a4a20f4b24f7ee63dfe087a21386335b9ea454d403823872bdacf406337daa456239ff9c42fd0ee5', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-01 17:02:03', '2021-08-01 17:02:03', '2021-08-15 12:02:04'),
('aeecb5328479a55e9443458f88e0087a3e58c1f52db86d05fb3f8595c3e9841058850db43a4ed76f', 11, 1, 'Personal Access Token', '[]', 0, '2021-08-04 17:22:06', '2021-08-04 17:22:06', '2022-08-04 12:22:06'),
('b396ad96eba50ffa48fdfc28d9de26f19e07bab61b744402b4ca268fc98503b9f7da29aa56f7eff5', 29, 1, 'Personal Access Token', '[]', 0, '2021-08-01 13:43:07', '2021-08-01 13:43:07', '2022-08-01 08:43:07'),
('b4b5dbcaa1cba596d8819f880a8f581b3980c556573c781fe61dc3319bba5933c02dd39ea01eec3c', 37, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:26:23', '2021-08-02 16:26:23', '2022-08-02 11:26:23'),
('bb23cc5a29c6fe87837ef3fc4f0df5326c1e9cf2706f775b2db367eaaba7594fed109e8a90f23cdc', 23, 1, 'Personal Access Token', '[]', 0, '2021-07-29 18:25:27', '2021-07-29 18:25:27', '2022-07-29 13:25:27'),
('bd8cc60812e6e07cc224c33ce10ddbbc3dd8285f6917bf0d4f7cb2537557a4a23ecd0b44c2977bb9', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:33:44', '2021-08-04 18:33:44', '2022-08-04 13:33:44'),
('bf134b956ebcd432afa584a671e9f126c82d4e4301b909412691ed3fdf46720380d04178f320d46d', 43, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:12:59', '2021-08-03 19:12:59', '2022-08-03 14:12:59'),
('bf664fa6ceb4929dc47f149485bfc1a5a0bbbafb2a87247d3de0205f59955da9bcdcef3b5ed5fa66', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 16:09:06', '2021-06-28 16:09:06', '2022-06-28 18:09:06'),
('c0ed26ee05f0d11b0d908bf2b04a11df7b1e7d3877ea9108294efcada567327b5754d277b984e14d', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 15:46:17', '2021-06-28 15:46:17', '2022-06-28 17:46:17'),
('c198aa80d3e48a5907a59d93ce2969bdfe25c511c983cd76276deac7a06eebac877b041082ac5b81', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 17:49:21', '2021-08-04 17:49:21', '2022-08-04 12:49:21'),
('c307f1c322bd357d80096f541768106aca1999e35cd108fc502e327fd569377d9b7c677d2a4d38ba', 31, 1, 'Personal Access Token', '[]', 0, '2021-08-01 16:01:45', '2021-08-01 16:01:45', '2022-08-01 11:01:45'),
('c456d7af717e35170ac28c3cf4709333638cd74e1e9cecb51e567a7a54d431c1eee19237ebf463de', 28, 1, 'Personal Access Token', '[]', 0, '2021-07-28 17:33:02', '2021-07-28 17:33:02', '2022-07-28 12:33:02'),
('c7194c8bdbe01ce2cf35938ea4edc1d0670a0a77d40b70597f0a21deeecb56d8cd118a3008511e63', 15, 1, 'Personal Access Token', '[]', 0, '2021-07-15 15:18:53', '2021-07-15 15:18:53', '2022-07-15 10:18:53'),
('ca25f65b7d09df52ae5076ba237504ad313ba498655cf2791ec98a462a9eb96bff4f5205d233b01a', 48, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:35:54', '2021-08-03 19:35:54', '2022-08-03 14:35:54'),
('ccc7a2ea59eae29533cdd47699ec66a24216cbccbdd44efad343f2f85716b2f0db38f62a6ffd22c2', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 16:54:20', '2021-08-04 16:54:20', '2022-08-04 11:54:20'),
('ce87465152b4218d593a97cbc7f9d45e2f908fcbee901479b487d650d9a1a1ad0aff5f9ed0aab9cb', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-02 15:30:39', '2021-08-02 15:30:39', '2022-08-02 10:30:39'),
('d15ea215ab99d38f0d363970bd61a8b72b9a50475a5999ae0f65cd32c43b95a5e80dfcf2bb8b9c99', 2, 1, 'Personal Access Token', '[]', 0, '2021-07-13 18:08:21', '2021-07-13 18:08:21', '2022-07-13 13:08:21'),
('d59ea9d2f130433397683ce86d46a23c13ad725e430e66446f352731b3c8bc58dbb55fccae12d389', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 17:20:12', '2021-08-04 17:20:12', '2022-08-04 12:20:12'),
('d66be00d6895c547f24b4d0a74f63f9677b0bcb19544ffe409a27572a236e638a02a931a0a270790', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-03 16:03:18', '2021-08-03 16:03:18', '2022-08-03 11:03:18'),
('d94c5663d3396b99d248c960b37e0d48ea4016b01eae51f3ae29bd694fec4b64ca2f1f5a76aba50f', 35, 1, 'Personal Access Token', '[]', 0, '2021-08-02 14:09:49', '2021-08-02 14:09:49', '2022-08-02 09:09:49'),
('d9cd26d24b285ff38b6746546fd3892cc5ac3765e26e9df2c92ecf41d310cc1e9af3405ea1318da0', 51, 1, 'Personal Access Token', '[]', 0, '2021-08-03 20:56:24', '2021-08-03 20:56:24', '2022-08-03 15:56:24'),
('dc4b301078371b349abbbcf2f7c8bac708c59a9c994ddaeae46e8dae20b5936ee283214519bf97d0', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-02 16:31:11', '2021-08-02 16:31:11', '2022-08-02 11:31:11'),
('e1db8f3811099813df7384ca4035ed250562b21c3a4c184cfbe360b4458ec0b57433497baed77219', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-01 14:34:32', '2021-08-01 14:34:32', '2022-08-01 09:34:32'),
('e35c65d848dcdbe1b2f3d3802e0e39f40119468b5ed7074103f76c68c00eef86a7b57d85598cb907', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-01 18:05:12', '2021-08-01 18:05:12', '2022-08-01 13:05:12'),
('e8a54624e0707f71740592e0c82eb52b4623b6c9bec00f70037893424b2b3c578e85bb1c7443adce', 13, 1, 'Personal Access Token', '[]', 0, '2021-07-15 14:53:05', '2021-07-15 14:53:05', '2022-07-15 09:53:05'),
('e920f97fa470a17ebd9322c859d89e7ffbbaa780303071eeb5a89f475abdf0fc0ec2d57a8015198b', 11, 1, 'Personal Access Token', '[]', 0, '2021-07-14 19:11:05', '2021-07-14 19:11:05', '2022-07-14 14:11:05'),
('ea045173e87f92cd38ad233eccdf0219e704cd952016aa4456ac6c810709ac9291d59d27d2cb2162', 36, 1, 'Personal Access Token', '[]', 0, '2021-08-02 17:06:01', '2021-08-02 17:06:01', '2022-08-02 12:06:01'),
('eb36498b38e83f9449031135a32afca9497de6b7f12fa4d94bbd6488fe6859cc60f0c69c1758181b', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-02 20:20:05', '2021-08-02 20:20:05', '2022-08-02 15:20:05'),
('ed91d7eb99721f236815e80dd21cb3795557d771ff616255963f183facb3f60e72d61af70cf97ef6', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-03 18:13:10', '2021-08-03 18:13:10', '2022-08-03 13:13:10'),
('ee313fb3635cfe270ecc04f44536881fc8b0b56e424ee519a6ad92f61e3e0b5fc4ebe3eaa92f13a5', 53, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:50:41', '2021-08-04 18:50:41', '2022-08-04 13:50:41'),
('ee40f536985bcf033c9465aa543fd9ace4295ec85f773db8abb576fa0202dde779702b53e32d9296', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 19:02:23', '2021-08-04 19:02:23', '2022-08-04 14:02:23'),
('ef44ed2157b4cce02fc908766ee3341989391945aa1ee82a8e9f891196f9bf96b1d0b583a8db38e0', 4, 1, 'Personal Access Token', '[]', 0, '2021-06-28 16:00:39', '2021-06-28 16:00:39', '2021-07-12 18:00:39'),
('f17e143b63099f1145e027398478dc0e75089cf554ce108e02d1dd3fb72050841966bf0f0ba4c016', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:44:11', '2021-08-04 18:44:11', '2022-08-04 13:44:11'),
('f2f87d244750bafcbbf99191c3f724a5dead14dbeac1fbfe4acb9b8f6a7ca3eb38da273d20a81d1b', 22, 1, 'Personal Access Token', '[]', 0, '2021-07-26 18:14:32', '2021-07-26 18:14:32', '2021-08-09 13:14:32'),
('f334a57f5e7d2e52b36d22fdae2f725588e22aba0bff404714f357667978d699bc27ddd74c958818', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-03 18:57:16', '2021-08-03 18:57:16', '2022-08-03 13:57:16'),
('f451f95a01aad2985df5272705be1a8f59c949d106371386efebfea3925c4a8a48c7b1727e5840ed', 23, 1, 'Personal Access Token', '[]', 0, '2021-08-04 20:56:17', '2021-08-04 20:56:17', '2022-08-04 15:56:17'),
('f452bda2fb735ff1e9bdefceb542940798d726eb48902ed511e15d6707b9075bb3f45a2cc7dd2b30', 12, 1, 'Personal Access Token', '[]', 0, '2021-07-14 19:55:37', '2021-07-14 19:55:37', '2022-07-14 14:55:37'),
('f58e3f0c4c860a3350803e1875903a9b545bfb220657e817e2d6acf53ce9917943d1f4fc1a476878', 52, 1, 'Personal Access Token', '[]', 0, '2021-08-04 18:51:25', '2021-08-04 18:51:25', '2022-08-04 13:51:25'),
('f88e57808500cc9e024e76523f8d276d791730b1cd74de4b285a737bb0592fa0077bc0662b7cb13c', 33, 1, 'Personal Access Token', '[]', 0, '2021-08-03 19:45:06', '2021-08-03 19:45:06', '2022-08-03 14:45:06'),
('f99e82b14d670428aefee682b9d3c99be78d089e0885ac93178ec8e2bc6a966593497466a8f5eed8', 20, 1, 'Personal Access Token', '[]', 0, '2021-07-25 20:49:22', '2021-07-25 20:49:22', '2022-07-25 15:49:22'),
('fa06b5397de11290e2dd3afe0b5db7e6ae940d1fa94b4ada014b8d84aede69545be99c926bb2b741', 2, 1, 'Personal Access Token', '[]', 0, '2021-08-01 16:02:41', '2021-08-01 16:02:41', '2022-08-01 11:02:41'),
('ffe4c175fe4dbb3afeff0b06ee0bf75df6bdc427cb2e0626fe5e76ce13c1c4b233257bb6c4afc2de', 30, 1, 'Personal Access Token', '[]', 0, '2021-08-01 15:14:18', '2021-08-01 15:14:18', '2022-08-01 10:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'Igg7bV6icqBfxvZFsmlW7bdMQieS9jHkEQY5yli5', NULL, 'http://localhost', 1, 0, 0, '2021-06-28 12:59:53', '2021-06-28 12:59:53'),
(2, NULL, 'Laravel Password Grant Client', 'eNCYUuqsfUvEnljStmf75kE6JtsrLJ7ftPNrOzQU', 'users', 'http://localhost', 0, 1, 0, '2021-06-28 12:59:53', '2021-06-28 12:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-06-28 12:59:53', '2021-06-28 12:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `offer` float(12,3) NOT NULL,
  `is_accept` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `order_id`, `delivery_id`, `offer`, `is_accept`) VALUES
(1, 1, 4, 500.000, 1),
(2, 2, 23, 500.000, 1),
(3, 6, 23, 900.000, 1),
(4, 24, 23, 200.000, 1),
(5, 23, 23, 200.000, 1),
(6, 29, 23, 200.000, 1),
(7, 40, 23, 200.000, 1),
(8, 38, 23, 200.000, 1),
(9, 39, 4, 500.000, 1),
(10, 37, 4, 500.000, 1),
(11, 43, 4, 500.000, 1),
(12, 42, 4, 500.000, 1),
(13, 45, 4, 500.000, 0),
(14, 46, 4, 500.000, 1),
(15, 48, 23, 200.000, 1),
(16, 50, 23, 200.000, 1),
(17, 47, 33, 500.000, 0),
(18, 45, 33, 55.000, 0),
(19, 34, 33, 55.000, 0),
(20, 35, 33, 3333.000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `from_lat` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `from_lng` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `from_address` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `to_address` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `from_city` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `to_city` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `to_lat` varchar(30) COLLATE utf8_general_mysql500_ci NOT NULL,
  `to_lng` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `offer` float(12,3) DEFAULT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `secondary_specialist_id` int(11) NOT NULL,
  `pay_method` varchar(50) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `notes` text COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `delivery_id`, `from_lat`, `from_lng`, `from_address`, `to_address`, `from_city`, `to_city`, `to_lat`, `to_lng`, `offer`, `main_specialist_id`, `secondary_specialist_id`, `pay_method`, `notes`, `reason`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 2, 33, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(2, 2, 33, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', 500.000, 1, 1, 'كاش', NULL, NULL, 2, NULL, NULL),
(3, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'test', 3, NULL, NULL),
(4, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, NULL, 3, NULL, NULL),
(5, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(6, 2, 33, '31.23161315918', '29.950466579248', NULL, NULL, NULL, NULL, '30.0583475', '31.2048143', 900.000, 1, 1, 'كاش', 'تا', NULL, 2, NULL, NULL),
(7, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'غبق\"', 3, NULL, NULL),
(8, 2, NULL, '31.231597900391', '29.950683708866', NULL, NULL, NULL, NULL, '31.2368289', '29.9927471', NULL, 1, 1, 'كاش', 'تر ور', 'The timing was not suitable', 3, NULL, NULL),
(9, 2, NULL, '31.231521606445', '29.950588736711', NULL, NULL, NULL, NULL, '30.6499477', '31.0746142', NULL, 1, 1, 'كاش', 'تتن', 'test', 3, NULL, NULL),
(10, 2, NULL, '31.231567382812', '29.950628577673', NULL, NULL, NULL, NULL, '21.2709595', '40.4289508', NULL, 1, 1, 'كاش', 'تا', 'Captain was late', 3, NULL, NULL),
(11, 2, NULL, '31.231552124023', '29.950530650122', NULL, NULL, NULL, NULL, '36.560462', '36.1721509', NULL, 1, 1, 'كاش', 'ورو', 'test', 3, NULL, NULL),
(12, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(13, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'rkrk', 3, NULL, NULL),
(14, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, NULL, 3, NULL, NULL),
(15, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'I want to change my trip', 3, NULL, NULL),
(16, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(17, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'I want to change my trip', 3, NULL, NULL),
(18, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(19, 2, NULL, '34.33333', '33.3333', NULL, NULL, NULL, NULL, '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'I want to change my trip', 3, NULL, NULL),
(20, 2, NULL, '53.2378404', '6.5991502', NULL, NULL, NULL, NULL, '10.3200307', '123.9150336', NULL, 1, 1, 'كاش', 'Chhg', 'I want to change my trip', 3, NULL, NULL),
(21, 2, NULL, '31.231521606445', '29.950622271393', NULL, NULL, NULL, NULL, '37.4805643', '-122.1525937', NULL, 1, 1, 'كاش', 'Hkjg', 'The timing was not suitable', 3, NULL, NULL),
(22, 2, NULL, '31.231449195213', '29.950556131108', NULL, NULL, NULL, NULL, '31.046054', '31.361335', NULL, 1, 1, 'كاش', 'تااووزا', 'The timing was not suitable', 3, NULL, NULL),
(23, 2, 33, '31.231552124023', '29.950456637917', NULL, NULL, NULL, NULL, '31.0909667', '31.4226841', 200.000, 1, 1, 'كاش', 'املبذلا', NULL, 1, NULL, NULL),
(24, 2, 33, '31.23161315918', '29.9503792473', NULL, NULL, NULL, NULL, '31.0909667', '31.4226841', 200.000, 1, 1, 'كاش', 'تلدزذيي', NULL, 1, NULL, NULL),
(25, 2, NULL, '31.231552124023', '29.950587311787', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', '234 SE 12th Ave, Portland, OR 97214, USA', NULL, NULL, '45.521054', '-122.6532194', NULL, 1, 1, 'كاش', 'Gjjg', 'The timing was not suitable', 3, NULL, NULL),
(26, 2, NULL, '31.231475830078', '29.950456051184', '18 Roushdy, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'VGFF+G8M, Fgura, Malta', NULL, NULL, '35.8738269', '14.5232901', NULL, 1, 1, 'كاش', 'Fgg', 'The timing was not suitable', 3, NULL, NULL),
(27, 2, NULL, '31.231582641602', '29.950646404205', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'Loma Mazamitla Sur 1507, La Aurora, 44790 Guadalajara, Jal., Mexico', NULL, NULL, '20.6596988', '-103.3496092', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(28, 2, NULL, '31.231597900391', '29.95043819773', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', '201 Grizzard Ave u28, Nashville, TN 37207, USA', NULL, NULL, '36.2093866', '-86.7719858', NULL, 1, 1, 'كاش', 'Hi sorry to you', 'The timing was not suitable', 3, NULL, NULL),
(29, 2, 33, '34.33333', '33.3333', '0', '0', NULL, NULL, '33.33333', '33.333333', 200.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(30, 2, NULL, '31.231552124023', '29.950369717581', '18 Roushdy, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'Calle Libertad 156, México Chico, 47300 Yahualica de González Gallo, Jal., Mexico', NULL, NULL, '21.1782822', '-102.8831247', NULL, 1, 1, 'كاش', 'Hijh', 'The timing was not suitable', 3, NULL, NULL),
(31, 2, NULL, '31.231607529364', '29.950402574642', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'Universitätsstraße 25, 33615 Bielefeld, Germany', NULL, NULL, '52.0367238', '8.4952413', NULL, 1, 1, 'كاش', 'Hjj', 'The timing was not suitable', 3, NULL, NULL),
(32, 2, NULL, '31.231692018948', '29.950534002883', '12 Salah Tawfik, First Al Raml, Alexandria Governorate, Egypt', 'برج فينيسيا ٦ المحاربيين الجديده - الدور الثاني علوي EG, Qism Kafr El-Shaikh, Kafr Al Sheikh Second, Kafr El Sheikh Governorate, Egypt', NULL, NULL, '31.1106593', '30.9387799', NULL, 1, 1, 'كاش', NULL, 'Captain was late', 3, NULL, NULL),
(33, 2, NULL, '31.231766450248', '29.950417326791', '14 Salah Tawfik, First Al Raml, Alexandria Governorate, Egypt', 'Mr. Visserplein, 1011 PL Amsterdam, Netherlands', NULL, NULL, '52.3675734', '4.9041389', NULL, 1, 1, 'كاش', 'Hhjg', 'The timing was not suitable', 3, NULL, NULL),
(34, 2, NULL, '31.231466721777', '29.950606753544', '11 Al Fereid Layan, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', '88 Abd El-Aziz Ali St, Banayos, Zagazig, Ash Sharqia Governorate, Egypt', 'Alexandria', 'Zagazig 2', '30.5951587', '31.4981809', NULL, 1, 1, 'كاش', 'Ghjjb', NULL, 0, NULL, NULL),
(35, 2, NULL, '31.231521606445', '29.950507851345', '18 Roushdy, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'Keskitie 28, 71200 Tuusniemi, Finland', 'Alexandria', 'North Eastern Savonia', '62.8107587', '28.4912383', NULL, 1, 1, 'كاش', NULL, NULL, 0, NULL, NULL),
(36, 2, NULL, '31.231491088867', '29.950596531881', '11 Al Fereid Layan, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'El-Nozha, Al Sheikh Zayed, Giza Governorate, Egypt', 'Alexandria', 'Sheikh Zayed City', '30.0854392', '30.9718576', NULL, 1, 1, 'كاش', NULL, NULL, 0, NULL, NULL),
(37, 2, 4, '31.231750488281', '29.950501564918', '11 Salah Tawfik, First Al Raml, Alexandria Governorate, Egypt', 'Loma Mazamitla Sur 1507, La Aurora, 44790 Guadalajara, Jal., Mexico', 'Alexandria', 'Guadalajara', '20.6596988', '-103.3496092', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(38, 2, 23, '31.231719970703', '29.950475245742', '14 Salah Tawfik, First Al Raml, Alexandria Governorate, Egypt', 'Dinglevägen 15, 457 40 Fjällbacka, Sweden', 'Alexandria', 'Tanum', '58.5997756', '11.2882238', 200.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(39, 2, 4, '31.231658935547', '29.950384302056', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'تأجير ملاعب - Dubai - United Arab Emirates', 'Alexandria', 'Dubai - United Arab Emirates', '25.2048493', '55.2707828', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(40, 2, 23, '31.231664945401', '29.950383966817', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', '198 Al Molazem Sameh, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', 'Alexandria', 'Alexandria', '31.231096274911', '29.954396635294', 200.000, 1, 1, 'كاش', 'Cj', NULL, 1, NULL, NULL),
(41, 2, NULL, '34.33333', '33.3333', '0', '0', '0', '0', '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(42, 2, 4, '-26.668700215100007', '136.29305742681026', 'Simpson Desert SA 5734, Australia', 'Tanami NT 0872, Australia', 'Eringa SA 5734', 'South Australia 0872', '-20.50199336004883', '131.3059688732028', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(43, 2, 4, '-17.656011339257706', '127.91379891335966', 'Unnamed Road, Ord River WA 6770, Australia', 'Ghan NT 0872, Australia', 'Western Australia 6770', 'South Australia 0872', '-25.005690076723216', '133.70806641876698', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(44, 2, NULL, '-29.464087928709706', '144.93850842118263', 'Unnamed Road, Yantabulla NSW 2840, Australia', 'Beadell WA 6440, Australia', 'New South Wales 2840', 'Western Australia 6440', '-28.554643097307714', '128.3285680040717', NULL, 1, 1, 'كاش', NULL, 'The timing was not suitable', 3, NULL, NULL),
(45, 2, NULL, '31.231628567941', '29.950475664837', '18 Salah Tawfik, Fleming, Qism El-Raml, Alexandria Governorate, Egypt', '610 Duke St, Alexandria, VA 22314, USA', 'Alexandria', 'Alexandria', '38.802661740527', '-77.046835497022', NULL, 1, 1, 'كاش', NULL, NULL, 0, NULL, NULL),
(46, 42, 4, '31.231561219349', '29.95050659406', '2 Naqib Maged Salah Tawfiq Street, from Roushdy Street, Ground Floor، Fleming, First Al Raml, Alexandria Governorate, Egypt', 'Saidpur Chiraiyyakot Marg, Ghhni, Uttar Pradesh 233307, India', 'Alexandria', 'Ghazipur', '25.6928371', '83.2425711', 500.000, 1, 1, 'كاش', 'Gygg', NULL, 1, NULL, NULL),
(47, 36, NULL, '31.23198618184', '29.950560573516', '4 Salah Tawfik, First Al Raml, Alexandria Governorate, Egypt', 'Pl. Pestalozzi 1, 1400 Yverdon-les-Bains, Switzerland', 'Alexandria', 'Jura-Nord vaudois District', '46.7784736', '6.641183', NULL, 1, 1, 'كاش', NULL, NULL, 0, NULL, NULL),
(48, 36, 23, '31.23160756981', '29.95048925926', '2 Naqib Maged Salah Tawfiq Street, from Roushdy Street, Ground Floor، Fleming, First Al Raml, Alexandria Governorate, Egypt', 'Station Rd, York YO1, UK', 'Alexandria', 'England', '53.9599651', '-1.0872979', 200.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(49, 52, NULL, '37.33233141', '-122.0312186', 'Unnamed Road, Cupertino, CA 95014, USA', '1481 Falcon Ct, Sunnyvale, CA 94087, USA', 'Santa Clara County', 'Santa Clara County', '37.34556422018', '-122.02389422804', NULL, 1, 1, 'كاش', 'Rrr', 'The timing was not suitable', 3, NULL, NULL),
(50, 52, 23, '37.33233141', '-122.0312186', 'Unnamed Road, Cupertino, CA 95014, USA', '651 Cheshire Way, Sunnyvale, CA 94087, USA', 'Santa Clara County', 'Santa Clara County', '37.348168819623', '-122.02419497073', 200.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phone_codes`
--

CREATE TABLE `phone_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(6) COLLATE utf8_general_mysql500_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `phone_codes`
--

INSERT INTO `phone_codes` (`id`, `code`, `phone`, `created_at`, `updated_at`) VALUES
(12, '5555', '018556555589', '2021-07-13 14:38:36', '2021-07-13 14:38:36'),
(14, '5555', '01213535', '2021-07-13 14:54:46', '2021-07-13 14:54:46'),
(31, '5555', '+20111111111111', '2021-07-14 08:21:07', '2021-07-14 08:21:07'),
(38, '5555', '+20111111111111', '2021-07-14 10:06:42', '2021-07-14 10:06:42'),
(56, '5555', '+201478523690', '2021-07-15 11:27:47', '2021-07-15 11:27:47'),
(60, '5555', '+20686554588955', '2021-07-25 14:01:41', '2021-07-25 14:01:41'),
(73, '5555', '01063745896', '2021-08-01 08:32:30', '2021-08-01 08:32:30'),
(81, '5555', '201018731806', '2021-08-01 11:01:24', '2021-08-01 11:01:24'),
(85, '5555', '201018731805', '2021-08-01 13:10:29', '2021-08-01 13:10:29'),
(100, '5555', '01018731802', '2021-08-02 15:59:28', '2021-08-02 15:59:28'),
(102, '5555', '01018731800', '2021-08-02 16:06:41', '2021-08-02 16:06:41'),
(103, '5555', '01018731866', '2021-08-02 16:07:54', '2021-08-02 16:07:54'),
(132, '5555', '8659655585', '2021-08-04 11:24:49', '2021-08-04 11:24:49'),
(133, '5555', '01063714613', '2021-08-04 11:27:12', '2021-08-04 11:27:12'),
(134, '5555', '+200155424313', '2021-08-04 12:19:11', '2021-08-04 12:19:11'),
(135, '5555', '+20011145916454', '2021-08-04 12:21:42', '2021-08-04 12:21:42'),
(136, '5555', '+20011145916454', '2021-08-04 12:24:54', '2021-08-04 12:24:54'),
(137, '5555', '+2001554243143', '2021-08-04 12:28:36', '2021-08-04 12:28:36'),
(138, '5555', '+20011145916454', '2021-08-04 12:30:17', '2021-08-04 12:30:17'),
(139, '5555', '010998770912', '2021-08-04 12:30:29', '2021-08-04 12:30:29'),
(140, '5555', '+20011145916454', '2021-08-04 12:31:50', '2021-08-04 12:31:50'),
(141, '5555', '01998770912', '2021-08-04 12:34:55', '2021-08-04 12:34:55'),
(142, '5555', '+20011145916454', '2021-08-04 12:35:35', '2021-08-04 12:35:35'),
(143, '5555', '010998770912', '2021-08-04 12:37:59', '2021-08-04 12:37:59'),
(144, '5555', '+20011145916454', '2021-08-04 12:40:03', '2021-08-04 12:40:03'),
(145, '5555', '010998770912', '2021-08-04 12:42:28', '2021-08-04 12:42:28'),
(146, '5555', '+20011145916454', '2021-08-04 12:45:47', '2021-08-04 12:45:47'),
(147, '5555', '010998770912', '2021-08-04 12:48:24', '2021-08-04 12:48:24'),
(148, '5555', '+2001878787575', '2021-08-04 12:50:20', '2021-08-04 12:50:20'),
(149, '5555', '+20011145916454', '2021-08-04 12:55:03', '2021-08-04 12:55:03'),
(150, '5555', '+20011145916454', '2021-08-04 13:03:44', '2021-08-04 13:03:44'),
(151, '5555', '010998770912', '2021-08-04 13:30:27', '2021-08-04 13:30:27'),
(153, '5555', '010998770912', '2021-08-04 15:43:32', '2021-08-04 15:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` text COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `user_id`, `delivery_id`, `rate`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 23, 0, NULL, '2021-07-29 09:28:12', '2021-07-29 09:28:12'),
(2, 2, 23, 0, NULL, '2021-07-29 09:33:02', '2021-07-29 09:33:02'),
(3, 2, 23, 0, NULL, '2021-07-29 10:07:47', '2021-07-29 10:07:47'),
(4, 2, 33, 2, NULL, '2021-07-29 09:28:12', '2021-07-29 09:28:12'),
(5, 2, 23, 0, NULL, '2021-08-01 13:17:03', '2021-08-01 13:17:03'),
(6, 2, 23, 0, NULL, '2021-08-01 13:17:07', '2021-08-01 13:17:07'),
(7, 2, 23, 2, NULL, '2021-08-01 13:19:12', '2021-08-01 13:19:12'),
(8, 2, 23, 4, NULL, '2021-08-01 13:19:27', '2021-08-01 13:19:27'),
(9, 2, 23, 5, NULL, '2021-08-01 13:25:35', '2021-08-01 13:25:35'),
(10, 2, 23, 4, NULL, '2021-08-01 14:30:31', '2021-08-01 14:30:31'),
(11, 2, 33, 5, NULL, '2021-08-03 09:43:52', '2021-08-03 09:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `secondary_specialists`
--

CREATE TABLE `secondary_specialists` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `image` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `secondary_specialists`
--

INSERT INTO `secondary_specialists` (`id`, `name_ar`, `name_en`, `main_specialist_id`, `image`) VALUES
(1, 'سطحه عاديه', 'original_surface', 1, 'uploads/fa393a34-93a5-4732-a4e5-213b648bf7e3_202104071425554101.jpg'),
(3, 'Eiusmod aliquip dict', 'Repellendus Consect', 1, 'uploads/secondary_specialists/08-2021/1628084699kozDP74tzS4Ht9S.png'),
(4, 'سسسسسسسسسسسسسسسس', 'ssssssssss', 1, 'uploads/secondary_specialists/08-2021/1628084851vSQFz8JQQbrrxGw.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`, `image`, `reset_password_token`, `remember_token`, `type`, `device_id`) VALUES
(2, 'hhhhgxgxh', 'k0ffcf@gmail.com', '+205555555555', '$2y$10$1lqLkY663eEyhNvXpFC0pOl6RAQVh1RHZP6oTgTO9ZFyS3X5.nSli', '2021-06-28 15:42:11', '2021-08-04 19:46:16', 'uploads/users/1627901173XfJzpwGO2a38ETs.jpeg', NULL, NULL, 1, 'fCoLGJEvlk2Inn50zJVTzR:APA91bFWW9u8pyGosCd2HlzJx1kguS1BwrgnHx-aaK-enqh3CP2yNJAjLo2CvonCD-JSRWw9HAwMhetgSf5NUubHbJ5jz3wqMl8W9n_e1B5MDy9lBj5defG9yLjTg6eMrXZkWFKXlLYG'),
(4, 'tests', 'eng.ahmedelsadanyd3@gmail.com', '01114591649', '$2y$10$WpzarU3bnlaKCiaVZ84FfeHd.y/QGYNNK8XrxnxCwle9CJTpArJse', '2021-06-28 16:00:39', '2021-08-01 20:48:49', NULL, NULL, NULL, 2, NULL),
(5, 'test', 'admin@admin.com', '01114591641', '$2y$10$WpzarU3bnlaKCiaVZ84FfeHd.y/QGYNNK8XrxnxCwle9CJTpArJse', '2021-06-28 16:00:39', '2021-06-28 16:00:39', NULL, NULL, NULL, 4, NULL),
(6, 'test', 'youssef@gmail.com', '01063714613', '$2y$10$f1tqF7sbH4RFPAPd46g1ueQz253mmRy8EtrGYCWBPRlt4quhMu5ie', '2021-07-13 17:16:53', '2021-07-13 17:16:53', NULL, NULL, NULL, 1, NULL),
(7, 'test', 'youssef@gmailff.com', '010637146133', '$2y$10$zwHTKTXLHEDanPS82b5Ey.BFQBGQT5A479h9sz.yOUa/TY/CRTpVK', '2021-07-14 16:18:25', '2021-07-14 16:18:25', NULL, NULL, NULL, 1, NULL),
(8, 'test', 'youssef@gmailfff.com', '0106371461332', '$2y$10$EFwJmgEmvKxrOBo9I3ZCe.ddkJ4pFa9vKGUSIuz4jhJ2E80cxKvZS', '2021-07-14 16:30:03', '2021-07-14 16:30:03', NULL, NULL, NULL, 1, NULL),
(9, 'test', 'youssef@gmailfffr.com', '01063714613323', '$2y$10$.xOcr6l7NvVikjgCbupU3.9FgdpGABj2FJXj.MA2lwkl4Il4dcT7K', '2021-07-14 16:33:41', '2021-07-14 16:33:41', NULL, NULL, NULL, 1, NULL),
(10, 'yhhok', 'youjj@gmail.com', '25665556555', '$2y$10$1dvMZUjbk7V66ZXf097pReTIYn81rmqQMx1nunCnGFQjlGsK09V0i', '2021-07-14 17:00:11', '2021-07-14 17:00:11', NULL, NULL, NULL, 1, NULL),
(11, 'test', 'eng.ahmedelsadany1@gmail.com', '01114591647', '$2y$10$X8umyd4RPjxwiDOdv4TwSOTe53FJ8r8vaAgg5Ab7RRCGtz/8fCVfm', '2021-07-14 19:11:05', '2021-08-03 20:22:50', NULL, NULL, NULL, 1, NULL),
(12, 'gdgdgd', 'ka140@gmail.com', '12453254789', '$2y$10$o3ieRf.9G1Is77K5pIgx9uzU1NEgdBIN/fJXBmFO74o7llH5yzWm2', '2021-07-14 19:55:37', '2021-07-14 19:55:37', NULL, NULL, NULL, 1, NULL),
(13, 'bcbcb', 'kari99314@gmail.com', '', '$2y$10$73VH0Qftax1sWSoRsLhu0e7onREHQxq9WLVXq.Y8QiH5WeXQ6WfU6', '2021-07-15 14:53:05', '2021-07-15 14:53:05', NULL, NULL, NULL, 1, NULL),
(14, 'gxhxv', 'karim.ali4@gmail.com', '+2011111111111', '$2y$10$KfANDyh0XAJOLfYiMmMDuueRs8zLqjfU0oyrVbczrPT0zK.Mmn19a', '2021-07-15 15:08:25', '2021-07-15 15:08:25', NULL, NULL, NULL, 1, NULL),
(15, 'test', 'eng.ahmekdeladany1@gmail.com', '0111459164', '$2y$10$VDv5ZWFq3j909GWmka4vV.l970Qkcary2yrs1oTdKcgUV1G/l2Bnm', '2021-07-15 15:18:53', '2021-07-15 15:18:53', NULL, NULL, NULL, 1, NULL),
(16, 'test', 'eng.ahmekeladany1@gmail.com', '0111459164545', '$2y$10$e4I6ukaH11hnUq4gRV.4MOq3/dBl65oKw3q8CR2m.40npdIR0uHjm', '2021-07-15 15:37:27', '2021-07-15 15:37:27', NULL, NULL, NULL, 1, NULL),
(17, 'test', 'eng.ahmekladany1@gmail.com', '011145916454', '$2y$10$D3wuoRXrTNd4ONV7/p3njOY9vwNidkXdxGpePhlC7XZjWxWgreaby', '2021-07-15 16:08:19', '2021-08-04 18:03:54', NULL, NULL, NULL, 1, NULL),
(18, 'hchfj', 'karli1314@gmail.com', '+202222222222', '$2y$10$flFf5hHdK3TNy9HnovB0ceJSU6BmBgVOtV8Hk0OPWGbMg67//iQvi', '2021-07-15 16:24:53', '2021-07-15 16:24:53', NULL, NULL, NULL, 1, NULL),
(19, 'bxhd', 'kai141@gmail.com', '+2014785236901', '$2y$10$tK8MIG8Sn95/1cJH67EoVeABIc6UvJUd5/0VGr3y8q6jSBPQt.U4.', '2021-07-15 16:28:59', '2021-07-15 16:28:59', NULL, NULL, NULL, 1, NULL),
(20, 'hhhh', 'k0@gmail.com', '5555+206666666666', '$2y$10$uc5KmlisE00Yku5pXWqD2etKDnjF0uXDrKJRVdddcGp9RjK5bd09m', '2021-07-25 20:49:22', '2021-07-25 20:50:01', NULL, NULL, NULL, 1, NULL),
(21, 'test', 'eng.ahmedelsadany3@gmail.com', '01114591642', '$2y$10$gtn5ONn2YlsE9U7P6OSDmOzw9X.tlz08hsNZXLNWXFohLHCDkv45e', '2021-07-26 17:06:06', '2021-07-26 17:06:06', NULL, NULL, NULL, 2, NULL),
(22, 'g3bery', 'g3bery@g.com', '010', '$2y$10$Iw0hNpP8B8jvnxuU5YxcAO7crX4H1Vvs2i1ZfUKNyBD/RmqtFtTdm', '2021-07-26 18:14:32', '2021-07-26 18:14:32', NULL, NULL, NULL, 2, NULL),
(23, 'g3bery web2', 'g3bery2@gg.com', '01000753', '$2y$10$NEDCzwTJa7/GyhkJ7E993OjFttK8MSP/Pi0hbtC/mBzIWSq0WYULm', '2021-07-26 18:17:23', '2021-08-04 20:59:44', 'uploads/users/1627893582fesBfcvphE9uX1h.jpeg', NULL, NULL, 2, 'cUcu8W6AzUTKr1EPgbCrjZ:APA91bHwAMz6gZwqoA4N3skqLYR7OkBzmwDeLd8cyn2HRbdq1-rnRmOchFADPihiK2IyczkSo7pXX5Y1-BUT4EkTopmOe2RzElZ-jB6clC9iFeAou17h1QGl2P-AH8iKYyHm9hhu9zz4'),
(24, 'test', 'eng.ahmedelsadany4@gmail.com', '01114591644', '$2y$10$6uNyfYExgBZaMDWvtT4wLOIRI42b3TefmGqZ/ulZXbKrTJ4bm/qSm', '2021-07-26 18:26:26', '2021-07-26 18:26:26', NULL, NULL, NULL, 2, NULL),
(25, 'youssef', 'yoin@gmail.com', '0106359674', '$2y$10$1/XBVHdySXVJNdgUdP34OOe5XBhjuRuP0j6YdldHbxRp9.etGR.0K', '2021-07-28 16:50:29', '2021-07-28 16:50:29', NULL, NULL, NULL, 1, NULL),
(26, 'yuhggg', 'yuhgg@gmail.com', '01063714658', '$2y$10$NQ8jHxht8H2bukLmro33rui3TeHXYZ8v3FePut23gA0YKQYZnbyMK', '2021-07-28 17:13:45', '2021-07-28 17:13:45', NULL, NULL, NULL, 1, NULL),
(27, 'youffg', 'yok@gmail.com', '01063714610', '$2y$10$BiH7jNETadmsNk9E/SqYHuYe6ZOUeDxwMiSOgjB/epb2l13iAUVee', '2021-07-28 17:22:55', '2021-07-28 17:22:55', NULL, NULL, NULL, 1, NULL),
(28, 'youggff', 'youbgg@gmail.com', '01063759580', '$2y$10$Z35aGkxAAu/eqqWVZtM0Qu/AK8qEFqc7VWPyFNZ/88l84vQfulnJW', '2021-07-28 17:33:02', '2021-07-28 17:33:02', NULL, NULL, NULL, 1, NULL),
(29, 'yommmm', 'yoummmm@gmail.com', '01085692175', '$2y$10$j136DVVT84TPAYd9RLKneO4A0Z7dXWZdCQ3lcbv7PfrDcm4UscyPu', '2021-08-01 13:43:07', '2021-08-01 13:43:07', NULL, NULL, NULL, 1, NULL),
(30, 'yhh', 'you@ggghh.com', '01069528566', '$2y$10$vyzFDBpVMdyn4oBexIUz3exZ7Ttvze6nOSNMF1.SkYAreN4qqXFCe', '2021-08-01 15:14:18', '2021-08-01 15:14:18', NULL, NULL, NULL, 1, NULL),
(31, 'yojhhjh', 'youvvv@gmail.com', '0106858569', '$2y$10$aBNRZA7i193ct0X/27b2OurIndWudD/.zXnz3RQLuNQehMQWnLgEW', '2021-08-01 16:01:44', '2021-08-01 16:01:44', NULL, NULL, NULL, 1, NULL),
(32, 'ryyy', 'ffggv@gmcghb.hhjh', '0063582698', '$2y$10$e5NrbsFmavsnxk23fnPJ1eaZkbwH8SmQAarBAxb6FqYjoWLLg/BzG', '2021-08-01 16:58:09', '2021-08-01 16:58:09', NULL, NULL, NULL, 1, NULL),
(33, 'mohammed', 'mm@gmail.com', '01018731806', '$2y$10$dG6sQENRIS6wAryEkVnro.ypLpWxlPETx1cai1R7rcHIGm0JfIiT6', '2021-08-01 17:02:03', '2021-08-04 19:48:31', NULL, NULL, NULL, 2, 'eqT7F5n4SQ-byOoCGxBPqi:APA91bEEi_PFWA5s6WIbxndC7vYDIop1Y-B3H3sS-q99M3p5H51pN2C8IkcCFcPzZyg8_gPQJibgS-Ck5ZvBL9Vdfh-SReaCRZU4fNcJNjIschDVJBTIYj0I4it5YZbdTAfhuuquMSUH'),
(34, 'mohammed', '55@gmail.com', '01018731805', '$2y$10$9VXQqGcEjePLKSOkfnkqdevy29lfpvrV.oyAiQgnFOxLSAfPnj1rq', '2021-08-01 18:11:21', '2021-08-01 18:11:21', NULL, NULL, NULL, 2, NULL),
(35, 'gfg', 'yut@gmail.com', '01063415896', '$2y$10$x050iIjUyQiGDxT6.NYe5OtXzT2lbO1z7oU/EngXoJB2uvUwe.xaC', '2021-08-02 14:09:49', '2021-08-02 14:09:49', NULL, NULL, NULL, 1, NULL),
(36, 'youssef', 'youssefff@gmail.com', '01463714613', '$2y$10$zi/A4LBStFA2is0NuVIaY./jI/vCh8TqE1ITBkTw7eU47VfRsPEUa', '2021-08-02 16:23:56', '2021-08-03 20:18:39', 'uploads/users/08-2021/16280039195Jcu7euEgRoTzdi.jpeg', NULL, NULL, 1, NULL),
(37, 'test', 'yousse@gmail.com', '01363714613', '$2y$10$zzceM1sssku2M6U6OR9UTOMHSMR9MjA0XNjLhpOHJAkk4169ygkfu', '2021-08-02 16:26:23', '2021-08-02 16:26:23', NULL, NULL, NULL, 1, NULL),
(38, 'youvgg', 'youhgg@gmail.com', '01598563289', '$2y$10$kCaWhssi37A.S11NHWOIfOSccvWCns2sMqKIorn4cTosCmmuhTKDi', '2021-08-02 19:27:19', '2021-08-02 19:27:19', NULL, NULL, NULL, 1, NULL),
(39, 'hhg', 'hh@gmail.com', '01063714568', '$2y$10$mH6MPDyAydEMxIoBwQu3Ve1WCWyUxMFXnHHG3LFNi66NLB4t3qWfK', '2021-08-02 20:45:44', '2021-08-02 20:45:44', NULL, NULL, NULL, 1, NULL),
(40, 'محمد منصور', 'MohammedMansourNseer@gmail.com', '+20', '$2y$10$d7/oRbJ6iQAkXlCA/3xRiORt5ixAxSSXTGG5oS.9Qg1e8JebJ4XZa', '2021-08-02 23:23:00', '2021-08-02 23:23:00', 'uploads/users/16279285802AN1YywFu86a8yH.jpg', NULL, NULL, 2, NULL),
(41, 'test', 'eng.ahmedelsadany5@gmail.com', '01114591645', '$2y$10$SZ.z7.uKnqVOfJj0aqjaSeyy10lKRaaq.HuyEb11jTlAo/TVoeETG', '2021-08-03 03:47:04', '2021-08-03 03:47:04', 'uploads/users/162794442427As7oKEnQeoDcC.png', NULL, NULL, 2, NULL),
(42, 'test', 'eng.ahmedelsada@gmail.com', '011145916477', '$2y$10$4fAuqyTTwyBszasMyiBiLOF/yqPD9hwJVvmOrzFYOPZzwTS/jNPzG', '2021-08-03 13:28:27', '2021-08-03 15:05:17', 'uploads/users/1627985117vfVtgt1EEPMuPOh.png', NULL, NULL, 1, NULL),
(43, 'test', 'youssettt@gmail.com', '01763714613', '$2y$10$..52.dcgrgDJzb/l9WbfFeTwpNTTI4L32AZU4EYfzQlDqQcZVMUuW', '2021-08-03 19:12:59', '2021-08-03 19:12:59', NULL, NULL, NULL, 1, NULL),
(44, 'test', 'eng.ahmedelsadany0@gmail.com', '01114591640', '$2y$10$w3wmfBJwxbfuL4hxbm.Hm.WohQiZhfWOTupMhWhc.qolKYc49hl1G', '2021-08-03 19:13:02', '2021-08-03 19:17:20', 'uploads/users/08-2021/1628000240CwH5ej58KQoCtnI.png', NULL, NULL, 1, NULL),
(45, 'test', 'youssettte@gmail.com', '01863714613', '$2y$10$aM9/SeXfJS.1hsbvhxim5OkxCMdUm4VWkWYUSNlYQapTNobTKRRc6', '2021-08-03 19:19:10', '2021-08-03 19:19:10', NULL, NULL, NULL, 1, NULL),
(46, 'test', 'youssettte5@gmail.com', '018637146135', '$2y$10$MvR.HKqruhXX36R2AYyvMOTjmNBSyMG5Ph.5qJqSIGD4hwSMq/.BG', '2021-08-03 19:22:37', '2021-08-03 19:22:37', 'uploads/users/1628000557RcyL6TLKMFlBON5.png', NULL, NULL, 1, NULL),
(47, 'test', 'eng.ahmedelsadany20@gmail.com', '011145916402', '$2y$10$DoGwTuYge9FcYEf3jr.UJenMdksd6lOU774I/zmhaanm/KkoPakwm', '2021-08-03 19:26:36', '2021-08-03 19:26:36', NULL, NULL, NULL, 1, NULL),
(48, 'test', 'eng.ahmedelsadany200@gmail.com', '011145916401', '$2y$10$hl..XlyQk37owraXVZi/bOuJ49Cjy0hVvJ/isX5vO3kvWOLFzimk2', '2021-08-03 19:35:54', '2021-08-03 19:35:54', 'uploads/users/1628001354XJVKRpdW8rxKDEi.png', NULL, NULL, 1, NULL),
(49, 'test', 'youssettte59@gmail.com', '01963714613', '$2y$10$/vgxDbvRnrkHC87I9dGtSOYDiNXy22Z6p0AlkfDadX4CkwbFf2mCK', '2021-08-03 20:23:48', '2021-08-03 20:23:48', 'uploads/users/08-2021/1628004228HgoyA427SQxnJgN.png', NULL, NULL, 1, NULL),
(50, 'test', 'youssettte595@gmail.com', '019637146134', '$2y$10$71mq7QzlR09N1iWSatyxAOEYThEjWPyYAEnxgsAyyQYj9/xO6aveq', '2021-08-03 20:24:14', '2021-08-03 20:24:14', NULL, NULL, NULL, 1, NULL),
(51, 'yu', 'yousseffffff@gmail.com', '0100063714613', '$2y$10$7HI913myg9sSlSzznCfDb.e7KDZwWyIMET//JiGRNDMC/Mc7H1Xke', '2021-08-03 20:56:24', '2021-08-03 20:57:00', 'uploads/users/08-2021/1628006220OQJX60BOXdil8ji.jpeg', NULL, NULL, 1, NULL),
(52, 'namer', 'namer@gmail.com', '010998770912', '$2y$10$R.0KSUrG7T7dBdiBe4QREuxjhRKTixUKyVjU4uf.Uor.q8l2uB75O', '2021-08-04 15:28:42', '2021-08-04 20:43:49', 'uploads/users/08-2021/162807292230l2kScfEqruhPe.jpeg', NULL, NULL, 1, 'fCoLGJEvlk2Inn50zJVTzR:APA91bFWW9u8pyGosCd2HlzJx1kguS1BwrgnHx-aaK-enqh3CP2yNJAjLo2CvonCD-JSRWw9HAwMhetgSf5NUubHbJ5jz3wqMl8W9n_e1B5MDy9lBj5defG9yLjTg6eMrXZkWFKXlLYG'),
(53, 'test', 'eng.ahmekladjany1@gmail.com', '5555555555', '$2y$10$Rihg8L3VyZJ7pJZPDu7.KeZeYZp.S/YNgr3xD8.4qSAn2BTH/5CU6', '2021-08-04 18:50:41', '2021-08-04 19:00:11', NULL, NULL, NULL, 1, NULL),
(54, 'test', 'eng.ahmehgkladjany1@gmail.com', '01028408481', '$2y$10$WMNfgSyxOfCTouKU8vrd..fAyF8BJrtcT5gsNPJdX59hRvstHf4Te', '2021-08-04 19:21:41', '2021-08-04 19:23:17', NULL, NULL, NULL, 1, NULL),
(55, 'yonnn', 'younn@gmail.com', '01088770912', '$2y$10$hWFh1jjKJsOWJPUHyghmq.MKMm8gHjCjP6YIjo0a/zWgRuI1yZbdq', '2021-08-04 19:22:20', '2021-08-04 20:41:02', 'uploads/users/1628091662cn7EMm6DyA4G49J.jpeg', NULL, NULL, 1, 'fCoLGJEvlk2Inn50zJVTzR:APA91bFWW9u8pyGosCd2HlzJx1kguS1BwrgnHx-aaK-enqh3CP2yNJAjLo2CvonCD-JSRWw9HAwMhetgSf5NUubHbJ5jz3wqMl8W9n_e1B5MDy9lBj5defG9yLjTg6eMrXZkWFKXlLYG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_specialists`
--
ALTER TABLE `main_specialists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_codes`
--
ALTER TABLE `phone_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_specialist_id` (`main_specialist_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `main_specialists`
--
ALTER TABLE `main_specialists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `phone_codes`
--
ALTER TABLE `phone_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  ADD CONSTRAINT `secondary_specialists_ibfk_1` FOREIGN KEY (`main_specialist_id`) REFERENCES `main_specialists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
