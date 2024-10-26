<?php
require_once('conection.php'); // Inclua seu arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adicione esta linha para ver os dados recebidos
     // Pare a execução para visualizar os dados

    $conteudo = htmlspecialchars($_POST['conteudo']);
    $usuarioId = $_POST['usuario_id']; // ID do usuário logado
    $artigoId = $_POST['artigo_id']; // ID do artigo ao qual o comentário pertence
    $paiId = ($_POST['pai_id'] ?? null) === '0' ? null : $_POST['pai_id']; // Se pai_id for '0', usa NULL

    // Insere o comentário no banco de dados
    $sql = "INSERT INTO comentario (COM_VAR_CONTEUDO, USU_INT_ID, ART_INT_ID, COM_INT_COM_ID) VALUES (?, ?, ?, ?)";
    $stmt = $conection->prepare($sql);

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da declaração: ' . $conection->error]);
        exit();
    }

    $stmt->bind_param('siii', $conteudo, $usuarioId, $artigoId, $paiId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Falha ao inserir o comentário: ' . $stmt->error]);
    }
}
?>
