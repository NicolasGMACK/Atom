-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 03:37 PM
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

--
-- Dumping data for table `artigo`
--

INSERT INTO `artigo` (`ART_INT_ID`, `ART_VAR_TITULO`, `ART_VAR_DESCRICAO`, `ART_VAR_CATEGORIA`, `ART_VAR_STATUS`, `ART_VAR_ARQUIVO`, `USU_INT_ID`, `ART_DAT_POSTAGEM`) VALUES
(23, 'Mudanças Climáticas e Impactos na Agricultura: Um Estudo de Caso em Xique Xique, Bahia.', 'tanana tata', 'História', 'Concluído', 'C:/xampp/htdocs/pi-atom/Atom/uploads/selects (1).pdf', 20, '2024-11-16 11:20:31'),
(24, 'CAPELETI\'S TEORY BITCH', 'ele tem ideias.', 'Ciências', 'Em andamento', 'C:/xampp/htdocs/pi-atom/Atom/uploads/sara.pdf', 21, '2024-11-16 11:22:10');

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

--
-- Dumping data for table `comentario`
--

INSERT INTO `comentario` (`COM_INT_ID`, `COM_VAR_CONTEUDO`, `USU_INT_ID`, `ART_INT_ID`, `COM_DAT_POSTAGEM`, `COM_INT_COM_ID`) VALUES
(26, 'Boa vitinho foi bem foi bem', 20, 24, '2024-11-16 11:23:21', NULL),
(27, 'aeeee', 20, 24, '2024-11-16 11:36:09', NULL),
(28, 'ae nada maluCAO', 20, 24, '2024-11-16 11:36:17', 26),
(29, 'aeee nada nicolas, rlx', 21, 24, '2024-11-16 11:36:46', 27),
(30, 'eu realmente tenho.', 21, 24, '2024-11-16 11:36:57', NULL),
(31, 'simm', 21, 24, '2024-11-16 11:37:12', 26);

-- --------------------------------------------------------

--
-- Table structure for table `conversas`
--

CREATE TABLE `conversas` (
  `CONV_INT_ID` int(11) NOT NULL,
  `USU_INT_ID_1` int(11) NOT NULL,
  `USU_INT_ID_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversas`
--

INSERT INTO `conversas` (`CONV_INT_ID`, `USU_INT_ID_1`, `USU_INT_ID_2`) VALUES
(25, 21, 20);

-- --------------------------------------------------------

--
-- Table structure for table `mensagens`
--

CREATE TABLE `mensagens` (
  `MSG_INT_ID` int(11) NOT NULL,
  `CONV_INT_ID` int(11) DEFAULT NULL,
  `USU_INT_ID` int(11) DEFAULT NULL,
  `MSG_VAR_CONTEUDO` text DEFAULT NULL,
  `MSG_DAT_ENVIO` datetime DEFAULT current_timestamp(),
  `MSG_TIPO` enum('texto','artigo') DEFAULT 'texto',
  `MSG_ARTIGO_TOKEN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensagens`
--

INSERT INTO `mensagens` (`MSG_INT_ID`, `CONV_INT_ID`, `USU_INT_ID`, `MSG_VAR_CONTEUDO`, `MSG_DAT_ENVIO`, `MSG_TIPO`, `MSG_ARTIGO_TOKEN`) VALUES
(4, 25, 21, 'Bom dia cara', '2024-11-16 11:22:39', 'texto', NULL),
(5, 25, 21, 'Confira este artigo: <a href=\"artigo.php?token=f960b76ae7f043b4b26f587c3ba5edce\" target=\"_blank\">CAPELETI&#039;S TEORY BITCH</a>', '2024-11-16 11:22:47', 'artigo', 'f960b76ae7f043b4b26f587c3ba5edce');

-- --------------------------------------------------------

--
-- Table structure for table `tokens_artigo`
--

CREATE TABLE `tokens_artigo` (
  `TOK_ART_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `TOK_ART_VAR_TOK` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens_artigo`
--

INSERT INTO `tokens_artigo` (`TOK_ART_INT_ID`, `ART_INT_ID`, `TOK_ART_VAR_TOK`) VALUES
(27, 23, '92271ce1d5ee16583c603033113f1ed5'),
(28, 24, 'f960b76ae7f043b4b26f587c3ba5edce');

-- --------------------------------------------------------

--
-- Table structure for table `tokens_usuario`
--

CREATE TABLE `tokens_usuario` (
  `TOK_USU_INT_ID` int(11) NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `TOK_USU_VAR_TOK` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens_usuario`
--

INSERT INTO `tokens_usuario` (`TOK_USU_INT_ID`, `USU_INT_ID`, `TOK_USU_VAR_TOK`) VALUES
(20, 19, '70bb676e303ecf5a9fe416cb794a6bfb'),
(21, 20, 'e97a8a024b37db81a45a65738709b63f'),
(22, 21, 'b2b5c0dbe70b0b48f777ab2c2622fb5c');

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

--
-- Dumping data for table `upvote`
--

INSERT INTO `upvote` (`UP_INT_ID`, `UP_USU_INT_ID`, `UP_ART_INT_ID`, `UP_DAT_DATA`) VALUES
(42, 21, 23, '2024-11-16 11:37:24');

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
  `USU_VAR_IMGBACK` varchar(255) DEFAULT NULL,
  `USU_VAR_DESC` varchar(255) DEFAULT NULL,
  `USU_VAR_CIDADE` varchar(50) DEFAULT NULL,
  `USU_VAR_OCUPACAO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`USU_INT_ID`, `USU_VAR_NAME`, `USU_VAR_EMAIL`, `USU_VAR_PASSWORD`, `USU_VAR_IMGPERFIL`, `USU_VAR_IMGBACK`, `USU_VAR_DESC`, `USU_VAR_CIDADE`, `USU_VAR_OCUPACAO`) VALUES
(20, 'MRFREEZE', 'nicolasgmack@gmail.com', '$2y$10$AhhXQ1DerspAN4Rf9aSvt.If.h1/L86/C7l/3YkPFY6PvZoDgyjsS', '/pi-atom/Atom/uploads/perfis/6738a9d9602e8_67350516bb689_6731f5d747b77_mrfreeze-corpo-removebg-preview.png', '/pi-atom/Atom/uploads/perfis/6738a9d96056b_67350516bb318_6731f630a924a_mrfreeze-inteiro-preto.png', 'the freezer mister', 'gelo', 'gelado'),
(21, 'Vitor Capeleti', 'v@gmail.com', '$2y$10$nvfLGJdwwjHs8PVaA.036eUi34wq.cFImXPb2wg2Wl7lpzhTwbZ6y', '/pi-atom/Atom/uploads/perfis/6738aa6e1c175_67314d609936a_capeleti.png', '/pi-atom/Atom/uploads/perfis/6738aa6e1c4a2_6731524473ec4_fundo-login.png', 'the vitor capeleti, diferente dos demais. GOAT!', 'cidado', 'ele tem');

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
-- Indexes for table `conversas`
--
ALTER TABLE `conversas`
  ADD PRIMARY KEY (`CONV_INT_ID`),
  ADD KEY `USU_INT_ID_1` (`USU_INT_ID_1`),
  ADD KEY `USU_INT_ID_2` (`USU_INT_ID_2`);

--
-- Indexes for table `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`MSG_INT_ID`),
  ADD KEY `CONV_INT_ID` (`CONV_INT_ID`),
  ADD KEY `USU_INT_ID` (`USU_INT_ID`),
  ADD KEY `MSG_ARTIGO_TOKEN` (`MSG_ARTIGO_TOKEN`);

--
-- Indexes for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  ADD PRIMARY KEY (`TOK_ART_INT_ID`),
  ADD UNIQUE KEY `TOK_ART_VAR_TOK` (`TOK_ART_VAR_TOK`),
  ADD KEY `artigo_id` (`ART_INT_ID`);

--
-- Indexes for table `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  ADD PRIMARY KEY (`TOK_USU_INT_ID`);

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
  MODIFY `ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `COM_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `conversas`
--
ALTER TABLE `conversas`
  MODIFY `CONV_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `MSG_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  MODIFY `TOK_ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  MODIFY `TOK_USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `upvote`
--
ALTER TABLE `upvote`
  MODIFY `UP_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artigo`
--
ALTER TABLE `artigo`
  ADD CONSTRAINT `artigo_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_3` FOREIGN KEY (`COM_INT_COM_ID`) REFERENCES `comentario` (`COM_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `conversas`
--
ALTER TABLE `conversas`
  ADD CONSTRAINT `conversas_ibfk_1` FOREIGN KEY (`USU_INT_ID_1`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversas_ibfk_2` FOREIGN KEY (`USU_INT_ID_2`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  ADD CONSTRAINT `tokens_artigo_ibfk_1` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `upvote`
--
ALTER TABLE `upvote`
  ADD CONSTRAINT `upvote_ibfk_1` FOREIGN KEY (`UP_USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `upvote_ibfk_2` FOREIGN KEY (`UP_ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
