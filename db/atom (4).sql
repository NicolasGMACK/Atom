-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 10:02 PM
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
(25, 'ATOMICOS GUYS', 'kkk', 'História', 'Em andamento', 'C:/xampp/htdocs/pi-atom/Atom/uploads/Aula 21 -  Desenvolvimento de Indicadores e Definição de Metas -v1.pdf', 22, '2024-11-16 12:31:32'),
(29, 'Mudanças Climáticas e Impactos na Agricultura: Um Estudo de Caso em Xique Xique, Bahia.', 'www', 'História', 'Em andamento', 'C:/xampp/htdocs/pi-atom/Atom/uploads/Aula 04 - Revisao MVC e Criando Servlet Pratica (1).pdf', 20, '2024-11-16 14:35:39'),
(30, 'ANIVERSARIO DA SARA', 'www', 'História', 'Em andamento', 'C:/xampp/htdocs/pi-atom/Atom/uploads/documentos.pdf', 22, '2024-11-16 17:03:23'),
(35, 'jjjjjjjjjj', 'jjjjjjjjjjjjjjjjjj', 'Ciências', 'Em andamento', 'C:/xampp/htdocs/pi-atom/Atom/uploads/sara (1).pdf', 23, '2024-11-17 17:36:10');

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
(30, 22, 20),
(31, 22, 21),
(32, 21, 20),
(33, 23, 22),
(34, 23, 21);

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
(90, 32, 20, 'eae', '2024-11-17 17:57:22', 'texto', 'd7d1b024a0908861b1f1ee8c82addcca'),
(91, 32, 20, 'bobo', '2024-11-17 17:57:26', 'texto', 'd7d1b024a0908861b1f1ee8c82addcca'),
(92, 32, 21, 'bobo é voce canalha', '2024-11-17 17:57:54', 'texto', 'd7d1b024a0908861b1f1ee8c82addcca'),
(93, 32, 21, 'Confira este artigo: <a href=\"artigo.php?token=fd663acb8ceb7f3128543ead887f9880\" target=\"_blank\">jjjjjjjjjj</a>', '2024-11-17 17:57:59', 'artigo', 'fd663acb8ceb7f3128543ead887f9880'),
(94, 32, 21, '<a href=\"faz o l\">eae</a>', '2024-11-17 17:58:06', 'texto', 'd7d1b024a0908861b1f1ee8c82addcca');

-- --------------------------------------------------------

--
-- Table structure for table `salvar`
--

CREATE TABLE `salvar` (
  `SALVAR_INT_ID` int(11) NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `SALVAR_DAT_CRIACAO` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salvar`
--

INSERT INTO `salvar` (`SALVAR_INT_ID`, `USU_INT_ID`, `ART_INT_ID`, `SALVAR_DAT_CRIACAO`) VALUES
(89, 22, 25, '2024-11-16 20:30:34'),
(98, 20, 29, '2024-11-16 20:45:02'),
(209, 23, 30, '2024-11-17 11:59:16'),
(210, 23, 29, '2024-11-17 11:59:18'),
(211, 23, 25, '2024-11-17 11:59:19');

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
(62, 30, 'a0def0e31e2737846470d4742282486e'),
(63, 29, 'a724a708ab8e263b7875f6a30bb375eb'),
(64, 25, '7f266c59f54659cb0694d962ec8fbf8f'),
(67, 35, 'fd663acb8ceb7f3128543ead887f9880');

-- --------------------------------------------------------

--
-- Table structure for table `tokens_conversa`
--

CREATE TABLE `tokens_conversa` (
  `TOK_CON_INT_ID` int(11) NOT NULL,
  `CONV_INT_ID` int(11) NOT NULL,
  `TOK_CON_VAR_TOK` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens_conversa`
--

INSERT INTO `tokens_conversa` (`TOK_CON_INT_ID`, `CONV_INT_ID`, `TOK_CON_VAR_TOK`) VALUES
(6, 30, '1aa7cc1a4f44d7a039b56488fb182452'),
(7, 31, '88b96db45e6746aea78a9b1bfa0b0bbc'),
(8, 32, 'd7d1b024a0908861b1f1ee8c82addcca'),
(9, 33, '879f3346e2e937a7d36e65f387fa4671'),
(10, 34, '6f160d8bf12838d38adaea5aa6128e34');

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
(21, 20, 'e97a8a024b37db81a45a65738709b63f'),
(22, 21, 'b2b5c0dbe70b0b48f777ab2c2622fb5c'),
(23, 22, '10f30d689b97cbe5f0a5b40fdebee2bd'),
(24, 23, 'f104f4ff2d044fe81ef6b284ac190be5');

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
(48, 22, 30, '2024-11-16 17:30:56');

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
(21, 'Vitor Capeleti', 'v@gmail.com', '$2y$10$nvfLGJdwwjHs8PVaA.036eUi34wq.cFImXPb2wg2Wl7lpzhTwbZ6y', '/pi-atom/Atom/uploads/perfis/6738aa6e1c175_67314d609936a_capeleti.png', '/pi-atom/Atom/uploads/perfis/6738aa6e1c4a2_6731524473ec4_fundo-login.png', 'the vitor capeleti, diferente dos demais. GOAT!', 'cidado', 'ele tem'),
(22, 'Kayky Paiva', 'k@gmail.com', '$2y$10$GPxJJTGEe0RCCVG7YGBK6ONI7QOJcSgdM2XVgMusacVmpItCE8Pqy', '/pi-atom/Atom/uploads/perfis/6738fd534cd64_task.png', NULL, 'Sem descrição.', 'Não especificado.', 'Não especificado.'),
(23, 'Tirano', 't@gmail.com', '$2y$10$cELom.ZbciiN6ILJo5WjAOyqkSOzuLpq/mEP5irmXGI3i346HHRoy', NULL, NULL, 'Sem descrição.', 'Não especificado.', 'Não especificado.');

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
-- Indexes for table `salvar`
--
ALTER TABLE `salvar`
  ADD PRIMARY KEY (`SALVAR_INT_ID`),
  ADD KEY `USU_INT_ID` (`USU_INT_ID`),
  ADD KEY `ART_INT_ID` (`ART_INT_ID`);

--
-- Indexes for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  ADD PRIMARY KEY (`TOK_ART_INT_ID`),
  ADD KEY `artigo_id` (`ART_INT_ID`);

--
-- Indexes for table `tokens_conversa`
--
ALTER TABLE `tokens_conversa`
  ADD PRIMARY KEY (`TOK_CON_INT_ID`),
  ADD KEY `CONV_INT_ID` (`CONV_INT_ID`);

--
-- Indexes for table `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  ADD PRIMARY KEY (`TOK_USU_INT_ID`),
  ADD KEY `tokens_usuario_ibfk_1` (`USU_INT_ID`);

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
  MODIFY `ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `COM_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `conversas`
--
ALTER TABLE `conversas`
  MODIFY `CONV_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `MSG_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `salvar`
--
ALTER TABLE `salvar`
  MODIFY `SALVAR_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  MODIFY `TOK_ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tokens_conversa`
--
ALTER TABLE `tokens_conversa`
  MODIFY `TOK_CON_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  MODIFY `TOK_USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `upvote`
--
ALTER TABLE `upvote`
  MODIFY `UP_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- Constraints for table `salvar`
--
ALTER TABLE `salvar`
  ADD CONSTRAINT `salvar_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `salvar_ibfk_2` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tokens_artigo`
--
ALTER TABLE `tokens_artigo`
  ADD CONSTRAINT `tokens_artigo_ibfk_1` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tokens_conversa`
--
ALTER TABLE `tokens_conversa`
  ADD CONSTRAINT `tokens_conversa_ibfk_1` FOREIGN KEY (`CONV_INT_ID`) REFERENCES `conversas` (`CONV_INT_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tokens_usuario`
--
ALTER TABLE `tokens_usuario`
  ADD CONSTRAINT `tokens_usuario_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`) ON DELETE CASCADE;

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
