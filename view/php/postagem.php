<?php
require_once('conection.php'); // Conexão com o banco de dados
require_once('protect.php'); // Verifica se o usuário esta autenticado
// Verifica se o formulário foi enviado e chama a função para inserir o artigo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    inserirArtigo($conection);
}

function inserirArtigo($conection) {
    if (isset($_POST['titulo']) && !empty($_POST['titulo']) && 
        isset($_POST['descricao']) && !empty($_POST['descricao']) && 
        isset($_POST['categoria']) && !empty($_POST['categoria']) && 
        isset($_POST['status']) && !empty($_POST['status'])) {
        
        $erros = array();
        $titulo = mysqli_real_escape_string($conection, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($conection, $_POST['descricao']);
        $categoria = mysqli_real_escape_string($conection, $_POST['categoria']);
        $status = mysqli_real_escape_string($conection, $_POST['status']);
        $usuario_id = $_SESSION['id']; // Pega o ID do usuário da sessão

        // Verifica se o PDF foi enviado
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === 0) {
            $arquivoTmp = $_FILES['pdf']['tmp_name'];
            $nomeArquivo = $_FILES['pdf']['name'];
            $diretorioDestino = $_SERVER['DOCUMENT_ROOT'] . '/pi-UNIAOSINISTRA/Atom/uploads/';
$caminhoCompleto = $diretorioDestino . basename($nomeArquivo);

            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                // Inserir artigo no banco de dados
                $query = "INSERT INTO artigo (ART_VAR_TITULO, ART_VAR_DESCRICAO, ART_VAR_CATEGORIA, ART_CHA_STATUS, ART_VAR_ARQUIVO, USU_INT_ID) 
                          VALUES ('$titulo', '$descricao', '$categoria', '$status', '$caminhoCompleto', '$usuario_id')";
            
                $executar = mysqli_query($conection, $query);
                if ($executar) {
                    // Define a mensagem de sucesso na sessão
                    $_SESSION['mensagem_sucesso'] = "Artigo postado com sucesso!";
                    header('Location: ../home.php'); // Redireciona para a home
                    exit();
                } else {
                    echo "<script>window.alert('Erro ao inserir o artigo, por favor tente novamente')</script>";
                }
            } else {
                echo "<script>window.alert('Erro ao salvar o arquivo. Verifique permissões e diretório.')</script>";
            }
        } else {
            $erros[] = "Nenhum arquivo PDF enviado!";
        }

        if (!empty($erros)) {
            foreach ($erros as $erro) {
                echo "<script>window.alert('$erro')</script>";
            }
        }
    }
}
?>