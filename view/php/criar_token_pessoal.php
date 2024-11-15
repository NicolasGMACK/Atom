<?php
require_once('conection.php'); // Conexão com o banco de dados
require_once('protect.php'); // Verifica se o usuário está autenticado
require_once('ObterOuCriarToken.php');
$userId = $_SESSION['id']; // ID do usuário logado

$tokenPessoal = obterOuCriarToken($conection, 'usuario', $userId);
?>