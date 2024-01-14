-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Mrz 2015 um 13:04
-- Server Version: 5.6.17-log
-- PHP-Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `saganaj_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookies`
--

CREATE TABLE IF NOT EXISTS `bookies` (
  `bid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `jdate` date NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `bookies`
--

INSERT INTO `bookies` (`bid`, `username`, `password`, `role`, `jdate`) VALUES
(1, 'admin', 'welcome', 'admin', '2014-07-10'),
(2, 'saran', 'welcome3ibm', NULL, '2014-11-06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(200) NOT NULL,
  `street` varchar(200) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jdate` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=184 ;

--
-- Daten für Tabelle `customer`
--

INSERT INTO `customer` (`cust_id`, `cname`, `street`, `city`, `zip`, `state`, `phone`, `mobile`, `email`, `jdate`, `status`) VALUES
(117, 'Ganesamorrthy Sayanthini', 'Wabersackerstrasse 71', 'Libefeld', '3097', NULL, '0319723953', NULL, NULL, '2014-12-22', NULL),
(118, 'Ganesamorrthy Niruthya', 'Wabersackerstrasse 71', 'Libefeld', '3097', NULL, '0319723953', NULL, NULL, '2014-12-22', NULL),
(119, 'mala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-22', NULL),
(120, 'karen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-22', NULL),
(121, 'Senthinathan Subothini', 'Obematstr 18', 'Bern', '3018', NULL, '031 3711457', NULL, NULL, '2014-12-27', NULL),
(122, 'Jeewa Kala', 'Untermattweg 64', 'Bern', '3027', NULL, '078 96 27204', '078 962 7204', NULL, '2014-12-27', NULL),
(123, 'Asthirina', 'Bernstr 22', 'Ostmundigen', '3072', NULL, NULL, '0779464904', NULL, '2014-12-27', NULL),
(124, 'Shan Kavitha', 'Murtenstr 139', 'Bern', '3008', NULL, NULL, '0796731233', NULL, '2014-12-31', NULL),
(125, 'Suganthi', 'Worbladenstr 111', 'Ittingen', '3063', NULL, NULL, '0319218347', NULL, '2014-12-31', NULL),
(126, 'Ramasandiran', 'Lindenhofweg 15', 'Belp', '3123', NULL, NULL, NULL, NULL, '2015-01-03', NULL),
(127, 'Rajendran Elayathamby', 'Frhmattstr 02', 'Tindligen', '1734', NULL, '0264812252', NULL, NULL, '2015-01-05', NULL),
(128, 'N.Uthayarajah', 'GÃ¼terstr 14', 'Bern', '3008', NULL, '0313814625', NULL, NULL, '2015-01-07', NULL),
(129, 'Vishnujithan Thenuja', 'RÃ¼tiweg 128', 'Ostmundigen', '3072', NULL, NULL, '0799537115', NULL, '2015-01-08', NULL),
(130, 'Sriskantharaja Vasanthadevi', 'RÃ¼tiweg 128', 'Ostmundigen', '3072', NULL, '0799537115', '0799537115', NULL, '2015-01-08', NULL),
(131, 'Manokaran Vinoth', 'Schwrzenburgstr 453', ' KÃ¶niz', '3098', NULL, '0318197518', '0779407269', NULL, '2015-01-08', NULL),
(132, 'Pirabakaran Saseetha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-01-09', NULL),
(133, 'R.Suruthy', 'MÃ¶venweg 2', 'Thun', '3604', NULL, '0333354012', NULL, NULL, '2015-01-09', NULL),
(134, 'Selvanathan Shanthi', 'Solathunstr 73', 'Urtenen SchÃ¶nbÃ¼hl', '3322', NULL, '0318520221', NULL, NULL, '2015-01-09', NULL),
(135, 'Nagarathnam', 'Looslistr 41', 'Bern', '3027', NULL, '0319923173', '0779021876', NULL, '2015-01-09', NULL),
(136, 'Kumar Sruthy', 'Murtenstr 356', 'Bern', '3027', NULL, '0319929461', NULL, NULL, '2015-01-10', NULL),
(137, 'Jeeva Pettik', 'BÃ¼mblizstr 25', 'Bern', '3027', NULL, '031 9916653', NULL, NULL, '2015-01-12', NULL),
(138, 'Kugathash Praniska', 'Telstr 101', 'ThÃ¶rishase', '3174', NULL, NULL, '0787369409', NULL, '2015-01-13', NULL),
(139, 'Karigalan Kajalaxcy', 'Ringstr  15', 'Ostmundigen', '3072', NULL, '0319313485', NULL, NULL, '2015-01-14', NULL),
(140, 'Karigalan ', 'Aarhaldenstr 4', 'Wabern', '3084', NULL, '0764307232', NULL, NULL, '2015-01-14', NULL),
(141, 'E.Rajendiram', NULL, 'Freiburg', '1700', NULL, NULL, NULL, NULL, '2015-01-14', NULL),
(142, 'Suba', 'Zenralstr 66', 'Biel', '2503', NULL, '0764243820', NULL, NULL, '2015-01-14', NULL),
(143, 'Thevarajah Santhini', 'Solothurnstr 23', 'Lengnau', '2543', NULL, '0326521204', NULL, NULL, '2015-01-14', NULL),
(144, 'Tharmalingam Sarujah', 'Tiefenaustr 86 b', 'Bern', '3004', NULL, '0313022294', NULL, NULL, '2015-01-17', NULL),
(145, 'N.Shanmugam', 'BÃ¼mblizstr 15', 'Bern', '3027', NULL, NULL, NULL, NULL, '2015-01-19', NULL),
(146, 'Nirmalan Saisha', 'MÃ¤dergutstr 43', 'Bern', '3018', NULL, NULL, '0765212311', NULL, '2015-01-19', NULL),
(147, 'Nirmalan Sabarisha', 'MÃ¤dergutstr 43', 'Bern', '3018', NULL, '0765212311', '0765212311', NULL, '2015-01-19', NULL),
(148, 'Thampaiya Kamalambikai', 'Rue de mont noble 6', 'Sierre', '3960', NULL, NULL, '0779019830', NULL, '2015-01-20', NULL),
(149, 'Muthukumarasamy Pathmarani', 'Wabersackerstrasse 71', 'Libefeld', '3097', NULL, '0319723953', NULL, NULL, '2015-01-21', NULL),
(150, 'Vivekananthan Nesamalar', 'Libefeld str 77', 'Libefeld', '3097', NULL, '0313814665', '0783177546', NULL, '2015-01-21', NULL),
(151, 'A.Mattews', 'Oberezollgasse 49A', 'Ostmundigen', '3072', NULL, NULL, NULL, NULL, '2015-01-21', NULL),
(152, 'Pirabakaran Rajadurai', 'GÃ¼terstr 44', 'Bern', '3008', NULL, '0313814132', NULL, NULL, '2015-01-23', NULL),
(153, 'Yogarajah Narmatha', 'Bernstr 77', 'KÃ¤zeraz', '3122', NULL, '0315340638', NULL, NULL, '2015-01-23', NULL),
(154, 'Charles Melissa', 'MÃ¼hlegasse 6', 'Kerzers', '3210', NULL, NULL, '0794744011', NULL, '2015-01-24', NULL),
(155, 'Santha selvarathnam', 'Wergasse 16', 'Bern', '3018', NULL, '0319913236', NULL, NULL, '2015-01-28', NULL),
(156, 'RAJAH', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-01-31', NULL),
(157, 'S.Kamalalogini', 'Murtenstr ', 'Bern', '3027', NULL, NULL, NULL, NULL, '2015-02-02', NULL),
(158, 'Manoranjetham', 'MÃ¼hlenstr 65', 'KÃ¶niz', '3098', NULL, NULL, '0787428755', NULL, '2015-02-04', NULL),
(159, 'Yoganathan Tharsika', 'BrÃ¼nnstube 6', 'Schwarzenburg', '3150', NULL, NULL, '0764387098', NULL, '2015-02-05', NULL),
(160, 'Angayatkanny', 'Looslistr 43', 'Bern', '3027', NULL, '0319918530', NULL, NULL, '2015-02-05', NULL),
(161, 'Rasiah Langadevi', 'Rtede Grand st Bernard 30', 'Bex', '1880', NULL, '0244634328', NULL, NULL, '2015-02-06', NULL),
(162, 'raman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-06', NULL),
(163, 'satha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-06', NULL),
(164, 'Thangavel Vanasanayake', 'Stooss str 2', 'Bern', '3008', NULL, '031 3725493', '0795119024', NULL, '2015-02-07', NULL),
(165, 'Maharajah Sailaya', 'Brunnmatt str 20a', 'Bern', '3007', NULL, '0313715330', NULL, NULL, '2015-02-09', NULL),
(166, 'Karunanithy Heetha', 'Waldmannstr 53', 'Bern', '3027', NULL, '0319914629', NULL, NULL, '2015-02-09', NULL),
(167, 'Sivananthan Rageipan', 'Waldheimstrasse 10', 'Bern', '3012', NULL, '0313029047', '0786248085', NULL, '2015-02-11', NULL),
(168, 'T.Uthayathas', 'Austr 83', 'Neuennegg', '3176', NULL, '0319923177', NULL, NULL, '2015-02-11', NULL),
(169, 'S.Mahendiran', 'Blumenweg 7', 'Herzogenbuchse', '3360', NULL, '0629610524', NULL, NULL, '2015-02-13', NULL),
(170, 'Poonkody', NULL, 'KÃ¶niz', '3098', NULL, NULL, NULL, NULL, '2015-02-18', NULL),
(171, 'Rathiga Manohararajah', 'Homaclstr 34', 'Thun', '3600', NULL, NULL, '0799547392', NULL, '2015-02-26', NULL),
(172, 'Ranjinidevi Ambikaipagan', 'Homaclstr 34', 'Thun', '3600', NULL, '0799547392', '0799547392', NULL, '2015-02-26', NULL),
(173, 'Senthilnathan Subothini', 'Obematstr 18', 'Bern', '3018', NULL, '031 3711457', NULL, NULL, '2015-02-27', NULL),
(174, 'Tharmarajah Renuka', 'Burunenstr 103', 'Bern', '3018', NULL, '0319810730', NULL, NULL, '2015-03-03', NULL),
(175, 'Suvenran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-07', NULL),
(176, 'S.Kanthasamy', 'Rehagg 49', 'Bern', '3018', NULL, NULL, NULL, NULL, '2015-03-10', NULL),
(177, 'yogeswaran Shameera', 'Hangweg 34', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-11', NULL),
(178, 'Yogeswran Shameera', 'Hangweg 34', 'LazenhÃ¤usern', '3148', NULL, '0319721235', NULL, NULL, '2015-03-11', NULL),
(179, 'Mery Abiramy', 'Lindenhofweg 5', 'Belp', '3123', NULL, '0318196571', NULL, NULL, '2015-03-11', NULL),
(180, 'Kamalanathan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-12', NULL),
(181, 'Srikaran Rathika', 'Helfigenweg 8', 'Laupen', '3177', NULL, '031 7470817', '0766820817', NULL, '2015-03-14', NULL),
(182, 'Santhirakumar Sivasothy', 'Riedmattstr 4', 'SOLOTHUN', '4500', NULL, NULL, '0789719058', NULL, '2015-03-14', NULL),
(183, 'Ramesh ', 'Murtenstr 17', 'Bern', '3008', NULL, NULL, '0787420694', NULL, '2015-03-18', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `inv_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `cust_id` mediumint(10) DEFAULT NULL,
  `mdate` date NOT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=354 ;

--
-- Daten für Tabelle `invoices`
--

INSERT INTO `invoices` (`inv_id`, `cust_id`, `mdate`) VALUES
(339, 119, '2014-12-22'),
(340, NULL, '2014-12-22'),
(341, 126, '2015-01-03'),
(342, 132, '2015-01-09'),
(343, 156, '2015-01-31'),
(344, 120, '2015-01-31'),
(345, 161, '2015-02-06'),
(347, 163, '2015-02-06'),
(348, 161, '2015-02-06'),
(349, 132, '2015-02-12'),
(350, 132, '2015-02-14'),
(351, 170, '2015-02-18'),
(352, 175, '2015-03-07'),
(353, 180, '2015-03-12');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `scheme_id` mediumint(10) NOT NULL,
  `cust_id` mediumint(10) NOT NULL,
  `paid_terms` int(3) DEFAULT NULL,
  `total_paid_amount` float(7,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Daten für Tabelle `members`
--

INSERT INTO `members` (`member_id`, `scheme_id`, `cust_id`, `paid_terms`, `total_paid_amount`, `status`) VALUES
(20, 4, 117, 2, 300.00, 'PAID'),
(21, 4, 118, 2, 300.00, 'PAID'),
(23, 4, 121, 3, 450.00, 'PAID'),
(24, 5, 122, 2, 200.00, 'PAID'),
(25, 6, 123, 0, 0.00, 'JOINED'),
(26, 4, 123, 2, 300.00, 'PAID'),
(27, 4, 124, 3, 450.00, 'PAID'),
(28, 4, 125, 0, 0.00, 'JOINED'),
(29, 4, 127, 3, 450.00, 'PAID'),
(30, 4, 128, 1, 150.00, 'PAID'),
(31, 5, 129, 0, 0.00, 'JOINED'),
(32, 5, 130, 2, 200.00, 'PAID'),
(33, 4, 131, 0, 0.00, 'JOINED'),
(34, 4, 133, 0, 0.00, 'JOINED'),
(35, 4, 134, 3, 450.00, 'PAID'),
(36, 4, 135, 3, 450.00, 'PAID'),
(37, 4, 136, 0, 0.00, 'UNPAID'),
(38, 5, 136, 3, 300.00, 'PAID'),
(39, 4, 137, 1, 150.00, 'PAID'),
(41, 5, 138, 2, 200.00, 'PAID'),
(42, 4, 139, 0, 0.00, 'JOINED'),
(43, 4, 140, 0, 0.00, 'JOINED'),
(45, 5, 142, 2, 200.00, 'PAID'),
(46, 5, 143, 0, 0.00, 'JOINED'),
(47, 4, 144, 1, 150.00, 'PAID'),
(48, 5, 145, 1, 100.00, 'PAID'),
(49, 4, 146, 1, 150.00, 'PAID'),
(50, 4, 147, 1, 150.00, 'PAID'),
(51, 5, 148, 0, 0.00, 'JOINED'),
(52, 5, 149, 0, 0.00, 'JOINED'),
(53, 4, 150, 0, 0.00, 'JOINED'),
(54, 5, 151, 1, 100.00, 'PAID'),
(55, 4, 152, 2, 300.00, 'PAID'),
(56, 4, 153, 1, 150.00, 'PAID'),
(57, 4, 154, 3, 450.00, 'PAID'),
(58, 4, 155, 3, 450.00, 'PAID'),
(59, 4, 157, 3, 450.00, 'PAID'),
(60, 4, 158, 2, 300.00, 'PAID'),
(61, 4, 159, 0, 0.00, 'JOINED'),
(62, 4, 160, 0, 0.00, 'JOINED'),
(63, 4, 164, 1, 150.00, 'PAID'),
(64, 4, 165, 3, 450.00, 'PAID'),
(65, 5, 166, 1, 100.00, 'PAID'),
(66, 4, 167, 0, 0.00, 'JOINED'),
(67, 5, 168, 1, 100.00, 'PAID'),
(68, 5, 169, 1, 100.00, 'PAID'),
(69, 4, 171, 0, 0.00, 'JOINED'),
(70, 4, 172, 0, 0.00, 'JOINED'),
(71, 4, 174, 1, 150.00, 'PAID'),
(72, 4, 176, 2, 300.00, 'PAID'),
(73, 4, 177, 0, 0.00, 'JOINED'),
(74, 4, 178, 0, 0.00, 'JOINED'),
(75, 4, 179, 4, 600.00, 'PAID'),
(76, 4, 181, 0, 0.00, 'JOINED'),
(77, 4, 182, 2, 300.00, 'PAID'),
(78, 4, 183, 2, 300.00, 'PAID');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `member_transactions`
--

CREATE TABLE IF NOT EXISTS `member_transactions` (
  `trans_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `member_id` mediumint(10) NOT NULL,
  `paid_date` date NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Daten für Tabelle `member_transactions`
--

INSERT INTO `member_transactions` (`trans_id`, `member_id`, `paid_date`) VALUES
(2, 23, '2014-12-27'),
(3, 27, '2014-12-31'),
(4, 29, '2015-01-05'),
(5, 29, '2015-01-05'),
(6, 29, '2015-01-05'),
(7, 29, '2015-01-05'),
(8, 29, '2015-01-05'),
(9, 30, '2015-01-07'),
(10, 36, '2015-01-09'),
(11, 37, '2015-01-10'),
(12, 37, '2015-01-10'),
(13, 37, '2015-01-10'),
(14, 37, '2015-01-10'),
(15, 38, '2015-01-10'),
(16, 39, '2015-01-14'),
(17, 45, '2015-01-14'),
(18, 48, '2015-01-19'),
(19, 23, '2015-01-24'),
(20, 57, '2015-01-24'),
(21, 58, '2015-01-28'),
(22, 59, '2015-02-02'),
(23, 38, '2015-02-03'),
(24, 26, '2015-02-06'),
(25, 26, '2015-02-06'),
(26, 63, '2015-02-07'),
(27, 55, '2015-02-09'),
(28, 57, '2015-02-09'),
(29, 58, '2015-02-09'),
(30, 64, '2015-02-09'),
(31, 64, '2015-02-09'),
(32, 65, '2015-02-09'),
(33, 67, '2015-02-11'),
(34, 29, '2015-02-12'),
(35, 60, '2015-02-12'),
(36, 60, '2015-02-12'),
(37, 45, '2015-02-12'),
(38, 24, '2015-02-13'),
(39, 56, '2015-02-14'),
(40, 59, '2015-02-14'),
(41, 35, '2015-02-20'),
(42, 35, '2015-02-20'),
(43, 47, '2015-02-23'),
(44, 49, '2015-02-23'),
(45, 50, '2015-02-23'),
(46, 36, '2015-02-26'),
(47, 24, '2015-02-27'),
(48, 59, '2015-03-02'),
(49, 38, '2015-03-02'),
(50, 71, '2015-03-03'),
(51, 55, '2015-03-04'),
(52, 29, '2015-03-05'),
(53, 23, '2015-03-07'),
(54, 35, '2015-03-07'),
(55, 32, '2015-03-07'),
(56, 68, '2015-03-07'),
(57, 54, '2015-03-07'),
(58, 20, '2015-03-07'),
(59, 21, '2015-03-07'),
(60, 20, '2015-03-07'),
(61, 21, '2015-03-07'),
(62, 32, '2015-03-07'),
(63, 72, '2015-03-10'),
(64, 72, '2015-03-10'),
(65, 75, '2015-03-11'),
(66, 75, '2015-03-11'),
(67, 75, '2015-03-11'),
(68, 75, '2015-03-11'),
(69, 58, '2015-03-11'),
(70, 57, '2015-03-13'),
(71, 64, '2015-03-13'),
(72, 77, '2015-03-14'),
(73, 77, '2015-03-14'),
(74, 27, '2015-03-17'),
(75, 27, '2015-03-17'),
(76, 41, '2015-03-18'),
(77, 41, '2015-03-18'),
(78, 78, '2015-03-18'),
(79, 78, '2015-03-18'),
(80, 36, '2015-03-20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mortages`
--

CREATE TABLE IF NOT EXISTS `mortages` (
  `m_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `cust_id` mediumint(10) DEFAULT NULL,
  `total_price` float(7,2) DEFAULT NULL,
  `per_interest` float(7,2) NOT NULL,
  `interest_amount` float(7,2) DEFAULT NULL,
  `loan_amount` float(7,2) DEFAULT NULL,
  `deposit` float(7,2) DEFAULT NULL,
  `balance` float(7,2) DEFAULT NULL,
  `mdate` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `mortages`
--

INSERT INTO `mortages` (`m_id`, `cust_id`, `total_price`, `per_interest`, `interest_amount`, `loan_amount`, `deposit`, `balance`, `mdate`, `status`) VALUES
(1, 141, NULL, 0.00, NULL, NULL, NULL, NULL, '2015-01-14', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mortage_transactions`
--

CREATE TABLE IF NOT EXISTS `mortage_transactions` (
  `trans_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `m_id` mediumint(10) NOT NULL,
  `action` varchar(200) NOT NULL,
  `mdate` date NOT NULL,
  `comments` varchar(100) DEFAULT NULL,
  `final_amount` float(7,2) DEFAULT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mschemes`
--

CREATE TABLE IF NOT EXISTS `mschemes` (
  `scheme_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `scheme_name` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `no_of_terms` int(3) DEFAULT NULL,
  `mpay` float(7,2) DEFAULT NULL,
  `members` int(3) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `price_amount` float(7,2) DEFAULT NULL,
  PRIMARY KEY (`scheme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `mschemes`
--

INSERT INTO `mschemes` (`scheme_id`, `scheme_name`, `start_date`, `no_of_terms`, `mpay`, `members`, `status`, `price_amount`) VALUES
(4, 'Sagana-150', '2015-01-01', 12, 150.00, 43, 'Started', 1800.00),
(5, 'Sagana-100', '2015-01-01', 12, 100.00, 14, 'Started', 1200.00),
(6, 'Sagana-150', '2015-01-01', 12, 150.00, 2, 'Started', 1800.00),
(7, 'Srikaran Rathika', '0000-00-00', NULL, NULL, NULL, 'Started', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `unit_weight` float(7,2) NOT NULL,
  `g_unit_price` float(7,2) NOT NULL,
  `mcharges` float(7,2) DEFAULT NULL,
  `unit_amount` float(7,2) NOT NULL,
  `inv_id` mediumint(10) DEFAULT NULL,
  `m_id` mediumint(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `quantity`, `unit_weight`, `g_unit_price`, `mcharges`, `unit_amount`, `inv_id`, `m_id`) VALUES
(122, 1098, 1, 12.70, 40.50, NULL, 514.35, 339, NULL),
(123, 1099, 5, 50.50, 30.00, NULL, 1515.00, NULL, 37),
(124, 1101, 2, 8.55, 47.00, NULL, 401.85, 340, NULL),
(125, 1098, 1, 22.34, 45.75, NULL, 1022.05, 341, NULL),
(126, 1097, 1, 45.95, 46.75, NULL, 2148.16, 342, NULL),
(128, 1099, 6, 0.00, 0.00, NULL, 0.00, NULL, 1),
(129, 1063, 1, 10.75, 45.00, NULL, 483.75, 343, NULL),
(130, 1099, 1, 25.50, 46.50, NULL, 1185.75, 344, NULL),
(131, 1097, 3, 240.50, 32.00, NULL, 7696.00, 345, NULL),
(133, 1103, 1, 1.50, 47.00, NULL, 70.50, 347, NULL),
(134, 1097, 6, 261.50, 32.00, NULL, 8368.00, 348, NULL),
(135, 1063, 5, 140.70, 32.00, NULL, 4502.40, 348, NULL),
(136, 1099, 20, 390.90, 32.00, NULL, 12508.80, 348, NULL),
(137, 1108, 1, 182.70, 32.00, NULL, 5846.40, 348, NULL),
(138, 1098, 6, 116.70, 32.00, NULL, 3734.40, 348, NULL),
(139, 1097, 1, 61.89, 46.25, NULL, 2862.41, 349, NULL),
(140, 1099, 1, 48.76, 46.25, NULL, 2255.15, 349, NULL),
(141, 1097, 1, 18.42, 46.25, NULL, 851.92, 350, NULL),
(142, 1102, 2, 11.30, 46.25, NULL, 522.62, 350, NULL),
(143, 1098, 1, 12.69, 46.25, NULL, 586.91, 351, NULL),
(144, 1097, 1, 33.99, 46.25, NULL, 1572.04, 352, NULL),
(145, 1108, 1, 81.30, 43.72, NULL, 3554.44, 353, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `inv_id` int(11) NOT NULL,
  `total_price` float(7,2) DEFAULT NULL,
  `discount` float(7,2) DEFAULT NULL,
  `net_amount` float(7,2) DEFAULT NULL,
  `deposit` float(7,2) DEFAULT NULL,
  `balance` float(7,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` (`inv_id`, `total_price`, `discount`, `net_amount`, `deposit`, `balance`, `status`) VALUES
(339, 514.35, 14.35, 500.00, 500.00, 0.00, 'PAID'),
(340, 401.85, 1.85, 400.00, 400.00, 0.00, 'PAID'),
(341, 1022.05, 22.05, 1000.00, 675.00, 325.00, 'UNPAID'),
(343, 483.75, 3.75, 480.00, NULL, 480.00, 'UNPAID'),
(344, 1185.75, NULL, 1185.75, NULL, 1185.75, 'UNPAID'),
(347, 70.50, 0.50, 70.00, 70.00, 0.00, 'PAID'),
(348, 34960.00, 0.00, 34960.00, 34960.00, 0.00, 'PAID'),
(349, 5117.56, NULL, 5117.56, 3000.56, 2117.00, 'UNPAID'),
(350, 1374.55, 24.55, 1350.00, NULL, 1350.00, 'UNPAID'),
(353, 3554.44, NULL, 3554.44, NULL, 3554.44, 'UNPAID');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tree_data`
--

CREATE TABLE IF NOT EXISTS `tree_data` (
  `id` int(10) unsigned NOT NULL,
  `nm` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tree_data`
--

INSERT INTO `tree_data` (`id`, `nm`) VALUES
(1, 'Gold Jwells'),
(1063, 'Necklace'),
(1097, 'Long Necklace'),
(1098, 'Chain'),
(1099, 'Bangales'),
(1100, 'Pendonts'),
(1101, 'Bracelets'),
(1102, 'Ear Rings'),
(1103, 'Rings'),
(1104, 'Fashion Jwells'),
(1105, 'Baby Necklace'),
(1106, 'Man Bracelet'),
(1108, 'thali kodi'),
(1109, 'Thali'),
(1110, 'haram');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tree_struct`
--

CREATE TABLE IF NOT EXISTS `tree_struct` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `lvl` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1111 ;

--
-- Daten für Tabelle `tree_struct`
--

INSERT INTO `tree_struct` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 30, 0, 0, 0),
(1063, 2, 5, 1, 1, 0),
(1097, 6, 7, 1, 1, 1),
(1098, 8, 9, 1, 1, 2),
(1099, 10, 11, 1, 1, 3),
(1100, 12, 13, 1, 1, 4),
(1101, 14, 17, 1, 1, 5),
(1102, 18, 19, 1, 1, 6),
(1103, 20, 21, 1, 1, 7),
(1104, 22, 23, 1, 1, 8),
(1105, 3, 4, 2, 1063, 0),
(1106, 15, 16, 2, 1101, 0),
(1108, 24, 25, 1, 1, 9),
(1109, 26, 27, 1, 1, 10),
(1110, 28, 29, 1, 1, 11);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
