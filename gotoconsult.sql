-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2022 at 04:01 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gotoconsult`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `consultant_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `session_id` int NOT NULL,
  `booking_date` datetime NOT NULL,
  `communication_type` enum('GotoConsult','Skype') CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL DEFAULT 'GotoConsult',
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_fk_1` (`user_id`),
  KEY `bookings_fk_2` (`consultant_id`),
  KEY `bookings_fk_3` (`plan_id`),
  KEY `bookings_fk_4` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `consultant_id`, `plan_id`, `session_id`, `booking_date`, `communication_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 48, 51, 4, 6, '2022-04-24 13:00:00', 'GotoConsult', 'pending', '2022-04-26 18:32:05', '2022-04-26 18:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat` smallint UNSIGNED NOT NULL DEFAULT '0',
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_name_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_description_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_url`, `category_description`, `vat`, `meta_title`, `meta_description`, `category_icon`, `created_at`, `updated_at`, `category_name_no`, `category_description_no`) VALUES
(1, 'Psychologist', 'psychologist', 'Our mind is an infinite space of memory and imagination. Connect with an online psychologist and explore it.', 10, 'Psychologist', NULL, '/images/consultant/psychologists-icon.svg', '2019-04-08 13:31:07', '2020-12-23 13:03:51', 'Psykolog', 'Er vi opptatt av mental helse, eller kanskje er vi bare nysgjerrige på hvordan det kartlagte psykologiske sinnet fungerer? Kontakt en nettpsykolog for å dykke dypt.'),
(2, 'Economist', 'economist', 'A robust economy means stable living. Connect with one of our online economists and be guided towards the best foundation.', 31, 'economist', NULL, '/images/consultant/economists-icon.svg', '2019-09-06 03:14:38', '2020-12-24 08:52:36', 'Økonom', 'Har vi henvendelser, spørsmål eller nysgjerrigheter der det gjelder økonomi, penger, regnskap eller kanskje budsjettering? Diskuter saker med en nettøkonom.'),
(3, 'Lawyer', 'lawyer', 'An ideal society is where people make laws for the benefit of the people. Connect and ask online lawyers about legal matters.', 11, 'lawyer', NULL, '/images/consultant/lawyers-icon.svg', '2019-09-06 03:14:41', '2020-12-28 12:19:00', 'Advokat', 'Skjedde noe uventet, og plutselig er det behov for juridisk rådgivning? Snakk med en nettadvokat og bli informert om rettigheter.'),
(4, 'Doctor', 'doctor', 'Gain access to medical expertise within moments. Talk about health and related issues with an online doctor.', 0, 'doctor', NULL, '/images/consultant/doctors-icon.svg', '2019-09-06 03:14:43', '2020-09-16 19:14:00', 'Lege', 'Bli ledsaget av legens kunnskap til enhver tid. Få rådgivningen som trengs for å ta riktige skritt for god helse og sikkerhet.'),
(5, 'Veterinarian', 'veterinarian', 'Speak with an online veterinarian about animal health within minutes, and get expert advice at any moment.', 0, 'veterinarian', NULL, '/images/consultant/veterinarian-icon.svg', '2019-09-06 03:14:45', '2020-09-16 19:14:11', 'Veterinær', 'Trenger vi medisinsk råd til kjæledyrene våre, mens det kanskje ikke er noen veterinær tilgjengelig i vår nærmeste omgivelse? Ikke noe problem, snakk med en nettveterinær.'),
(6, 'Astrologer', 'astrologer', 'Connect with an online astrologer to get personal energy readings and to talk about everything between heaven and earth.', 0, 'astrologer', NULL, '/images/consultant/astrologers-icon.svg', '2019-09-06 03:14:48', '2020-09-16 19:14:22', 'Astrolog', 'Er vi nysgjerrige på stjernetegn, energier, sjel og astrologiske fødselsdiagrammer? Ta kontakt med en nettastrolog for personlig konsultasjon.'),
(7, 'Teacher', 'teacher', 'Speak with an online teacher for guidance, to acquire new skills, or to solve practical issues. Good help is one connection away.', 0, 'teacher', NULL, '/images/consultant/teachers-icon.svg', '2019-09-06 03:14:51', '2020-09-16 19:14:32', 'Lærer', 'Trenger du raskt praktisk hjelp, forklaringer eller praksis veiledning? Snakk med kompetente lærere som kan hjelpe oss med å overvinne problemer og mestre utfordringer.'),
(8, 'Nurse', 'nurse', 'Connect with an online nurse and get practical healthcare-related support or acquire instant nursing abilities.', 0, 'nurse', NULL, '/images/consultant/nurses-icon.svg', '2020-05-20 09:39:25', '2020-09-16 19:14:58', 'Sykepleier', 'Hvis vi er i en situasjon der det er nødvendig med praktiske råd knyttet til sykepleie og helsetjenester, kan vi koble til og snakke med en nettsykepleier.');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `consultant_id` varchar(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `institution` varchar(191) DEFAULT NULL,
  `description` longtext,
  `diploma` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `consultant_id`, `date`, `name`, `institution`, `description`, `diploma`, `created_at`, `updated_at`) VALUES
(1, '1', '2020', 'Best CEO 2020', 'FantasyLab', 'Certificate Description', '/assets/uploads/member/JBf3ALvqAf7si7bEuU4iHClfUjPckFcXZ2wT3iWU.jpeg', '2020-09-30 16:40:00', '2020-09-30 16:40:00'),
(2, '2', '2020', 'Best Marketing Woman 2020', 'Law Corp.', 'Certificate description', '/assets/uploads/member/jcG2DJ0pSCMmYfKVKgdgKIjuoRWcLkBEL8iWHWpL.jpeg', '2020-09-30 16:43:57', '2020-09-30 16:43:57'),
(3, '3', '2020', 'Doctor of the year 2020', 'Rikshospitalet', 'Certificate description', '/assets/uploads/member/HlR9SSj7kPV7Kln5edQa0yvXyyKVYopyo1wKJhdX.jpeg', '2020-09-30 16:47:08', '2020-09-30 16:47:08'),
(4, '4', '2020', 'test', 'test', 'test', NULL, '2020-10-28 22:45:50', '2020-10-28 22:45:50'),
(5, '5', '2020', 'Best Doctor of 2020', 'Barclona Hospital', NULL, NULL, '2020-10-31 18:23:40', '2020-10-31 18:23:40'),
(6, '6', '2020', 'Best Veterinarian 2020', 'UiO', NULL, NULL, '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(7, '7', '2020', 'Best CEO 2020', 'Uio', NULL, '/assets/uploads/member/ihe9ntmfsL3JQF0Wi7s6Zuaq32pP6wztFRuQRQdT.jpeg', '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(8, '8', '2020', 'Best employee of 2020', 'Mari AS', 'test', '/assets/uploads/member/P9rDZfFrmcu6LPtPzmOdo1rPr4plQQZlIFNSUkmx.jpeg', '2020-11-01 16:04:06', '2020-11-01 16:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
CREATE TABLE IF NOT EXISTS `channels` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel` varchar(255) NOT NULL,
  `consultant_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `direction` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`id`, `channel`, `consultant_id`, `customer_id`, `direction`, `created_at`, `updated_at`) VALUES
(1, 'private-53-48', '53', '48', 'con-cus', '2020-09-30 16:55:40', '2020-09-30 16:55:40'),
(2, 'private-53-49', '53', '49', 'con-cus', '2020-09-30 18:02:56', '2020-09-30 18:02:56'),
(3, 'private-52-49', '52', '49', 'con-cus', '2020-10-15 23:28:08', '2020-10-15 23:28:08'),
(4, 'private-52-50', '52', '50', 'con-cus', '2020-10-21 14:32:29', '2020-10-21 14:32:29'),
(5, 'private-51-48', '51', '48', 'con-cus', '2020-10-27 00:05:41', '2020-10-27 00:05:41'),
(6, 'private-52-48', '52', '48', 'con-cus', '2020-10-27 02:31:56', '2020-10-27 02:31:56'),
(7, 'private-51-54', '51', '54', 'con-cus', '2020-11-01 13:06:04', '2020-11-01 13:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `charging_transactions`
--

DROP TABLE IF EXISTS `charging_transactions`;
CREATE TABLE IF NOT EXISTS `charging_transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount` float(255,0) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `charging_transactions`
--

INSERT INTO `charging_transactions` (`id`, `user_id`, `type`, `amount`, `currency`, `transaction_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '48', 'Visa', 100, NULL, 'ch_1HX9bMFofdOxgXrmcV61T8UO', 'succeeded', '2020-09-30 18:00:29', '2020-09-30 18:00:29'),
(2, '48', 'Visa', 300, NULL, 'ch_1HX9cjFofdOxgXrmXybz3rMA', 'succeeded', '2020-09-30 18:01:54', '2020-09-30 18:01:54'),
(3, '48', 'Klarna', 100, NULL, 'ce7d3411-18e1-6a27-a3bc-079d331c88c3', 'success', '2020-09-30 18:34:55', '2020-09-30 18:34:55'),
(4, '48', 'Visa', 300, NULL, 'ch_1HXBqDFofdOxgXrmlnS93l5a', 'succeeded', '2020-09-30 20:23:57', '2020-09-30 20:23:57'),
(5, '48', 'Visa', 300, NULL, 'ch_1HXBqDFofdOxgXrmjqMZURIE', 'succeeded', '2020-09-30 20:23:58', '2020-09-30 20:23:58'),
(6, '48', 'Visa', 300, NULL, 'ch_1HXBqEFofdOxgXrmpW6SLA3B', 'succeeded', '2020-09-30 20:23:58', '2020-09-30 20:23:58'),
(7, '48', 'Visa', 300, NULL, 'ch_1HXBqEFofdOxgXrmSGq8ODDr', 'succeeded', '2020-09-30 20:23:59', '2020-09-30 20:23:59'),
(8, '48', 'Visa', 300, NULL, 'ch_1HXBqaFofdOxgXrmpdFj0TF8', 'succeeded', '2020-09-30 20:24:20', '2020-09-30 20:24:20'),
(9, '54', 'Visa', 100, NULL, 'ch_1HXBtYFofdOxgXrm7RViDyFV', 'succeeded', '2020-10-26 20:55:16', '2022-03-31 14:09:22'),
(10, '49', 'Visa', 5000, 'NOK', 'ch_1HgcilFofdOxgXrmt8wzSVm7', 'succeeded', '2020-10-26 20:55:16', '2020-10-26 20:55:16'),
(11, '49', 'Visa', 100, 'NOK', 'ch_1HgcpxFofdOxgXrmIwn6lc4O', 'succeeded', '2020-10-26 21:02:44', '2020-10-26 21:02:44'),
(12, '49', 'Visa', 100, 'NOK', 'ch_1HgcqwFofdOxgXrmjrHwPyOY', 'succeeded', '2020-10-26 21:03:43', '2020-10-26 21:03:43'),
(13, '49', 'Visa', 100, 'NOK', 'ch_1HgcubFofdOxgXrmoNkRSUo9', 'succeeded', '2020-10-26 21:07:29', '2020-10-26 21:07:29'),
(14, '49', 'Visa', 100, 'NOK', 'ch_1HgeQOFofdOxgXrmnMggMD02', 'succeeded', '2020-10-26 22:44:25', '2020-10-26 22:44:25'),
(15, '48', 'Visa', 100, 'NOK', 'ch_1HhLKiFofdOxgXrmwB8G51M2', 'succeeded', '2020-10-28 20:33:24', '2020-10-28 20:33:24'),
(16, '48', 'Visa', 100, 'NOK', 'ch_1HiPJ8FofdOxgXrmsoCwpjEa', 'succeeded', '2020-10-31 19:00:11', '2020-10-31 19:00:11'),
(17, '51', 'Klarna', 100, NULL, 'ffce8d44-855d-6d0f-af8a-0eaa4cdc695d', 'success', '2020-10-31 19:34:47', '2020-10-31 19:34:47'),
(18, '51', 'Visa', 100, 'NOK', 'ch_1HiPrzFofdOxgXrm8biO1nBP', 'succeeded', '2020-10-31 19:36:11', '2020-10-31 19:36:11'),
(19, '51', 'Visa', 100, 'NOK', 'ch_1HiPseFofdOxgXrmRWcEtFu3', 'succeeded', '2020-10-31 19:36:53', '2020-10-31 19:36:53'),
(20, '51', 'Visa', 100, 'NOK', 'ch_1HigMqFofdOxgXrmUERwkNPT', 'succeeded', '2020-11-01 13:13:08', '2020-11-01 13:13:08'),
(21, '55', 'Visa', 100, 'NOK', 'ch_1HiggFFofdOxgXrmlMFghxsc', 'succeeded', '2020-11-01 13:33:11', '2020-11-01 13:33:11'),
(22, '55', 'Visa', 100, 'NOK', 'ch_1HiggfFofdOxgXrmI6HS9CqR', 'succeeded', '2020-11-01 13:33:37', '2020-11-01 13:33:37'),
(23, '48', 'Visa', 100, 'NOK', 'ch_1HiiRuFofdOxgXrmwQFKDPfe', 'succeeded', '2020-11-01 15:26:31', '2020-11-01 15:26:31'),
(24, '48', 'Klarna', 100, NULL, '6f1ac278-d644-64fb-86ae-ac1901957d58', 'success', '2020-11-01 15:29:16', '2020-11-01 15:29:16'),
(25, '54', 'Visa', 10, 'USD', 'ch_1HlodDFofdOxgXrmJMTo37a4', 'succeeded', '2020-11-10 04:39:00', '2020-11-10 04:39:00'),
(26, '54', NULL, 500, 'USD', 'ch_1HltOyFofdOxgXrmpaxPi6MI', 'succeeded', '2020-11-10 09:44:37', '2020-11-10 09:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) DEFAULT NULL,
  `organization_number` varchar(191) DEFAULT NULL,
  `bank_account` varchar(191) DEFAULT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `zip_code` varchar(191) DEFAULT NULL,
  `zip_place` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `organization_number`, `bank_account`, `first_name`, `last_name`, `address`, `zip_code`, `zip_place`, `country`, `created_at`, `updated_at`) VALUES
(1, 'company name', 'organization number', 'bank account number', 'Arild', 'Heltberg', 'company address', 'zip code', 'Oslo', 'Norway', '2020-09-30 16:40:00', '2020-09-30 16:40:00'),
(2, 'company name', 'organization number', 'bank account number', 'Jasmine', 'Santori', 'company address', 'zip code', 'Oslo', 'Norway', '2020-09-30 16:43:57', '2020-09-30 16:43:57'),
(3, 'company name', 'organization number', 'bank account number', 'Chris', 'Pettersen', 'company address', 'zip code', 'Oslo', 'Norway', '2020-09-30 16:47:08', '2020-09-30 16:47:08'),
(4, 'FantasyLab', '914798493', '1234123412341234', 'Aryan', 'Browzki', 'Firmadresse 123', '1234', 'Islāmābād', 'Pakistan', '2020-10-28 22:45:50', '2020-10-28 22:45:50'),
(5, 'FantasyLab', '914798493', '1234123412341234', 'Laila', 'Lund', 'Company Address 1', '1234', 'Barcelona', 'Spain', '2020-10-31 18:23:40', '2020-10-31 18:23:40'),
(6, 'test', '12345678', '1234567889', 'Nina', 'Jensen', 'test', '12345', 'Al Muḩarraq', 'Bahrain', '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(7, 'test', '123456789', '123456789', 'Farhood', 'Gandomani', 'test', '12345', 'Hamburg', 'Germany', '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(8, 'Mari AS', '123456789', '12345689', 'Mari', 'Ekeløf', 'Test veien', '12345', 'Delhi', 'India', '2020-11-01 16:04:06', '2020-11-01 16:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `consultants`
--

DROP TABLE IF EXISTS `consultants`;
CREATE TABLE IF NOT EXISTS `consultants` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_contact` int DEFAULT NULL,
  `chat_contact` int DEFAULT NULL,
  `video_contact` int DEFAULT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hourly_rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` float(11,0) DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_sessions` int DEFAULT NULL,
  `response_rate` float(11,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultants`
--

INSERT INTO `consultants` (`id`, `user_id`, `profile_id`, `company_id`, `phone_contact`, `chat_contact`, `video_contact`, `currency`, `hourly_rate`, `rate`, `payment_method`, `completed_sessions`, `response_rate`, `created_at`, `updated_at`) VALUES
(1, '51', '4', '1', 1, 1, 0, 'NOK', '25', 2, NULL, 19, NULL, '2020-09-30 16:40:00', '2020-12-28 14:27:09'),
(2, '52', '5', '2', 1, 1, 0, 'USD', '24', NULL, NULL, NULL, NULL, '2020-09-30 16:43:57', '2020-10-23 22:41:38'),
(3, '53', '6', '3', 0, 1, 1, 'NOK', '24', 5, NULL, 1, NULL, '2020-09-30 16:47:08', '2020-09-30 20:39:15'),
(4, '55', '7', '4', 1, 1, 1, 'NOK', '34', NULL, NULL, NULL, NULL, '2020-10-28 22:45:50', '2020-10-28 22:45:50'),
(5, '57', '8', '5', 0, 1, 1, 'NOK', '64', NULL, NULL, NULL, NULL, '2020-10-31 18:23:40', '2020-10-31 18:37:10'),
(6, '60', '9', '6', 1, 1, 1, 'NOK', '25', NULL, NULL, NULL, NULL, '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(7, '61', '10', '7', 1, 1, 1, 'NOK', '78', NULL, NULL, NULL, NULL, '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(8, '63', '11', '8', 1, 1, 1, 'NOK', '50', NULL, NULL, NULL, NULL, '2020-11-01 16:04:06', '2020-11-01 16:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_contact` int DEFAULT NULL,
  `chat_contact` int DEFAULT NULL,
  `video_contact` int DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` float(11,0) DEFAULT NULL,
  `completed_sessions` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `profile_id`, `company_id`, `phone_contact`, `chat_contact`, `video_contact`, `payment_method`, `currency`, `rate`, `completed_sessions`, `created_at`, `updated_at`) VALUES
(1, '48', '1', NULL, 0, 0, 0, NULL, 'EUR', 2, 20, '2020-09-30 16:29:41', '2020-12-28 14:27:09'),
(2, '49', '2', NULL, 0, 0, 0, NULL, 'NOK', NULL, NULL, '2020-09-30 16:31:30', '2020-10-26 22:23:54'),
(3, '50', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-30 16:33:52', '2020-09-30 16:35:40'),
(4, '54', '13', NULL, NULL, NULL, NULL, NULL, 'USD', 5, 5, '2020-10-03 13:56:18', '2020-11-10 16:25:49'),
(5, '56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-10-31 17:57:51', '2020-10-31 17:57:51'),
(6, '58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-01 13:20:57', '2020-11-01 13:20:57'),
(7, '59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-01 13:22:57', '2020-11-01 13:22:57'),
(8, '62', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-01 15:38:19', '2020-11-01 15:38:19'),
(9, '55', '12', NULL, 1, 1, 1, NULL, 'NOK', NULL, NULL, '2020-11-05 11:55:13', '2020-11-05 11:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

DROP TABLE IF EXISTS `educations`;
CREATE TABLE IF NOT EXISTS `educations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `consultant_id` varchar(11) DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `institution` varchar(191) DEFAULT NULL,
  `major` varchar(50) DEFAULT NULL,
  `degree` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `diploma` longtext,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `consultant_id`, `from`, `to`, `institution`, `major`, `degree`, `description`, `diploma`, `created_at`, `updated_at`) VALUES
(1, '1', '2020', '2020', 'University of Oslo', 'Psychology', 'master', 'Education description', '/assets/uploads/member/Ul9W7dhkquNkVqxy2JjsReQ7Dfsqj4GaZC8xKbtC.jpeg', '2020-09-30 16:40:00', '2020-09-30 16:40:00'),
(2, '2', '2020', '2020', 'University of Oslo', 'Lawyer', 'postdoctoral', 'Education description', '/assets/uploads/member/TLZumjbw9m8cQWT2sPZBM4oq4WzMMeC7l9N8L3T5.jpeg', '2020-09-30 16:43:57', '2020-09-30 16:43:57'),
(3, '3', '2020', '2020', 'University of Oslo', 'Medicine', 'master', 'Education description', '/assets/uploads/member/qAP6j3OBNEVhp3FDhNOM2f2WFHLgly6qxaqkSg5J.jpeg', '2020-09-30 16:47:08', '2020-09-30 16:47:08'),
(4, '4', '2020', '2020', 'test', 'test', 'bachelor', NULL, NULL, '2020-10-28 22:45:50', '2020-10-28 22:45:50'),
(5, '5', '2020', '2020', 'University of Barcelona', 'Medicine', 'doctorate', NULL, NULL, '2020-10-31 18:23:40', '2020-10-31 18:23:40'),
(6, '6', '2020', '2020', 'UiO', 'Animal Doctor', 'postdoctoral', NULL, NULL, '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(7, '7', '2020', '2020', 'UiO', 'Psycology', 'master', NULL, '/assets/uploads/member/h7syVFHxz0XOg8fEVm1WQwPIjrvly35mIUq5fP83.jpeg', '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(8, '8', '2016', '2020', 'University of Oslo', 'Psychology', 'master', 'Hei å hå', '/assets/uploads/member/Z9s4m3NnbtY02mCenCl67UsHIBTqiOrqDNzGmVDy.jpeg', '2020-11-01 16:04:06', '2020-11-01 16:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
CREATE TABLE IF NOT EXISTS `experiences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `consultant_id` varchar(11) DEFAULT NULL,
  `from` varchar(50) DEFAULT NULL,
  `to` varchar(50) DEFAULT NULL,
  `company` varchar(191) DEFAULT NULL,
  `position` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `description` longtext,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `consultant_id`, `from`, `to`, `company`, `position`, `country`, `city`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', '2020', '2020', 'FantasyLab', 'CEO', 'Norway', 'Oslo', 'Work experience description', '2020-09-30 16:40:00', '2020-09-30 16:40:00'),
(2, '2', '2020', '2020', 'Law Corp.', 'CMO', 'Norway', 'Oslo', 'Work experience description', '2020-09-30 16:43:57', '2020-09-30 16:43:57'),
(3, '3', '2020', '2020', 'Rikshospitalet', 'Doctor', 'Norway', 'Oslo', 'Work experience description', '2020-09-30 16:47:08', '2020-09-30 16:47:08'),
(4, '4', '2020', '2020', 'test', 'test', 'Albania', 'Dibër', 'test', '2020-10-28 22:45:50', '2020-10-28 22:45:50'),
(5, '5', '2020', '2020', 'Barcelona Hospital', 'Doctor', 'Spain', 'Barcelona', NULL, '2020-10-31 18:23:40', '2020-10-31 18:23:40'),
(6, '6', '2020', '2020', 'Animal Doctor', 'Veterinarian', 'Aruba', 'Aruba', NULL, '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(7, '7', '2020', '2020', 'FantasyLab', 'CEO', 'Afghanistan', 'Badakhshan', NULL, '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(8, '8', '2020', '2020', 'Mari AS', 'Psychologist', 'Norway', 'Oslo', 'test', '2020-11-01 16:04:06', '2020-11-01 16:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_id` bigint UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `till_date` date NOT NULL,
  `status` enum('N','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '  N=>Not paid, P=>Paid',
  `gtc_fee` decimal(7,2) UNSIGNED NOT NULL,
  `vat` decimal(7,2) UNSIGNED NOT NULL,
  `total` decimal(7,2) UNSIGNED NOT NULL,
  `ref_transactions` json NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `invoices_creator_id_status_from_date_till_date_index` (`creator_id`,`status`,`from_date`,`till_date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `creator_id`, `from_date`, `till_date`, `status`, `gtc_fee`, `vat`, `total`, `ref_transactions`, `updated_at`, `created_at`) VALUES
(3, 51, '2021-04-01', '2021-05-31', 'N', '6.00', '2.50', '27.50', '[\"243\"]', '2021-04-07 01:46:40', '2021-04-07 01:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2020_12_18_144354_create_missed_notifications_table', 1),
(19, '2020_12_18_145728_categories_add_vat_field', 1),
(21, '2020_12_25_112954_transactions_add_vat_fields', 2);

-- --------------------------------------------------------

--
-- Table structure for table `missed_notifications`
--

DROP TABLE IF EXISTS `missed_notifications`;
CREATE TABLE IF NOT EXISTS `missed_notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `missed_notifications_receiver_id_foreign` (`receiver_id`),
  KEY `missed_notifications_sender_id_receiver_id_index` (`sender_id`,`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missed_notifications`
--

INSERT INTO `missed_notifications` (`id`, `sender_id`, `receiver_id`, `created_at`) VALUES
(24, 53, 48, '2020-12-26 07:31:10'),
(26, 50, 49, '2020-12-28 11:51:54'),
(28, 52, 48, '2020-12-28 13:03:36'),
(29, 51, 48, '2020-12-28 13:03:36'),
(30, 50, 48, '2020-12-28 13:03:36'),
(31, 52, 48, '2020-12-28 13:03:36'),
(32, 48, 51, '2020-12-28 14:33:29'),
(33, 48, 51, '2020-12-28 16:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` int UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` int UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `page_url`, `page_body`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'category', NULL, '{\"review_list\":{\"en_title\":\"Good people. Good word\",\"no_title\":\"Bra mennesker.  Gode \\u200b\\u200bord\",\"arr\":[{\"path\":\"/images/christine.png\",\"en_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"name\":\"Sara C.\"},{\"path\":\"/images/christine.png\",\"en_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"name\":\"Arman\"},{\"path\":\"/images/christine.png\",\"en_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"name\":\"Sara C.\"},{\"path\":\"/images/christine.png\",\"en_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_des\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"name\":\"Martin\"}]},\"footer\":{\"en_title\":\"New to GotoConsult?\",\"no_title\":\"Er du ny p\\u00e5 GotoConsult?\",\"en_des\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\\n\\nWhen an unknown printer took a galley of type and scrambledit to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.\",\"no_des\":\"Lorem Ipsum er ganske enkelt dummy tekst fra trykkeri- og typebransjen. Lorem Ipsum har v\\u00e6rt bransjens standard dummy-tekst helt siden 1500-tallet.\\n\\nDa en ukjent skriver tok en bysse av type og scrambledit for \\u00e5 lage en type eksemplarbok. Det har overlevd ikke bare fem \\u00e5rhundrer, men ogs\\u00e5 spranget til elektronisk setting, og forblir i hovedsak uendret.\",\"en_btn_title1\":\"Sign up\",\"en_btn_link1\":\"register\",\"no_btn_title1\":\"Melde deg p\\u00e5\",\"no_btn_link1\":\"no\\/registrer\",\"en_btn_title2\":\"Become a Consultant\",\"en_btn_link2\":\"become-consultant\",\"no_btn_title2\":\"Bli konsulent\",\"no_btn_link2\":\"no\\/bli-konsulent\"},\"reviews\":{\"en_title\":\"Let our reviews influence.\",\"no_title\":\"La v\\u00e5re anmeldelser p\\u00e5virke.\"}}', NULL, NULL, '2019-10-12 22:35:12', '2019-10-18 00:43:36'),
(2, 'Become a Consultant', 'become_consultant', '{\"en_header\":{\"title\":\"Become a Consultant\",\"description\":\"Start earning money from anywhere in the world.\"},\"no_header\":{\"title\":\"Bli konsulent\",\"description\":\"Begynn \\u00e5 tjene penger hvor som helst i verden.\"},\"list\":[{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/GS4KzMNfYM1yQBCEYER40w2gKGC5cVNIDfdPHsz9.svg\",\"en_txt\":\"Be the boss and work independently from anywhere.\",\"no_txt\":\"V\\u00e6r sjefen og jobb uavhengig fra hvor som helst.\",\"en_title\":\"Be an independent online consultant.\",\"no_title\":\"V\\u00e6r en uavhengig nettkonsulent.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/rhpNWWYSVURIOf5QxEVqTdcDeY1bUlS36V8ovuuc.svg\",\"en_txt\":\"Share expertise and get paid through our platform.\",\"no_txt\":\"Del kompetanse og f\\u00e5 betalt gjennom v\\u00e5r plattform.\",\"en_title\":\"Earn money as an independent online consultant.\",\"no_title\":\"Tjen penger som uavhengig nettkonsulent.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/pnL5U9Gse4XTvm5ugFRVj0zOaeZZ0qCnuiTs7bJx.svg\",\"en_txt\":\"Be in the comforts of the Homebase.\",\"no_txt\":\"V\\u00e6r i hjemmebasens komfort.\",\"en_title\":\"Work from anywhere in the world.\",\"no_title\":\"Jobb fra hvor som helst i verden.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/2504k6ITJ2K1oWdwnx93j22CFamRTzP3cZXx2mgp.svg\",\"en_txt\":\"Provide high value and watch the income grow.\",\"no_txt\":\"Skap h\\u00f8y verdi og se inntekten vokse.\",\"en_title\":\"Keep track of income.\",\"no_title\":\"Hold oversikt over inntekt.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/T2VOZyh3rB4tBUCa0au6CKCX5qySBXS8wme9YXfb.svg\",\"en_txt\":\"Set up an account, customize, and stay in control.\",\"no_txt\":\"Sett opp en konto, tilpass og hold kontroll.\",\"en_title\":\"Complete account control.\",\"no_title\":\"Fullstendig kontroll over konto.\"}]}', 'GoToConsult - Become Consultant', 'Become Consultant page', '2019-10-12 22:35:48', '2020-09-16 19:19:59'),
(3, 'About us', 'about', '{\"desktop_banner_img\":\"\\/assets\\/uploads\\/banner\\/osgdFFhXlCv5Q8wVw6wMO39qdIi3MxOb0DSw8Nlw.png\",\"mobile_banner_img\":\"\\/images\\/about\\/about-banner-mobile.png\",\"en_header\":{\"title\":\"We are GotoConsult\",\"description\":\"We strongly believe in sharing and receiving expert help through the power of digital technology. We have simplified the connection process between clients and professional consultants, through time- and cost-efficiency.\"},\"no_header\":{\"title\":\"Vi er GotoConsult\",\"description\":\"Vi har sterk tro p\\u00e5 deling av eksperthjelp gjennom kraften i digital teknologi. Vi har forenklet tilkoblingsprosessen mellom klienter og profesjonelle nettkonsulenter, gjennom tids- og kostnadseffektivitet.\"},\"article_list\":{\"en_title\":\"Our platform is the right choice.\",\"no_title\":\"Plattformen v\\u00e5r er det riktige valget.\",\"en_des\":\"\",\"no_des\":\"\",\"arr\":[{\"icon\":\"\\/images\\/consultant\\/psychologists-icon.svg\",\"en_title\":\"Direct communication.\",\"no_title\":\"Direkte kommunikasjon.\",\"en_des\":\"Our platform allows direct communication between clients and consultants.\",\"no_des\":\"V\\u00e5r plattform tillater direkte kommunikasjon mellom klienter og nettkonsulenter.\"},{\"icon\":\"\\/images\\/consultant\\/economists-icon.svg\",\"en_title\":\"Pay and go.\",\"no_title\":\"Betal og kom i gang.\",\"en_des\":\"Pay for quick and good help as a client, or earn good money by providing quality services as an online consultant.\",\"no_des\":\"Betal for rask og god hjelp som klient, eller tjen gode penger ved \\u00e5 tilby kvalitetstjenester som nettkonsulent.\"},{\"icon\":\"\\/images\\/consultant\\/lawyers-icon.svg\",\"en_title\":\"Save time.\",\"no_title\":\"Spar tid.\",\"en_des\":\"Connect, explore, resolve issues, and progress in lesser time.\",\"no_des\":\"Koble til, utforsk, l\\u00f8s utfordringer og skap fremgang p\\u00e5 kortere tid.\"},{\"icon\":\"\\/images\\/consultant\\/doctors-icon.svg\",\"en_title\":\"Be independent.\",\"no_title\":\"V\\u00e6r uavhengig\",\"en_des\":\"Share or receive expert help online, and feel the power of independence.\",\"no_des\":\"Del eller motta eksperthjelp p\\u00e5 nett, og f\\u00f8l kraften av uavhengighet.\"}]},\"story\":{\"en_title\":\"Our Story\",\"no_title\":\"V\\u00e5r historie\",\"en_des\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,<br><br>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,<br><br>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,<br><br>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,<br><br>Lorem Ipsum is simply dummy text of the printing and typesetting.\",\"no_des\":\"Lorem Ipsum er Ghanaian enkelt dummy text fra trykkeri- og typebransjen.  Lorem Ipsum har v\\u00e6rt bransjens standard dummy-text helt siden 1500-tallet,<br><br>Lorem Ipsum er ganski enkelt dummy text fra trykkeri- og typebransjen.  Lorem Ipsum har v\\u00e6rt bransjens standard dummy-text helt siden 1500-tallet,<br><br>Lorem Ipsum er ganski enkelt dummy text fra trykkeri- og typebransjen.  Lorem Ipsum har v\\u00e6rt bransjens standard dummy-text helt siden 1500-tallet,<br><br>Lorem Ipsum er ganski enkelt dummy text fra trykkeri- og typebransjen.  Lorem Ipsum har v\\u00e6rt bransjens standard dummy-text helt siden 1500-tallet,<br><br>Lorem Ipsum er Ghanaian enkelt dummitekst for utskrift og innstilling.\",\"path\":\"\\/images\\/about\\/mobile-screen.png\"},\"team\":[{\"avatar\":\"\",\"name\":\"Mari Chauhan\",\"en_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"en_job\":\"Chief Executive Officer\",\"no_job\":\"Konsernsjef\"},{\"avatar\":\"\",\"name\":\"Mohammed Elhatri\",\"en_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"en_job\":\"Chief Marketing Officer\",\"no_job\":\"Chief Marketing Officer\"},{\"avatar\":\"\\/images\\/member\\/nohman.png\",\"name\":\"Nohman Janjua\",\"en_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"no_bio\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptatibus, distinctio nisi similique saepe architecto modi labore sequi accusamus debitis suscipit dicta non, deserunt dolorum aspernatur, odio dignissimos earum animi.\",\"en_job\":\"Chief Technology Officer\",\"no_job\":\"Chief Technology Officer\"}],\"get_started\":{\"en_title\":\"Easy to get started.\",\"no_title\":\"Lett \\u00e5 komme i gang.\",\"arr\":[{\"en_title\":\"Create account\",\"no_title\":\"Opprett konto\",\"en_des\":\"Sign up as a client, or fill out our form to start an online career.\",\"no_des\":\"Registrer deg som kunde, eller fyll ut skjemaet v\\u00e5rt for \\u00e5 starte en nettkarriere.\"},{\"en_title\":\"Add balance\",\"no_title\":\"Legg til balanse\",\"en_des\":\"Use a credit card to purchase a positive balance for your account.\",\"no_des\":\"Bruk et kredittkort til \\u00e5 kj\\u00f8pe en positiv saldo for kontoen din.\"},{\"en_title\":\"Choose a consultant\",\"no_title\":\"Velg konsulent\",\"en_des\":\"Start a chat, call, or video session about whatever that is on the mind.\",\"no_des\":\"Start en chat-, samtale- eller videom\\u00f8te om hva du m\\u00e5tte \\u00f8nske deg.\"}]},\"reviews\":{\"en_title\":\"Let our reviews influence in the best way.\",\"no_title\":\"La v\\u00e5re anmeldelser p\\u00e5virke deg i riktig retning.\"},\"footer\":{\"en_title\":\"Join the platform\",\"no_title\":\"Meld deg inn og bruk v\\u00e5r plattform.\",\"en_des\":\"Clients from all over the world can GotoConsult and connect with online consultants from various professions such as psychologists, doctors, lawyers, and more.<br><br>\\nWe made our application after extensive research, with the sole purpose of making it a secure platform for clients and online consultants to connect fast and easy to solve whatever issue.<br><br>  \\nSign up for free as a client or click on \\\"Become a Consultant\\\" to fill out required forms and start your online career with us.\",\"no_des\":\"Klienter fra hele verden kan GotoConsult og f\\u00e5 kontakt med nettkonsulenter fra forskjellige yrker som psykologer, leger, advokater og mer.<br><br>\\nVi skapte applikasjonen v\\u00e5r etter omfattende unders\\u00f8kelser, med det eneste form\\u00e5l \\u00e5 gj\\u00f8re det til en sikker plattform for kunder og nettkonsulenter \\u00e5 koble seg enkelt til, for \\u00e5 l\\u00f8se utfordringer. <br><br>\\nRegistrer deg gratis som klient eller klikk p\\u00e5 \\\"Bli konsulent\\\" for \\u00e5 fylle ut n\\u00f8dvendige skjemaer og starte din nettkarriere hos oss.\",\"en_btn_title1\":\"Sign up\",\"en_btn_link1\":\"register\",\"no_btn_title1\":\"Melde deg p\\u00e5\",\"no_btn_link1\":\"no\\/registrer\",\"en_btn_title2\":\"Become a Consultant\",\"en_btn_link2\":\"become-consultant\",\"no_btn_title2\":\"Bli konsulent\",\"no_btn_link2\":\"no\\/bli-konsulent\"}}', 'GoToConsult - About US', 'About us Page', '2019-10-12 22:36:15', '2020-12-10 18:16:54'),
(4, 'FAQ', 'faq', '{\"header\":{\"path\":\"/images/q-mark.png\",\"en_des\":\"Here you can read the answers to the most common questions about our services.<br>Can\'t find what you\'re wondering about? Fill out the contact form and we will contact you in no time\",\"no_des\":\"Her kan du lese welded p\\u00e5 de vanligste sp\\u00f8rsm\\u00e5lene om v\\u00e5re tjenester. <br> Finner du ikke det du lurer p\\u00e5?  Fyll ut contact s\\u00e5 kontak vi deg p\\u00e5 kort tid\",\"en_title\":\"Frequently Asked Questions\",\"no_title\":\"ofte stilte sp\\u00f8rsm\\u00e5l\"},\"question_header\":{\"en_title\":\"Frequently Asked Questions\",\"no_title\":\"ofte stilte sp\\u00f8rsm\\u00e5l\",\"en_msg_title\":\"Send message\",\"no_msg_title\":\"Sende melding\"},\"questions\":[{\"en_que\":\"How does the service work?\",\"no_que\":\"Hvordan fungerer tjenesten?\",\"en_asw\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\"no_asw\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"},{\"en_que\":\"What is GoToConsult?\",\"no_que\":\"Hva er GoToConsult?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"How can I connect with a consultant?\",\"no_que\":\"Hvordan kan jeg f\\u00e5 kontakt med en konsulent?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"Can the consultant see who I am?\",\"no_que\":\"Kan konsulenten se hvem jeg er?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"How much does the service cost and how do I pay?\",\"no_que\":\"Hvor mye koster tjenesten, og hvordan betaler jeg?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"Who can use the service?\",\"no_que\":\"Hvem kan bruke tjenesten?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"What kind of advice can you get?\",\"no_que\":\"Hva slags r\\u00e5d kan du f\\u00e5?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"},{\"en_que\":\"What happens if I am not satisfied?\",\"no_que\":\"Hva skjer hvis jeg ikke er forn\\u00f8yd?\",\"en_asw\":\"CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc.\",\"no_asw\":\"CSS st\\u00e5r for Cascading Style Sheet. CSS lar deg spesifisere forskjellige stilegenskaper for et gitt HTML-element, for eksempel farger, bakgrunn, skrifter osv.\"}]}', 'GoToConsult - FAQ', 'FAQ Page', '2019-10-12 22:36:36', '2020-09-23 00:57:27'),
(5, 'Terms for Customer', 'terms_customer', '{\"header\":{\"path\":\"\\/images\\/document-icon.svg\",\"en_des\":\"Here you will find an overview of our terms and conditions when you use our services at Teletjenesten.no If you have any questions, you can always contact us by filling out the contact form\",\"no_des\":\"Dette er standard avtalevilk\\u00e5r for bruk av v\\u00e5re tjenester rettet mot kunder. V\\u00e6r s\\u00e5 vennlig \\u00e5 les og godta, f\\u00f8r du bruker tjenestene v\\u00e5re.\",\"en_title\":\"Terms of Service for Customer\",\"no_title\":\"Servicevilk\\u00e5r for kunden\",\"link\":null},\"contents\":{\"en\":\"<h2 style=\\\"margin-bottom: 2px; color:#000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the site with its terms<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The Website, www.gotoconsult.com, (the \\\"Website\\\") is wholly owned by Teletjenesten AS (hereinafter referred to as \\\"GoToConsult\\\"), org.no. <\\/font><font style=\\\"vertical-align: inherit;\\\">921 757 468.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">By registered user, Provider and Customer agree to be bound by the Telecommunications Service\'s current terms and conditions at all times. <\\/font><font style=\\\"vertical-align: inherit;\\\">Significant change of terms will be notified by GoToConsult to the Provider\'s or Customer\'s registered email address and will not occur until 30 days after sent notice.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">More about the requirements for offers<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Minimum Requirements for Creating User Profile as Provider<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">In order to create a profile, the provider is required to be self-employed, either by constituting an AS, individual enterprises or the like. <\\/font><font style=\\\"vertical-align: inherit;\\\">The company must comply with statutory requirements that apply to the business.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">To provide services that require authorization, documentation is required that the relevant service provider, as well as persons acting on behalf of the Provider, are authorized to do so.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider profile requirements<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile should describe and any photos other than profile pictures should show the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">From the User Profile, payment terms, including prices, for the service must be clear and clear. <\\/font><font style=\\\"vertical-align: inherit;\\\">It will also be stated if VAT is incurred for the service.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The profile should describe relevant and correct information about the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">A profile that is considered misleading in violation of mandatory legislation or which may be considered offensive is not permitted. <\\/font><font style=\\\"vertical-align: inherit;\\\">It is not allowed to copy text or images in such a way that it violates the intellectual property rights of the licensee or other rights under the law. <\\/font><font style=\\\"vertical-align: inherit;\\\">Pictures of an individual that can be linked to an individual can only be used if explicit consent from the person is obtained.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile that violates the requirements described above will be removed if conditions are not rectified within 7 days notice from GoToConsult. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult has access to the provider profile under any circumstances and can edit content as an alternative to notification and \\/ or removal of user profile as mentioned above.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Requirements for communication between provider and customer<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Communication between the Provider and the Customer should be objective and should be limited to what is necessary for the execution of the service.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Any complaints from the customer to the Provider shall be sought to be answered by the Provider directly and objectively. <\\/font><font style=\\\"vertical-align: inherit;\\\">If the complaint case is not resolved within a reasonable time, the Offeror is obliged to notify GoToConsult of the complaint case.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">contract conditions<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the contractual conditions<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is a mediation service between the Provider and the User, which also facilitates the setting of contract terms, execution and payment for the service. <\\/font><font style=\\\"vertical-align: inherit;\\\">However, GoToConsult is not part of the agreement between the Provider and the User and has no responsibility for any relationship arising in the agreement between them.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Provider accepts Customer\'s right and obligation to pay Provider for services rendered with release to GoToConsults Account.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">The tenderer even sets his own minute price, which, plus any applicable VAT, is set off against the customer\'s paid amount.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">For payment of a share of the balance sheet, the offeror is obliged to issue an invoice with the addition of any taxable VAT.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is entitled to a proportionate share of the price of its Services, as specified in the following price matrix (LINK TO PRICE MATRIX). <\\/font><font style=\\\"vertical-align: inherit;\\\">The price matrix is \\u200b\\u200bcalculated based on the cost price plus the profit margin of XX per cent.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment appears as a defined percentage of the accumulated balance and is settled before payment of the balance.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Defaults<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Suspected breach of these Terms or any violation of Norwegian law will result in the closure or freezing of the Provider\'s profile. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult will, by closing or freezing the Provider\'s profile, to the best of its ability, seek to disburse the net balance, after settlement as mentioned in section 3.2, but in any case can not be held liable if this is not done.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult reserves the right to withhold a portion of the net balance in the event of a dispute between the Provider and the Customer relating to services rendered until the dispute is resolved or the parties agree otherwise. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult is not responsible for the direct or indirect loss Provider or others may suffer as a result of this.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Furthermore, GoToConsult is not responsible for the loss responsible for direct or indirect losses that the Offeror or others may suffer as a result of closing or freezing the Offeror profile.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">If the terms are found to be invalid, the relevant provision shall be adapted, including limited or eliminated, so that the invalidity does not extend beyond the grounds of invalidity.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Norwegian law is used as background law.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Oslo District Court is the venue for any disputes.<\\/font><\\/p>\",\"no\":\"<h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om nettstedet med dets vilk\\u00e5r<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Nettstedet, www.gotoconsult.com, (\\u00abNettstedet\\u00bb) eies fullt ut av Teletjenesten AS (heretter omtalt som \\u00abGoToConsult\\u00bb), org.nr. 921&nbsp;757&nbsp;468.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Ved registrert bruker aksepterer Tilbyder og kunde \\u00e5 v\\u00e6re bundet av Teletjenestens til enhver tid gjeldende vilk\\u00e5r. Vesentlig endring av vilk\\u00e5r vil bli varslet av GoToConsult til Tilbyders eller kundes registrerte epostadresse og inntrer f\\u00f8rst 30 dager etter sendt varsel.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">N\\u00e6rmere om kravene til tilbyder<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Minstekrav for opprettelse av brukerprofil som tilbyder<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">For opprettelse av profil kreves at tilbyder er selvstendig n\\u00e6ringsdrivende, enten ved \\u00e5 utgj\\u00f8re et AS, enkeltpersonforetak el. Foretaket m\\u00e5 oppfylle lovp\\u00e5lagte krav som gjelder virksomheten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For \\u00e5 tilby tjenester som krever autorisasjon, kreves dokumentasjon p\\u00e5 at vedkommende tjenestetilbyder, samt personer som opptrer p\\u00e5 vegne av Tilbyder, er autorisert for dette.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til tilbyders profil<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil skal beskrive og eventuelle andre bilder enn profilbilder skal vise tjenesten som tilbys. Av Brukerprofilen skal betalingsvilk\\u00e5r, herunder priser, for tjenesten fremkomme klart og tydelig. Det skal ogs\\u00e5 fremkomme om det p\\u00e5l\\u00f8per moms for tjenesten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Profilen skal beskrive relevante og riktige opplysninger om den tjenesten som tilbys. Profil som anses som villedende i strid med ufravikelig lovgivning eller som kan oppfattes som st\\u00f8tende, er ikke tillatt. Det er ikke tillatt \\u00e5 kopiere tekst eller bilder p\\u00e5 slikt vis at det er i strid med rettighetshavers immaterielle rettigheter eller andre rettigheter etter loven. Bilder av enkeltperson som kan knyttes til enkeltperson kan kun nyttes dersom eksplisitt samtykke fra vedkommende er innhentet.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil som er i strid med kravene som beskrevet over vil bli fjernet dersom forholdene ikke rettes oppi innen 7 dags varsel fra GoToConsult. GoToConsult har under enhver omstendighet tilgang til tilbyders profil og kan redigere innhold som alternativ til varsling og \\/ eller fjerning av brukerprofil som nevnt foran.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til kommunikasjon mellom tilbyder og kunde<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Kommunikasjon mellom Tilbyder og Kunde skal v\\u00e6re saklig og b\\u00f8r begrense til det som er n\\u00f8dvendig for tjenestens gjennomf\\u00f8ring.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Eventuelle reklamasjoner fra kunde til Tilbyder skal s\\u00f8kes besvart av Tilbyder direkte og p\\u00e5 saklig vis. Dersom reklamasjonssaken ikke l\\u00f8ses innen rimelig tid plikter Tilbyder \\u00e5 varsle GoToConsult om reklamasjonssaken.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Kontraktsforholdene<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om kontraktsforholdene<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er en formidlingstjeneste mellom Tilbyder og Bruker som ogs\\u00e5 tilrettelegger for angivelse av avtalevilk\\u00e5r, gjennomf\\u00f8ring og betaling for tjenesten. GoToConsult er imidlertid ikke en del av avtalen mellom Tilbyder og Bruker og har intet ansvar for eventuelle forholdet som oppst\\u00e5r i avtaleforhold dem imellom.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Tilbyders krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder aksepterer Kundes rett og plikt til \\u00e5 betale Tilbyder for utf\\u00f8rte tjenester med frigj\\u00f8rende virkning til konto hos GoToConsults.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder fastsetter selv egen minuttpris som, tillagt eventuell pliktig mva, avregnes mot kundens innbetalte bel\\u00f8p.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For utbetaling av andel av balansen plikter tilbyder \\u00e5 utstede faktura med tillegg av eventuell pliktig mva.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">GoToConsults krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult har krav p\\u00e5 forholdsmessig andel av pris for sine Tjenester, som n\\u00e6rmere angitt i f\\u00f8lgende prismatrise (LINK TIL PRISMATRISE). Prismatrisen regnes ut fra kostpris tillagt fortjenestemargin p\\u00e5 XX prosent.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsults krav p\\u00e5 betaling fremkommer som definert andel av opparbeidet balanse og avregnes f\\u00f8r utbetaling av balansen.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Mislighold<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Ved mistanke om mislighold av disse vilk\\u00e5rene eller brudd p\\u00e5 norsk lov vil medf\\u00f8re stengning eller frysing av Tilbyders profil. GoToConsult vil ved stengning eller frysing av Tilbyders profil, etter beste evne, s\\u00f8ke \\u00e5 utbetaling av nettobalanse, etter avregning som nevnt i pkt. 3.2, men kan under enhver omstendighet ikke bli holdt ansvarlig dersom dette ikke blir utf\\u00f8rt.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult forbeholder seg retten til \\u00e5 tilbakeholde andel nettobalanse ved tvist mellom Tilbyder og Kunde knyttet til utf\\u00f8rte tjenester inntil tvisten er avklart eller partene er enige om annet. GoToConsult er ikke ansvarlig for det direkte eller indirekte tapet Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av dette.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er heller ikke ansvarlig for det tap ansvarlig for direkte eller indirekte tap som Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av stengning eller frysing av Tilbyder profil.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Dersom vilk\\u00e5rsbestemmelser blir funnet ugyldig, skal den aktuelle bestemmelsen tilpasses, herunder begrenses eller elimineres, slik at ugyldigheten ikke strekker seg lenger enn ugyldighetsgrunnen tilsier.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Som bakgrunnsrett benyttes norsk rett.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Oslo tingrett er verneting for eventuelle tvister.<\\/p>\"}}', 'GoToConsult - Terms of Customers', 'Terms of Service Page', '2019-10-12 22:37:19', '2020-09-23 00:57:42');
INSERT INTO `pages` (`id`, `page_name`, `page_url`, `page_body`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(6, 'Privacy Policy', 'privacy', '{\"header\":{\"path\":\"\\/images\\/document-icon.svg\",\"en_des\":\"Here you will find an overview of our terms and conditions when you use our services at Teletjenesten.no If you have any questions, you can always contact us by filling out the contact form\",\"no_des\":\"V\\u00e5re retningslinjer for personvern er aktiv under GDPR. Personopplysninger oppbevares trygt hos oss, og vi tar dens beskyttelse p\\u00e5 alvor.\",\"en_title\":\"Privacy Policy\",\"no_title\":\"Personvernerkl\\u00e6ring\"},\"contents\":{\"en\":\"<h2 style=\\\"margin-bottom: 2px; color:#000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the site with its terms<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The Website, www.gotoconsult.com, (the \\\"Website\\\") is wholly owned by Teletjenesten AS (hereinafter referred to as \\\"GoToConsult\\\"), org.no. <\\/font><font style=\\\"vertical-align: inherit;\\\">921 757 468.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">By registered user, Provider and Customer agree to be bound by the Telecommunications Service\'s current terms and conditions at all times. <\\/font><font style=\\\"vertical-align: inherit;\\\">Significant change of terms will be notified by GoToConsult to the Provider\'s or Customer\'s registered email address and will not occur until 30 days after sent notice.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">More about the requirements for offers<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Minimum Requirements for Creating User Profile as Provider<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">In order to create a profile, the provider is required to be self-employed, either by constituting an AS, individual enterprises or the like. <\\/font><font style=\\\"vertical-align: inherit;\\\">The company must comply with statutory requirements that apply to the business.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">To provide services that require authorization, documentation is required that the relevant service provider, as well as persons acting on behalf of the Provider, are authorized to do so.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider profile requirements<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile should describe and any photos other than profile pictures should show the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">From the User Profile, payment terms, including prices, for the service must be clear and clear. <\\/font><font style=\\\"vertical-align: inherit;\\\">It will also be stated if VAT is incurred for the service.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The profile should describe relevant and correct information about the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">A profile that is considered misleading in violation of mandatory legislation or which may be considered offensive is not permitted. <\\/font><font style=\\\"vertical-align: inherit;\\\">It is not allowed to copy text or images in such a way that it violates the intellectual property rights of the licensee or other rights under the law. <\\/font><font style=\\\"vertical-align: inherit;\\\">Pictures of an individual that can be linked to an individual can only be used if explicit consent from the person is obtained.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile that violates the requirements described above will be removed if conditions are not rectified within 7 days notice from GoToConsult. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult has access to the provider profile under any circumstances and can edit content as an alternative to notification and \\/ or removal of user profile as mentioned above.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Requirements for communication between provider and customer<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Communication between the Provider and the Customer should be objective and should be limited to what is necessary for the execution of the service.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Any complaints from the customer to the Provider shall be sought to be answered by the Provider directly and objectively. <\\/font><font style=\\\"vertical-align: inherit;\\\">If the complaint case is not resolved within a reasonable time, the Offeror is obliged to notify GoToConsult of the complaint case.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">contract conditions<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the contractual conditions<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is a mediation service between the Provider and the User, which also facilitates the setting of contract terms, execution and payment for the service. <\\/font><font style=\\\"vertical-align: inherit;\\\">However, GoToConsult is not part of the agreement between the Provider and the User and has no responsibility for any relationship arising in the agreement between them.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Provider accepts Customer\'s right and obligation to pay Provider for services rendered with release to GoToConsults Account.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">The tenderer even sets his own minute price, which, plus any applicable VAT, is set off against the customer\'s paid amount.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">For payment of a share of the balance sheet, the offeror is obliged to issue an invoice with the addition of any taxable VAT.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is entitled to a proportionate share of the price of its Services, as specified in the following price matrix (LINK TO PRICE MATRIX). <\\/font><font style=\\\"vertical-align: inherit;\\\">The price matrix is \\u200b\\u200bcalculated based on the cost price plus the profit margin of XX per cent.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment appears as a defined percentage of the accumulated balance and is settled before payment of the balance.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Defaults<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Suspected breach of these Terms or any violation of Norwegian law will result in the closure or freezing of the Provider\'s profile. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult will, by closing or freezing the Provider\'s profile, to the best of its ability, seek to disburse the net balance, after settlement as mentioned in section 3.2, but in any case can not be held liable if this is not done.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult reserves the right to withhold a portion of the net balance in the event of a dispute between the Provider and the Customer relating to services rendered until the dispute is resolved or the parties agree otherwise. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult is not responsible for the direct or indirect loss Provider or others may suffer as a result of this.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Furthermore, GoToConsult is not responsible for the loss responsible for direct or indirect losses that the Offeror or others may suffer as a result of closing or freezing the Offeror profile.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">If the terms are found to be invalid, the relevant provision shall be adapted, including limited or eliminated, so that the invalidity does not extend beyond the grounds of invalidity.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Norwegian law is used as background law.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Oslo District Court is the venue for any disputes.<\\/font><\\/p>\",\"no\":\"<h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om nettstedet med dets vilk\\u00e5r<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Nettstedet, www.gotoconsult.com, (\\u00abNettstedet\\u00bb) eies fullt ut av Teletjenesten AS (heretter omtalt som \\u00abGoToConsult\\u00bb), org.nr. 921&nbsp;757&nbsp;468.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Ved registrert bruker aksepterer Tilbyder og kunde \\u00e5 v\\u00e6re bundet av Teletjenestens til enhver tid gjeldende vilk\\u00e5r. Vesentlig endring av vilk\\u00e5r vil bli varslet av GoToConsult til Tilbyders eller kundes registrerte epostadresse og inntrer f\\u00f8rst 30 dager etter sendt varsel.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">N\\u00e6rmere om kravene til tilbyder<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Minstekrav for opprettelse av brukerprofil som tilbyder<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">For opprettelse av profil kreves at tilbyder er selvstendig n\\u00e6ringsdrivende, enten ved \\u00e5 utgj\\u00f8re et AS, enkeltpersonforetak el. Foretaket m\\u00e5 oppfylle lovp\\u00e5lagte krav som gjelder virksomheten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For \\u00e5 tilby tjenester som krever autorisasjon, kreves dokumentasjon p\\u00e5 at vedkommende tjenestetilbyder, samt personer som opptrer p\\u00e5 vegne av Tilbyder, er autorisert for dette.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til tilbyders profil<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil skal beskrive og eventuelle andre bilder enn profilbilder skal vise tjenesten som tilbys. Av Brukerprofilen skal betalingsvilk\\u00e5r, herunder priser, for tjenesten fremkomme klart og tydelig. Det skal ogs\\u00e5 fremkomme om det p\\u00e5l\\u00f8per moms for tjenesten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Profilen skal beskrive relevante og riktige opplysninger om den tjenesten som tilbys. Profil som anses som villedende i strid med ufravikelig lovgivning eller som kan oppfattes som st\\u00f8tende, er ikke tillatt. Det er ikke tillatt \\u00e5 kopiere tekst eller bilder p\\u00e5 slikt vis at det er i strid med rettighetshavers immaterielle rettigheter eller andre rettigheter etter loven. Bilder av enkeltperson som kan knyttes til enkeltperson kan kun nyttes dersom eksplisitt samtykke fra vedkommende er innhentet.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil som er i strid med kravene som beskrevet over vil bli fjernet dersom forholdene ikke rettes oppi innen 7 dags varsel fra GoToConsult. GoToConsult har under enhver omstendighet tilgang til tilbyders profil og kan redigere innhold som alternativ til varsling og \\/ eller fjerning av brukerprofil som nevnt foran.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til kommunikasjon mellom tilbyder og kunde<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Kommunikasjon mellom Tilbyder og Kunde skal v\\u00e6re saklig og b\\u00f8r begrense til det som er n\\u00f8dvendig for tjenestens gjennomf\\u00f8ring.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Eventuelle reklamasjoner fra kunde til Tilbyder skal s\\u00f8kes besvart av Tilbyder direkte og p\\u00e5 saklig vis. Dersom reklamasjonssaken ikke l\\u00f8ses innen rimelig tid plikter Tilbyder \\u00e5 varsle GoToConsult om reklamasjonssaken.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Kontraktsforholdene<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om kontraktsforholdene<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er en formidlingstjeneste mellom Tilbyder og Bruker som ogs\\u00e5 tilrettelegger for angivelse av avtalevilk\\u00e5r, gjennomf\\u00f8ring og betaling for tjenesten. GoToConsult er imidlertid ikke en del av avtalen mellom Tilbyder og Bruker og har intet ansvar for eventuelle forholdet som oppst\\u00e5r i avtaleforhold dem imellom.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Tilbyders krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder aksepterer Kundes rett og plikt til \\u00e5 betale Tilbyder for utf\\u00f8rte tjenester med frigj\\u00f8rende virkning til konto hos GoToConsults.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder fastsetter selv egen minuttpris som, tillagt eventuell pliktig mva, avregnes mot kundens innbetalte bel\\u00f8p.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For utbetaling av andel av balansen plikter tilbyder \\u00e5 utstede faktura med tillegg av eventuell pliktig mva.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">GoToConsults krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult har krav p\\u00e5 forholdsmessig andel av pris for sine Tjenester, som n\\u00e6rmere angitt i f\\u00f8lgende prismatrise (LINK TIL PRISMATRISE). Prismatrisen regnes ut fra kostpris tillagt fortjenestemargin p\\u00e5 XX prosent.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsults krav p\\u00e5 betaling fremkommer som definert andel av opparbeidet balanse og avregnes f\\u00f8r utbetaling av balansen.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Mislighold<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Ved mistanke om mislighold av disse vilk\\u00e5rene eller brudd p\\u00e5 norsk lov vil medf\\u00f8re stengning eller frysing av Tilbyders profil. GoToConsult vil ved stengning eller frysing av Tilbyders profil, etter beste evne, s\\u00f8ke \\u00e5 utbetaling av nettobalanse, etter avregning som nevnt i pkt. 3.2, men kan under enhver omstendighet ikke bli holdt ansvarlig dersom dette ikke blir utf\\u00f8rt.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult forbeholder seg retten til \\u00e5 tilbakeholde andel nettobalanse ved tvist mellom Tilbyder og Kunde knyttet til utf\\u00f8rte tjenester inntil tvisten er avklart eller partene er enige om annet. GoToConsult er ikke ansvarlig for det direkte eller indirekte tapet Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av dette.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er heller ikke ansvarlig for det tap ansvarlig for direkte eller indirekte tap som Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av stengning eller frysing av Tilbyder profil.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Dersom vilk\\u00e5rsbestemmelser blir funnet ugyldig, skal den aktuelle bestemmelsen tilpasses, herunder begrenses eller elimineres, slik at ugyldigheten ikke strekker seg lenger enn ugyldighetsgrunnen tilsier.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Som bakgrunnsrett benyttes norsk rett.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Oslo tingrett er verneting for eventuelle tvister.<\\/p>\"}}', 'GoToConsult - Privacy & Policy', 'Privacy & Policy Page', '2019-10-12 22:37:35', '2020-09-23 00:57:52'),
(7, 'Login', 'login', '{\"header\":{\"path\":\"\\/images\\/logo-.png\",\"en_des\":\"with your GotoConsult account\",\"no_des\":\"med GoToConsult-kontoen din\",\"en_title\":\"Login\",\"no_title\":\"Logg Inn\"}}', 'GoToConsult - Login', 'Login Page', '2019-10-12 22:38:15', '2020-09-30 16:10:40'),
(8, 'Register', 'register', '{\"header\":{\"en_des\":\"with GotoConsult today\",\"no_des\":\"med GotoConsult i dag\",\"en_title\":\"Sign Up\",\"no_title\":\"Melde deg p\\u00e5\"},\"list\":[{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/GS4KzMNfYM1yQBCEYER40w2gKGC5cVNIDfdPHsz9.svg\",\"en_title\":\"Start chat\",\"no_title\":\"Start Chat\",\"en_txt\":\"Communication is in writing, and one has the time to absorb and process the information.\",\"no_txt\":\"Kommunikasjon er skriftlig, og man har tid til \\u00e5 absorbere og behandle informasjonen.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/rhpNWWYSVURIOf5QxEVqTdcDeY1bUlS36V8ovuuc.svg\",\"en_title\":\"Start Call\",\"no_title\":\"Ringe\",\"en_txt\":\"Make a call with an online consultant via the web browser and talk it out.\",\"no_txt\":\"Ring en nettkonsulent via nettleseren og snakk det ut.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/pnL5U9Gse4XTvm5ugFRVj0zOaeZZ0qCnuiTs7bJx.svg\",\"en_title\":\"Start Video Call\",\"no_title\":\"Start video samtale\",\"en_txt\":\"A video call gives it that extra edge of focus, attention, presence, and personality.\",\"no_txt\":\"En videosamtale gir den den ekstra lille f\\u00f8lelsen av fokus, oppmerksomhet, tilstedev\\u00e6relse og personlighet.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/2504k6ITJ2K1oWdwnx93j22CFamRTzP3cZXx2mgp.svg\",\"en_title\":\"My Wallet\",\"no_title\":\"Min lommebok\",\"en_txt\":\"Purchase credits for spending, and keep track of the account balance.\",\"no_txt\":\"Kj\\u00f8p kreditt for \\u00e5 bruke og ha oversikt over kontosaldo.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/T2VOZyh3rB4tBUCa0au6CKCX5qySBXS8wme9YXfb.svg\",\"en_title\":\"My Transactions\",\"no_title\":\"Min transaksjoner\",\"en_txt\":\"Access spending history.\",\"no_txt\":\"F\\u00e5 tilgang til utgifter og ha oversikt over historikk.\"},{\"path\":\"\\/assets\\/uploads\\/become_consultant\\/54IxBFIkfvyv4NRDe3YjxcSmiyv9YXi54DrqkIhy.svg\",\"en_title\":\"Account Control\",\"no_title\":\"Kontokontroll\",\"en_txt\":\"Set up an account, stay in charge of it, and maintain a personalized profile.\",\"no_txt\":\"Sett opp en konto, ha ansvaret for den og oppretthold en personlig profil.\"}]}', 'GoToConsult - Register', 'Register Page', '2019-10-12 22:38:47', '2020-09-30 16:10:50'),
(9, 'Terms for Consultant', 'terms_consultant', '{\"header\":{\"path\":\"\\/images\\/document-icon.svg\",\"en_des\":\"Here you will find an overview of our terms and conditions when you use our services at Teletjenesten.no If you have any questions, you can always contact us by filling out the contact form\",\"no_des\":\"Dette er standard avtalevilk\\u00e5r for konsulenter. V\\u00e6r s\\u00e5 vennlig \\u00e5 les og godta, f\\u00f8r du bruker tjenestene v\\u00e5re.\",\"en_title\":\"Terms of Service for Consultant\",\"no_title\":\"Vilk\\u00e5r for konsulent\",\"link\":null},\"contents\":{\"en\":\"<h2 style=\\\"margin-bottom: 2px; color:#000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the site with its terms<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The Website, www.gotoconsult.com, (the \\\"Website\\\") is wholly owned by Teletjenesten AS (hereinafter referred to as \\\"GoToConsult\\\"), org.no. <\\/font><font style=\\\"vertical-align: inherit;\\\">921 757 468.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">By registered user, Provider and Customer agree to be bound by the Telecommunications Service\'s current terms and conditions at all times. <\\/font><font style=\\\"vertical-align: inherit;\\\">Significant change of terms will be notified by GoToConsult to the Provider\'s or Customer\'s registered email address and will not occur until 30 days after sent notice.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">More about the requirements for offers<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Minimum Requirements for Creating User Profile as Provider<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">In order to create a profile, the provider is required to be self-employed, either by constituting an AS, individual enterprises or the like. <\\/font><font style=\\\"vertical-align: inherit;\\\">The company must comply with statutory requirements that apply to the business.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">To provide services that require authorization, documentation is required that the relevant service provider, as well as persons acting on behalf of the Provider, are authorized to do so.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider profile requirements<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile should describe and any photos other than profile pictures should show the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">From the User Profile, payment terms, including prices, for the service must be clear and clear. <\\/font><font style=\\\"vertical-align: inherit;\\\">It will also be stated if VAT is incurred for the service.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">The profile should describe relevant and correct information about the service offered. <\\/font><font style=\\\"vertical-align: inherit;\\\">A profile that is considered misleading in violation of mandatory legislation or which may be considered offensive is not permitted. <\\/font><font style=\\\"vertical-align: inherit;\\\">It is not allowed to copy text or images in such a way that it violates the intellectual property rights of the licensee or other rights under the law. <\\/font><font style=\\\"vertical-align: inherit;\\\">Pictures of an individual that can be linked to an individual can only be used if explicit consent from the person is obtained.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">User profile that violates the requirements described above will be removed if conditions are not rectified within 7 days notice from GoToConsult. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult has access to the provider profile under any circumstances and can edit content as an alternative to notification and \\/ or removal of user profile as mentioned above.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Requirements for communication between provider and customer<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Communication between the Provider and the Customer should be objective and should be limited to what is necessary for the execution of the service.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Any complaints from the customer to the Provider shall be sought to be answered by the Provider directly and objectively. <\\/font><font style=\\\"vertical-align: inherit;\\\">If the complaint case is not resolved within a reasonable time, the Offeror is obliged to notify GoToConsult of the complaint case.<\\/font><\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">contract conditions<\\/font><\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally about the contractual conditions<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is a mediation service between the Provider and the User, which also facilitates the setting of contract terms, execution and payment for the service. <\\/font><font style=\\\"vertical-align: inherit;\\\">However, GoToConsult is not part of the agreement between the Provider and the User and has no responsibility for any relationship arising in the agreement between them.<\\/font><\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">Provider\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Provider accepts Customer\'s right and obligation to pay Provider for services rendered with release to GoToConsults Account.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">The tenderer even sets his own minute price, which, plus any applicable VAT, is set off against the customer\'s paid amount.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">For payment of a share of the balance sheet, the offeror is obliged to issue an invoice with the addition of any taxable VAT.<\\/font><\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment<\\/font><\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult is entitled to a proportionate share of the price of its Services, as specified in the following price matrix (LINK TO PRICE MATRIX). <\\/font><font style=\\\"vertical-align: inherit;\\\">The price matrix is \\u200b\\u200bcalculated based on the cost price plus the profit margin of XX per cent.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult\'s claim for payment appears as a defined percentage of the accumulated balance and is settled before payment of the balance.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Defaults<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">Suspected breach of these Terms or any violation of Norwegian law will result in the closure or freezing of the Provider\'s profile. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult will, by closing or freezing the Provider\'s profile, to the best of its ability, seek to disburse the net balance, after settlement as mentioned in section 3.2, but in any case can not be held liable if this is not done.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\"><font style=\\\"vertical-align: inherit;\\\">GoToConsult reserves the right to withhold a portion of the net balance in the event of a dispute between the Provider and the Customer relating to services rendered until the dispute is resolved or the parties agree otherwise. <\\/font><font style=\\\"vertical-align: inherit;\\\">GoToConsult is not responsible for the direct or indirect loss Provider or others may suffer as a result of this.<\\/font><\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Furthermore, GoToConsult is not responsible for the loss responsible for direct or indirect losses that the Offeror or others may suffer as a result of closing or freezing the Offeror profile.<\\/font><\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\"><font style=\\\"vertical-align: inherit;\\\">Generally<\\/font><\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">If the terms are found to be invalid, the relevant provision shall be adapted, including limited or eliminated, so that the invalidity does not extend beyond the grounds of invalidity.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Norwegian law is used as background law.<\\/font><\\/p><p style=\\\"color: rgb(33, 37, 41);\\\"><font style=\\\"vertical-align: inherit;\\\">Oslo District Court is the venue for any disputes.<\\/font><\\/p>\",\"no\":\"<h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om nettstedet med dets vilk\\u00e5r<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Nettstedet, www.gotoconsult.com, (\\u00abNettstedet\\u00bb) eies fullt ut av Teletjenesten AS (heretter omtalt som \\u00abGoToConsult\\u00bb), org.nr. 921&nbsp;757&nbsp;468.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Ved registrert bruker aksepterer Tilbyder og kunde \\u00e5 v\\u00e6re bundet av Teletjenestens til enhver tid gjeldende vilk\\u00e5r. Vesentlig endring av vilk\\u00e5r vil bli varslet av GoToConsult til Tilbyders eller kundes registrerte epostadresse og inntrer f\\u00f8rst 30 dager etter sendt varsel.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">N\\u00e6rmere om kravene til tilbyder<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Minstekrav for opprettelse av brukerprofil som tilbyder<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">For opprettelse av profil kreves at tilbyder er selvstendig n\\u00e6ringsdrivende, enten ved \\u00e5 utgj\\u00f8re et AS, enkeltpersonforetak el. Foretaket m\\u00e5 oppfylle lovp\\u00e5lagte krav som gjelder virksomheten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For \\u00e5 tilby tjenester som krever autorisasjon, kreves dokumentasjon p\\u00e5 at vedkommende tjenestetilbyder, samt personer som opptrer p\\u00e5 vegne av Tilbyder, er autorisert for dette.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til tilbyders profil<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil skal beskrive og eventuelle andre bilder enn profilbilder skal vise tjenesten som tilbys. Av Brukerprofilen skal betalingsvilk\\u00e5r, herunder priser, for tjenesten fremkomme klart og tydelig. Det skal ogs\\u00e5 fremkomme om det p\\u00e5l\\u00f8per moms for tjenesten.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Profilen skal beskrive relevante og riktige opplysninger om den tjenesten som tilbys. Profil som anses som villedende i strid med ufravikelig lovgivning eller som kan oppfattes som st\\u00f8tende, er ikke tillatt. Det er ikke tillatt \\u00e5 kopiere tekst eller bilder p\\u00e5 slikt vis at det er i strid med rettighetshavers immaterielle rettigheter eller andre rettigheter etter loven. Bilder av enkeltperson som kan knyttes til enkeltperson kan kun nyttes dersom eksplisitt samtykke fra vedkommende er innhentet.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Brukerprofil som er i strid med kravene som beskrevet over vil bli fjernet dersom forholdene ikke rettes oppi innen 7 dags varsel fra GoToConsult. GoToConsult har under enhver omstendighet tilgang til tilbyders profil og kan redigere innhold som alternativ til varsling og \\/ eller fjerning av brukerprofil som nevnt foran.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Krav til kommunikasjon mellom tilbyder og kunde<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Kommunikasjon mellom Tilbyder og Kunde skal v\\u00e6re saklig og b\\u00f8r begrense til det som er n\\u00f8dvendig for tjenestens gjennomf\\u00f8ring.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Eventuelle reklamasjoner fra kunde til Tilbyder skal s\\u00f8kes besvart av Tilbyder direkte og p\\u00e5 saklig vis. Dersom reklamasjonssaken ikke l\\u00f8ses innen rimelig tid plikter Tilbyder \\u00e5 varsle GoToConsult om reklamasjonssaken.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Kontraktsforholdene<\\/h2><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Generelt om kontraktsforholdene<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er en formidlingstjeneste mellom Tilbyder og Bruker som ogs\\u00e5 tilrettelegger for angivelse av avtalevilk\\u00e5r, gjennomf\\u00f8ring og betaling for tjenesten. GoToConsult er imidlertid ikke en del av avtalen mellom Tilbyder og Bruker og har intet ansvar for eventuelle forholdet som oppst\\u00e5r i avtaleforhold dem imellom.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">Tilbyders krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder aksepterer Kundes rett og plikt til \\u00e5 betale Tilbyder for utf\\u00f8rte tjenester med frigj\\u00f8rende virkning til konto hos GoToConsults.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Tilbyder fastsetter selv egen minuttpris som, tillagt eventuell pliktig mva, avregnes mot kundens innbetalte bel\\u00f8p.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">For utbetaling av andel av balansen plikter tilbyder \\u00e5 utstede faktura med tillegg av eventuell pliktig mva.<\\/p><h3 style=\\\"font-family: &quot;Gotham Medium&quot;; color: #000; font-size: 18px;\\\">GoToConsults krav p\\u00e5 betaling<\\/h3><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult har krav p\\u00e5 forholdsmessig andel av pris for sine Tjenester, som n\\u00e6rmere angitt i f\\u00f8lgende prismatrise (LINK TIL PRISMATRISE). Prismatrisen regnes ut fra kostpris tillagt fortjenestemargin p\\u00e5 XX prosent.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsults krav p\\u00e5 betaling fremkommer som definert andel av opparbeidet balanse og avregnes f\\u00f8r utbetaling av balansen.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Mislighold<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Ved mistanke om mislighold av disse vilk\\u00e5rene eller brudd p\\u00e5 norsk lov vil medf\\u00f8re stengning eller frysing av Tilbyders profil. GoToConsult vil ved stengning eller frysing av Tilbyders profil, etter beste evne, s\\u00f8ke \\u00e5 utbetaling av nettobalanse, etter avregning som nevnt i pkt. 3.2, men kan under enhver omstendighet ikke bli holdt ansvarlig dersom dette ikke blir utf\\u00f8rt.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult forbeholder seg retten til \\u00e5 tilbakeholde andel nettobalanse ved tvist mellom Tilbyder og Kunde knyttet til utf\\u00f8rte tjenester inntil tvisten er avklart eller partene er enige om annet. GoToConsult er ikke ansvarlig for det direkte eller indirekte tapet Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av dette.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">GoToConsult er heller ikke ansvarlig for det tap ansvarlig for direkte eller indirekte tap som Tilbyder eller andre m\\u00e5tte lide som f\\u00f8lge av stengning eller frysing av Tilbyder profil.<\\/p><h2 style=\\\"margin-bottom: 2px; color: #000; font-size: 24px;\\\">Generelt<\\/h2><p style=\\\"color: rgb(33, 37, 41);\\\">Dersom vilk\\u00e5rsbestemmelser blir funnet ugyldig, skal den aktuelle bestemmelsen tilpasses, herunder begrenses eller elimineres, slik at ugyldigheten ikke strekker seg lenger enn ugyldighetsgrunnen tilsier.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Som bakgrunnsrett benyttes norsk rett.<\\/p><p style=\\\"color: rgb(33, 37, 41);\\\">Oslo tingrett er verneting for eventuelle tvister.<\\/p>\"}}', 'GoToConsult - Terms for Consultants', 'Terms of Service for Consultants Page', '2020-02-06 01:17:39', '2020-09-30 16:11:06'),
(10, 'Features', 'features', '{\"desktop_banner_img\":\"\\/assets\\/uploads\\/banner\\/efJHL3IUbxJPCRREycCJ2c3qnZqHdrYFF1ayasrb.png\",\"mobile_banner_img\":\"\\/images\\/features\\/features-banner-mobile.png\",\"en_header\":{\"title\":\"Platform Key Features\",\"description\":\"Our platform is custom-built. Chat, voice, video calls, and transactions between clients and online consultants are made secure, fast, and convenient.\",\"button_title1\":\"Sign up\",\"button_link1\":\"register\",\"button_title2\":\"Become a Consultant\",\"button_link2\":\"become-consultant\"},\"no_header\":{\"title\":\"Plattformens n\\u00f8kkelfunksjonalitet\",\"description\":\"V\\u00e5r plattform er spesialbygget. Chat, tale, video og transaksjoner mellom klienter og nettkonsulenter gj\\u00f8res trygt, raskt og praktisk.\",\"button_title1\":\"Melde deg p\\u00e5\",\"button_link1\":\"no\\/registrer\",\"button_title2\":\"Bli konsulent\",\"button_link2\":\"no\\/bli-konsulent\"},\"services\":{\"en_title\":\"Consultants and Services.\",\"no_title\":\"Konsulenter og tjenester.\",\"arr\":[{\"path\":\"images\\/consultant\\/psychologists-icon.svg\",\"en_title\":\"Psychologist\",\"no_title\":\"Psykolog\",\"en_des\":\"Our mind is an infinite space of memory and imagination. Connect with an online psychologist and explore it.\",\"no_des\":\"V\\u00e5rt sinn er et uendelig rom med minner og fantasi. Ta kontakt med en nett-psykolog og utforsk den.\"},{\"path\":\"images\\/consultant\\/economists-icon.svg\",\"en_title\":\"Economists\",\"no_title\":\"\\u00d8konom\",\"en_des\":\"A robust economy means stable living. Connect with one of our online economists and be guided towards the best foundation.\",\"no_des\":\"En robust personlig \\u00f8konomi betyr et stabilt liv. Ta kontakt med en av v\\u00e5re nett-\\u00f8konomer og bli veiledet mot det beste grunnlaget.\"},{\"path\":\"images\\/consultant\\/lawyers-icon.svg\",\"en_title\":\"Lawyer\",\"no_title\":\"Advokat\",\"en_des\":\"An ideal society is where people make laws for the benefit of the people. Connect and ask online lawyers about legal matters.\",\"no_des\":\"Et ideelt samfunn er der folk lager lover til fordel for folket. Koble til og sp\\u00f8r nett-advokater om juridiske forhold.\"},{\"path\":\"images\\/consultant\\/doctors-icon.svg\",\"en_title\":\"Doctor\",\"no_title\":\"Lege\",\"en_des\":\"Gain access to medical expertise within moments. Talk about health and related issues with an online doctor.\",\"no_des\":\"F\\u00e5 tilgang til medisinsk ekspertise innen f\\u00e5 \\u00f8yeblikk. Snakk om helse og relaterte problemer med en nettlege.\"},{\"path\":\"images\\/consultant\\/nurses-icon.svg\",\"en_title\":\"Nurse\",\"no_title\":\"Sykepleier\",\"en_des\":\"Connect with an online nurse and get practical healthcare-related support or acquire instant nursing abilities.\",\"no_des\":\"Ta kontakt med en online sykepleier og f\\u00e5 praktisk helsevesen st\\u00f8tte eller skaff deg \\u00f8yeblikkelig sykepleieevner.\"},{\"path\":\"images\\/consultant\\/veterinarian-icon.svg\",\"en_title\":\"Veterinarian\",\"no_title\":\"Veterin\\u00e6r\",\"en_des\":\"Speak with an online veterinarian about animal health within minutes, and get expert advice at any moment.\",\"no_des\":\"Snakk med en nettveterin\\u00e6r om dyrehelse i l\\u00f8pet av f\\u00e5 minutter, og f\\u00e5 ekspertr\\u00e5d n\\u00e5r som helst.\"},{\"path\":\"images\\/consultant\\/astrologers-icon.svg\",\"en_title\":\"Astrologer\",\"no_title\":\"Astrolog\",\"en_des\":\"Connect with an online astrologer to get personal energy readings and to talk about everything between heaven and earth.\",\"no_des\":\"Ta kontakt med en nett-astrolog for \\u00e5 f\\u00e5 personlig stjernetegn veiledning eller generelt for \\u00e5 snakke om alt og intet, mellom himmel og jord.\"},{\"path\":\"images\\/consultant\\/teachers-icon.svg\",\"en_title\":\"Teacher\",\"no_title\":\"L\\u00e6rer\",\"en_des\":\"Speak with an online teacher for guidance, to acquire new skills, or to solve practical issues. Good help is one connection away.\",\"no_des\":\"Snakk med en nettl\\u00e6rer for veiledning, for \\u00e5 tilegne deg nye ferdigheter eller for \\u00e5 l\\u00f8se praktiske problemer. God hjelp er et par klikk unna.\"}]},\"consultant\":{\"path\":\"images\\/features\\/showcase-1.png\",\"en_title\":\"Discover Consultants\",\"no_title\":\"Oppdag konsulenter\",\"en_des\":\"Imagine the power of having so much knowledge and expertise available within no time. Explore our database and discover specialists by country, rating, price, and more.\",\"no_des\":\"Se for deg kraften i \\u00e5 ha s\\u00e5 mye kunnskap og kompetanse tilgjengelig p\\u00e5 kort tid. Utforsk v\\u00e5r database og oppdag spesialister etter land, vurdering, pris og mer.\"},\"session\":{\"path\":\"images\\/features\\/showcase-2.png\",\"en_title\":\"My Sessions\",\"no_title\":\"Mine \\u00f8kter\",\"en_des\":\"Speak with a consultant before starting any session. Choose the estimated amount of time needed, and get started. Consultant and chat \\u2013 history is made available through My Sessions.\",\"no_des\":\"Snakk med en konsulent f\\u00f8r du starter en \\u00f8kt. Velg den estimerte tiden som trengs, og kom i gang. Konsulent og chat - historikk er alltid tilgjengelig gjennom Mine \\u00f8kter.\"},\"wallet\":{\"path\":\"images\\/features\\/showcase-3.png\",\"en_title\":\"My Wallet\",\"no_title\":\"Min lommebok\",\"en_des\":\"Use a credit card to purchase a positive balance for My Wallet. Use balance to start chat, call, or video sessions with professional, online consultants. Also, gain access to transaction history.\",\"no_des\":\"Bruk et kredittkort til \\u00e5 kj\\u00f8pe en positiv saldo for Min lommebok. Bruk saldo for \\u00e5 starte chat-, samtale- eller video\\u00f8kter med profesjonelle nettkonsulenter. F\\u00e5 ogs\\u00e5 tilgang til transaksjonshistorikk.\"},\"profile\":{\"path\":\"images\\/features\\/showcase-4.png\",\"en_title\":\"My Profile\",\"no_title\":\"Min profil\",\"en_des\":\"Create, maintain, and control the profile. As an end-user, set up a profile that expresses needs or promotes expertise. Add relevant information, so potential clients or consultants can get a good understanding before engaging.\",\"no_des\":\"Opprett, vedlikehold og kontroller profilen. Som sluttbruker, sett opp en profil som uttrykker behov eller fremmer kompetanse. Legg til relevant informasjon, slik at potensielle kunder eller konsulenter kan f\\u00e5 en god forst\\u00e5else f\\u00f8r de engasjerer.\"},\"transactions\":{\"en_title\":\"My Transactions\",\"no_title\":\"Min transaksjoner\",\"en_des\":\"Get a complete overview of your chat, call or video sessions with a customer or a consultant. Choose a desired budget for your session, and always keep track of your spendings and earnings.\",\"no_des\":\"F\\u00e5 en fullstendig oversikt over chat-, samtale- eller video\\u00f8kter med en kunde eller en konsulent. Velg \\u00f8nsket budsjett for \\u00f8kten, og hold alltid oversikt over dine utgifter og inntekter.\",\"path\":\"images\\/features\\/showcase-5.png\"},\"reviews\":{\"en_title\":\"Let our reviews influence in the best way.\",\"no_title\":\"La v\\u00e5re anmeldelser p\\u00e5virke deg i riktig retning.\"},\"transaction\":{\"path\":\"images\\/features\\/showcase-5.png\",\"en_title\":\"My Transactions\",\"no_title\":\"Min transaksjoner\",\"en_des\":\"Get a complete overview of your chat, call or video sessions with a customer or a consultant. Choose a desired budget for your session, and always keep track of your spendings and earnings.\",\"no_des\":\"Kunder og konsulenter kan f\\u00e5 tilgang til transaksjonshistorikk for \\u00e5 se utgifter eller inntekter. Appen v\\u00e5r holder oversikt over all viktig data som er relevant for brukeren.\"},\"footer\":{\"en_title\":\"Join the platform\",\"no_title\":\"Meld deg inn og bruk v\\u00e5r plattform.\",\"en_des\":\"Clients from all over the world can GotoConsult and connect with online consultants from various professions such as psychologists, doctors, lawyers, and more.<br><br>\\nWe made our application after extensive research, with the sole purpose of making it a secure platform for clients and online consultants to connect fast and easy to solve whatever issue.<br><br>  \\nSign up for free as a client or click on \\\"Become a Consultant\\\" to fill out required forms and start your online career with us.\",\"no_des\":\"Klienter fra hele verden kan GotoConsult og f\\u00e5 kontakt med nettkonsulenter fra forskjellige yrker som psykologer, leger, advokater og mer.<br><br>\\nVi skapte applikasjonen v\\u00e5r etter omfattende unders\\u00f8kelser, med det eneste form\\u00e5l \\u00e5 gj\\u00f8re det til en sikker plattform for kunder og nettkonsulenter \\u00e5 koble seg enkelt til, for \\u00e5 l\\u00f8se utfordringer. <br><br>\\nRegistrer deg gratis som klient eller klikk p\\u00e5 \\\"Bli konsulent\\\" for \\u00e5 fylle ut n\\u00f8dvendige skjemaer og starte din nettkarriere hos oss.\",\"en_btn_title1\":\"Sign up\",\"en_btn_link1\":\"register\",\"no_btn_title1\":\"Melde deg p\\u00e5\",\"no_btn_link1\":\"no\\/registrer\",\"en_btn_title2\":\"Become a Consultant\",\"en_btn_link2\":\"become-consultant\",\"no_btn_title2\":\"Bli konsulent\",\"no_btn_link2\":\"no\\/bli-konsulent\"}}', 'GoToConsult - Features', 'Features Page', '2020-05-21 12:29:31', '2020-12-10 18:17:11');
INSERT INTO `pages` (`id`, `page_name`, `page_url`, `page_body`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(63, 'Home', 'home', '{\"desktop_banner_img\":\"\\/assets\\/uploads\\/banner\\/3WHfzeL3AfRpk4tk7ROxeUjEwBFzjK8apdrMPHwH.png\",\"mobile_banner_img\":\"\\/images\\/home\\/home-banner-mobile.png\",\"en_header\":{\"title\":\"A world of consulting. Communicate by chat, call, or video.\",\"description\":\"Professional knowledge is available within moments. Welcome to the future. We provide clients and online consultants a platform to communicate directly and explore whatever that is on the mind.\",\"button_title1\":\"Sign up\",\"button_link1\":\"register\",\"button_title2\":\"Become a Consultant\",\"button_link2\":\"become-consultant\"},\"no_header\":{\"title\":\"En verden av r\\u00e5dgivning. Kommuniser via chat, samtale eller video.\",\"description\":\"Profesjonell kunnskap er tilgjengelig i l\\u00f8pet av \\u00f8yeblikk. Velkommen til fremtiden. Vi gir klienter og nettkonsulenter en plattform for \\u00e5 kommunisere direkte og utforske hva som er i tankene.\",\"button_title1\":\"Melde deg p\\u00e5\",\"button_link1\":\"no\\/registrer\",\"button_title2\":\"Bli konsulent\",\"button_link2\":\"no\\/bli-konsulent\"},\"help_list\":[{\"path\":\"\\/images\\/home\\/illustration-1.svg\",\"en_title\":\"Our biggest challenge is our greatest gift.\",\"no_title\":\"V\\u00e5r st\\u00f8rste utfordring er v\\u00e5r flotteste gave.\",\"en_des\":\"Life is a gift, and we all have a little room for some challenges. It makes us grow.  How we deal with challenges defines us and our world. Steadiness in coping with different obstacles comes from clarity, and sometimes, we may need help to clear the fog out. Use GotoConsult to connect with an online consultant to explore possibilities and be guided towards a solution.\",\"no_des\":\"Livet er en gave, og vi har alle litt rom for noen utfordringer. Det f\\u00e5r oss til \\u00e5 vokse. Hvordan vi takler utfordringer definerer oss og v\\u00e5r verden. St\\u00f8dighet til \\u00e5 takle forskjellige hindringer kommer fra klarhet, og noen ganger kan vi trenge hjelp til \\u00e5 lette p\\u00e5 t\\u00e5ken. Bruk GotoConsult for \\u00e5 f\\u00e5 kontakt med en nettkonsulent for \\u00e5 utforske muligheter og bli ledet mot en l\\u00f8sning.\"},{\"path\":\"\\/images\\/home\\/illustration-2.svg\",\"en_title\":\"Provide value, build trust, and earn an income.\",\"no_title\":\"Skap verdi, bygg tillit og f\\u00e5 en inntekt.\",\"en_des\":\"Share expertise as an online consultant, build trust, and earn an income. Set a price on the service, perform to a worldwide audience, and be independent. Our GotoConsult platform is an excellent tool for consultants wanting to work online from the comforts of their headquarter.\",\"no_des\":\"Del kompetanse som en nettkonsulent, bygg tillit og tjen penger. Sett en pris p\\u00e5 tjenesten, prester for et verdensomspennende publikum og v\\u00e6r uavhengig. GotoConsult-plattformen v\\u00e5r er et utmerket verkt\\u00f8y for konsulenter som \\u00f8nsker \\u00e5 jobbe p\\u00e5 nett fra hovedkvarterets komfort.\"},{\"path\":\"\\/images\\/home\\/illustration-3.svg\",\"en_title\":\"It is tailor-made for convenience.\",\"no_title\":\"Det er skreddersydd for enkelhets skyld.\",\"en_des\":\"Good advice is priceless. Consultation can lead us to doors and maybe even open it up for us. However, ultimately, we need to walk through it ourselves. Be safe in knowing that the support needed is just a few clicks away. The GotoConsult platform simplifies the process of connecting clients and online consultants.\",\"no_des\":\"Godt r\\u00e5d er uvurderlig. Konsultasjon kan f\\u00f8re oss til d\\u00f8ren og kanskje til og med \\u00e5pne den for oss. Men i bunn og grunn m\\u00e5 vi g\\u00e5 gjennom det selv. V\\u00e6r trygg p\\u00e5 at st\\u00f8tten som trengs er bare noen f\\u00e5 klikk unna. GotoConsult-plattformen forenkler prosessen med \\u00e5 koble klienter og nettkonsulenter.\"}],\"benefit_list\":{\"en_title\":\"Our platform is focused only on the essentials.\",\"no_title\":\"Plattformen v\\u00e5r er kun fokusert p\\u00e5 det vesentlige.\",\"arr\":[{\"path\":\"\\/images\\/home\\/chat-icon.svg\",\"en_title\":\"Start Chat\",\"no_title\":\"Start Chat\",\"en_des\":\"Instant messaging is a convenient way to engage. It is excellent for the introverted soul.\",\"no_des\":\"Direktemeldinger er en enkel m\\u00e5te \\u00e5 engasjere p\\u00e5. Passer utmerket for den innadvendte sjel.\"},{\"path\":\"\\/images\\/home\\/call-icon.svg\",\"en_title\":\"Start Call\",\"no_title\":\"Start samtale\",\"en_des\":\"Communicate through sound, tone, and speech. Have a natural conversation.\",\"no_des\":\"Kommuniser gjennom lyd, tone og tale. Ha en naturlig samtale.\"},{\"path\":\"\\/images\\/home\\/video-icon.svg\",\"en_title\":\"Start Video Call\",\"no_title\":\"Start videosamtale\",\"en_des\":\"Besides holograms, this is the closest we can get to be present, without being there.\",\"no_des\":\"Foruten hologrammer, er dette det n\\u00e6rmeste vi kan komme fysisk tilstedev\\u00e6relse, uten \\u00e5 v\\u00e6re der.\"},{\"path\":\"\\/images\\/home\\/wallet-icon.svg\",\"en_title\":\"My Wallet\",\"no_title\":\"Min lommebok\",\"en_des\":\"Not all wallets go in the pocket. Access the accounts balance through My Wallet.\",\"no_des\":\"Ikke alle lommeb\\u00f8ker g\\u00e5r i lommen. F\\u00e5 tilgang til kontosaldoen gjennom Min lommebok.\"},{\"path\":\"\\/images\\/home\\/transaction-icon.svg\",\"en_title\":\"My Transactions\",\"no_title\":\"Mine transaksjoner\",\"en_des\":\"Keep track. Access the history of spending as a client, or earnings as a consultant.\",\"no_des\":\"Hold oversikt. F\\u00e5 tilgang til utgifts-historikk som klient, eller inntekts-historikk som konsulent.\"},{\"path\":\"\\/images\\/home\\/account-icon.svg\",\"en_title\":\"Account Control\",\"no_title\":\"Kontokontroll\",\"en_des\":\"Signup for an account and receive full control over the profile. Everything is easy.\",\"no_des\":\"Registrer deg for en konto og f\\u00e5 full kontroll over profilen.\"}]},\"footer\":{\"en_title\":\"Join the platform\",\"no_title\":\"Meld deg inn og bruk v\\u00e5r plattform.\",\"en_des\":\"Clients from all over the world can GotoConsult and connect with online consultants from various professions such as psychologists, doctors, lawyers, and more.<br><br>\\nWe made our application after extensive research, with the sole purpose of making it a secure platform for clients and online consultants to connect fast and easy to solve whatever issue.<br><br>  \\nSign up for free as a client or click on \\\"Become a Consultant\\\" to fill out required forms and start your online career with us.\",\"no_des\":\"Klienter fra hele verden kan GotoConsult og f\\u00e5 kontakt med nettkonsulenter fra forskjellige yrker som psykologer, leger, advokater og mer.<br><br>\\nVi skapte applikasjonen v\\u00e5r etter omfattende unders\\u00f8kelser, med det eneste form\\u00e5l \\u00e5 gj\\u00f8re det til en sikker plattform for kunder og nettkonsulenter \\u00e5 koble seg enkelt til, for \\u00e5 l\\u00f8se utfordringer. <br><br>\\nRegistrer deg gratis som klient eller klikk p\\u00e5 \\\"Bli konsulent\\\" for \\u00e5 fylle ut n\\u00f8dvendige skjemaer og starte din nettkarriere hos oss.\",\"en_btn_title1\":\"Sign up\",\"en_btn_link1\":\"register\",\"no_btn_title1\":\"Melde deg p\\u00e5\",\"no_btn_link1\":\"no\\/registrer\",\"en_btn_title2\":\"Become a Consultant\",\"en_btn_link2\":\"become-consultant\",\"no_btn_title2\":\"Bli konsulent\",\"no_btn_link2\":\"no\\/bli-konsulent\"},\"reviews\":{\"en_title\":\"Let our reviews influence in the best way.\",\"no_title\":\"La v\\u00e5re anmeldelser p\\u00e5virke deg i riktig retning.\"}}', 'GoToConsult - Home', 'Home Page', '2019-04-08 15:10:03', '2022-03-31 09:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'kishore.sundaraiah@colanonline.com', '$2y$10$n0gvOazTEtpfy9wzPArhmeAGqB0UHLm2vSuyJdj3RmRPVHI8wsdZS', '2019-04-05 15:49:54'),
(2, 'mubarak@fantasylab.com', '$2y$10$x9S3Ajxhm7Ij0vUX2gIfYOuQDrfi3f2BiBNdY5U0r7DFiDVYyo/KS', '2019-04-05 16:22:06'),
(3, 'kishoresundar1992@gmail.com', '$2y$10$LrCHwX1RkGZaOIOj/xghq..pAwQXHbUcgqbGftHPKjR5fmNIA.f3S', '2019-04-05 16:52:36'),
(4, 'admin@gmail.com', '$2y$10$kVN94NMYyJwJEXMjpok//OjM/MlVpywctAhYpGbrpbLIzVS.2ACi.', '2019-04-22 07:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(191) NOT NULL,
  `category` varchar(191) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_FK_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `user_id`, `title`, `category`, `description`, `created_at`, `updated_at`) VALUES
(4, 51, 'English Learn', 'Language', 'English Learn', '2022-04-25 06:44:53', '2022-04-25 06:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `plan_sessions`
--

DROP TABLE IF EXISTS `plan_sessions`;
CREATE TABLE IF NOT EXISTS `plan_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_id` bigint NOT NULL,
  `title` varchar(191) NOT NULL,
  `duration` int NOT NULL DEFAULT '0',
  `currency_type` varchar(255) NOT NULL DEFAULT 'NOK',
  `price` double(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plan_sessions_FK_1` (`plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `plan_sessions`
--

INSERT INTO `plan_sessions` (`id`, `plan_id`, `title`, `duration`, `price`, `created_at`, `updated_at`) VALUES
(6, 4, 'Intro', 20,'NOK', 12.00, '2022-04-25 06:45:06', '2022-04-25 06:45:06'),
(7, 4, 'Test', 2, 'EUR', 0.00, '2022-04-25 06:45:17', '2022-04-25 06:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender` varchar(191) DEFAULT NULL,
  `birth` varchar(191) DEFAULT NULL,
  `street` varchar(191) DEFAULT NULL,
  `zip_code` varchar(191) DEFAULT NULL,
  `cover_img` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `skype` varchar(191) DEFAULT NULL,
  `profession` varchar(191) DEFAULT NULL,
  `college` varchar(191) DEFAULT NULL,
  `from` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `region` varchar(191) DEFAULT NULL,
  `gmt` varchar(191) DEFAULT NULL,
  `timezone` varchar(191) DEFAULT NULL,
  `timetable` text,
  `description` longtext,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `gender`, `birth`, `street`, `zip_code`, `cover_img`, `avatar`, `skype`, `profession`, `college`, `from`, `country`, `region`, `gmt`, `timezone`, `timetable`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, '/assets/uploads/member/dETDv3yWM29DAZKljAACYbcU94nqJ3dbAacEiJJr.jpg', '/assets/uploads/member/WFlCsIN5vtuBvxyK5BcPtLH0ILbsPZisuOS6soO3.jpg', NULL, NULL, NULL, 'Norway', 'Norway', 'Troms', '(GMT )', 'Universal', NULL, '<p>Jeg elsker psykologi</p>', '2022-02-14 08:27:36', '2022-02-14 00:27:36'),
(2, NULL, NULL, NULL, NULL, '/assets/uploads/member/ZxepSx13jMdl249wU5XNwfRrdlfyxDXKTIhZok91.jpeg', '/assets/uploads/member/MI5BOO3GzfcZ7HoA4WpwrP2T2iolSodTsqhuyI7A.jpeg', NULL, NULL, NULL, 'Norway', 'Norway', 'Oslo', '(GMT )', 'Africa/Algiers', NULL, '<p>Lorem ipsum dolor sit amet consectetur</p>', '2020-11-01 15:04:44', '2020-11-01 15:04:44'),
(3, NULL, NULL, NULL, NULL, NULL, '/assets/uploads/member/BNe15NFuXgJ3kF4gdUQ75FgQks6Jk2l0Ft9whai8.jpeg', NULL, NULL, NULL, 'Norway', 'Norway', 'Oslo', '(GMT )', 'Africa/Algiers', NULL, '<p><br></p>', '2020-11-19 01:50:35', '2020-11-19 01:50:35'),
(4, 'male', '09/09/2002', 'Street address', 'zip code', NULL, '/assets/uploads/member/dr72FqJbAR3ZeH9g3cYqDmYqrRLzt3RiwintkWZ2.jpg', NULL, 'Psychologist', 'Marywood University', 'Norway', 'Norway', 'Oslo', '(GMT )', 'Africa/Algiers', '2022-03-22 7:00,2022-03-22 8:00,2022-03-22 10:00,2022-03-22 9:00,2022-03-22 11:00,2022-03-22 12:00,2022-03-22 13:00,2022-03-22 14:00,2022-03-22 15:00,2022-03-22 17:00,2022-03-22 16:00,2022-03-22 18:00,2022-03-21 10:00,2022-03-21 11:00,2022-03-21 13:00,2022-03-21 12:00,2022-03-21 14:00,2022-03-21 15:00,2022-03-21 16:00,2022-03-21 17:00,2022-03-21 18:00,2022-03-23 11:00,2022-03-23 12:00,2022-03-23 13:00,2022-03-23 16:00,2022-03-23 17:00,2022-03-23 18:00,2022-03-23 19:00,2022-03-23 20:00,2022-03-24 20:00,2022-03-24 21:00,2022-03-24 22:00,2022-03-25 10:00,2022-03-25 11:00,2022-03-25 13:00,2022-03-25 12:00,2022-03-26 10:00,2022-03-26 11:00,2022-03-26 12:00,2022-03-26 13:00,2022-03-27 18:00,2022-03-27 19:00,2022-03-27 20:00,2022-03-27 21:00,2022-03-24 19:00,2022-03-23 4:00,2022-03-28 10:00,2022-03-28 11:00,2022-03-28 12:00,2022-03-28 13:00,2022-03-28 18:00,2022-03-28 19:00,2022-03-28 20:00,2022-03-29 12:00,2022-03-29 13:00,2022-03-29 14:00,2022-03-29 15:00,2022-03-30 10:00,2022-03-30 12:00,2022-03-30 11:00,2022-03-30 13:00,2022-03-30 14:00,2022-04-11 8:00,2022-04-11 9:00,2022-04-11 10:00,2022-04-11 12:00,2022-04-11 11:00,2022-04-11 13:00,2022-04-11 16:00,2022-04-11 15:00,2022-04-11 17:00,2022-04-26 10:00,2022-04-26 11:00,2022-04-26 12:00,2022-04-26 13:00,2022-04-27 10:00,2022-04-27 11:00,2022-04-27 12:00,2022-04-28 9:00,2022-04-29 10:00,2022-04-29 11:00,2022-04-29 12:00,2022-04-30 12:00,2022-04-30 14:00,2022-04-26 10:00,2022-04-26 11:00,2022-04-26 12:00,2022-04-26 13:00,2022-04-27 11:00,2022-04-27 12:00,2022-04-27 13:00,2022-04-27 14:00,2022-04-28 10:00,2022-04-28 12:00,2022-04-28 13:00,2022-04-29 11:00,2022-04-29 12:00,2022-04-29 13:00,2022-04-29 14:00,2022-04-30 11:00,2022-04-30 12:00,2022-04-30 14:00,2022-04-25 13:00,2022-04-25 14:00,2022-04-25 15:00,2022-04-25 16:00,2022-04-25 12:00,2022-04-25 13:00', 'Lorem ipsum dolor sit amet', '2022-04-27 02:32:05', '2022-04-26 18:32:05'),
(5, 'female', '09/20/2002', 'Street address', 'zip code', NULL, '/assets/uploads/member/aUfuU1kPWYJriXkAABzv2kHwW9dTOoQeHZw6qL4i.jpg', NULL, 'Psychologist', 'Marywood University', 'Norway', 'Norway', 'Oslo', '(GMT )', 'Africa/Algiers', NULL, 'Lorem ipsum dolor sit amet consectetur ipsum.', '2022-02-14 08:42:44', '2022-02-14 00:42:44'),
(6, 'male', '09/15/2002', 'Street address', 'zip code', '/assets/uploads/member/iM5cCFPf3tUd2nvBqBpVASHydhNE7suKwIRKAcrK.jpg', '/assets/uploads/member/eicjxizCrnb38xS6lHV21FOUQxiWESAXFAmVPbm1.jpg', NULL, 'Psychologist', 'University of Oslo', 'Norway', 'Norway', 'Oslo', '(GMT )', 'Africa/Bangui', '', 'Lorem ipsum dolor sit amet consectetur ipsum.', '2022-04-25 03:41:43', '2022-04-24 19:41:43'),
(7, 'male', '10/09/2002', 'Gateadresse 123', '1234', NULL, '/assets/uploads/member/KtgjziJLJAWFvs23cCc4zIChrY2k7jPO5YitI2mm.jpeg', NULL, 'Psychologist', 'Marywood University', 'Pakistan', 'Pakistan', 'Islāmābād', '(GMT )', 'Africa/Algiers', NULL, 'test', '2020-10-31 18:09:06', '2020-10-31 18:09:06'),
(8, 'male', '10/04/1990', 'Street Address 1', '1234', NULL, '/assets/uploads/member/8xo11JPnBpqtW4uBlcwJOmvAu6IjhGWm5hEpRVLQ.jpeg', NULL, 'Doctor', NULL, 'Norway', 'Spain', 'Barcelona', NULL, 'Africa/Algiers', NULL, 'Lorem ipsum dolor sit amet', '2020-10-31 18:23:40', '2020-10-31 18:23:40'),
(9, 'male', '10/29/2002', 'test', '1234', NULL, '/assets/uploads/member/mB52WDc17L2vxoih0zcSfoBtck21FPKfhUbcJS9E.jpeg', NULL, 'Veterinarian', NULL, 'Bahrain', 'Bangladesh', 'Dhaka', NULL, 'UTC', NULL, 'test', '2020-11-01 13:29:05', '2020-11-01 13:29:05'),
(10, 'male', '10/29/2002', 'test', '1234', NULL, '/assets/uploads/member/Kq5hqh1xclVZ8FqlontY790ewYCkYOh581ePCrgS.jpeg', NULL, 'Psychologist', NULL, 'Bahamas', 'Bahamas', 'Long Island', NULL, 'Africa/Algiers', NULL, 'test', '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(11, 'male', '10/01/2002', 'Street address', '0280', NULL, '/assets/uploads/member/sOf6INraQAZX7c5zmbLUzLu27BROK93RS055w93h.jpeg', NULL, 'Psychologist', NULL, 'India', 'India', 'Delhi', NULL, 'Africa/Algiers', NULL, 'Lorem ipsum dolro sit aet', '2020-11-01 16:04:06', '2020-11-01 16:04:06'),
(12, 'male', '05/23/1996', 'GongChangLing 29', '0523', NULL, NULL, NULL, NULL, NULL, 'China', 'China', 'Liaoning', NULL, NULL, NULL, NULL, '2020-11-05 11:56:38', '2020-11-05 11:56:40'),
(13, NULL, NULL, NULL, NULL, '/assets/uploads/member/HFnayoTUks2Knh09iOpqq9NF7kL6zsgPZi5gD782.jpeg', '/assets/uploads/member/97pSOXXXmkZ6TNAXn41CK2wJ0bU4Ve6xMFLMmuLN.jpeg', NULL, NULL, NULL, 'China', 'China', 'Liaoning', '(GMT )', 'Asia/Shanghai', NULL, '<p>Professional Web Developer</p>', '2020-11-10 04:38:22', '2020-11-10 04:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `consultant_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `customer_id`, `consultant_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2020-09-30 18:05:00', '2020-09-30 18:05:00'),
(2, 1, 3, '2020-09-30 18:05:24', '2020-09-30 18:05:24'),
(3, 1, 3, '2020-09-30 20:39:37', '2020-09-30 20:39:37'),
(4, 1, 3, '2020-09-30 20:44:07', '2020-09-30 20:44:07'),
(5, 2, 2, '2020-10-26 20:57:26', '2020-10-26 20:57:26'),
(6, 1, 1, '2020-10-27 02:34:50', '2020-10-27 02:34:50'),
(7, 1, 1, '2020-10-27 02:37:15', '2020-10-27 02:37:15'),
(8, 1, 1, '2020-10-27 02:38:24', '2020-10-27 02:38:24'),
(9, 1, 1, '2020-10-28 18:53:21', '2020-10-28 18:53:21'),
(10, 1, 1, '2020-10-31 19:48:00', '2020-10-31 19:48:00'),
(11, 1, 1, '2020-10-31 19:51:19', '2020-10-31 19:51:19'),
(12, 1, 1, '2020-11-01 02:21:51', '2020-11-01 02:21:51'),
(13, 1, 1, '2020-11-01 02:23:26', '2020-11-01 02:23:26'),
(14, 1, 1, '2020-11-01 03:56:20', '2020-11-01 03:56:20'),
(15, 1, 1, '2020-11-01 03:56:20', '2020-11-01 03:56:20'),
(16, 1, 1, '2020-11-01 13:38:56', '2020-11-01 13:38:56'),
(17, 1, 1, '2020-11-01 16:13:58', '2020-11-01 16:13:58'),
(18, 1, 1, '2020-11-01 16:19:10', '2020-11-01 16:19:10'),
(19, 4, 1, '2020-11-10 09:24:06', '2020-11-10 09:24:06'),
(20, 4, 1, '2020-11-10 09:51:42', '2020-11-10 09:51:42'),
(21, 4, 1, '2020-11-10 12:38:55', '2020-11-10 12:38:55'),
(22, 4, 1, '2020-11-10 12:44:04', '2020-11-10 12:44:04'),
(23, 4, 1, '2020-11-10 12:50:23', '2020-11-10 12:50:23'),
(24, 4, 1, '2020-11-10 12:55:37', '2020-11-10 12:55:37'),
(25, 4, 1, '2020-11-10 16:13:50', '2020-11-10 16:13:50'),
(26, 4, 1, '2020-11-10 16:17:14', '2020-11-10 16:17:14'),
(27, 4, 1, '2020-11-10 16:23:03', '2020-11-10 16:23:03'),
(28, 4, 1, '2020-11-10 16:26:19', '2020-11-10 16:26:19'),
(29, 4, 1, '2020-11-10 16:29:10', '2020-11-10 16:29:10'),
(30, 4, 1, '2020-11-10 16:32:45', '2020-11-10 16:32:45'),
(31, 4, 1, '2020-11-10 16:37:18', '2020-11-10 16:37:18'),
(32, 4, 1, '2020-11-10 16:37:19', '2020-11-10 16:37:19'),
(33, 4, 1, '2020-11-10 16:39:55', '2020-11-10 16:39:55'),
(34, 4, 1, '2020-11-10 16:42:06', '2020-11-10 16:42:06'),
(35, 4, 1, '2020-11-11 01:53:14', '2020-11-11 01:53:14'),
(36, 4, 1, '2020-11-11 02:19:42', '2020-11-11 02:19:42'),
(37, 4, 1, '2020-11-11 04:41:22', '2020-11-11 04:41:22'),
(38, 4, 1, '2020-11-11 15:27:51', '2020-11-11 15:27:51'),
(39, 4, 1, '2020-11-11 15:30:42', '2020-11-11 15:30:42'),
(40, 4, 1, '2020-11-11 15:33:35', '2020-11-11 15:33:35'),
(41, 4, 1, '2020-11-11 15:49:07', '2020-11-11 15:49:07'),
(42, 4, 1, '2020-11-11 16:09:37', '2020-11-11 16:09:37'),
(43, 4, 1, '2020-11-11 16:23:13', '2020-11-11 16:23:13'),
(44, 4, 1, '2020-11-11 17:04:43', '2020-11-11 17:04:43'),
(45, 4, 1, '2020-11-11 17:25:21', '2020-11-11 17:25:21'),
(46, 4, 1, '2020-11-11 18:32:55', '2020-11-11 18:32:55'),
(47, 4, 1, '2020-11-11 18:49:18', '2020-11-11 18:49:18'),
(48, 4, 1, '2020-11-11 19:00:56', '2020-11-11 19:00:56'),
(49, 4, 1, '2020-11-11 19:03:50', '2020-11-11 19:03:50'),
(50, 4, 1, '2020-11-11 19:12:10', '2020-11-11 19:12:10'),
(51, 1, 1, '2020-12-15 03:43:01', '2020-12-15 03:43:01'),
(52, 1, 1, '2020-12-15 04:47:19', '2020-12-15 04:47:19'),
(53, 1, 1, '2020-12-25 09:13:09', '2020-12-25 09:13:09'),
(54, 1, 1, '2020-12-25 12:19:30', '2020-12-25 12:19:30'),
(55, 1, 1, '2020-12-25 12:37:41', '2020-12-25 12:37:41'),
(56, 1, 1, '2020-12-25 12:42:25', '2020-12-25 12:42:25'),
(57, 1, 1, '2020-12-25 12:46:22', '2020-12-25 12:46:22'),
(58, 1, 1, '2020-12-25 12:52:32', '2020-12-25 12:52:32'),
(59, 1, 1, '2020-12-25 12:54:57', '2020-12-25 12:54:57'),
(60, 1, 1, '2020-12-25 12:57:15', '2020-12-25 12:57:15'),
(61, 1, 1, '2020-12-25 12:59:59', '2020-12-25 12:59:59'),
(62, 1, 1, '2020-12-25 13:04:14', '2020-12-25 13:04:14'),
(63, 1, 1, '2020-12-25 13:06:43', '2020-12-25 13:06:43'),
(64, 1, 1, '2020-12-25 13:10:24', '2020-12-25 13:10:24'),
(65, 1, 1, '2020-12-25 13:14:17', '2020-12-25 13:14:17'),
(66, 1, 1, '2020-12-25 13:15:56', '2020-12-25 13:15:56'),
(67, 1, 1, '2020-12-25 13:18:39', '2020-12-25 13:18:39'),
(68, 1, 1, '2020-12-25 13:21:51', '2020-12-25 13:21:51'),
(69, 1, 1, '2020-12-25 13:25:21', '2020-12-25 13:25:21'),
(70, 1, 1, '2020-12-26 04:55:51', '2020-12-26 04:55:51'),
(71, 1, 1, '2020-12-26 05:02:38', '2020-12-26 05:02:38'),
(72, 1, 1, '2020-12-26 05:06:41', '2020-12-26 05:06:41'),
(73, 1, 1, '2020-12-26 05:27:52', '2020-12-26 05:27:52'),
(74, 1, 1, '2020-12-26 05:32:19', '2020-12-26 05:32:19'),
(75, 1, 1, '2020-12-26 05:33:42', '2020-12-26 05:33:42'),
(76, 1, 1, '2020-12-26 05:35:28', '2020-12-26 05:35:28'),
(77, 1, 1, '2020-12-26 05:37:14', '2020-12-26 05:37:14'),
(78, 1, 1, '2020-12-26 05:40:18', '2020-12-26 05:40:18'),
(79, 1, 1, '2020-12-26 05:46:05', '2020-12-26 05:46:05'),
(80, 1, 1, '2020-12-26 05:58:22', '2020-12-26 05:58:22'),
(81, 1, 1, '2020-12-28 12:29:41', '2020-12-28 12:29:41'),
(82, 1, 1, '2020-12-28 14:25:55', '2020-12-28 14:25:55'),
(83, 1, 1, '2020-12-28 14:27:28', '2020-12-28 14:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(191) DEFAULT NULL,
  `receiver_id` varchar(191) DEFAULT NULL,
  `rate` int DEFAULT NULL,
  `description` longtext,
  `type` varchar(191) DEFAULT NULL,
  `session` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `sender_id`, `receiver_id`, `rate`, `description`, `type`, `session`, `created_at`, `updated_at`) VALUES
(1, '48', '53', 5, 'Very good consultant. He knows what he is tallking about. Will use again for sure!', 'CUSTOCON', 1, '2020-09-30 18:09:46', '2020-09-30 18:09:46'),
(2, '53', '48', 4, 'Very good customer. Understaind. curious, and always happy.', 'CONTOCUS', 1, '2020-09-30 18:10:09', '2020-09-30 18:10:09'),
(3, '48', '51', 2, 'Best consultant ever.', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(4, '51', '48', 1, 'I didnt like this customer.', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(5, '51', '48', 3, 'It was an okay session with Jan.', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(6, '48', '51', 4, 'He was very good!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(7, '51', '48', 5, 'Wow! So amazing!', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(8, '48', '51', 5, 'Wow, so amazing session!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(9, '48', '51', 3, 'Not so happy!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(10, '51', '48', 0, 'It was okay!', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(11, '48', '51', 5, 'test', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(12, '51', '48', 5, 'test', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(13, '51', '48', 4, 'Best session I ever had with a consultant!', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(14, '48', '51', 4, 'Best session I ever had with a consultant!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(15, '51', '48', 1, 'I am so happy...not!', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(16, '48', '51', 1, 'I am so happy...not!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(17, '48', '51', 5, 'Good consultant!', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(18, '51', '48', 5, 'Good customer!', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(19, '54', '51', 5, 'weird testing', 'CUSTOCON', 5, '2020-11-10 16:25:49', '2020-11-10 16:25:49'),
(20, '54', '51', 5, 'let\'s test again', 'CUSTOCON', 5, '2020-11-10 16:25:49', '2020-11-10 16:25:49'),
(21, '51', '54', 5, 'hmm.. test again.', 'CONTOCUS', 3, '2020-11-10 16:25:37', '2020-11-10 16:25:37'),
(22, '54', '51', 5, 'awesome. video and voice call logic is working fine.', 'CUSTOCON', 5, '2020-11-10 16:25:49', '2020-11-10 16:25:49'),
(23, '54', '51', 5, 'testing voice call', 'CUSTOCON', 5, '2020-11-10 16:25:49', '2020-11-10 16:25:49'),
(24, '51', '54', 5, 'cool', 'CONTOCUS', 3, '2020-11-10 16:25:37', '2020-11-10 16:25:37'),
(25, '51', '54', 5, 'cool', 'CONTOCUS', 3, '2020-11-10 16:25:37', '2020-11-10 16:25:37'),
(26, '54', '51', 5, 'sasasa', 'CUSTOCON', 5, '2020-11-10 16:25:49', '2020-11-10 16:25:49'),
(27, '51', '48', 3, '3 rate done', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(28, '48', '51', 5, '5 rate', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(29, '48', '51', 3, '333', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(30, '51', '48', 0, '44444', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(31, '48', '51', 0, '111', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(32, '51', '48', 3, '444', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(33, '48', '51', 5, 'gggggggg', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(34, '51', '48', 3, '444hh', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(35, '48', '51', 0, 'ffff', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(36, '51', '48', 0, 'ggv', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(37, '48', '51', 0, 'g', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(38, '48', '51', 0, 'nnhnh', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(39, '51', '48', 0, 'jj', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(40, '48', '51', 0, 'fvvc', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(41, '51', '48', 0, 'jj', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(42, '48', '51', 0, 'bb', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(43, '51', '48', 0, 'jj', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(44, '48', '51', 0, 'vcvc', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(45, '51', '48', 0, 'jj', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(46, '48', '51', 3, 'bb', 'CUSTOCON', 20, '2020-12-28 16:27:02', '2020-12-28 14:27:02'),
(47, '51', '48', 3, 'bbbn', 'CONTOCUS', 19, '2020-12-28 16:27:09', '2020-12-28 14:27:09'),
(48, '48', '51', 3, 'dfhf', 'CUSTOCON', 20, '2020-12-28 14:27:02', '2020-12-28 14:27:02'),
(49, '51', '48', 3, 'gffdh', 'CONTOCUS', 19, '2020-12-28 14:27:09', '2020-12-28 14:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `consultant_id` int DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `customer_id`, `consultant_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 48, 3, 'CUSTOCON', '2020-09-30 18:05:27', '2020-09-30 18:05:27'),
(2, 48, 3, 'CUSTOCON', '2020-09-30 20:39:39', '2020-09-30 20:39:39'),
(3, 48, 3, 'CUSTOCON', '2020-09-30 20:44:08', '2020-09-30 20:44:08'),
(4, 49, 2, 'CUSTOCON', '2020-10-26 20:57:30', '2020-10-26 20:57:30'),
(5, 48, 1, 'CUSTOCON', '2020-10-27 02:34:58', '2020-10-27 02:34:58'),
(6, 48, 1, 'CUSTOCON', '2020-10-27 02:37:16', '2020-10-27 02:37:16'),
(7, 48, 1, 'CUSTOCON', '2020-10-27 02:38:26', '2020-10-27 02:38:26'),
(8, 48, 1, 'CUSTOCON', '2020-10-28 18:53:23', '2020-10-28 18:53:23'),
(9, 48, 1, 'CUSTOCON', '2020-10-31 19:48:04', '2020-10-31 19:48:04'),
(10, 48, 1, 'CUSTOCON', '2020-10-31 19:51:52', '2020-10-31 19:51:52'),
(11, 48, 1, 'CUSTOCON', '2020-11-01 02:21:54', '2020-11-01 02:21:54'),
(12, 48, 1, 'CUSTOCON', '2020-11-01 02:23:28', '2020-11-01 02:23:28'),
(13, 48, 1, 'CUSTOCON', '2020-11-01 13:38:58', '2020-11-01 13:38:58'),
(14, 48, 1, 'CUSTOCON', '2020-11-01 16:14:50', '2020-11-01 16:14:50'),
(15, 48, 1, 'CUSTOCON', '2020-11-01 16:19:12', '2020-11-01 16:19:12'),
(16, 54, 1, 'CUSTOCON', '2020-11-10 09:24:11', '2020-11-10 09:24:11'),
(17, 54, 1, 'CUSTOCON', '2020-11-10 09:51:45', '2020-11-10 09:51:45'),
(18, 54, 1, 'CUSTOCON', '2020-11-10 12:39:23', '2020-11-10 12:39:23'),
(19, 54, 1, 'CUSTOCON', '2020-11-10 12:44:09', '2020-11-10 12:44:09'),
(20, 54, 1, 'CUSTOCON', '2020-11-10 12:50:36', '2020-11-10 12:50:36'),
(21, 54, 1, 'CUSTOCON', '2020-11-10 12:55:40', '2020-11-10 12:55:40'),
(22, 54, 1, 'CUSTOCON', '2020-11-10 16:13:53', '2020-11-10 16:13:53'),
(23, 54, 1, 'CUSTOCON', '2020-11-10 16:17:18', '2020-11-10 16:17:18'),
(24, 54, 1, 'CUSTOCON', '2020-11-10 16:23:04', '2020-11-10 16:23:04'),
(25, 54, 1, 'CUSTOCON', '2020-11-10 16:26:20', '2020-11-10 16:26:20'),
(26, 54, 1, 'CUSTOCON', '2020-11-10 16:29:13', '2020-11-10 16:29:13'),
(27, 54, 1, 'CUSTOCON', '2020-11-10 16:32:48', '2020-11-10 16:32:48'),
(28, 54, 1, 'CUSTOCON', '2020-11-10 16:37:22', '2020-11-10 16:37:22'),
(29, 54, 1, 'CUSTOCON', '2020-11-10 16:37:23', '2020-11-10 16:37:23'),
(30, 54, 1, 'CUSTOCON', '2020-11-10 16:40:00', '2020-11-10 16:40:00'),
(31, 54, 1, 'CUSTOCON', '2020-11-10 16:42:08', '2020-11-10 16:42:08'),
(32, 54, 1, 'CUSTOCON', '2020-11-11 01:53:24', '2020-11-11 01:53:24'),
(33, 54, 1, 'CUSTOCON', '2020-11-11 02:19:53', '2020-11-11 02:19:53'),
(34, 54, 1, 'CUSTOCON', '2020-11-11 04:42:03', '2020-11-11 04:42:03'),
(35, 54, 1, 'CUSTOCON', '2020-11-11 15:28:26', '2020-11-11 15:28:26'),
(36, 54, 1, 'CUSTOCON', '2020-11-11 15:31:18', '2020-11-11 15:31:18'),
(37, 54, 1, 'CUSTOCON', '2020-11-11 15:33:52', '2020-11-11 15:33:52'),
(38, 54, 1, 'CUSTOCON', '2020-11-11 16:09:45', '2020-11-11 16:09:45'),
(39, 54, 1, 'CUSTOCON', '2020-11-11 16:23:21', '2020-11-11 16:23:21'),
(40, 54, 1, 'CUSTOCON', '2020-11-11 17:04:47', '2020-11-11 17:04:47'),
(41, 54, 1, 'CUSTOCON', '2020-11-11 17:25:25', '2020-11-11 17:25:25'),
(42, 54, 1, 'CUSTOCON', '2020-11-11 18:32:59', '2020-11-11 18:32:59'),
(43, 54, 1, 'CUSTOCON', '2020-11-11 18:49:22', '2020-11-11 18:49:22'),
(44, 54, 1, 'CUSTOCON', '2020-11-11 19:00:57', '2020-11-11 19:00:57'),
(45, 54, 1, 'CUSTOCON', '2020-11-11 19:03:55', '2020-11-11 19:03:55'),
(46, 54, 1, 'CUSTOCON', '2020-11-11 19:12:14', '2020-11-11 19:12:14'),
(47, 48, 1, 'CUSTOCON', '2020-12-15 03:43:23', '2020-12-15 03:43:23'),
(48, 48, 1, 'CUSTOCON', '2020-12-15 04:47:59', '2020-12-15 04:47:59'),
(49, 48, 1, 'CUSTOCON', '2020-12-25 09:13:18', '2020-12-25 09:13:18'),
(50, 48, 1, 'CUSTOCON', '2020-12-25 12:19:43', '2020-12-25 12:19:43'),
(51, 48, 1, 'CUSTOCON', '2020-12-25 12:46:33', '2020-12-25 12:46:33'),
(52, 48, 1, 'CUSTOCON', '2020-12-25 12:52:39', '2020-12-25 12:52:39'),
(53, 48, 1, 'CUSTOCON', '2020-12-25 13:00:04', '2020-12-25 13:00:04'),
(54, 48, 1, 'CUSTOCON', '2020-12-25 13:04:19', '2020-12-25 13:04:19'),
(55, 48, 1, 'CUSTOCON', '2020-12-25 13:10:28', '2020-12-25 13:10:28'),
(56, 48, 1, 'CUSTOCON', '2020-12-25 13:14:21', '2020-12-25 13:14:21'),
(57, 48, 1, 'CUSTOCON', '2020-12-26 04:55:55', '2020-12-26 04:55:55'),
(58, 48, 1, 'CUSTOCON', '2020-12-26 05:02:41', '2020-12-26 05:02:41'),
(59, 48, 1, 'CUSTOCON', '2020-12-26 05:06:44', '2020-12-26 05:06:44'),
(60, 48, 1, 'CUSTOCON', '2020-12-26 05:32:23', '2020-12-26 05:32:23'),
(61, 48, 1, 'CUSTOCON', '2020-12-26 05:33:45', '2020-12-26 05:33:45'),
(62, 48, 1, 'CUSTOCON', '2020-12-26 05:37:17', '2020-12-26 05:37:17'),
(63, 48, 1, 'CUSTOCON', '2020-12-26 05:40:21', '2020-12-26 05:40:21'),
(64, 48, 1, 'CUSTOCON', '2020-12-26 05:46:09', '2020-12-26 05:46:09'),
(65, 48, 1, 'CUSTOCON', '2020-12-26 05:58:23', '2020-12-26 05:58:23'),
(66, 48, 1, 'CUSTOCON', '2020-12-28 12:29:48', '2020-12-28 12:29:48'),
(67, 48, 1, 'CUSTOCON', '2020-12-28 14:26:00', '2020-12-28 14:26:00'),
(68, 48, 51, 'BOOKING', '2022-04-09 03:03:59', '2022-04-09 03:03:59'),
(69, 48, 51, 'BOOKING', '2022-04-19 17:09:33', '2022-04-19 17:09:33'),
(70, 48, 51, 'BOOKING', '2022-04-26 06:26:07', '2022-04-26 06:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) DEFAULT NULL,
  `receiver_id` bigint DEFAULT NULL,
  `payer_id` bigint DEFAULT NULL,
  `amount` float(50,0) DEFAULT NULL,
  `vat_amount` decimal(7,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total_amount` decimal(7,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `time_spent` int DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` enum('U','P','I') NOT NULL DEFAULT 'U',
  `payed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `receiver_id`, `payer_id`, `amount`, `vat_amount`, `total_amount`, `time_spent`, `type`, `status`, `payed_at`, `created_at`, `updated_at`) VALUES
(1, '101539910154485', 3, 48, 24, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-19 12:37:28', '2020-10-19 12:37:28'),
(2, '571005648984910', 3, 48, 24, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-19 12:37:30', '2020-10-19 12:37:30'),
(3, '985655995210048', 3, 48, 24, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-19 12:37:32', '2020-10-19 12:37:32'),
(4, 'GTC001574910049565356', 2, 49, 0, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-26 20:57:30', '2020-10-26 20:57:30'),
(5, 'GTC001555197515498535', 1, 48, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-10-27 02:34:58', '2020-10-27 02:34:58'),
(6, 'GTC001515110110048481', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-27 02:37:16', '2020-10-27 02:37:16'),
(7, 'GTC001535699551011009', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-27 02:38:26', '2020-10-27 02:38:26'),
(8, 'GTC001521015657995149', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-28 18:53:23', '2020-10-28 18:53:23'),
(9, 'GTC001974998525754579', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-31 19:48:04', '2020-10-31 19:48:04'),
(10, 'GTC001485610098535448', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-10-31 19:51:52', '2020-10-31 19:51:52'),
(11, 'GTC001539850555510049', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-01 02:21:54', '2020-11-01 02:21:54'),
(12, 'GTC001545351525498975', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-01 02:23:28', '2020-11-01 02:23:28'),
(13, 'GTC001985753100521005', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-01 13:38:58', '2020-11-01 13:38:58'),
(14, 'GTC001995399101100575', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-01 16:14:50', '2020-11-01 16:14:50'),
(15, 'GTC001975649102102975', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-01 16:19:12', '2020-11-01 16:19:12'),
(16, 'GTC001994851515353499', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 09:24:11', '2020-11-10 09:24:11'),
(17, 'GTC001504899999998971', 1, 54, 250, '0.00', '0.00', 10, 'CUSTOCON', 'U', NULL, '2020-11-10 09:51:45', '2020-11-10 09:51:45'),
(18, 'GTC001565253555054989', 1, 54, 250, '0.00', '0.00', 10, 'CUSTOCON', 'U', NULL, '2020-11-10 12:39:23', '2020-11-10 12:39:23'),
(19, 'GTC001521025350565110', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 12:44:09', '2020-11-10 12:44:09'),
(20, 'GTC001525510199979710', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 12:50:36', '2020-11-10 12:50:36'),
(21, 'GTC001545310197575310', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 12:55:40', '2020-11-10 12:55:40'),
(22, 'GTC001495498565251549', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 16:13:53', '2020-11-10 16:13:53'),
(23, 'GTC001985010299495698', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 16:17:18', '2020-11-10 16:17:18'),
(24, 'GTC001525249995252495', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 16:23:04', '2020-11-10 16:23:04'),
(25, 'GTC001994852102575153', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 16:26:20', '2020-11-10 16:26:20'),
(26, 'GTC001515410154101489', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 16:29:13', '2020-11-10 16:29:13'),
(27, 'GTC001491015410299551', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 16:32:48', '2020-11-10 16:32:48'),
(28, 'GTC001535499995197985', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 16:37:22', '2020-11-10 16:37:22'),
(29, 'GTC001565653985057494', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 16:37:23', '2020-11-10 16:37:23'),
(30, 'GTC001575310099531004', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-10 16:40:00', '2020-11-10 16:40:00'),
(31, 'GTC001101102501001021', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-10 16:42:08', '2020-11-10 16:42:08'),
(32, 'GTC001571025456974997', 1, 54, 125, '0.00', '0.00', 5, 'CUSTOCON', 'U', NULL, '2020-11-11 01:53:24', '2020-11-11 01:53:24'),
(33, 'GTC001521009951102551', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-11 02:19:53', '2020-11-11 02:19:53'),
(34, 'GTC001549710248100525', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-11 04:42:03', '2020-11-11 04:42:03'),
(35, 'GTC001491009950100979', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 15:28:26', '2020-11-11 15:28:26'),
(36, 'GTC001515297564951545', 1, 54, 75, '0.00', '0.00', 3, 'CUSTOCON', 'U', NULL, '2020-11-11 15:31:18', '2020-11-11 15:31:18'),
(37, 'GTC001531004898491015', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 15:33:52', '2020-11-11 15:33:52'),
(38, 'GTC001579810054505755', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 16:09:45', '2020-11-11 16:09:45'),
(39, 'GTC001505110249485048', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 16:23:21', '2020-11-11 16:23:21'),
(40, 'GTC001999899985010151', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 17:04:47', '2020-11-11 17:04:47'),
(41, 'GTC001559951995698100', 1, 54, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-11 17:25:25', '2020-11-11 17:25:25'),
(42, 'GTC001495410055525799', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 18:32:59', '2020-11-11 18:32:59'),
(43, 'GTC001515098531015451', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 18:49:22', '2020-11-11 18:49:22'),
(44, 'GTC001985298535049559', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 19:00:57', '2020-11-11 19:00:57'),
(45, 'GTC001985198489998975', 1, 54, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-11-11 19:03:55', '2020-11-11 19:03:55'),
(46, 'GTC001100569910051985', 1, 54, 50, '0.00', '0.00', 2, 'CUSTOCON', 'U', NULL, '2020-11-11 19:12:14', '2020-11-11 19:12:14'),
(47, 'GTC001102971019856534', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-15 03:43:23', '2020-12-15 03:43:23'),
(48, 'GTC001485549541025253', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-15 04:47:59', '2020-12-15 04:47:59'),
(49, 'GTC001579951575351981', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-25 09:13:18', '2020-12-25 09:13:18'),
(50, 'GTC001575548101101989', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-25 12:19:43', '2020-12-25 12:19:43'),
(51, 'GTC001102571005155495', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-25 12:46:33', '2020-12-25 12:46:33'),
(52, 'GTC001100485249521004', 1, 48, 25, '0.00', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-25 13:04:19', '2020-12-25 13:04:19'),
(53, 'GTC001499810299555110', 1, 48, 50, '5.00', '55.00', 2, 'CUSTOCON', 'U', NULL, '2020-12-25 13:14:21', '2020-12-25 13:14:21'),
(54, 'GTC001102975599525610', 1, 48, 50, '5.00', '55.00', 2, 'CUSTOCON', 'U', NULL, '2020-12-26 04:55:55', '2020-12-26 04:55:55'),
(55, 'GTC001100565610099511', 1, 48, 25, '2.50', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-26 05:02:41', '2020-12-26 05:02:41'),
(56, 'GTC001571015155974910', 1, 48, 25, '2.50', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-26 05:06:44', '2020-12-26 05:06:44'),
(57, 'GTC001489810148485399', 1, 48, 25, '0.00', '0.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-26 05:33:45', '2020-12-26 05:33:45'),
(58, 'GTC001505699101975110', 1, 48, 25, '0.00', '25.00', 1, 'CUSTOCON', 'U', NULL, '2020-12-26 05:37:17', '2020-12-26 05:37:17'),
(59, 'GTC001571015397100100', 1, 48, 50, '0.00', '50.00', 2, 'CUSTOCON', 'U', NULL, '2020-12-26 05:40:21', '2020-12-26 05:40:21'),
(60, 'GTC001495410057519753', 1, 48, 50, '0.00', '50.00', 2, 'CUSTOCON', 'U', NULL, '2020-12-26 05:46:09', '2020-12-26 05:46:09'),
(61, 'GTC001101529910298100', 1, 48, 25, '2.50', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-26 05:58:23', '2020-12-26 05:58:23'),
(62, 'GTC001555299989710010', 1, 48, 25, '2.50', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-28 12:29:48', '2020-12-28 12:29:48'),
(63, 'GTC001571005350975099', 1, 48, 25, '2.50', '27.50', 1, 'CUSTOCON', 'U', NULL, '2020-12-28 14:26:00', '2020-12-28 14:26:00'),
(64, 'GTC001505151491019999', 51, 48, 22, '0.00', '22.00', 0, 'BOOKING', 'U', NULL, '2022-04-09 03:03:59', '2022-04-09 03:03:59'),
(65, 'GTC001979910297489951', 51, 48, 22, '0.00', '22.00', 0, 'BOOKING', 'U', NULL, '2022-04-19 17:09:33', '2022-04-19 17:09:33'),
(66, 'GTC001521019756491015', 51, 48, 12, '0.00', '12.00', 0, 'BOOKING', 'U', NULL, '2022-04-26 06:26:07', '2022-04-26 06:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_cus_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `stripe_cards` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `account_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(2) UNSIGNED ZEROFILL NOT NULL,
  `fee` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `phone`, `password`, `remember_token`, `role`, `status`, `payment_method`, `balance`, `stripe_cus_id`, `stripe_cards`, `account_id`, `api_token`, `active`, `fee`, `created_at`, `updated_at`) VALUES
(1, 'GotoConsult', '', 'admin@gotoconsult.com', '2019-09-03 17:26:52', '+17187154887', '$2y$10$nEY2PIXtMqJcsOGuJWcvz.v9aTUn0C2W90qu.mTKqxV7W8jibv1wu', 'gTuWRVfQ49sUyssNFF2M7pcW63bfEKunjanzBROgL4KHtGS1rXUF8d96FD7i', 'admin', 'offline', NULL, '0', NULL, NULL, NULL, NULL, 01, '6', '2019-09-03 17:27:25', '2022-04-09 09:58:15'),
(2, 'FantasyLab', NULL, 'executive@fantasylab.io', '2019-08-30 17:26:52', '+4745494649', '$2y$10$5848UteGPhRFoJouW9RaA.r4eI6uCsErB4//JlR6TAPzlhDCwc0UG', 'vTkywHk5JULgolxeSeaknXYQGMeAchsCLTh9yQkZUCySEu5U4oM0p7TZU7cJ', 'admin', 'offline', NULL, '0', '', NULL, NULL, NULL, 01, NULL, '2019-08-30 17:26:52', '2020-10-31 19:20:08'),
(48, 'Jan', 'Ivar', 'janivar@mailinator.com', '2020-09-30 16:29:47', '45494649', '$2y$10$mUCkwkqWmO9zxHgjUpUHaO46KoACDYTu7Mbor/bOMvETyqM.cN.GC', 'RPZjVBNilfMHpGzYVN3RvHa8VlVnyyO33pCPW1A3G7Y1w7mPv1U7fwfZAIfF', 'customer', 'offline', 'klarna', '1459.5', 'cus_I7PWNwPFxhMQFj', '[{\"last4\":\"4242\",\"id\":\"card_1HiPJ3FofdOxgXrmLlQH3e52\"}]', NULL, 'NLNaCUMkWvFzhgBYWiYU1MuwRwAaI5eHUSwDp5eubZbLUf8IvaFwmphM0188', 01, NULL, '2020-09-30 16:29:41', '2022-05-06 19:39:53'),
(49, 'Jeanette', 'Eriksen', 'jeanetteeriksen@mailinator.com', '2020-09-30 16:31:44', '45494649', '$2y$10$Jeofe./sTvNDjLjfbFNpi.Te5W/MV98SE8mODRfdNt1ok3s/qeGty', '4zUXuMrJdg17rMfwEAfIyA0NGnnFk6X8jMcm06rFpwiR4J2LxlBSByykT4Rp', 'customer', 'offline', 'stripe', '5400', 'cus_IHCpZue2jiLB5A', NULL, NULL, 'HfnrL375oGX0OFZxNF4DxZrGCd8oQTKTddNRtgrfYCk54lQHTlFAtd6OE9oD', 01, NULL, '2020-09-30 16:31:30', '2020-11-10 16:11:54'),
(50, 'Abdel', 'Mossaui', 'abdelmossaui@mailinator.com', '2020-09-30 16:34:02', '45494649', '$2y$10$m7oNuWmQ4jbPzFHhBqgiFOq21B/YUYQHfxcQD0Vf8KY91FmfnW4lu', '6Lc9qMFwc1OVMNFuJskO60Nk220oSP37NGFnWhjG6aDZPSebLhluhZtTfBKN', 'customer', 'available', NULL, '0', '', NULL, NULL, '94irIaJKExQkvpIbd1DcSKQD4LdsHQwqKCxsK2oWr9CmDF53l6ZYmLg1TVit', 01, NULL, '2020-09-30 16:33:52', '2020-11-19 01:50:20'),
(51, 'Arild', 'Heltberg', 'arildheltberg@mailinator.com', NULL, '+4745494649', '$2y$10$QtvTp8nJpLnilaKrxS4YqegRCVmB0fVTLeDuGcbI2CRMufOdTjqyW', 'sLK99MlJ627vVG5qEyrFKBqPt5kUqKeUaN48u2z5RUX6oLJ6uQU01nhS5TLZ', 'consultant', 'available', 'klarna', '400', '', NULL, 'arildheltberg', 'T47AL4NoSKLHyQEypBPDlL9KDfeMHhQK7eoYssg2Lde2LfOI4e4v0K1f5Oxe', 01, NULL, '2020-09-30 16:40:00', '2022-05-06 19:40:37'),
(52, 'Jasmine', 'Santori', 'jasminesantori@mailinator.com', NULL, '+4745494649', '$2y$10$MjZgYJNbOFEGAEXAsMsT0ektnwpBu3BUXBjvaRRZz9AW7kfe37Jzq', 'IUsmmwG5Vsjqueo3en2PuZFKI6UXXwzuGkFejRO5Rfn5M4gOioVsxmHzfPaL', 'consultant', 'offline', NULL, '0', '', NULL, 'jasminesantori', 'NmzzsybRHrqULz9pPjdCGFmgR6hTdYnamWcLNHNC1QgziG8vwsTpOKautxZl', 01, NULL, '2020-09-30 16:43:57', '2022-02-14 00:42:52'),
(53, 'Chris', 'Pettersen', 'chrispettersen@mailinator.com', NULL, '+4745494649', '$2y$10$mUCkwkqWmO9zxHgjUpUHaO46KoACDYTu7Mbor/bOMvETyqM.cN.GC', 'GNMPpxRj8W86WXvlKz9Xxmbwq94kZt532Wo0NAjaPebuUQPQtzxTiWz59FmW', 'consultant', 'offline', 'stripe', '0', 'cus_I7PXcFklu6LlRY', NULL, 'chrispettersen', 'y5fwuVHwiEIjPxAj4McDC1MSlxVlHfR0zGCvAHWDR0GZVAPLTsP1SUrfCyxG', 01, NULL, '2020-09-30 16:47:08', '2022-02-14 00:39:01'),
(54, 'Dmitrii', 'Katserikov', 'dmitrii@fantasylab.io', '2020-10-03 13:56:48', '+4745494649', '$2y$10$tRpfMEPFO8SyWMho4eg4euz/6hXNmKHuxG51qUcnWWJcnxCG0P/qS', 'pPGow5skkKrZPGWbfsSrGzv7u8ZAHlT5Zqy9z1GKvUhH8MGTj8eZtAfBwtjd', 'customer', 'available', 'stripe', '1893.8925', 'cus_IMXib3d5y9zUHP', '[{\"last4\":\"1111\",\"id\":\"card_1HlodBFofdOxgXrmTfC8IJvn\"}]', NULL, 'FPHFmZUXX3YxAckpRjG2Ir6LhDzAIiO9qBxBkmWSXsNYJ87QvZL3BdeBiadr', 01, NULL, '2020-10-03 13:56:18', '2020-11-11 19:13:05'),
(55, 'Aryan', 'Browzki', 'aryanbrowzki@mailinator.com', NULL, '+4745494649', '$2y$10$YINl9zrBGTM60N/A3ziCTOEX.rMR9Klp0ZT9IvW4zNR5J1aTl0p3.', 'z3OsBJLFE7C4PxmeNWUP5RDo4y4tGkUOtcxtA6IQqXG9fQTW7SSovtRavBta', 'consultant', 'offline', NULL, '200', '', NULL, 'aryanbrowzki', 'pdOaThKmrhqMg0145zod6CFHQ8830PQ3NoSF6vmZ2d0rdMKY2lxLk7gIUV5a', 01, NULL, '2020-10-28 22:45:50', '2020-11-01 15:07:01'),
(56, 'Sara', 'Louise', 'saralouise@mailinator.com', '2020-10-31 17:58:09', '45494649', '$2y$10$YpRNLy3j5N83qAc78UPinueR2wr3egL/0V4rEXKq/JCfzckcQw0WS', 'A5DMWJrR8aTMknLZCROPXwmskKWgwqSfw79vGJsKtIOJcQXy9Tb6PLrlyBsA', 'customer', 'offline', NULL, '0', '', NULL, NULL, 'mzA9ClugrqK2NnqsufWCK0KUxC37F6RGgeLWbldoaf4sFjOBcTEKlZ4qEm5N', 01, NULL, '2020-10-31 17:57:51', '2020-11-01 14:53:52'),
(57, 'Laila', 'Lund', 'lailalund@mailinator.com', NULL, '+4745494649', '$2y$10$DX88xh5ladfdcI0MOkGYUOryeHN89jwfik2WzbrD4.As/a8uX4TF6', '3mt6cxBGvi7Lxlj24HH9WxYfJryzqiMzlzNNcdaCyzUP1RtOayjxyAT96uNw', 'consultant', 'offline', NULL, '0', '', NULL, 'lailalund', 'm7HvaPcfvCf7RiZBBCmVEQ8ndUYc88wtnE9x7HJiS1K8lixEzt1sYjbg5zBc', 01, NULL, '2020-10-31 18:23:40', '2020-11-01 13:25:30'),
(58, 'Nohman', 'Janjua', 'fantasylaboperations@gmail.com', NULL, '45494649', '$2y$10$wvU3.L06muAv.tcCR6vaaeehVo61cioo4eVE9Pb7Vfdtyw8tAobGi', NULL, 'customer', 'offline', NULL, '0', '', NULL, NULL, 'Iyf1aWUusSkr9AdcjO5Z3AVsf9IlzUq1J06RY6uELDkOzKtqgnrLvzpVhxCv', 00, NULL, '2020-11-01 13:20:57', '2020-11-01 13:20:57'),
(59, 'Ali', 'Emret', 'aliemret@mailinator.com', '2020-11-01 13:23:40', '45494649', '$2y$10$nvspAfhFmBhFY6240Rlt7OVoM41.3yqv/q/7RlFY0fg7zZ6UO.ifq', 'iRE4gTEMU1LDuMah91XbxC9nCAk1CuFiQ1kQdqAha04NWcqP6dhehP4lUZaM', 'customer', 'offline', NULL, '0', '', NULL, NULL, 'catcijTgq7aphnl1piPGgm47IJ0hgaK16lNaXVvbLqaXNU4KyfQhUfRC9qRL', 01, NULL, '2020-11-01 13:22:57', '2020-11-05 03:52:01'),
(60, 'Nina', 'Jensen', 'ninajensen@mailinator.com', NULL, '+4745494649', '$2y$10$zEBMW7BcfaQ45JevX/5qJeUSwpJ.6xr2xzQlwSRD3Giyw0MEHE7se', 'xidxaASSnp0Jj7NiiBO8WH7Kkhb7yHsm8W3kJEFxop8DZFZIFIG0OCtdJbd0', 'consultant', 'offline', NULL, '0', '', NULL, 'ninajensen', '7WppS4soLHSOsQssOvA5cuHhC5vFFoZRCAbbKL7UJOXW6FpErY5s3LXFOhhw', 01, NULL, '2020-11-01 13:29:05', '2020-11-01 13:35:40'),
(61, 'Farhood', 'Gandomani', 'farhoodgandomani@mailinator.com', NULL, '+4745494649', '$2y$10$apdSgO0NheP6zT5/PZ/Ws.wW.XuTw3W6th7RPhBrZznMH7Am5rl3i', NULL, 'consultant', 'offline', NULL, '0', '', NULL, 'farhoodgandomani', 'u2d4zVI4tsyYsWGcoL6W9XKQu3b3DXUkAGADMZIeG65UmIaNbDerb9CG09Bv', 02, NULL, '2020-11-01 14:00:12', '2020-11-01 14:00:12'),
(62, 'Kari', 'Olsen', 'kariolsen@mailinator.com', '2020-11-01 15:39:03', '45494649', '$2y$10$K0v1blCCLKomJvePIdSDHujORZM8oTPqWZQTgWRunHwa1EzH6g9m6', '5Zrm8wEB8EPx62k1gEDe2mTlvQR55plTvtR1xuSAX9OofTXC3PzBF6H1UcyQ', 'customer', 'offline', NULL, '0', '', NULL, NULL, 'TzeDxwSd7eEZZ6puB7AThaGZ3hK67mZVKVh3SnIhEYvwKSrSPLE6upO6qc66', 01, NULL, '2020-11-01 15:38:19', '2020-11-01 15:41:29'),
(63, 'Mari', 'Ekeløf', 'mariekelof@mailinator.com', NULL, '+4745494649', '$2y$10$D3dqfGiesHQ1jVV4QK1dveWRLrT75XFO3Yl4KFM4ZKPCXmj8LKgH2', 'j9qbjeRSaybylQuHS07qKqhTVCiaH7Y0s8knCOP92goatJsrjFlK9KGZDf4p', 'consultant', 'offline', NULL, '0', '', NULL, 'mariekelof', 'Fh3MkArHOqp7yeOEb80sX9qLP80VhJNVVnI4NJGl1yWetIngw0wnphgeTKcg', 02, NULL, '2020-11-01 16:04:06', '2020-11-01 16:07:38');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `missed_notifications`
--
ALTER TABLE `missed_notifications`
  ADD CONSTRAINT `missed_notifications_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `missed_notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
