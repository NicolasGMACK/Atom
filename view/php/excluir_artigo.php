<?php
require_once('conection.php');
require_once('protect.php');

if (isset($_GET['id'])) {
    $idArtigo = $_GET['id'];
    $usuarioLogadoId = $_SESSION['id'];

    // Verifica se o usuário logado é o autor
    $sqlVerificar = "SELECT USU_INT_ID, ART_VAR_ARQUIVO FROM artigo WHERE ART_INT_ID = ?";
    $stmtVerificar = $conection->prepare($sqlVerificar);
    $stmtVerificar->bind_param('i', $idArtigo);
    $stmtVerificar->execute();
    $result = $stmtVerificar->get_result();

    if ($result->num_rows > 0) {
        $artigo = $result->fetch_assoc();
        $caminhoArquivo = $artigo['ART_VAR_ARQUIVO'];

        if ($artigo['USU_INT_ID'] == $usuarioLogadoId) {
            // Verificar se o arquivo PDF existe e deletá-lo
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }

            // Excluir o artigo do banco de dados
            $sqlExcluir = "DELETE FROM artigo WHERE ART_INT_ID = ?";
            $stmtExcluir = $conection->prepare($sqlExcluir);
            $stmtExcluir->bind_param('i', $idArtigo);
            $stmtExcluir->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Permissão negada']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Artigo não encontrado']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Parâmetro inválido']);
}
?>
