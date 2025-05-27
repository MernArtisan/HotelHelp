-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2025 at 10:12 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appwebdemo_hotelhelp`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_checks`
--

CREATE TABLE `additional_checks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `check_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additional_checks`
--

INSERT INTO `additional_checks` (`id`, `employee_id`, `check_date`, `amount`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 56, '1982-09-09', 46.00, 'Minim consectetur ma', 'tiar4', '2025-02-10 18:08:48', '2025-02-10 18:08:48'),
(2, 56, '2002-06-08', 43.00, 'Est sed a sed repre', 'tiar4', '2025-02-10 18:17:02', '2025-02-10 18:17:02'),
(3, 56, '1979-12-16', 78.00, 'Earum exercitationem', 'tiar4', '2025-02-10 18:17:08', '2025-02-10 18:17:08'),
(4, 56, '2025-02-12', 222.00, 'xzxzxzxzxzxzxz', 'tiar4', '2025-02-11 10:35:38', '2025-02-11 10:35:38'),
(5, 57, '2025-03-27', 4500.00, 'Test', 'tiar4', '2025-03-24 18:51:03', '2025-03-24 18:51:03'),
(6, 54, '2025-05-02', 1111.00, 'sssssssssssss', 'tiar4', '2025-05-01 19:06:27', '2025-05-01 19:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', '<b><i><u>                            We value your privacy and are committed to protecting your personal data. Information collected is used solely for improving our services and ensuring a seamless user experience. We do not share your personal information with third parties without your consents\r\n                        </u></i></b>', '2025-02-03 16:15:06', '2025-02-03 11:23:40'),
(2, 'Term & Condition', '<p><span style=\"font-weight: bolder;\"><i><u>By using our services, you agree to comply with all applicable laws and our terms of use. We reserve the right to modify or discontinue any part of the service without prior notice. Continued use of the platform constitutes acceptance of any changes to these termssss</u></i></span></p><p><span style=\"font-weight: bolder;\"><i><u>By using our services, you agree to comply with all applicable laws and our terms of use. We reserve the right to modify or discontinue any part of the service without prior notice. Continued use of the platform constitutes acceptance of any changes to these termssss<br><br><div style=\"text-align: left;\"><i><u>By using our services, you agree to comply with all applicable laws and our terms of use. We reserve the right to modify or discontinue any part of the service without prior notice. Continued use of the platform constitutes acceptance of any changes to these termssss</u></i></div></u></i></span></p><p style=\"text-align: left;\"><br></p>', '2025-02-03 16:15:06', '2025-02-11 18:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deduction_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `deduction_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction_type`, `amount`, `deduction_reason`, `created_at`, `updated_at`) VALUES
(4, 'Erin Meadows', 79.00, 'Sit labore facilis', '2025-02-11 11:38:49', '2025-02-11 11:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` varchar(255) NOT NULL,
  `hire_date` date NOT NULL,
  `status` enum('hold','left','active','terminated') NOT NULL DEFAULT 'active',
  `employee_type` varchar(255) NOT NULL,
  `pay_group_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_manager` varchar(255) DEFAULT NULL,
  `organization_manager` varchar(255) DEFAULT NULL,
  `pay_rate` decimal(8,2) NOT NULL,
  `alternate_pay_rate` decimal(8,2) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `hotel_id`, `designation`, `user_id`, `employee_id`, `hire_date`, `status`, `employee_type`, `pay_group_id`, `assigned_manager`, `organization_manager`, `pay_rate`, `alternate_pay_rate`, `location`, `job_id`, `gender`, `contact`, `message`, `documents`, `created_at`, `updated_at`) VALUES
(54, 1, 'Quasi vel quaerat au', 56, 'hh-2', '1992-09-05', 'active', '1099', 7, 'Eos quisquam dolor', 'Petersen and Carver Inc', 20.00, 70.00, 'The Ritz-Carlton, Dubai International Financial Centre - Sheikh Zayed Road - Dubai - United Arab Emirates', 1, 'male', '+1 (969) 319-8329', 'Veniam et vero cons', 'documents/1738104086.pdf', '2025-01-28 17:41:26', '2025-02-03 15:33:58'),
(55, 1, 'Fugiat in voluptas d', 57, 'hh-3', '1983-05-26', 'active', '1099', 9, 'Fugiat consectetur', 'Pratt Wilson Associates', 20.00, 23.00, 'Delhi, India', 2, 'other', '+1 (292) 452-2767', 'Sit sit minim hic ma', 'documents/1738179884.pdf', '2025-01-29 14:44:44', '2025-02-03 15:34:04'),
(56, 1, 'Exercitation nulla m', 58, 'hh-4', '2017-04-09', 'active', '1099', 8, 'Qui elit est nemo', 'Kane Dotson Traders', 20.00, 27.00, 'Kiribati', 1, 'other', '+1 (264) 472-1858', 'Quidem ad praesentiu', 'documents/1738180154.pdf', '2025-01-29 14:49:14', '2025-02-03 15:34:10'),
(57, 3, 'Assumenda atque omni', 59, 'hh-5', '2021-12-21', 'active', 'w2', 7, 'Voluptas error quae', 'Mckinney and Cole Co', 20.00, 21.00, 'Dubai - United Arab Emirates', 1, 'male', '2222222222', 'Ipsum natus in asper', 'documents/1738703444.pdf', '2025-02-04 16:10:44', '2025-05-01 21:36:44'),
(58, 5, 'Mollit blanditiis it', 60, 'hh-6', '1993-05-26', 'terminated', 'w2', 9, 'Ipsa proident et a', 'Sears Mcintyre Plc', 8.00, 21.00, 'Canada\'s Wonderland, Vaughan, ON, Canada', 1, 'male', '+1 (225) 159-2219', 'Ab est ut qui impedidd', NULL, '2025-04-30 23:36:58', '2025-05-01 18:39:32'),
(59, 1, 'Housekeeper', 61, 'hh-7', '2025-05-04', 'active', 'w2', 7, 'Jeff Sanders', 'Jeff Byars', 69.00, 70.00, 'California, USA', 1, 'male', '9014510470', NULL, NULL, '2025-05-12 18:06:54', '2025-05-12 18:06:54'),
(60, 3, 'Tester', 62, 'hh-8', '2025-05-14', 'active', 'w2', 8, 'Jeff Sanders', 'Jeff Byars', 24.00, 46.00, 'Hollywood, FL, USA', 2, 'male', '9014510470', NULL, NULL, '2025-05-15 14:08:03', '2025-05-15 14:08:03'),
(61, 1, 'wei', 63, 'hh-9', '2025-05-16', 'active', 'w2', 8, 'marjk', NULL, 16.00, 18.00, 'California, USA', 1, 'male', '68641896846', 'test 3212', NULL, '2025-05-15 19:38:38', '2025-05-15 19:38:38'),
(69, 4, 'In ullamco consequat', 71, 'hh-10', '1995-12-18', 'active', 'w2', 8, 'Numquam dolor eius n', 'Graham Albert Traders', 93.00, 33.00, 'Canary Islands, Spain', 10, 'male', '+1 (778) 549-1296', 'Quod porro ut elit', 'documents/1748033255.pdf', '2025-05-23 20:47:35', '2025-05-23 20:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `eligibility_criteria` text NOT NULL,
  `holiday_entitlement` int(11) NOT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `holiday_start_date` varchar(255) DEFAULT NULL,
  `holiday_end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `role`, `eligibility_criteria`, `holiday_entitlement`, `shift`, `holiday_start_date`, `holiday_end_date`, `created_at`, `updated_at`) VALUES
(1, 'tiar4', 'ddddddd', 333, '03:48 PM', '03:48 PM', '2025-02-12', '2025-02-12 16:32:51', '2025-02-12 16:32:51'),
(2, 'tiar3', 'In quod mollit vero', 27, '03:48 PM', '03:48 PM', NULL, '2025-02-12 11:53:35', '2025-02-12 11:53:35'),
(3, 'tiar3', 'Ut sed ex nulla cumq', 10, '10:20 PM', '09:41 PM', NULL, '2025-02-12 12:12:28', '2025-02-12 12:12:28'),
(4, 'tiar3', 'Vel fuga Iure dolor', 14, '03:48 PM', '09:33 AM', NULL, '2025-02-12 12:12:39', '2025-02-12 12:12:39'),
(5, 'tiar3', 'Iure sint at aliqui', 16, '10:17 AM', '12:35 PM', NULL, '2025-02-12 12:23:56', '2025-02-12 12:23:56'),
(6, 'tiar3', 'Voluptatem necessit', 33, '01:08 PM', '09:39 PM', NULL, '2025-02-12 12:32:43', '2025-02-12 12:43:44'),
(7, 'tiar3', 'yyyyyyyyyywwww', 33, '08:42 PM', '08:43 PM', NULL, '2025-02-13 10:39:58', '2025-02-13 10:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `management_company` varchar(255) NOT NULL,
  `ownership_group` varchar(255) NOT NULL,
  `tax_location_code` varchar(255) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('active','block') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `address`, `manager`, `supervisor`, `management_company`, `ownership_group`, `tax_location_code`, `latitude`, `longitude`, `contact`, `email`, `notes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Molly Mays', 'California, USA', 'Voluptatem dolorum d', 'Esse iure qui dicta', 'Irure ducimus eos c', 'Gregory Vincent Plc', 'Iste mollit impedit', 'Elit elit ut aliqu', 36.77826100, -119.41793240, '242134236754', 'faizankhan888980@gmail.com', 'Id soluta sed in eni', 'active', '2025-01-27 14:13:40', '2025-02-04 17:43:43', NULL),
(3, 'Xandra Rivera', 'Hollywood, FL, USA', 'Corporis sit non ani', 'Eaque dignissimos cu', 'Cupiditate est quo n', 'Stanley Green Traders', 'Rem aut voluptatum i', 'Omnis dolor esse vol', 26.01120140, -80.14949010, '8723523456745', 'furuvodi@mailinator.com', 'Velit vel esse proid', 'active', '2025-01-27 14:52:58', '2025-02-04 17:44:03', NULL),
(4, 'Leila Cochran', 'Canary Islands, Spain', 'Et ullamco beatae co', 'Sint sint maiores u', 'Autem laboris nemo d', 'Morales and Rosa LLC', 'Consectetur velit', 'Lorem nostrum eum re', 28.29156370, -16.62913040, '754567890', 'temudexir@mailinator.com', 'Soluta non ducimus', 'active', '2025-01-27 17:46:13', '2025-02-04 17:44:22', NULL),
(5, 'Lilah Olsen', 'Canada\'s Wonderland, Vaughan, ON, Canada', 'Asperiores non et co', 'Quis ex fugiat aspe', 'Veniam cum sed offi', 'Schmidt and Rhodes Traders', 'Facilis explicabo A', 'Fugiat culpa magna v', 43.84236190, -79.54121550, '63', 'gabef@mailinator.com', 'Et consectetur exerc', 'active', '2025-01-27 18:29:08', '2025-02-04 17:44:31', NULL),
(6, 'Hadley Sargent', 'Russia', 'Id corrupti tempori', 'Et natus quia nostru', 'Labore incidunt nob', 'Jennings and Ford LLC', 'Et est dolorum dolor', 'Assumenda do veniam', 42.38964850, -83.50665990, '09+0078601', 'zyna@mailinator.com', 'Vel nobis sunt even', 'active', '2025-01-27 19:35:29', '2025-02-12 17:03:31', '2025-02-12');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `employee_id`, `email`, `seen`, `message`, `created_at`, `updated_at`) VALUES
(1, 'faizan', 53, 'developercoder51@gmail.com', 0, 'abc', '2025-02-03 11:00:10', '2025-02-03 11:00:10'),
(2, 'faizan', 53, 'developercoder51@gmail.com', 0, 'abc', '2025-02-03 11:00:20', '2025-02-03 11:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `hotel_id`, `invoice_number`, `invoice_date`, `due_date`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(44, 1, 'INV-0001', '2025-05-19', '2025-05-26', 375.00, 'unpaid', '2025-05-19 22:56:44', '2025-05-19 22:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `task_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `time` decimal(10,2) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `platform_fee` decimal(8,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `task_item_id`, `employee_id`, `service`, `quantity`, `time`, `price_per_unit`, `platform_fee`, `total`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(71, 44, 27, 54, 'Housekeeping', 0, 5.00, 20.00, 5.00, 375.00, '2025-05-20', '2025-05-22', '2025-05-19 22:56:44', '2025-05-19 22:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('active','block') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Housekeeping', 'Cleaning and maintaining hotel rooms, public areas, and guest spaces. Tasks include changing linens, cleaning bathrooms, restocking supplies, and ensuring rooms are guest-ready.', 'active', '2025-01-23 22:43:53', '2025-01-23 22:43:53'),
(2, 'Maintenance', 'Responsible for maintaining and repairing the hotel’s infrastructure, such as plumbing, electrical systems, and HVAC. Ensures the building is in good working order.', 'active', '2025-01-23 22:43:53', '2025-01-23 22:43:53'),
(9, 'Cleaner', 'n/a', 'active', '2025-05-15 18:53:23', '2025-05-15 18:53:23'),
(10, 'Developer', 'n/a', 'active', '2025-05-15 22:58:44', '2025-05-15 22:58:44'),
(11, 'Tester', 'n/a', 'active', '2025-05-23 13:48:30', '2025-05-23 13:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `meal_break_rules`
--

CREATE TABLE `meal_break_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `meal_break` tinyint(1) NOT NULL,
  `break_duration` int(11) NOT NULL,
  `break_frequency` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meal_break_rules`
--

INSERT INTO `meal_break_rules` (`id`, `role`, `meal_break`, `break_duration`, `break_frequency`, `created_at`, `updated_at`) VALUES
(1, 'sadf', 127, 45, 12, '2025-02-11 16:41:29', NULL),
(4, 'Minim doloremque neq', 0, 15, 31, '2025-02-13 12:18:10', '2025-02-13 12:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_01_23_034810_create_permission_tables', 2),
(6, '2025_01_23_210018_create_hotels_table', 3),
(7, '2025_01_23_224219_create_jobs_table', 4),
(8, '2025_01_23_224916_create_pay_groups_table', 5),
(9, '2025_01_24_163136_create_employees_table', 6),
(10, '2025_01_24_164918_create_employees_table', 7),
(11, '2025_01_27_151959_create_hotels_table', 8),
(12, '2025_01_27_203840_add_hotel_id_to_employees_table', 9),
(13, '2025_01_27_204031_remove_foreign_keys_from_employees_table', 10),
(14, '2025_01_27_204136_add_foreign_keys_to_employees_table', 11),
(15, '2025_01_29_202521_create_terminations_table', 12),
(16, '2025_01_29_224728_create_timecards_table', 13),
(17, '2025_02_03_152424_create_inquiries_table', 14),
(18, '2025_02_03_153856_create_notifications_table', 15),
(19, '2025_02_03_160953_create_contents_table', 16),
(20, '2025_02_05_173109_create_miscellaneous_table', 17),
(21, '2025_02_05_182544_create_miscellaneous_employee_fields_table', 18),
(22, '2025_02_05_203900_create_invoices_table', 19),
(23, '2025_02_05_203907_create_invoice_items_table', 19),
(24, '2025_02_07_170128_create_revenues_table', 20),
(25, '2025_02_10_223533_create_additional_checks_table', 21),
(26, '2025_02_11_154955_create_deductions_table', 22),
(27, '2025_02_12_162151_create_holidays_table', 23),
(28, '2025_02_12_181909_create_occurrence_rules_table', 24),
(29, '2025_02_12_222219_create_note_rules_table', 25),
(30, '2025_02_13_163621_create_meal_break_rules_table', 26),
(31, '2025_02_13_172805_create_rounding_rules_table', 27),
(32, '2025_05_14_204859_create_tasks_table', 28),
(33, '2025_05_14_204907_create_task_items_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `miscellaneous`
--

CREATE TABLE `miscellaneous` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `miscellaneous`
--

INSERT INTO `miscellaneous` (`id`, `hotel_id`, `item_name`, `description`, `category`, `value`, `created_at`, `updated_at`) VALUES
(13, 3, 'Olympia Cervantes', 'Voluptatibus ut dolo', 'Tempora minima ea si', NULL, '2025-02-05 13:16:36', '2025-02-05 13:17:12'),
(18, 3, 'Uriah Morse', 'Voluptatibus volupta', 'Cupiditate quis dign', NULL, '2025-02-05 13:43:17', '2025-02-05 13:43:17'),
(19, 4, 'Myra Henson', 'Quis eum est dolor q', 'Eos labore architect', NULL, '2025-02-05 13:43:17', '2025-02-05 13:43:17'),
(20, 4, 'dfgsdf', 'dfh', 'dfh', NULL, '2025-02-06 16:50:25', '2025-02-06 16:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `miscellaneous_employee_fields`
--

CREATE TABLE `miscellaneous_employee_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `miscellaneous_employee_fields`
--

INSERT INTO `miscellaneous_employee_fields` (`id`, `employee_id`, `hotel_id`, `field_name`, `field_value`, `created_at`, `updated_at`) VALUES
(3, 57, 3, 'testing', 'testing', '2025-04-24 18:08:50', '2025-04-24 18:08:50'),
(4, 57, 3, 'testing', 'testing', '2025-04-24 18:08:51', '2025-04-24 18:08:51'),
(5, 54, 1, 'swwwww', 'wwww', '2025-05-01 19:03:12', '2025-05-01 19:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 61),
(1, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 58),
(3, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 63),
(4, 'App\\Models\\User', 71);

-- --------------------------------------------------------

--
-- Table structure for table `note_rules`
--

CREATE TABLE `note_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_name` varchar(255) NOT NULL,
  `rule_description` text DEFAULT NULL,
  `effective_start_date` date NOT NULL,
  `effective_end_date` date DEFAULT NULL,
  `associated_department` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `notifyBy` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `employee_id`, `message`, `notifyBy`, `created_at`, `updated_at`) VALUES
(15, 54, 'dddddd', 'aaaaaaa', '2025-05-01 21:48:18', '2025-05-01 21:48:18'),
(16, 55, 'dddddd', 'aaaaaaa', '2025-05-01 21:48:18', '2025-05-01 21:48:18'),
(17, 56, 'dddddd', 'aaaaaaa', '2025-05-01 21:48:18', '2025-05-01 21:48:18'),
(18, 57, 'dddddd', 'aaaaaaa', '2025-05-01 21:48:18', '2025-05-01 21:48:18'),
(19, 58, 'dddddd', 'aaaaaaa', '2025-05-01 21:48:18', '2025-05-01 21:48:18'),
(20, 54, 'ssssssssssssssssssssssssssssssssssssssssssss', 'sssssssssssssssssssssssssssssssssssssssss', '2025-05-01 21:50:24', '2025-05-01 21:50:24'),
(21, 56, 'ssssssssssssssssssssssssssssssssssssssssssss', 'sssssssssssssssssssssssssssssssssssssssss', '2025-05-01 21:50:24', '2025-05-01 21:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `occurrence_rules`
--

CREATE TABLE `occurrence_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `time_of_occurrence` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occurrence_rules`
--

INSERT INTO `occurrence_rules` (`id`, `rule_name`, `description`, `time_of_occurrence`, `created_at`, `updated_at`) VALUES
(10, 'Lara Fry', 'Incididunt voluptas', '08:37 AM', '2025-02-13 10:31:01', '2025-02-13 10:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ahsan.ahmed9977@gmail.com', '6468', '2025-05-16 18:23:52'),
('developercoder51@gmail.com', '6195', '2025-05-16 17:27:40'),
('faizankhan888980@gmail.com', '3609', '2025-05-16 17:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `pay_groups`
--

CREATE TABLE `pay_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `pay_frequency` enum('weekly','biweekly') NOT NULL,
  `payroll_input_method` varchar(255) NOT NULL,
  `payroll_type` varchar(255) NOT NULL,
  `normal_hours` varchar(255) DEFAULT NULL,
  `pay_day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `run_date` varchar(255) NOT NULL,
  `inpound_date` varchar(255) NOT NULL,
  `period_date` varchar(255) NOT NULL,
  `status` enum('active','block') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_groups`
--

INSERT INTO `pay_groups` (`id`, `name`, `pay_frequency`, `payroll_input_method`, `payroll_type`, `normal_hours`, `pay_day_of_week`, `run_date`, `inpound_date`, `period_date`, `status`, `created_at`, `updated_at`) VALUES
(7, 'G1', 'biweekly', 'manual', 'hourly', '40', 'Friday', '3', '2', '7', 'active', NULL, '2025-01-29 13:58:01'),
(8, 'G2', 'biweekly', 'manual', 'hourly', '40', 'Friday', '3', '2', '7', 'active', NULL, '2025-02-13 14:58:00'),
(9, 'G3', 'biweekly', 'manual', 'salary', '40', 'Monday', '5', '3', '10', 'active', NULL, '2025-02-13 13:42:40'),
(20, 'G4', 'weekly', 'manual', 'Pariatur In consect', '80', 'Monday', '04-Jan-1978', '06-Aug-1981', '26-Mar-2011', 'active', '2025-02-13 13:42:48', '2025-02-13 14:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'pay-group-management', 'web', '2025-02-04 14:40:16', '2025-02-04 14:40:16'),
(3, 'hotels-management', 'web', '2025-02-04 14:40:23', '2025-02-04 14:40:23'),
(4, 'employees-management', 'web', '2025-02-04 14:40:29', '2025-02-04 14:40:29'),
(5, 'permissions-management', 'web', '2025-02-04 14:40:35', '2025-02-04 14:40:35'),
(6, 'roles-management', 'web', '2025-02-04 14:40:41', '2025-02-04 14:40:41'),
(10, 'employee-data-report', 'web', '2025-02-04 14:51:00', '2025-02-04 14:51:00'),
(11, 'view-client-addresses', 'web', '2025-02-04 14:51:05', '2025-02-04 14:51:05'),
(12, 'view-EmployeeDemographics', 'web', '2025-02-04 14:51:10', '2025-02-04 14:51:10'),
(13, 'view-termination', 'web', '2025-02-04 14:51:17', '2025-02-04 14:51:17'),
(14, 'Termination-post', 'web', '2025-02-04 14:51:24', '2025-02-04 14:51:24'),
(15, 'view-headCount', 'web', '2025-02-04 14:51:30', '2025-02-04 14:51:30'),
(16, 'add-timecard', 'web', '2025-02-04 14:51:36', '2025-02-04 14:51:36'),
(17, 'view-timecard', 'web', '2025-02-04 14:51:43', '2025-02-04 14:51:43'),
(18, 'view-privacyPolicy', 'web', '2025-02-04 14:51:49', '2025-02-04 14:51:49'),
(19, 'view-term-condition', 'web', '2025-02-04 14:51:54', '2025-02-04 14:51:54'),
(20, 'update-privacyPolicy', 'web', '2025-02-04 14:52:01', '2025-02-04 14:52:01'),
(21, 'update-term-condition', 'web', '2025-02-04 14:52:07', '2025-02-04 14:52:07'),
(22, 'view-organization-table', 'web', '2025-02-04 14:52:13', '2025-02-04 14:52:13'),
(23, 'view-employment-categories', 'web', '2025-02-04 14:52:20', '2025-02-04 14:52:20'),
(24, 'view-termination-reasons', 'web', '2025-02-04 14:52:24', '2025-02-04 14:52:24'),
(25, 'view-employment-statuses', 'web', '2025-02-05 12:16:45', '2025-02-05 12:16:45'),
(26, 'view-misc-field-categories', 'web', '2025-02-05 12:33:21', '2025-02-05 12:33:21'),
(27, 'add-misc-field-categories', 'web', '2025-02-05 12:33:37', '2025-02-05 12:33:37'),
(28, 'view-misc-field-employee', 'web', '2025-02-05 13:32:07', '2025-02-05 13:32:07'),
(29, 'add-misc-field-employee', 'web', '2025-02-05 13:32:15', '2025-02-05 13:32:15'),
(30, 'aged-receivables', 'web', '2025-02-07 11:20:24', '2025-02-07 11:20:24'),
(31, 'organizational-chart', 'web', '2025-02-07 12:41:33', '2025-02-07 12:41:33'),
(32, 'hotel-report', 'web', '2025-02-07 13:12:14', '2025-02-07 13:12:14'),
(33, 'roi-dashboard', 'web', '2025-02-07 13:36:25', '2025-02-07 13:36:25'),
(34, 'quarterly-reports', 'web', '2025-02-07 14:14:02', '2025-02-07 14:14:02'),
(35, 'employees-reports', 'web', '2025-02-07 16:25:45', '2025-02-07 16:25:45'),
(36, 'view-payables', 'web', '2025-02-10 12:32:19', '2025-02-10 12:32:19'),
(37, 'view-announcements', 'web', '2025-02-10 13:01:28', '2025-02-10 13:01:28'),
(38, 'add-announcements', 'web', '2025-02-10 13:14:07', '2025-02-10 13:14:07'),
(39, 'Using-App', 'web', '2025-02-10 13:59:25', '2025-02-10 13:59:25'),
(40, 'view-earnings', 'web', '2025-02-11 16:01:58', '2025-02-11 16:01:58'),
(41, 'view-additional-checks', 'web', '2025-02-11 16:02:05', '2025-02-11 16:02:05'),
(42, 'add-additional-checks', 'web', '2025-02-11 16:02:14', '2025-02-11 16:02:14'),
(43, 'view-deductions', 'web', '2025-02-11 16:02:33', '2025-02-11 16:02:33'),
(44, 'add-deductions', 'web', '2025-02-11 16:02:40', '2025-02-11 16:02:40'),
(45, 'delete-deductions', 'web', '2025-02-11 16:02:48', '2025-02-11 16:02:48'),
(46, 'payroll-report', 'web', '2025-02-11 16:02:54', '2025-02-11 16:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(30, 'App\\Models\\User', 59, 'auth_token', '34be43f2e66b103c5cd96de39f939437324518ae531d836d27300434a0e4ae0a', '[\"*\"]', '2025-05-07 16:58:31', NULL, '2025-05-07 16:56:37', '2025-05-07 16:58:31'),
(40, 'App\\Models\\User', 56, 'auth_token', 'e5c96ef12472b5e6d493cce9935641e496bffd2d4093245d0c68867c42917335', '[\"*\"]', '2025-05-15 19:30:57', NULL, '2025-05-15 19:30:56', '2025-05-15 19:30:57'),
(41, 'App\\Models\\User', 61, 'auth_token', 'bf7898c15b6c34af7218e8e0af993d4592e2340a4e01bae72753b51810506380', '[\"*\"]', '2025-05-23 20:28:31', NULL, '2025-05-23 20:28:30', '2025-05-23 20:28:31'),
(42, 'App\\Models\\User', 61, 'auth_token', 'a769bb1acde3b4a52e5b78dbb24ea924023f66bb3c0f21466c113668baec99fd', '[\"*\"]', '2025-05-23 20:29:22', NULL, '2025-05-23 20:29:21', '2025-05-23 20:29:22'),
(43, 'App\\Models\\User', 61, 'auth_token', 'fe01d4b43e2a1aeddda188277c18c7d8a198f71ece4cbfa97a90e9bea036b03f', '[\"*\"]', '2025-05-23 20:30:07', NULL, '2025-05-23 20:30:06', '2025-05-23 20:30:07'),
(44, 'App\\Models\\User', 61, 'auth_token', 'e554cfa81523ec967e33e08a3b3452f398c74c2a8d656e98fa524e30ac74db07', '[\"*\"]', '2025-05-23 20:49:51', NULL, '2025-05-23 20:49:50', '2025-05-23 20:49:51'),
(45, 'App\\Models\\User', 71, 'auth_token', '7b7c444fa29863fe0e74d8e06a05eeaa8bc0bb36c50271efe70057de3339ee9e', '[\"*\"]', '2025-05-23 20:51:38', NULL, '2025-05-23 20:51:37', '2025-05-23 20:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `revenues`
--

CREATE TABLE `revenues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(10,2) NOT NULL,
  `employees_amount` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL,
  `profit_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'tiar1', 'web', '2025-01-23 11:36:50', '2025-01-23 11:36:50'),
(2, 'tiar2', 'web', '2025-01-23 11:38:39', '2025-01-23 11:38:39'),
(3, 'tiar3', 'web', '2025-01-23 11:38:50', '2025-01-23 11:38:50'),
(4, 'tiar4', 'web', '2025-01-23 11:39:05', '2025-01-23 11:39:05'),
(6, 'Developer', 'web', '2025-05-20 19:16:45', '2025-05-20 19:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 3),
(2, 6),
(3, 3),
(3, 6),
(4, 3),
(4, 6),
(5, 3),
(5, 6),
(6, 3),
(6, 6),
(10, 3),
(10, 6),
(11, 3),
(11, 6),
(12, 3),
(12, 6),
(13, 3),
(13, 6),
(14, 3),
(14, 6),
(15, 3),
(15, 6),
(16, 3),
(16, 6),
(17, 3),
(17, 6),
(18, 3),
(18, 6),
(19, 3),
(19, 6),
(20, 3),
(20, 6),
(21, 1),
(21, 3),
(21, 6),
(22, 1),
(22, 3),
(22, 6),
(23, 3),
(23, 6),
(24, 3),
(24, 4),
(24, 6),
(25, 3),
(25, 6),
(26, 3),
(26, 6),
(27, 3),
(27, 6),
(28, 3),
(28, 6),
(29, 3),
(29, 6),
(30, 3),
(30, 6),
(31, 3),
(31, 6),
(32, 3),
(32, 6),
(33, 3),
(33, 6),
(34, 3),
(34, 6),
(35, 3),
(35, 6),
(36, 3),
(36, 6),
(37, 3),
(37, 6),
(38, 3),
(38, 6),
(39, 3),
(39, 6),
(40, 3),
(40, 6),
(41, 3),
(41, 6),
(42, 3),
(42, 6),
(43, 3),
(43, 6),
(44, 3),
(44, 6),
(45, 3),
(45, 6),
(46, 3),
(46, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rounding_rules`
--

CREATE TABLE `rounding_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `working_hours_rounding` int(11) NOT NULL,
  `overtime_rounding` int(11) NOT NULL,
  `break_time_rounding` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rounding_rules`
--

INSERT INTO `rounding_rules` (`id`, `role`, `working_hours_rounding`, `overtime_rounding`, `break_time_rounding`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Quisquam id sint ame', 89, 73, 5, 'Quos recusandae Ea', '2025-02-13 12:35:44', '2025-02-13 12:35:44'),
(2, 'Optio officiis aper', 17, 76, 36, 'Aut aliqua Eu nihil', '2025-02-13 12:36:54', '2025-02-13 12:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `task_number` varchar(255) NOT NULL,
  `task_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `hotel_id`, `task_number`, `task_date`, `due_date`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(24, 1, 'TASK-0001', '2025-05-19', '2025-12-12', 375.00, 'unpaid', '2025-05-19 22:56:23', '2025-05-19 22:56:23'),
(25, 1, 'TASK-00025', '2025-05-19', '2025-12-12', 1500.00, 'unpaid', '2025-05-19 22:56:49', '2025-05-19 22:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `task_items`
--

CREATE TABLE `task_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `service` varchar(255) NOT NULL,
  `time` decimal(8,2) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `platform_fee` decimal(8,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_items`
--

INSERT INTO `task_items` (`id`, `task_id`, `employee_id`, `service`, `time`, `price_per_unit`, `platform_fee`, `total`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(27, 24, 54, 'Developer', 5.00, 20.00, 5.00, 375.00, '2025-05-20', '2025-05-22', '2025-05-19 22:56:23', '2025-05-19 22:56:23'),
(28, 25, 54, 'Developer', 5.00, 20.00, 5.00, 1500.00, '2025-05-23', '2025-06-03', '2025-05-19 22:56:49', '2025-05-19 22:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `terminations`
--

CREATE TABLE `terminations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `hotel_name` varchar(255) NOT NULL,
  `termination_reason` varchar(255) NOT NULL,
  `termination_date` date DEFAULT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terminations`
--

INSERT INTO `terminations` (`id`, `employee_id`, `employee_name`, `hotel_name`, `termination_reason`, `termination_date`, `additional_notes`, `created_at`, `updated_at`) VALUES
(1, 58, 'Ulyssesss Erich Littlesss Chandlerss', 'Lilah Olsen', 'Performance Issues', NULL, 'aaaaa', '2025-05-01 18:39:32', '2025-05-01 18:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `timecards`
--

CREATE TABLE `timecards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `break_start` varchar(255) DEFAULT NULL,
  `break_end` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `total_hours` int(11) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `status` varchar(1000) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timecards`
--

INSERT INTO `timecards` (`id`, `employee_id`, `date`, `start_time`, `break_start`, `break_end`, `end_time`, `total_hours`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 57, '2025-01-31', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-01-31 17:33:23', '2025-02-10 12:54:19'),
(2, 56, '2025-02-01', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'unpaid', '2025-02-01 17:33:23', '2025-02-01 17:33:23'),
(3, 55, '2025-02-02', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-02-02 17:33:23', '2025-05-15 19:24:12'),
(4, 54, '2025-02-03', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-02-03 17:33:23', '2025-05-01 22:55:38'),
(5, 57, '2025-02-04', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'unpaid', '2025-02-04 17:33:23', '2025-02-07 17:52:12'),
(6, 56, '2025-02-05', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-02-05 17:33:23', '2025-02-05 17:33:23'),
(7, 55, '2025-02-06', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-02-06 17:33:23', '2025-05-15 19:24:12'),
(8, 54, '2025-02-07', '2025-02-04T08:00:00Z', '2025-02-04T14:00:00Z', '2025-02-04T15:00:00Z', '2025-02-04T17:00:00Z', 8, '160', 'paid', '2025-02-07 17:33:23', '2025-05-01 22:55:38'),
(9, 55, '2025-04-04', '21:41', NULL, NULL, '13:59', 8, '160', 'paid', '2025-04-04 16:55:43', '2025-05-15 19:24:12'),
(10, 58, '2025-04-30', '05:01', '06:01', '07:01', '17:01', 11, '88', 'unpaid', '2025-05-01 00:01:18', '2025-05-01 00:01:18'),
(13, 59, '2025-05-12', '07:52', NULL, NULL, '16:51', 9, '619.85', 'unpaid', '2025-05-12 18:08:38', '2025-05-12 18:08:38'),
(14, 59, '2025-05-20', '08:01', NULL, NULL, '16:58', 9, '617.55', 'unpaid', '2025-05-21 15:22:02', '2025-05-21 15:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `marital_status` enum('single','married','divorced','widowed') NOT NULL DEFAULT 'single',
  `contact_number` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL DEFAULT 'male',
  `about` text DEFAULT NULL,
  `fcm_token` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `image`, `address`, `ssn`, `birth_date`, `marital_status`, `contact_number`, `gender`, `about`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$10$mVGIGdxk9ryP7GobfAqAMOo4MN9.Bzs0QUFAByWzxdhwmkrX99Ez2', 'profileImage/1739556411.png', 'UKA', '123', '2015-01-12', 'married', '5465455555', 'male', 'To display the user\'s image or a default dummy image in your Blade view, you can use a conditional st/atement to check if the user has uploaded a profile image. If the user has an image, it will be displayed; otherwise, a default image will be shown.', NULL, NULL, '2025-01-28 12:15:23', '2025-03-14 20:03:32'),
(56, 'MR', 'Abc', 'oder', 'abc', 'pyrobytesdeveloper@gmail.com', NULL, '$2y$10$VpyrJ1MGE8lJNHdOzuoJk.NDGzhq25plqzhaJms5qeDnWyhhxnigq', '1747261241.jpg', 'Ex laboriosam susci', 'Ullamco magna libero', '2007-08-18', 'single', '+1 (969) 319-8329', 'male', NULL, 'bhcgycgcgwgc', NULL, '2025-01-28 17:41:26', '2025-05-14 22:29:20'),
(57, 'MR', 'EFG', 'woder', 'abc', 'ahsan.ahmed9977@gmail.com', NULL, '$2y$10$c3NYYFxuCBas2El715ruPOQzIqHXQnBjM7rH75QXHjcDoTr6JojAq', 'profileImage/1738943142.webp', 'In irure in ut non n', 'Do est ut vitae des', '1985-09-04', 'single', '+1 (292) 452-2767', 'other', NULL, NULL, NULL, '2025-01-29 14:44:44', '2025-05-01 21:35:42'),
(58, 'MRa', 'HIJa', 'bodera', 'abc', 'developercoder51@gmail.com', NULL, '$2y$10$1HdNs/VAOKGDATC.QlI18e6tXbLOBHugLSgaeS2RPZVXywUOTqhGG', 'profileImage/1738943142.webp', 'Atque ipsam quibusda', 'Ut eveniet autem ut', '2019-11-12', 'single', '+1 (264) 472-1858', 'other', NULL, NULL, NULL, '2025-01-29 14:49:14', '2025-05-01 21:36:24'),
(59, 'MR', 'KLM', 'Loser', 'abc', 'abdulmoiz492@gmail.com', NULL, '$2y$10$mVGIGdxk9ryP7GobfAqAMOo4MN9.Bzs0QUFAByWzxdhwmkrX99Ez2', '1746636805.jpg', 'Nemo magni repellend', 'Magna et in qui qui', '2012-12-21', 'married', '2222222222', 'male', NULL, 'bhcgycgcgwgc', NULL, '2025-02-04 16:10:44', '2025-05-07 16:53:25'),
(60, 'Ulyssesss', 'Erich Littlesss', 'Chandlerss', NULL, 'abc@gmail.com', NULL, '$2y$10$MvgEza/4fnqNvPeXx7N1duyvNWzx3iaeWZeegMu1AC5IWun0J8B3y', NULL, 'Vel qui quia sed sundd', 'Labore rerum aliquam', '2007-11-13', 'married', '+1 (225) 159-2219', 'male', NULL, NULL, NULL, '2025-04-30 23:36:58', '2025-04-30 23:40:29'),
(61, 'Parker', 'Dean', 'Byars', NULL, 'employee01@gmail.com', NULL, '$2y$10$mVGIGdxk9ryP7GobfAqAMOo4MN9.Bzs0QUFAByWzxdhwmkrX99Ez2', NULL, '894 N Germantown Prkwy Suite 200\r\nCordova, TN \r\n38018', '409837571', '1997-08-21', 'married', '9014510470', 'male', NULL, 'bhcgycgcgwgc', NULL, '2025-05-12 18:06:54', '2025-05-23 20:28:30'),
(62, 'Hotel', 'LLC', 'Help', NULL, 'Hotelhelp@gmail.com', NULL, '$2y$10$wRbXMHhp7W3Wk9fqPrDf.OkWq.k5oWkxuoUmPFZuFhtyqZZd3WdE2', NULL, '4377 Hickory Run Place\r\nEads, Tn 38002', '555555555', '1990-08-20', 'married', '9014510470', 'male', NULL, NULL, NULL, '2025-05-15 14:08:03', '2025-05-15 14:08:03'),
(63, 'Ruthmar', 'dmwamd', 'awjdwad', NULL, 'mark@gmail.com', NULL, '$2y$10$vW0yWx1/9ClEI4WLgLMC2ekOR81C5x78CkklFbXhlkEiJSyZXm01e', NULL, 'hello', 'jdoajpdojkapdojwq', '2025-05-16', 'married', '68641896846', 'male', NULL, NULL, NULL, '2025-05-15 19:38:38', '2025-05-15 19:38:38'),
(71, 'Acton', 'Maia James', 'Wilcox', NULL, 'hipozutesi@gmail.com', NULL, '$2y$10$mVGIGdxk9ryP7GobfAqAMOo4MN9.Bzs0QUFAByWzxdhwmkrX99Ez2', NULL, 'Officia aliquid et e', 'Eum sunt aspernatur', '2017-04-30', 'married', '+1 (778) 549-1296', 'male', NULL, 'bhcgycgcgwgc', NULL, '2025-05-23 20:47:35', '2025-05-23 20:51:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_checks`
--
ALTER TABLE `additional_checks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additional_checks_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_id_unique` (`employee_id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_pay_group_id_foreign` (`pay_group_id`),
  ADD KEY `employees_job_id_foreign` (`job_id`),
  ADD KEY `employees_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `fk_invoice_items_employee` (`employee_id`),
  ADD KEY `fk_task_item` (`task_item_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_break_rules`
--
ALTER TABLE `meal_break_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miscellaneous_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `miscellaneous_employee_fields`
--
ALTER TABLE `miscellaneous_employee_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miscellaneous_employee_fields_employee_id_foreign` (`employee_id`),
  ADD KEY `miscellaneous_employee_fields_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `note_rules`
--
ALTER TABLE `note_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `occurrence_rules`
--
ALTER TABLE `occurrence_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pay_groups`
--
ALTER TABLE `pay_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `revenues`
--
ALTER TABLE `revenues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revenues_invoice_id_foreign` (`invoice_id`),
  ADD KEY `revenues_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rounding_rules`
--
ALTER TABLE `rounding_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tasks_task_number_unique` (`task_number`),
  ADD KEY `tasks_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `task_items`
--
ALTER TABLE `task_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_items_task_id_foreign` (`task_id`),
  ADD KEY `task_items_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `terminations`
--
ALTER TABLE `terminations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terminations_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `timecards`
--
ALTER TABLE `timecards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timecards_employee_id_foreign` (`employee_id`);

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
-- AUTO_INCREMENT for table `additional_checks`
--
ALTER TABLE `additional_checks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `meal_break_rules`
--
ALTER TABLE `meal_break_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `miscellaneous_employee_fields`
--
ALTER TABLE `miscellaneous_employee_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `note_rules`
--
ALTER TABLE `note_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `occurrence_rules`
--
ALTER TABLE `occurrence_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pay_groups`
--
ALTER TABLE `pay_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `revenues`
--
ALTER TABLE `revenues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rounding_rules`
--
ALTER TABLE `rounding_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `task_items`
--
ALTER TABLE `task_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `terminations`
--
ALTER TABLE `terminations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timecards`
--
ALTER TABLE `timecards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_checks`
--
ALTER TABLE `additional_checks`
  ADD CONSTRAINT `additional_checks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_pay_group_id_foreign` FOREIGN KEY (`pay_group_id`) REFERENCES `pay_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `fk_invoice_items_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task_item` FOREIGN KEY (`task_item_id`) REFERENCES `task_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD CONSTRAINT `miscellaneous_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `miscellaneous_employee_fields`
--
ALTER TABLE `miscellaneous_employee_fields`
  ADD CONSTRAINT `miscellaneous_employee_fields_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `miscellaneous_employee_fields_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `revenues`
--
ALTER TABLE `revenues`
  ADD CONSTRAINT `revenues_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `revenues_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_items`
--
ALTER TABLE `task_items`
  ADD CONSTRAINT `task_items_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terminations`
--
ALTER TABLE `terminations`
  ADD CONSTRAINT `terminations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timecards`
--
ALTER TABLE `timecards`
  ADD CONSTRAINT `timecards_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
