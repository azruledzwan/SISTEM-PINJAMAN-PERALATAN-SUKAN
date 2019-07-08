-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2019 at 10:45 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alatansukan`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategoripeminjam`
--

CREATE TABLE IF NOT EXISTS `kategoripeminjam` (
  `idkategoripeminjam` varchar(5) NOT NULL,
  `kategoripeminjam` varchar(20) NOT NULL,
  PRIMARY KEY (`idkategoripeminjam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategoripeminjam`
--

INSERT INTO `kategoripeminjam` (`idkategoripeminjam`, `kategoripeminjam`) VALUES
('GR', 'Guru'),
('JL', 'Jurulatih Luar'),
('MD', 'Murid');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `idpengguna` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nokp` varchar(12) NOT NULL,
  PRIMARY KEY (`idpengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`idpengguna`, `username`, `password`, `nokp`) VALUES
(1, 'azruledzwan', '123', '970617095183');

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE IF NOT EXISTS `peminjam` (
  `nokppeminjam` varchar(12) NOT NULL,
  `namapeminjam` varchar(100) NOT NULL,
  `notelpeminjam` varchar(20) NOT NULL,
  `gambar` mediumblob NOT NULL,
  `idkategoripeminjam` varchar(10) NOT NULL,
  PRIMARY KEY (`nokppeminjam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`nokppeminjam`, `namapeminjam`, `notelpeminjam`, `gambar`, `idkategoripeminjam`) VALUES
('970617095183', 'azruledzwan', '0134871069', 0x38386335376364372d623432352d346131372d383432632d6332653534333565656237382e6a7067, 'GR');

-- --------------------------------------------------------

--
-- Table structure for table `peralatan`
--

CREATE TABLE IF NOT EXISTS `peralatan` (
  `idperalatan` int(11) NOT NULL AUTO_INCREMENT,
  `kodperalatan` varchar(15) NOT NULL,
  `namaperalatan` varchar(50) NOT NULL,
  `jenamaperalatan` varchar(50) NOT NULL,
  `bilanganstok` varchar(4) NOT NULL,
  PRIMARY KEY (`idperalatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `peralatan`
--

INSERT INTO `peralatan` (`idperalatan`, `kodperalatan`, `namaperalatan`, `jenamaperalatan`, `bilanganstok`) VALUES
(1, 'BB', 'BOLA BALING', 'MOLTEN', '10'),
(2, 'BH', 'BOLA HOKI', 'ALFA', '10'),
(3, 'BS', 'BOLA SEPAK', 'ADIDAS', '15'),
(4, 'KH', 'KAYU HOKI', 'MAHARADJA', '30');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE IF NOT EXISTS `pinjaman` (
  `idpinjaman` int(11) NOT NULL AUTO_INCREMENT,
  `nokppeminjam` varchar(12) NOT NULL,
  `kodperalatan` varchar(10) NOT NULL,
  `tujuanpinjaman` varchar(100) NOT NULL,
  `kuantitipinjam` int(5) NOT NULL,
  `tarikhpinjam` date NOT NULL,
  `kuantitipulang` varchar(10) NOT NULL,
  `tarikhpulang` date NOT NULL,
  `statusperalatanrosak` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`idpinjaman`),
  KEY `nokppeminjam` (`nokppeminjam`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`idpinjaman`, `nokppeminjam`, `kodperalatan`, `tujuanpinjaman`, `kuantitipinjam`, `tarikhpinjam`, `kuantitipulang`, `tarikhpulang`, `statusperalatanrosak`, `status`) VALUES
(1, '970617095183', 'BB', 'hari sukan sekolah', 10, '2019-06-27', '10', '2019-06-29', 'TIDAK ROSAK', 'SUDAH PULANG'),
(2, '970617095183', 'BH', 'sukaneka', 50, '2019-06-14', '', '0000-00-00', '', 'BELUM PULANG'),
(3, '970617095183', 'BS', 'hari kantin', 15, '2019-06-14', '', '0000-00-00', '', 'BELUM PULANG'),
(4, '970617095183', 'KH', 'sukan balapan dan padang', 10, '2019-06-08', '', '0000-00-00', '', 'BELUM PULANG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
