<?php
require_once('conection.php');
require_once('protect.php');

if (isset($_POST['artigo_id']) && isset($_POST['action'])) {
    $usuarioLogadoId = $_SESSION['id'];
    $artigoId = $_POST['artigo_id'];
    $action = $_POST['action']; // Recebe a ação (salvar ou remover)

    // Verificar se o artigo já está salvo pelo usuário
    $sqlVerificar = "SELECT * FROM salvar WHERE USU_INT_ID = ? AND ART_INT_ID = ?";
    $stmtVerificar = $conection->prepare($sqlVerificar);
    $stmtVerificar->bind_param('ii', $usuarioLogadoId, $artigoId);
    $stmtVerificar->execute();
    $result = $stmtVerificar->get_result();

    // Lógica para salvar ou remover o artigo
    if ($action === 'salvar') {
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'error' => 'Artigo já salvo']);
        } else {
            // Inserir o artigo salvo na tabela
            $sqlInserir = "INSERT INTO salvar (USU_INT_ID, ART_INT_ID) VALUES (?, ?)";
            $stmtInserir = $conection->prepare($sqlInserir);
            $stmtInserir->bind_param('ii', $usuarioLogadoId, $artigoId);

            if ($stmtInserir->execute()) {
                echo json_encode(['success' => true, 'message' => 'Artigo salvo com sucesso']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao salvar o artigo']);
            }
        }
    } elseif ($action === 'remover') {
        if ($result->num_rows > 0) {
            // Remover o artigo salvo da tabela
            $sqlRemover = "DELETE FROM salvar WHERE USU_INT_ID = ? AND ART_INT_ID = ?";
            $stmtRemover = $conection->prepare($sqlRemover);
            $stmtRemover->bind_param('ii', $usuarioLogadoId, $artigoId);

            if ($stmtRemover->execute()) {
                echo json_encode(['success' => true, 'message' => 'Artigo removido com sucesso']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao remover o artigo']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Artigo não encontrado para remoção']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Ação inválida']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Parâmetro inválido']);
}
?>
