    <?php
    require_once('conection.php'); // Conexão com o banco de dados
    require_once('protect.php');  // Verifica se o usuário está autenticado
    require_once('ObterOuCriarToken.php');  // Função para obter ou criar tokens

    $userId = $_SESSION['id']; // ID do usuário logado

    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

    // Função para obter os artigos salvos pelo usuário do perfil
    function carregarArtigosSalvos($conection, $userId, $PerfilId) { 
        // Usando prepared statements para segurança
        $query = "            SELECT a.ART_VAR_TITULO, a.ART_VAR_DESCRICAO, a.ART_VAR_CATEGORIA, a.ART_VAR_STATUS, a.ART_DAT_POSTAGEM, 
                u.USU_VAR_NAME, u.USU_VAR_IMGPERFIL, a.USU_INT_ID, a.ART_INT_ID,
                (SELECT COUNT(*) FROM comentario WHERE ART_INT_ID = a.ART_INT_ID) AS num_comentarios,
                (SELECT COUNT(*) FROM upvote WHERE UP_ART_INT_ID = a.ART_INT_ID) AS num_likes,
                (SELECT COUNT(*) FROM upvote WHERE UP_USU_INT_ID = ? AND UP_ART_INT_ID = a.ART_INT_ID) AS user_liked,
                (SELECT COUNT(*) FROM salvar WHERE USU_INT_ID = ? AND ART_INT_ID = a.ART_INT_ID) AS user_saved                
            FROM artigo a 
            JOIN usuario u ON a.USU_INT_ID = u.USU_INT_ID
            JOIN salvar s ON a.ART_INT_ID = s.ART_INT_ID
            WHERE s.USU_INT_ID = ?
            ORDER BY s.SALVAR_DAT_CRIACAO DESC
        ";

        // Prepara a consulta SQL
        $stmt = $conection->prepare($query);
        $stmt->bind_param('iii', $userId, $userId, $PerfilId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado && $resultado->num_rows > 0) {
            while ($artigo = $resultado->fetch_assoc()) {
                // Extração dos dados do artigo
                $titulo = $artigo['ART_VAR_TITULO'];
                $categoria = $artigo['ART_VAR_CATEGORIA'];
                $status = $artigo['ART_VAR_STATUS'];
                $dataPostagem = $artigo['ART_DAT_POSTAGEM'];
                $nomeUsuario = $artigo['USU_VAR_NAME'];
                $idUsuario = $artigo['USU_INT_ID'];
                $idArtigo = $artigo['ART_INT_ID']; 
                $numComentarios = $artigo['num_comentarios']; 
                $numLikes = $artigo['num_likes'];
                $userLiked = $artigo['user_liked']; 
                $userSaved = $artigo['user_saved']; 
                
                // Gerando os tokens
                $tokenUser = obterOuCriarToken($conection, 'usuario', $idUsuario);
                $tokenArtigo = obterOuCriarToken($conection, 'artigo', $idArtigo);

                // Caminho da imagem de perfil do usuário
                $fotoPerfil = empty($artigo['USU_VAR_IMGPERFIL']) ? '../view/img/user.jpg' : $artigo['USU_VAR_IMGPERFIL'];

                // Formatação da data
                $dataFormatada = strftime('%B %Y', strtotime($dataPostagem));
                $dataFormatada = ucfirst($dataFormatada);

                // Definição da classe do botão de like e texto
                $likeButtonClass = $userLiked > 0 ? 'liked' : '';
                $likeButtonText = $userLiked > 0 ? "$numLikes" : "Relevante";

                // Definição do botão de salvar
                $saveButtonText = $userSaved > 0 ? 'Em biblioteca' : 'Salvar';
                $saveButtonClass = $userSaved > 0 ? 'saved' : '';

            // Exibição do artigo
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
                            
                            <!-- Botão de Salvar com Input Hidden -->
                            <button class='botoes Salvar $saveButtonClass' data-artigo-id='$idArtigo'>$saveButtonText</button>                   
                        </div>                                                 
                        <div class='ape'>
                            <button class='openCompartilhar botoes' data-token-artigo='$tokenArtigo'>Compartilhar</button>
                        </div>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<div class='bloco'><h1 style=' padding: 20px;'>Este usuário não salvou nenhum artigo.</h1></div>";
    }
}

// Chama a função para exibir os artigos salvos pelo usuário do perfil
carregarArtigosSalvos($conection, $userId, $PerfilId);
?>
