<?php 
require_once('conection.php'); // Conexão com o banco de dados
$userId = $_SESSION['id']; // ID do usuário logado

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');
// Função para obter os artigos do banco de dados
function carregarArtigos($conection, $userId) { 
    $query = "SELECT a.ART_VAR_TITULO, a.ART_VAR_DESCRICAO, a.ART_VAR_CATEGORIA, a.ART_VAR_STATUS, a.ART_DAT_POSTAGEM, 
                     u.USU_VAR_NAME, u.USU_VAR_IMGPERFIL, a.USU_INT_ID, a.ART_INT_ID,
                     (SELECT COUNT(*) FROM comentario WHERE ART_INT_ID = a.ART_INT_ID) AS num_comentarios,
                     (SELECT COUNT(*) FROM upvote WHERE UP_ART_INT_ID = a.ART_INT_ID) AS num_likes,
                     (SELECT COUNT(*) FROM upvote WHERE UP_USU_INT_ID = $userId AND UP_ART_INT_ID = a.ART_INT_ID) AS user_liked
              FROM artigo a 
              JOIN usuario u ON a.USU_INT_ID = u.USU_INT_ID
              ORDER BY a.ART_DAT_POSTAGEM DESC";

    $resultado = mysqli_query($conection, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($artigo = mysqli_fetch_assoc($resultado)) {
            $titulo = $artigo['ART_VAR_TITULO'];
            $categoria = $artigo['ART_VAR_CATEGORIA'];
            $status = $artigo['ART_VAR_STATUS'];
            $dataPostagem = $artigo['ART_DAT_POSTAGEM'];
            $nomeUsuario = $artigo['USU_VAR_NAME'];
            $idUsuario = $artigo['USU_INT_ID'];
            $idArtigo = $artigo['ART_INT_ID']; // ID do artigo
            $numComentarios = $artigo['num_comentarios']; // Número de comentários
            $numLikes = $artigo['num_likes'];
            $userLiked = $artigo['user_liked']; // Verifica se o usuário curtiu

            require_once('ObterOuCriarToken.php');

            $tokenUser = obterOuCriarToken($conection, 'usuario', $idUsuario);
            $tokenArtigo = obterOuCriarToken($conection, 'artigo', $idArtigo);

            // Recupera o caminho da imagem de perfil do usuário
            $fotoPerfil = $artigo['USU_VAR_IMGPERFIL'];
            // Se não houver imagem de perfil, usa a imagem padrão
            if (empty($fotoPerfil)) {
                $fotoPerfil = '../view/img/user.jpg'; // Caminho da imagem padrão
            }

            // Converter data para formato legível (Mês por extenso e ano em PT-BR)
            $dataFormatada = strftime('%B %Y', strtotime($dataPostagem)); // Exemplo: "outubro 2024"
            $dataFormatada = ucfirst($dataFormatada); // Coloca a primeira letra do mês em maiúscula

            $likeButtonClass = $userLiked > 0 ? 'liked' : ''; // Adiciona classe liked se o usuário curtiu
            $likeButtonText = $userLiked > 0 ? "$numLikes" : "Relevante"; // Texto "Relevante" ou o número de likes

            // HTML para exibir o artigo
            echo "
            <div class='bloco'>
                <div class='bloco-top'>
                    <p>Relacionado a <strong>$categoria</strong></p>
                </div>
                <div class='bloco-mid'>
                    <div class='cabecalho'>
                        <a href='perfil.php?token=$tokenUser'>
                            <div class='foto1 user'>
                                <img src='$fotoPerfil' alt='Foto de perfil' class='user-photo'>
                            </div>
                        </a>
                        <div class='profile-artigo'>
                            <a href='perfil.php?token=$tokenUser'>
                                <div class='nome'>$nomeUsuario</div>
                            </a>
                            <p>Publicou um artigo</p>
                        </div>
                    </div>
                    <div class='conteudo'>
                         <a href='artigo.php?token=$tokenArtigo'>$titulo</a>

                        <br><br>
                        <span>$dataFormatada &#8226; $status</span>
                    </div>
                </div>
                <div class='bloco-bot'>
                    <div class='rodape'>
                        <div class='rod'>
                            <button class='relevante $likeButtonClass' onclick='toggleLike(this, $idArtigo)' data-article-id='$idArtigo'>
                                <span class='material-symbols-outlined like-icon'>shift</span>
                                <span class='like-count'>$likeButtonText</span>
                            </button>
                            <button id='goToComments' class='comentarios' onclick=\"window.location.href='artigo.php?token=$tokenArtigo#comments';\">
                                <i class='fa-regular fa-comment'></i>$numComentarios
                            </button>                              
                            <button class='botoes' id='Salvar'>Salvar</button>
                        </div>
                        <div class='notification' id='notification'>
                            <h4 id='notificationTitle'>Arquivo salvo com sucesso!</h4>
                            <p id='notificationText'>Você pode encontrar o arquivo no seu perfil.</p>
                        </div>
                        <script src='../view/js/salvar.js'></script>
                        <div class='ape'>
                            <button id='openCompartilhar' class='botoes'>Compartilhar</button>
                        </div>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<div class='bloco'><h1 style=' padding: 20px;'>Nenhum artigo encontrado. Seja primeiro a fazer uma publicação.</h1></div>";
    }
}

// Chama a função para exibir os artigos
carregarArtigos($conection, $userId);
?>
