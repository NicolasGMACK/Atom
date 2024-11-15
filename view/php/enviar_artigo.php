<?php
require_once('conection.php');
require_once('protect.php');

// Verificar se a sessão contém um ID de usuário
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$usuarioId = $_SESSION['id']; // Usuário logado (remetente)

// Verificar se os dados foram recebidos via POST
if (isset($_POST['conversaId'], $_POST['mensagem'], $_POST['tipo'])) {
    $conversaId = $_POST['conversaId']; // ID da conversa existente
    $mensagem = $_POST['mensagem']; // Mensagem a ser enviada
    $tipoMensagem = $_POST['tipo']; // Tipo da mensagem (texto, artigo, etc.)
    $tokenArtigo = $_POST['tokenArtigo'] ?? null; // Token do artigo (se for uma mensagem de artigo)
    $dataEnvio = date('Y-m-d H:i:s'); // Data e hora do envio

    // Prevenir ataques XSS - escapar a mensagem
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');

    // **Ajuste da mensagem se for um compartilhamento de artigo**
    if ($tipoMensagem === 'artigo' && $tokenArtigo) {
        $mensagem = 'Confira este artigo: <a href="artigo.php?token=' . htmlspecialchars($tokenArtigo, ENT_QUOTES, 'UTF-8') . '" target="_blank">Clique aqui para ver o artigo</a>';
    }

    // Inserir a mensagem na tabela 'mensagens'
    $query = "INSERT INTO mensagens (CONV_INT_ID, USU_INT_ID, MSG_VAR_CONTEUDO, MSG_TIPO, MSG_ARTIGO_TOKEN, MSG_DAT_ENVIO) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conection->prepare($query);

    if ($stmt) {
        // Vincular parâmetros
        $stmt->bind_param("iissss", $conversaId, $usuarioId, $mensagem, $tipoMensagem, $tokenArtigo, $dataEnvio);

        // Executar a consulta e retornar o resultado
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao enviar mensagem: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
}
?>
