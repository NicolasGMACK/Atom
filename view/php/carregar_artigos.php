<?php
require_once('conection.php'); // Conexão com o banco de dados

// Definir locale para português
setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

// Função para obter os artigos do banco de dados
function carregarArtigos($conection) {
    $query = "SELECT a.ART_VAR_TITULO, a.ART_VAR_DESCRICAO, a.ART_VAR_CATEGORIA, a.ART_VAR_STATUS, a.ART_DAT_POSTAGEM, u.USU_VAR_NAME
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

            // Converter data para formato legível (Mês por extenso e ano em PT-BR)
            $dataFormatada = strftime('%B %Y', strtotime($dataPostagem)); // Exemplo: "outubro 2024"
            $dataFormatada = ucfirst($dataFormatada); // Coloca a primeira letra do mês em maiúscula

            // HTML para exibir o artigo
            echo "
            <div class='bloco'>
                <div class='bloco-top'>
                    <p>Relacionado a <strong>$categoria</strong></p>
                </div>
                <div class='bloco-mid'>
                    <div class='cabecalho'>
                        <a href='perfil.php'>
                            <div class='foto1 user'>
                                <img src='../view/img/user.jpg' alt='img teste' class='user-photo'>
                            </div>
                        </a>
                        <div class='profile-artigo'>
                            <a href='perfil.php'>
                                <div class='nome'>$nomeUsuario</div>
                            </a>
                            <p>Publicou um artigo</p>
                        </div>
                    </div>
                    <div class='conteudo'>
                        <a href='artigo.php'>$titulo</a>
                        <br><br>
                        <span>$dataFormatada &#8226; $status</span>
                    </div>
                </div>
                <div class='bloco-bot'>
                    <div class='rodape'>
                        <div class='rod'>
                            <button class='relevante' onclick='toggleLike(this)'>
                                <span class='material-symbols-outlined'>shift</span>
                                <div class='vote'>Relevante</div>
                            </button>
                            <button id='goToComments' class='comentarios'>
                                <i class='fa-regular fa-comment'></i>37
                            </button>
                            <script>
                                document.getElementById('goToComments').addEventListener('click', function() {
                                    window.location.href = 'artigo.php#comments';
                                });
                            </script>   
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
        echo "<p>Nenhum artigo encontrado.</p>";
    }
}

// Chama a função para exibir os artigos
carregarArtigos($conection);

?>
