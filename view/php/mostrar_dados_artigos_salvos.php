<?php
require_once('conection.php'); // Conexão com o banco de dados
require_once('protect.php');  // Verifica se o usuário está autenticado
require_once('ObterOuCriarToken.php');  // Função para obter ou criar tokens


setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

// Função para obter os artigos salvos pelo usuário do perfil

    // Usando prepared statements para segurança
    $query = "
    SELECT  
        -- Contagem do número de artigos salvos
        (SELECT COUNT(DISTINCT ART_INT_ID) FROM salvar WHERE USU_INT_ID = ?) AS num_artigos_salvos,
        -- Contagem de autores distintos dos artigos salvos
        (SELECT COUNT(DISTINCT a.USU_INT_ID) 
         FROM salvar s 
         JOIN artigo a ON s.ART_INT_ID = a.ART_INT_ID 
         WHERE s.USU_INT_ID = ?) AS num_autores_distintos
    FROM artigo a
    JOIN salvar s ON a.ART_INT_ID = s.ART_INT_ID
    WHERE s.USU_INT_ID = ?
    LIMIT 1";  // Garantir que traga apenas um resultado, já que são valores agregados

// Prepara a consulta SQL
$stmt = $conection->prepare($query);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die('Erro na preparação da consulta SQL: ' . $conection->error);
}

// Bind dos parâmetros
$stmt->bind_param('iii', $PerfilId, $PerfilId, $PerfilId);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se há resultados
if ($resultado && $resultado->num_rows > 0) {
    // Extrai os dados de artigos salvos e autores distintos
    $artigo = $resultado->fetch_assoc();
    $numArtigosSalvos = $artigo['num_artigos_salvos']; // Total de artigos salvos pelo usuário
    $numAutoresDistintos = $artigo['num_autores_distintos']; // Número de autores distintos
} else {
    $numArtigosSalvos = 0;
    $numAutoresDistintos = 0;
}
    ?>