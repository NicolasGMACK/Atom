<?php
require_once('conection.php'); // Conexão com o banco de dados

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
            $diretorioDestino = 'uploads/';
            $caminhoCompleto = $diretorioDestino . basename($nomeArquivo);

            if (move_uploaded_file($arquivoTmp, $caminhoCompleto)) {
                // Inserir artigo no banco de dados
                $query = "INSERT INTO artigo (ART_VAR_TITULO, ART_VAR_DESCRICAO, ART_VAR_CATEGORIA, ART_CHA_STATUS, ART_VAR_ARQUIVO, USU_INT_ID) 
                          VALUES ('$titulo', '$descricao', '$categoria', '$status', '$caminhoCompleto', '$usuario_id')";

                $executar = mysqli_query($conection, $query);
                if ($executar) {
                    echo "<script>window.alert('Artigo inserido com sucesso!')</script>";
                    header('Refresh: 0.5, url=login-real.php');
                } else {
                    echo "<script>window.alert('Erro ao inserir o artigo, por favor tente novamente')</script>";
                }
            } else {
                $erros[] = "Erro ao salvar o arquivo.";
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
