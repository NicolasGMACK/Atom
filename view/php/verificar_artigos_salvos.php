<?php
require_once('conection.php');
require_once('protect.php');

// ID do usuário logado a partir da sessão
$usuarioId = $_SESSION['id'];

if ($usuarioId) {
    // Seleciona todos os artigos salvos pelo usuário logado
    $sql = "SELECT ART_INT_ID FROM salvar WHERE USU_INT_ID = ?";
    $stmt = $conection->prepare($sql);
    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result();

    $artigosSalvos = [];
    while ($row = $result->fetch_assoc()) {
        $artigosSalvos[] = (int) $row['ART_INT_ID'];
    }

    // Resposta JSON com status e artigos salvos
    echo json_encode(['success' => true, 'artigosSalvos' => $artigosSalvos]);
} else {
    // Caso o usuário não esteja logado ou não tenha ID na sessão
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
}
?>
