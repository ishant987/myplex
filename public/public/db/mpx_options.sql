-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2022 at 04:41 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `myplexus_dbx`
--

--
-- Dumping data for table `mpx_options`
--

INSERT INTO `mpx_options` (`option_id`, `field_type`, `field_label`, `option_key`, `option_value`, `options_label`, `options_value`, `type`, `field_info`, `is_required`, `c_order`, `status`, `updated_id`, `updated_at`) VALUES
(NULL, 'text', 'NAV Last Migrate', 'nav_migrate', '1987-02-03', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:32:53'),
(NULL, 'text', 'Indices Last Migrate', 'indices_migrate', '1980-01-02', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:35:23'),
(NULL, 'text', 'Currency Last Migrate', 'currency_migrate', '2005-04-21', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:39:59'),
(NULL, 'text', 'MCAP EPS Last Migrate', 'mcap_eps_migrate', '2005-12-31', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:39:11'),
(NULL, 'text', 'AUM Last Migrate', 'aum_migrate', '2003-08-31', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:40:34'),
(NULL, 'text', 'Fund Composition Last Migrate', 'fund_composition_migrate', '2003-08-31', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:34:01'),
(NULL, 'text', 'Indices Composition Last Migrate', 'indices_composition_migrate', '2003-09-30', NULL, NULL, 'custom', '', 'y', 0, 2, 1, '2022-02-26 15:34:37');
COMMIT;