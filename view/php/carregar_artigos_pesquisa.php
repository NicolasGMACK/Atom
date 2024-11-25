<?php
require_once('conection.php'); // Conexão com o banco de dados
$userId = $_SESSION['id']; // ID do usuário logado

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

// Função para obter os artigos do banco de dados
function carregarArtigos($conection, $userId, $pesquisa = '', $data = '', $data_inicio = '', $data_fim = '', $categoria = '', $status = [], $ordenar = 'relevancia') {
    // Base da query
    $query = "SELECT a.ART_VAR_TITULO, a.ART_VAR_DESCRICAO, a.ART_VAR_CATEGORIA, a.ART_VAR_STATUS, a.ART_DAT_POSTAGEM, 
                     u.USU_VAR_NAME, u.USU_VAR_IMGPERFIL, a.USU_INT_ID, a.ART_INT_ID,
                     (SELECT COUNT(*) FROM comentario WHERE ART_INT_ID = a.ART_INT_ID) AS num_comentarios,
                     (SELECT COUNT(*) FROM upvote WHERE UP_ART_INT_ID = a.ART_INT_ID) AS num_likes,
                     (SELECT COUNT(*) FROM upvote WHERE UP_USU_INT_ID = $userId AND UP_ART_INT_ID = a.ART_INT_ID) AS user_liked,
                     (SELECT COUNT(*) FROM salvar WHERE USU_INT_ID = $userId AND ART_INT_ID = a.ART_INT_ID) AS user_saved
              FROM artigo a 
              JOIN usuario u ON a.USU_INT_ID = u.USU_INT_ID";

    // Filtros
    $conditions = [];
    
    // Pesquisa
    if (!empty($pesquisa)) {
        $pesquisa = mysqli_real_escape_string($conection, $pesquisa);
        $conditions[] = "(a.ART_VAR_TITULO LIKE '%$pesquisa%' OR a.ART_VAR_CATEGORIA LIKE '%$pesquisa%' OR u.USU_VAR_NAME LIKE '%$pesquisa%')";
    }

    // Filtro de Data
    if (!empty($data)) {
        $conditions[] = "YEAR(a.ART_DAT_POSTAGEM) >= $data";
    } elseif (!empty($data_inicio) && !empty($data_fim)) {
        $conditions[] = "YEAR(a.ART_DAT_POSTAGEM) BETWEEN $data_inicio AND $data_fim";
    }

    // Filtro de Categoria
    if (!empty($categoria)) {
        $categoria = mysqli_real_escape_string($conection, $categoria);
        $conditions[] = "a.ART_VAR_CATEGORIA = '$categoria'";
    }

    // Filtro de Status
    if (!empty($status)) {
        $statusList = array_map(function ($s) use ($conection) {
            return "'" . mysqli_real_escape_string($conection, $s) . "'";
        }, $status);
        $conditions[] = "a.ART_VAR_STATUS IN (" . implode(',', $statusList) . ")";
    }

    // Adiciona os filtros na query
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    // Ordenação
    if ($ordenar === 'data') {
        $query .= " ORDER BY a.ART_DAT_POSTAGEM DESC";
    } else {
        $query .= " ORDER BY num_likes DESC"; // Relevância baseada em likes
    }

    // Executa a query
    $resultado = mysqli_query($conection, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($artigo = mysqli_fetch_assoc($resultado)) {
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

            require_once('ObterOuCriarToken.php');
            $tokenUser = obterOuCriarToken($conection, 'usuario', $idUsuario);
            $tokenArtigo = obterOuCriarToken($conection, 'artigo', $idArtigo);

            $fotoPerfil = $artigo['USU_VAR_IMGPERFIL'];
            if (empty($fotoPerfil)) {
                $fotoPerfil = '../view/img/user.jpg';
            }

            $dataFormatada = strftime('%B %Y', strtotime($dataPostagem));
            $dataFormatada = ucfirst($dataFormatada);

            $likeButtonClass = $userLiked > 0 ? 'liked' : '';
            $likeButtonText = $userLiked > 0 ? "$numLikes" : "Relevante";
            $saveButtonText = $userSaved > 0 ? 'Em biblioteca' : 'Salvar';
            $saveButtonClass = $userSaved > 0 ? 'saved' : '';

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
        echo "<div class='bloco'><h1 style='padding: 20px;'>Nenhum artigo encontrado.</h1></div>";
    }
}
?>
