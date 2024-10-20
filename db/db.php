<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atom"; // Nome do banco de dados

// Cria conexão
$conn = new mysqli($servername, $username, $password);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o banco de dados já existe
$dbCheckQuery = "SHOW DATABASES LIKE '$dbname'";
$result = $conn->query($dbCheckQuery);

if ($result->num_rows == 0) {
    // Cria o banco de dados se não existir
    $createDBQuery = "CREATE DATABASE $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($createDBQuery) === TRUE) {
        echo "Banco de dados criado com sucesso.\n";
    } else {
        die("Erro ao criar banco de dados: " . $conn->error);
    }
} else {
    echo "Banco de dados já existe.\n";
}

// Seleciona o banco de dados
$conn->select_db($dbname);

// Função para executar SQLs de criação e atualização de tabelas
function executeSQL($conn, $sql) {
    if ($conn->multi_query($sql)) {
        do {
            // Armazena o resultado se houver
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    } else {
        die("Erro ao executar SQL: " . $conn->error);
    }
}

// SQL do dump fornecido
$sql = <<<SQL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE IF NOT EXISTS `artigo` (
  `ART_INT_ID` int(11) NOT NULL,
  `ART_VAR_TITULO` varchar(250) NOT NULL,
  `ART_VAR_DESCRICAO` varchar(2000) NOT NULL,
  `ART_VAR_CATEGORIA` varchar(50) NOT NULL,
  `ART_VAR_STATUS` varchar(12) NOT NULL,
  `ART_VAR_ARQUIVO` varchar(500) NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `ART_DAT_POSTAGEM` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `comentario` (
  `COM_INT_ID` int(11) NOT NULL,
  `COM_VAR_CONTEUDO` text NOT NULL,
  `USU_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `COM_DAT_POSTAGEM` datetime DEFAULT current_timestamp(),
  `COM_INT_COM_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tokens` (
  `TOK_INT_ID` int(11) NOT NULL,
  `ART_INT_ID` int(11) NOT NULL,
  `TOK_VAR_TOK` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `upvote` (
  `UP_INT_ID` int(11) NOT NULL,
  `UP_USU_INT_ID` int(11) DEFAULT NULL,
  `UP_ART_INT_ID` int(11) DEFAULT NULL,
  `UP_DAT_DATA` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `usuario` (
  `USU_INT_ID` int(11) NOT NULL,
  `USU_VAR_NAME` varchar(50) NOT NULL,
  `USU_VAR_EMAIL` varchar(100) NOT NULL,
  `USU_VAR_PASSWORD` varchar(255) NOT NULL,
  `USU_VAR_IMGPERFIL` varchar(255) DEFAULT NULL,
  `USU_VAR_IMGBACK` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Índices e chaves primárias
ALTER TABLE `artigo`
  ADD PRIMARY KEY IF NOT EXISTS (`ART_INT_ID`),
  ADD KEY IF NOT EXISTS `USU_INT_ID` (`USU_INT_ID`);

ALTER TABLE `comentario`
  ADD PRIMARY KEY IF NOT EXISTS (`COM_INT_ID`),
  ADD KEY IF NOT EXISTS `USU_INT_ID` (`USU_INT_ID`),
  ADD KEY IF NOT EXISTS `ART_INT_ID` (`ART_INT_ID`),
  ADD KEY IF NOT EXISTS `COM_INT_COM_ID` (`COM_INT_COM_ID`);

ALTER TABLE `tokens`
  ADD PRIMARY KEY IF NOT EXISTS (`TOK_INT_ID`),
  ADD KEY IF NOT EXISTS `artigo_id` (`ART_INT_ID`);

ALTER TABLE `upvote`
  ADD PRIMARY KEY IF NOT EXISTS (`UP_INT_ID`),
  ADD KEY IF NOT EXISTS `UP_USU_INT_ID` (`UP_USU_INT_ID`),
  ADD KEY IF NOT EXISTS `UP_ART_INT_ID` (`UP_ART_INT_ID`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY IF NOT EXISTS (`USU_INT_ID`);

-- AUTO_INCREMENT
ALTER TABLE `artigo`
  MODIFY `ART_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comentario`
  MODIFY `COM_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tokens`
  MODIFY `TOK_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `upvote`
  MODIFY `UP_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuario`
  MODIFY `USU_INT_ID` int(11) NOT NULL AUTO_INCREMENT;

-- Chaves estrangeiras
ALTER TABLE `artigo`
  ADD CONSTRAINT IF NOT EXISTS `artigo_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`);

ALTER TABLE `comentario`
  ADD CONSTRAINT IF NOT EXISTS `comentario_ibfk_1` FOREIGN KEY (`USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`),
  ADD CONSTRAINT IF NOT EXISTS `comentario_ibfk_2` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`),
  ADD CONSTRAINT IF NOT EXISTS `comentario_ibfk_3` FOREIGN KEY (`COM_INT_COM_ID`) REFERENCES `comentario` (`COM_INT_ID`);

ALTER TABLE `tokens`
  ADD CONSTRAINT IF NOT EXISTS `tokens_ibfk_1` FOREIGN KEY (`ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`);

ALTER TABLE `upvote`
  ADD CONSTRAINT IF NOT EXISTS `upvote_ibfk_1` FOREIGN KEY (`UP_USU_INT_ID`) REFERENCES `usuario` (`USU_INT_ID`),
  ADD CONSTRAINT IF NOT EXISTS `upvote_ibfk_2` FOREIGN KEY (`UP_ART_INT_ID`) REFERENCES `artigo` (`ART_INT_ID`);

COMMIT;
SQL;

// Executa o SQL
executeSQL($conn, $sql);

echo "Tabelas criadas/atualizadas com sucesso.\n";

// Fecha a conexão
$conn->close();
?>
