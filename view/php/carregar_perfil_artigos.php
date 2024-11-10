<?php
require_once('conection.php'); // Arquivo com a conexão ao banco de dados

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

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

        // Busca as informações do artigo
        $sqlArtigo = "SELECT ART_VAR_TITULO, USU_INT_ID, ART_VAR_CATEGORIA, ART_VAR_STATUS, ART_VAR_DESCRICAO, ART_DAT_POSTAGEM,
        (SELECT COUNT(*) FROM comentario WHERE ART_INT_ID = ?) AS num_comentarios,
        (SELECT COUNT(*) FROM upvote WHERE UP_ART_INT_ID = ?) AS num_likes
    FROM artigo 
    WHERE ART_INT_ID = ?
";
        $stmtArtigo = $conection->prepare($sqlArtigo);
        $stmtArtigo->bind_param('iii', $artigoId, $artigoId, $artigoId);
        $stmtArtigo->execute();
        $resultArtigo = $stmtArtigo->get_result();

        if ($resultArtigo->num_rows > 0) {
            // O artigo foi encontrado
            $artigo = $resultArtigo->fetch_assoc();

            // Variáveis com os dados do artigo
            $titulo = $artigo['ART_VAR_TITULO'];
            $autorId = $artigo['USU_INT_ID']; // ID do autor
            $categoria = $artigo['ART_VAR_CATEGORIA'];
            $status = $artigo['ART_VAR_STATUS'];
            $descricao = $artigo['ART_VAR_DESCRICAO'];
            $dataPostagem = $artigo['ART_DAT_POSTAGEM'];

            $dataFormatada = strftime('%d de %B, %Y.', strtotime($dataPostagem)); // Exemplo: "26 deoutubro 2024"
            $dataFormatada = ucfirst($dataFormatada); // Coloca a primeira letra do mês em maiúscula

            $numLikes = $artigo['num_likes'];
            $numComentarios = $artigo['num_comentarios'];
 

            // Pegar nome do autor com base no USU_INT_ID
            $sqlAutor = "SELECT USU_VAR_NAME, USU_VAR_IMGPERFIL FROM usuario WHERE USU_INT_ID = ?";
            $stmtAutor = $conection->prepare($sqlAutor);
            $stmtAutor->bind_param('i', $autorId);
            $stmtAutor->execute();
            $resultAutor = $stmtAutor->get_result();

            if ($resultAutor->num_rows > 0) {
                $usuario = $resultAutor->fetch_assoc();
                $autor = $usuario['USU_VAR_NAME'];
                $autorFoto = $usuario['USU_VAR_IMGPERFIL'];
                
            } 

            // Aqui você pode exibir as informações do artigo
            echo "<div class='cartao-top'>
                    <div class='status'>$status</div>
                    <div class='tema'>$categoria</div>
                </div>
                <div class='artigo-conteudo'>
                <h1>$titulo</h1>
                <div class='linha-autor'>
                    <div class='autor'>$autor.</div>
                </div>
                <div class='data-postagem'>Postado em $dataFormatada</div>
                </div>";
        } else {
            echo "Artigo não encontrado.";
            exit();
        }
    } else {
        echo "Token inválido.";
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
    exit();
}
?>
