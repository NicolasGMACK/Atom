<?php
function obterOuCriarToken($conection, $tipo, $id) {
    // Define a tabela e a coluna de acordo com o tipo (usuario ou artigo)
    if ($tipo === 'usuario') {
        $tabela = 'tokens_usuario';
        $colunaId = 'USU_INT_ID';
        $colunaToken = 'TOK_USU_VAR_TOK';

    } elseif ($tipo === 'artigo') {
        $tabela = 'tokens_artigo';
        $colunaId = 'ART_INT_ID';
        $colunaToken = 'TOK_ART_VAR_TOK';
    } elseif ($tipo === 'conversa') {
        $tabela = 'tokens_conversa';
        $colunaId = 'CONV_INT_ID';
        $colunaToken = 'TOK_CON_VAR_TOK';
        } else {
        throw new Exception("Tipo de token inválido.");
    }

    // Consulta para verificar se o token já existe
    $queryToken = "SELECT $colunaToken FROM $tabela WHERE $colunaId = $id";
    $resultToken = mysqli_query($conection, $queryToken);

    if ($resultToken && mysqli_num_rows($resultToken) > 0) {
        $tokenData = mysqli_fetch_assoc($resultToken);
        return $tokenData[$colunaToken];
    } else {
        // Gera e insere o novo token
        $token = bin2hex(random_bytes(16));
        $queryInsertToken = "INSERT INTO $tabela ($colunaToken, $colunaId) VALUES ('$token', $id)";
        mysqli_query($conection, $queryInsertToken);
        return $token;
    }
}
?>