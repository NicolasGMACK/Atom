<?php
require_once('conection.php'); // Arquivo com a conexão ao banco de dados

// Verifica se o token foi passado
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta no banco de dados para validar o token
    $sqlToken = "SELECT ART_INT_ID FROM tokens_artigo WHERE TOK_ART_VAR_TOK = ?";
    $stmtToken = $conection->prepare($sqlToken);
    $stmtToken->bind_param('s', $token);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    if ($resultToken->num_rows > 0) {
        // Se o token for válido, pega o ID do artigo
        $artigo = $resultToken->fetch_assoc();
        $artigoId = $artigo['ART_INT_ID'];

        // Busca o caminho do arquivo no artigo na coluna ART_VAR_ARQUIVO
        $sqlArtigo = "SELECT ART_VAR_ARQUIVO FROM artigo WHERE ART_INT_ID = ?";
        $stmtArtigo = $conection->prepare($sqlArtigo);
        $stmtArtigo->bind_param('i', $artigoId);
        $stmtArtigo->execute();
        $resultArtigo = $stmtArtigo->get_result();

        if ($resultArtigo->num_rows > 0) {
            // O arquivo foi encontrado
            $artigo = $resultArtigo->fetch_assoc();
            $caminhoArquivo = $artigo['ART_VAR_ARQUIVO'];

            // Verifica se o arquivo existe no servidor
            if (file_exists($caminhoArquivo)) {
                // Força o download do arquivo
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($caminhoArquivo) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($caminhoArquivo));
                readfile($caminhoArquivo);
                exit();
            } else {
                echo "Arquivo não encontrado.";
            }
        } else {
            echo "Artigo não encontrado.";
        }
    } else {
        echo "Token inválido.";
    }
} else {
    echo "Parâmetros inválidos.";
}
?>