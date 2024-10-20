<?php
require_once('../view/php/protect.php');
require_once('../view/php/conection.php'); // Arquivo com a conexão ao banco de dados

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');

// Verifica se o token foi passado
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta no banco de dados para validar o token
    $sqlToken = "SELECT ART_INT_ID FROM tokens WHERE TOK_VAR_TOK = ?";
    $stmtToken = $conection->prepare($sqlToken);
    $stmtToken->bind_param('s', $token);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    if ($resultToken->num_rows > 0) {
        // Se o token for válido, pega o ID do artigo
        $artigo = $resultToken->fetch_assoc();
        $artigoId = $artigo['ART_INT_ID'];

        // Busca as informações do artigo
        $sqlArtigo = "SELECT ART_VAR_TITULO, USU_INT_ID, ART_VAR_CATEGORIA, ART_VAR_STATUS, ART_VAR_DESCRICAO, ART_DAT_POSTAGEM FROM artigo WHERE ART_INT_ID = ?";
        $stmtArtigo = $conection->prepare($sqlArtigo);
        $stmtArtigo->bind_param('i', $artigoId);
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

            $dataFormatada = strftime('%d de %B, %Y', strtotime($dataPostagem)); // Exemplo: "26 deoutubro 2024"
            $dataFormatada = ucfirst($dataFormatada); // Coloca a primeira letra do mês em maiúscula
 

            // Pegar nome do autor com base no USU_INT_ID
            $sqlAutor = "SELECT USU_VAR_NAME FROM usuario WHERE USU_INT_ID = ?";
            $stmtAutor = $conection->prepare($sqlAutor);
            $stmtAutor->bind_param('i', $autorId);
            $stmtAutor->execute();
            $resultAutor = $stmtAutor->get_result();

            if ($resultAutor->num_rows > 0) {
                $autor = $resultAutor->fetch_assoc()['USU_VAR_NAME'];
            } else {
                $autor = "Autor desconhecido";
            }

            // Aqui você pode exibir as informações do artigo
            echo "
            <div class='topo'>
                <div class='topo-bloco'>
                    <div class='voltar'>
                        <script>
                            function goBack() {
                                window.history.back();
                            }
                        </script>
                        <div class='circulo-padding'>
                            <div class='circulo'>
                                <a onclick='goBack()'>
                                    <i class='fa-solid fa-arrow-left'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class='cartao'>
                        <div class='cartao-top'>
                            <div class='status'>$status</div>
                            <div class='tema'>$categoria</div>
                        </div>
                        <h1>$titulo</h1>
                        <div class='linha-autor'>
                            <div class='autor'>$autor.</div>
                        </div>
                        <div class='data-postagem'>Postado em $dataFormatada</div>
                        <div class='cartao-bot'>
                            <div class='rod'>
                                <button class='votos'><span class='material-symbols-outlined'>shift</span><p>3.956</p></button>
                                <button id='scrollToComments' class='comentarios'><i class='fa-regular fa-comment'></i>37</button>
                            </div>
                            <div class='ape'>
                                <button class='botoes' id='Salvar'>Salvar</button>
                                <div class='notification' id='notification'>
                                    <h4 id='notificationTitle'>Arquivo salvo com sucesso!</h4>
                                    <p id='notificationText'>Você pode encontrar o arquivo no seu perfil.</p>
                                </div>
                                <script src='../view/js/salvar.js'></script>
                                <button id='openCompartilhar' class='botoes'>Compartilhar</button>
                                <button class='baixar'><i class='fa-regular fa-circle-down'></i><p>Download</p></button>
                            </div>
                        </div>
                    </div>
                </div>
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
