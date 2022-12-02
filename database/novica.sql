-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2016 at 08:03 PM
-- Server version: 5.5.41
-- PHP Version: 5.5.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `novica`
--

-- --------------------------------------------------------

--
-- Table structure for table `klijenti`
--

CREATE TABLE IF NOT EXISTS `klijenti` (
  `idKlijent` int(32) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `jmbg` int(13) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `rights` tinyint(1) NOT NULL DEFAULT '0',
  `obrisan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `klijenti`
--

INSERT INTO `klijenti` (`idKlijent`, `ime`, `prezime`, `jmbg`, `username`, `password`, `rights`, `obrisan`) VALUES
(2, 'Aleksandar', 'Stankovic', 2147483647, 'akusawa', '123', 2, 0),
(7, 'Pera', 'Ovuka', 2147483647, 'Pele', '123', 1, 0),
(10, 'TestUser', 'Test', 1231231253, 'Test', '123', 2, 0),
(42, 'Dejan', 'Novovic', 12345678, 'Deki', '2345', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE IF NOT EXISTS `rent` (
  `idRent` int(11) NOT NULL,
  `idKlijent` int(11) NOT NULL,
  `idVozilo` int(11) NOT NULL,
  `pocetniDatum` date NOT NULL,
  `krajnjiDatum` date NOT NULL,
  `vracen` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`idRent`, `idKlijent`, `idVozilo`, `pocetniDatum`, `krajnjiDatum`, `vracen`) VALUES
(84, 2, 1, '2016-04-01', '2016-04-09', 0),
(85, 2, 2, '2016-04-06', '2016-04-09', 0),
(86, 2, 24, '2016-04-09', '2016-04-29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `servisiranje`
--

CREATE TABLE IF NOT EXISTS `servisiranje` (
  `idServisiranja` int(11) NOT NULL,
  `pocetakServisiranja` date DEFAULT NULL,
  `krajServisiranja` date DEFAULT NULL,
  `promene` text,
  `cena` double DEFAULT NULL,
  `idVozila` int(11) NOT NULL,
  `naServisiranju` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servisiranje`
--

INSERT INTO `servisiranje` (`idServisiranja`, `pocetakServisiranja`, `krajServisiranja`, `promene`, `cena`, `idVozila`, `naServisiranju`) VALUES
(2, '2016-04-15', '2016-04-17', 'Akumulator, prozor, sedista, sve i svasta, ulje, gorivo', 22, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vozilo`
--

CREATE TABLE IF NOT EXISTS `vozilo` (
  `idVozila` int(11) NOT NULL,
  `nazivVozila` varchar(32) NOT NULL,
  `godisteVozila` int(11) NOT NULL,
  `opisVozila` text NOT NULL,
  `iznajmljen` tinyint(1) NOT NULL DEFAULT '0',
  `obrisan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vozilo`
--

INSERT INTO `vozilo` (`idVozila`, `nazivVozila`, `godisteVozila`, `opisVozila`, `iznajmljen`, `obrisan`) VALUES
(1, 'Automobila', 2003, 'Random', 0, 0),
(2, 'Second car', 2009, 'Random', 0, 0),
(22, 'Third Car', 2015, 'Nema opisa', 0, 0),
(23, 'Almost Final', 2004, 'Random Description', 0, 0),
(24, 'Rented car', 2011, 'Neki random', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klijenti`
--
ALTER TABLE `klijenti`
  ADD PRIMARY KEY (`idKlijent`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`idRent`),
  ADD KEY `idVozilo` (`idVozilo`),
  ADD KEY `idKlijent` (`idKlijent`);

--
-- Indexes for table `servisiranje`
--
ALTER TABLE `servisiranje`
  ADD PRIMARY KEY (`idServisiranja`),
  ADD KEY `naServisiranju` (`naServisiranju`),
  ADD KEY `idVozila` (`idVozila`),
  ADD KEY `idVozila_2` (`idVozila`);

--
-- Indexes for table `vozilo`
--
ALTER TABLE `vozilo`
  ADD PRIMARY KEY (`idVozila`),
  ADD KEY `obrisan` (`obrisan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klijenti`
--
ALTER TABLE `klijenti`
  MODIFY `idKlijent` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `idRent` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `servisiranje`
--
ALTER TABLE `servisiranje`
  MODIFY `idServisiranja` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vozilo`
--
ALTER TABLE `vozilo`
  MODIFY `idVozila` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`idKlijent`) REFERENCES `klijenti` (`idKlijent`),
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`idVozilo`) REFERENCES `vozilo` (`idVozila`);

--
-- Constraints for table `servisiranje`
--
ALTER TABLE `servisiranje`
  ADD CONSTRAINT `servisiranje_ibfk_1` FOREIGN KEY (`idServisiranja`) REFERENCES `vozilo` (`idVozila`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
