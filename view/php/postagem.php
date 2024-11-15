<?php
require_once('conection.php'); // Conexão com o banco de dados
require_once('protect.php'); // Verifica se o usuário está autenticado
 // Inicia a sessão para armazenar mensagens

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
                        // Obtém o diretório base da aplicação atual dinamicamente
            // Obtém o caminho dinâmico até a pasta "Atom/uploads"
            $diretorioBase = dirname(__DIR__, 3); // Sobe três pastas a partir do arquivo atual
            $diretorioDestino = $diretorioBase . '/Atom/uploads/';

            $caminhoCompleto = str_replace('\\', '/', $diretorioDestino . basename($nomeArquivo));


            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                // Inserir artigo no banco de dados
                $query = "INSERT INTO artigo (ART_VAR_TITULO, ART_VAR_DESCRICAO, ART_VAR_CATEGORIA, ART_VAR_STATUS, ART_VAR_ARQUIVO, USU_INT_ID) 
                          VALUES ('$titulo', '$descricao', '$categoria', '$status', '$caminhoCompleto', '$usuario_id')";
            
                   $executar = mysqli_query($conection, $query);
                if ($executar) {
                    // Define a mensagem de sucesso na sessão
                    $_SESSION['mensagem_sucesso'] = "Artigo postado com sucesso!";
                    header('Location: ../home.php'); // Redireciona para a home
                    exit();
                } else {
                    // Define a mensagem de erro na sessão e redireciona
                    $_SESSION['mensagem_erro'] = "Erro ao inserir o artigo, por favor tente novamente.";
                    header('Location: ../home.php');
                    exit();
                }
            } else {
                // Define mensagem de erro para problema ao salvar o arquivo e redireciona
                $_SESSION['mensagem_erro'] = "Erro ao salvar o arquivo. Verifique permissões e diretório.";
                header('Location: ../home.php');
                exit();
            }
        } else {
            // Define mensagem de erro para arquivo PDF não enviado e redireciona
            $_SESSION['mensagem_erro'] = "Postagem inválida, nenhum arquivo PDF enviado!";
            header('Location: ../home.php');
            exit();
        }
    } else {
        // Define mensagem de erro caso algum campo obrigatório não esteja preenchido e redireciona
        $_SESSION['mensagem_erro'] = "Todos os campos são obrigatórios!";
        header('Location: ../home.php');
        exit();
    }
}
?>
