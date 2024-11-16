<?php 
require_once('conection.php'); // Arquivo com a conexão ao banco de dados
require_once('protect.php'); // Verifica se o usuário está autenticado
require_once('ObterOuCriarToken.php');

$userId = $_SESSION['id']; // ID do usuário logado

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
        $sqlArtigo = "SELECT a.ART_INT_ID, a.ART_VAR_TITULO, a.USU_INT_ID, a.ART_VAR_CATEGORIA, a.ART_VAR_STATUS, a.ART_VAR_DESCRICAO, a.ART_DAT_POSTAGEM,
        (SELECT COUNT(*) FROM comentario WHERE ART_INT_ID = ?) AS num_comentarios,
        (SELECT COUNT(*) FROM upvote WHERE UP_ART_INT_ID = ?) AS num_likes,
        (SELECT COUNT(*) FROM salvar WHERE USU_INT_ID = ? AND ART_INT_ID = a.ART_INT_ID) AS user_saved
    FROM artigo a 
    WHERE ART_INT_ID = ?";
    
    $stmtArtigo = $conection->prepare($sqlArtigo);
    $stmtArtigo->bind_param('iiii', $artigoId, $artigoId, $userId, $artigoId);
    $stmtArtigo->execute();
    $resultArtigo = $stmtArtigo->get_result();
    
    if ($resultArtigo->num_rows > 0) {
        // O artigo foi encontrado
        $artigo = $resultArtigo->fetch_assoc();
    
        // Variáveis com os dados do artigo
        $idArtigo = $artigo['ART_INT_ID'];
        $titulo = $artigo['ART_VAR_TITULO'];
        $autorId = $artigo['USU_INT_ID']; // ID do autor
        $categoria = $artigo['ART_VAR_CATEGORIA'];
        $status = $artigo['ART_VAR_STATUS'];
        $descricao = $artigo['ART_VAR_DESCRICAO'];
        $dataPostagem = $artigo['ART_DAT_POSTAGEM'];
        $userSaved = $artigo['user_saved']; // Verifica se o usuário salvou o artigo
    
        $dataFormatada = strftime('%d de %B, %Y.', strtotime($dataPostagem)); 
        $dataFormatada = ucfirst($dataFormatada);
    
        $numLikes = $artigo['num_likes'];
        $numComentarios = $artigo['num_comentarios'];
    
        $tokenArtigo = obterOuCriarToken($conection, 'artigo', $idArtigo);
        $tokenUser = obterOuCriarToken($conection, 'usuario', $autorId);
    
        // Definindo o texto e a classe do botão
        $saveButtonText = $userSaved > 0 ? 'Em biblioteca' : 'Salvar';
        $saveButtonClass = $userSaved > 0 ? 'saved' : '';
            
            // Pegar nome do autor com base no USU_INT_ID
            $sqlAutor = "SELECT USU_VAR_NAME, USU_VAR_IMGPERFIL FROM usuario WHERE USU_INT_ID = ?";
            $stmtAutor = $conection->prepare($sqlAutor);
            $stmtAutor->bind_param('i', $autorId);
            $stmtAutor->execute();
            $resultAutor = $stmtAutor->get_result();

            if ($resultAutor->num_rows > 0) {
                $usuario = $resultAutor->fetch_assoc();
                $autor = $usuario['USU_VAR_NAME'];
                $autorFoto = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';     
            }

            // Verificar se o usuário logado é o autor do artigo                        
            $usuarioLogadoId = (int)$_SESSION['id']; // Converter para inteiro
            $mostrarBotaoExcluir = ($usuarioLogadoId == (int)$autorId); // Comparação de valor


            echo "<div class='cartao-top'>
                    <div class='cartao_top_l'>
                        <div class='status'>$status</div>
                        <div class='tema'>$categoria</div>
                    </div>
                    <div class='cartao_top_r'>";
            
            // Exibir o botão de exclusão se o usuário logado for o autor
            if ($mostrarBotaoExcluir) {
                echo "<div class='excluir_artigo'>
                        <button onclick='excluirArtigo($idArtigo)'><i class='fa-solid fa-trash'></i></button>
                      </div>";
            }
            
            echo "</div>
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
