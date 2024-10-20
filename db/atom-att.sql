-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 01:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atom`
--

-- --------------------------------------------------------

--
-- Table structure for table `artigo`
--

CREATE TABLE `artigo` (
  `ART_INT_ID` int(11) NOT NULL,
  `ART_VAR_TITULO` varchar(250) NOT NULL,
  `ART_VAR_DESCRICAO` varchar(2000) NOT NULL,
  `ART_VAR_CATEGORIA` varchar(50) NOT NULL,
  `ART_VAR_STATUS` varchar(12) NOT NULL,
  `ART_VAR_ARQUIVO` varchar(500) NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `ART_DAT_POSTAGEM` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE `comentario` (
  `COM_INT_ID` int(11) NOT NULL,
  `COM_VAR_CONTEUDO` text NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `COM_DAT_POSTAGEM` datetime DEFAULT current_timestamp(),
  `COM_INT_COM_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `TOK_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `TOK_VAR_TOK` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upvote`
--

CREATE TABLE `upvote` (
  `UP_INT_ID` int(11) NOT NULL,
  `UP_USU_INT_ID` int(11) DEFAULT NULL,
  `UP_ART_INT_ID` int(11) DEFAULT NULL,
  `UP_DAT_DATA` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `USU_INT_ID` int(11) NOT NULL,
  `USU_VAR_NAME` varchar(50) NOT NULL,
  `USU_VAR_EMAIL` varchar(100) NOT NULL,
  `USU_VAR_PASSWORD` varchar(255) NOT NULL,
  `USU_VAR_IMGPERFIL` varchar(255) DEFAULT NULL,
  `USU_VAR_IMGBACK` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artigo`
--
ALTER TABLE `artigo`
  ADD PRIMARY KEY (`ART_INT_ID`),
  ADD KEY `USU_INT_ID` (`USU_INT_ID`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`COM_INT_ID`),
  ADD KEY `USU_INT_ID` (`USU_INT_ID`),
  ADD KEY `ART_INT_ID` (`ART_INT_ID`),
  ADD KEY `COM_INT_COM_ID` (`COM_INT_COM_ID`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`TOK_INT_ID`),
  ADD KEY `artigo_id` (`ART_INT_ID`);

--
-- Indexes for table `upvote`
--
ALTER TABLE `upvote`
  ADD PRIMARY KEY (`UP_INT_ID`),
  ADD KEY `UP_USU_INT_ID` (`UP_USU_INT_ID`),
  ADD KEY `UP_ART_INT_ID` (`UP_ART_INT_ID`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`USU_INT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artigo`
--
ALTER TABLE `artigo`
  MODIFY `ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `COM_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `TOK_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upvote`
--
ALTER TABLE `upvote`
  MODIFY `UP_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artigo`
--
ALTER TABLE `artigo`
  ADD CONSTRAINT `artigo_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`);

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`),
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`),
  ADD CONSTRAINT `comentario_ibfk_3` FOREIGN KEY (`COM_INT_COM_ID`) REFERENCES `comentario` (`COM_INT_ID`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`);

--
-- Constraints for table `upvote`
--
ALTER TABLE `upvote`
  ADD CONSTRAINT `upvote_ibfk_1` FOREIGN KEY (`UP_USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`),
  ADD CONSTRAINT `upvote_ibfk_2` FOREIGN KEY (`UP_ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
