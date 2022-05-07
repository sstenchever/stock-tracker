-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2022 at 08:52 PM
-- Server version: 10.5.13-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u511358360_stock_tracker`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`u511358360_steve`@`127.0.0.1` PROCEDURE `create_open_stock_trade` (IN `username` VARCHAR(255), IN `user_shares` DECIMAL(10,2), IN `user_ticker` CHAR(5), IN `user_purchasePrice` DECIMAL(10,2), IN `user_currentPrice` DECIMAL(10,2), OUT `pstatus` VARCHAR(255))  BEGIN
  SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
  IF total_user_profit_loss(username) > -10000 THEN
    INSERT INTO open_stock_trades (dateOpened, shares, ticker, purchasePrice, currentPrice)
      VALUES (CURRENT_DATE, user_shares, user_ticker, user_purchasePrice, user_currentPrice);
      SET pstatus = 'Good job not losing too much money. We''ve added your trade.';
  ELSE
    SET pstatus = 'You''ve lost a lot of money already. Consider taking a break. Trade not added.';
  END IF;
  COMMIT;
END$$

--
-- Functions
--
CREATE DEFINER=`u511358360_steve`@`127.0.0.1` FUNCTION `total_user_profit_loss` (`username` VARCHAR(255)) RETURNS DECIMAL(10,2) BEGIN
  DECLARE open_stock_pl DECIMAL(10,2);
  DECLARE closed_stock_pl DECIMAL(10,2);
  DECLARE open_options_pl DECIMAL(10,2);
  DECLARE closed_options_pl DECIMAL(10,2);
  DECLARE total_pl DECIMAL(10,2);
  
  SET open_stock_pl = (SELECT SUM(openProfitLoss) FROM user_open_stock_trades WHERE user_username=username);
  IF open_stock_pl IS NULL THEN SET open_stock_pl = 0;
  END IF;
  SET closed_stock_pl = (SELECT SUM(closedProfitLoss) FROM user_closed_stock_trades WHERE user_username=username);
  IF closed_stock_pl IS NULL THEN SET closed_stock_pl = 0;
  END IF;
  SET open_options_pl = (SELECT SUM(openProfitLoss) FROM user_open_options_trades WHERE user_username=username);
  IF open_options_pl IS NULL THEN SET open_options_pl = 0;
  END IF;
  SET closed_options_pl = (SELECT SUM(closedProfitLoss) FROM user_closed_options_trades WHERE user_username=username);
  IF closed_options_pl IS NULL THEN SET closed_options_pl = 0;
  END IF;
  
  SET total_pl = open_stock_pl + closed_stock_pl + open_options_pl + closed_options_pl;
  RETURN total_pl;
END$$

CREATE DEFINER=`u511358360_steve`@`127.0.0.1` FUNCTION `total_user_trades` (`username` VARCHAR(255)) RETURNS INT(11) BEGIN
    DECLARE l_open_stock INT;
    DECLARE l_closed_stock INT;
    DECLARE l_open_options INT;
    DECLARE l_closed_options INT;
    DECLARE l_total_trades INT;
    SET l_open_stock = (SELECT COUNT(*) FROM user_open_stock_trades WHERE user_username=username);
    SET l_closed_stock = (SELECT COUNT(*) FROM user_closed_stock_trades WHERE user_username=username);
    SET l_open_options = (SELECT COUNT(*) FROM user_open_options_trades WHERE user_username=username);
    SET l_closed_options = (SELECT COUNT(*) FROM user_closed_options_trades WHERE user_username=username);
    SET l_total_trades = l_open_stock + l_closed_stock + l_open_options + l_closed_options;
    RETURN l_total_trades;   
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `closed_options_trades`
--

CREATE TABLE `closed_options_trades` (
  `dateClosed` date DEFAULT NULL,
  `contracts` decimal(10,0) NOT NULL,
  `ticker` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchasePrice` decimal(10,2) NOT NULL,
  `sellPrice` decimal(10,2) NOT NULL,
  `transactionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closed_options_trades`
--

INSERT INTO `closed_options_trades` (`dateClosed`, `contracts`, `ticker`, `contract_type`, `purchasePrice`, `sellPrice`, `transactionId`) VALUES
('2022-05-04', '2', 'AMD220506C00092000	', 'CALL', '6.70', '3.80', 2),
('2022-05-06', '2', 'QQQ220509C00310000', 'CALL', '10.00', '2.49', 3);

-- --------------------------------------------------------

--
-- Table structure for table `closed_stock_trades`
--

CREATE TABLE `closed_stock_trades` (
  `dateClosed` date DEFAULT NULL,
  `shares` decimal(10,2) NOT NULL,
  `ticker` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchasePrice` decimal(10,2) NOT NULL,
  `sellPrice` decimal(10,2) NOT NULL,
  `transactionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `closed_stock_trades`
--

INSERT INTO `closed_stock_trades` (`dateClosed`, `shares`, `ticker`, `purchasePrice`, `sellPrice`, `transactionId`) VALUES
('2022-05-01', '500.00', 'DWAC', '50.00', '40.00', 4),
('2021-04-22', '200.00', 'NET', '23.00', '130.00', 5),
('2021-07-25', '150.00', 'AAPL', '87.00', '140.00', 6),
('2021-04-25', '400.00', 'BB', '18.00', '7.60', 7),
('2020-06-07', '400.00', 'PLTR', '20.00', '14.00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `open_options_trades`
--

CREATE TABLE `open_options_trades` (
  `dateOpened` date DEFAULT NULL,
  `contracts` decimal(10,0) NOT NULL,
  `ticker` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchasePrice` decimal(10,2) NOT NULL,
  `currentPrice` decimal(10,2) NOT NULL,
  `transactionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `open_options_trades`
--

INSERT INTO `open_options_trades` (`dateOpened`, `contracts`, `ticker`, `contract_type`, `purchasePrice`, `currentPrice`, `transactionId`) VALUES
('2022-04-28', '10', 'AAPL220506C00100000', 'CALL', '60.00', '62.01', 1),
('2022-05-02', '1', 'QQQ220506C00313000', 'CALL', '6.25', '4.37', 4),
('2022-05-06', '5', 'QQQ220509C00307000	', 'CALL', '11.00', '4.30', 5);

-- --------------------------------------------------------

--
-- Table structure for table `open_stock_trades`
--

CREATE TABLE `open_stock_trades` (
  `dateOpened` date DEFAULT NULL,
  `shares` decimal(10,2) NOT NULL,
  `ticker` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchasePrice` decimal(10,2) NOT NULL,
  `currentPrice` decimal(10,2) NOT NULL,
  `transactionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `open_stock_trades`
--

INSERT INTO `open_stock_trades` (`dateOpened`, `shares`, `ticker`, `purchasePrice`, `currentPrice`, `transactionId`) VALUES
('2022-04-28', '100.00', 'AAPL', '160.00', '163.64', 1),
('2022-04-28', '150.00', 'SNAP', '14.00', '28.81', 3),
('0000-00-00', '2000.00', 'CAT', '222.00', '215.93', 5),
('2021-11-26', '10.00', 'SHOP', '910.00', '405.00', 6),
('2020-05-20', '50.00', 'TGT', '65.52', '220.11', 7),
(NULL, '100.00', 'FB', '300.00', '190.00', 8),
('2022-05-06', '150.00', 'STOR', '29.00', '28.50', 9),
('2022-05-07', '10.00', 'GOOG', '2400.00', '2350.00', 10),
('2022-05-07', '45.00', 'CLF', '16.00', '23.00', 12),
('2022-05-07', '100.00', 'AAPL', '100.00', '150.00', 18),
('2022-05-07', '100.00', 'AAPL', '150.00', '155.00', 19);

-- --------------------------------------------------------

--
-- Stand-in structure for view `open_stock_trades_per_user`
-- (See below for the actual view)
--
CREATE TABLE `open_stock_trades_per_user` (
`username` varchar(255)
,`total_trades` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`) VALUES
(36, 'Joe', 'Byron', 'lets_go_joe'),
(37, 'Donnie', 'Azoff', 'donnie_tradez'),
(38, 'Steve', 'NO', 'steveo'),
(41, 'Cathie', 'Wood', 'the_ark_princess'),
(42, 'Jim', 'Cramer', 'sad_money_cramer');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `update_user` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
	INSERT INTO user_audit (user_id, old_firstname, old_lastname, old_username) VALUES (old.user_id, old.firstname, old.lastname, old.username);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_audit`
--

CREATE TABLE `user_audit` (
  `user_id` int(11) DEFAULT NULL,
  `old_firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_audit`
--

INSERT INTO `user_audit` (`user_id`, `old_firstname`, `old_lastname`, `old_username`) VALUES
(37, 'Donnie', 'Darko', 'donnie_tradez'),
(36, 'Tim', 'Byron', 'lets_go_joe'),
(44, 'Joe', 'Brown', 'joe_b'),
(45, 'Joe', 'Brown', 'joe_b'),
(46, 'joe', 'brown', 'joe_b'),
(38, 'Steve', 'O', 'steve'),
(38, 'Steve', 'O', 'steveo');

-- --------------------------------------------------------

--
-- Table structure for table `user_closed_options_trades`
--

CREATE TABLE `user_closed_options_trades` (
  `closed_options_trades_transactionId` int(11) NOT NULL,
  `user_user_id` int(11) NOT NULL,
  `user_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closedProfitLoss` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_closed_options_trades`
--

INSERT INTO `user_closed_options_trades` (`closed_options_trades_transactionId`, `user_user_id`, `user_username`, `closedProfitLoss`) VALUES
(2, 38, 'steve', '-580.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_closed_stock_trades`
--

CREATE TABLE `user_closed_stock_trades` (
  `closed_stock_trades_transactionId` int(11) NOT NULL,
  `user_user_id` int(11) NOT NULL,
  `user_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closedProfitLoss` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_closed_stock_trades`
--

INSERT INTO `user_closed_stock_trades` (`closed_stock_trades_transactionId`, `user_user_id`, `user_username`, `closedProfitLoss`) VALUES
(5, 38, 'steve', '21400.00'),
(6, 38, 'steve', '7950.00'),
(7, 42, 'sad_money_cramer', '-4160.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_open_options_trades`
--

CREATE TABLE `user_open_options_trades` (
  `open_options_trades_transactionId` int(11) NOT NULL,
  `user_user_id` int(11) NOT NULL,
  `user_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openProfitLoss` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_open_options_trades`
--

INSERT INTO `user_open_options_trades` (`open_options_trades_transactionId`, `user_user_id`, `user_username`, `openProfitLoss`) VALUES
(1, 36, 'lets_go_joe', '2010.00'),
(4, 38, 'steve', '-188.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_open_stock_trades`
--

CREATE TABLE `user_open_stock_trades` (
  `open_stock_trades_transactionId` int(11) NOT NULL,
  `user_user_id` int(11) NOT NULL,
  `user_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openProfitLoss` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_open_stock_trades`
--

INSERT INTO `user_open_stock_trades` (`open_stock_trades_transactionId`, `user_user_id`, `user_username`, `openProfitLoss`) VALUES
(1, 37, 'donnie_tradez', '364.00'),
(3, 37, 'donnie_tradez', '2221.50'),
(7, 38, 'steve', '7729.50'),
(10, 38, 'steve', '-500.00'),
(5, 41, 'the_ark_princess', '-12140.00'),
(6, 41, 'the_ark_princess', '-5050.00');

-- --------------------------------------------------------

--
-- Structure for view `open_stock_trades_per_user`
--
DROP TABLE IF EXISTS `open_stock_trades_per_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u511358360_steve`@`127.0.0.1` SQL SECURITY DEFINER VIEW `open_stock_trades_per_user`  AS SELECT `A`.`username` AS `username`, count(0) AS `total_trades` FROM (`user` `A` join `user_closed_stock_trades` `B` on(`A`.`user_id` = `B`.`user_user_id`)) GROUP BY `A`.`username` ORDER BY count(0) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `closed_options_trades`
--
ALTER TABLE `closed_options_trades`
  ADD PRIMARY KEY (`transactionId`),
  ADD UNIQUE KEY `transactionId` (`transactionId`);

--
-- Indexes for table `closed_stock_trades`
--
ALTER TABLE `closed_stock_trades`
  ADD PRIMARY KEY (`transactionId`),
  ADD UNIQUE KEY `transactionId` (`transactionId`);

--
-- Indexes for table `open_options_trades`
--
ALTER TABLE `open_options_trades`
  ADD PRIMARY KEY (`transactionId`),
  ADD UNIQUE KEY `transactionId` (`transactionId`);

--
-- Indexes for table `open_stock_trades`
--
ALTER TABLE `open_stock_trades`
  ADD PRIMARY KEY (`transactionId`),
  ADD UNIQUE KEY `transactionId` (`transactionId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_closed_options_trades`
--
ALTER TABLE `user_closed_options_trades`
  ADD PRIMARY KEY (`user_user_id`,`closed_options_trades_transactionId`),
  ADD KEY `fk_user_closed_options_trades_closed_options_trades1` (`closed_options_trades_transactionId`);

--
-- Indexes for table `user_closed_stock_trades`
--
ALTER TABLE `user_closed_stock_trades`
  ADD PRIMARY KEY (`user_user_id`,`closed_stock_trades_transactionId`),
  ADD KEY `fk_user_closed_stock_trades_closed_stock_trades1` (`closed_stock_trades_transactionId`);

--
-- Indexes for table `user_open_options_trades`
--
ALTER TABLE `user_open_options_trades`
  ADD PRIMARY KEY (`user_user_id`,`open_options_trades_transactionId`),
  ADD KEY `fk_user_open_options_trades_open_options_trades1` (`open_options_trades_transactionId`);

--
-- Indexes for table `user_open_stock_trades`
--
ALTER TABLE `user_open_stock_trades`
  ADD PRIMARY KEY (`user_user_id`,`open_stock_trades_transactionId`),
  ADD UNIQUE KEY `open_stock_trades_transactionId` (`open_stock_trades_transactionId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `closed_options_trades`
--
ALTER TABLE `closed_options_trades`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `closed_stock_trades`
--
ALTER TABLE `closed_stock_trades`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `open_options_trades`
--
ALTER TABLE `open_options_trades`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `open_stock_trades`
--
ALTER TABLE `open_stock_trades`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_closed_options_trades`
--
ALTER TABLE `user_closed_options_trades`
  ADD CONSTRAINT `fk_user_closed_options_trades_closed_options_trades1` FOREIGN KEY (`closed_options_trades_transactionId`) REFERENCES `closed_options_trades` (`transactionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_closed_options_trades_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_closed_stock_trades`
--
ALTER TABLE `user_closed_stock_trades`
  ADD CONSTRAINT `fk_user_closed_stock_trades_closed_stock_trades1` FOREIGN KEY (`closed_stock_trades_transactionId`) REFERENCES `closed_stock_trades` (`transactionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_closed_stock_trades_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_open_options_trades`
--
ALTER TABLE `user_open_options_trades`
  ADD CONSTRAINT `fk_user_open_options_trades_open_options_trades1` FOREIGN KEY (`open_options_trades_transactionId`) REFERENCES `open_options_trades` (`transactionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_open_options_trades_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_open_stock_trades`
--
ALTER TABLE `user_open_stock_trades`
  ADD CONSTRAINT `fk_user_open_stock_trades_open_stock_trades1` FOREIGN KEY (`open_stock_trades_transactionId`) REFERENCES `open_stock_trades` (`transactionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_open_stock_trades_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
