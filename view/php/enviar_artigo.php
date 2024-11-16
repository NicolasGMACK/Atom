<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('conection.php');
require_once('protect.php');

// Verificar se a sessão contém um ID de usuário
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

$usuarioId = $_SESSION['id']; // Usuário logado (remetente)

// Verificar se os dados foram recebidos via POST
if (isset($_POST['conversaId'], $_POST['mensagem'], $_POST['tipo'])) {
    $conversaId = $_POST['conversaId'];
    $mensagem = $_POST['mensagem'];
    $tipoMensagem = $_POST['tipo'];
    $tokenArtigo = $_POST['tokenArtigo'] ?? null;
    $dataEnvio = date('Y-m-d H:i:s');

    // Log para depuração
    error_log("Recebido: conversaId = $conversaId, mensagem = $mensagem, tipo = $tipoMensagem, tokenArtigo = $tokenArtigo");

    // Escapar a mensagem para evitar ataques XSS
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');

    // Ajustar mensagem se for um compartilhamento de artigo
    if ($tipoMensagem === 'artigo' && $tokenArtigo) {
        $queryToken = "SELECT ART_INT_ID FROM tokens_artigo WHERE TOK_ART_VAR_TOK = ?";
        $stmtToken = $conection->prepare($queryToken);

        if ($stmtToken) {
            $stmtToken->bind_param("s", $tokenArtigo);
            $stmtToken->execute();
            $stmtToken->bind_result($artigoId);
            $stmtToken->fetch();
            $stmtToken->close();

            if ($artigoId) {
                // Buscar o título do artigo
                $queryTitulo = "SELECT ART_VAR_TITULO FROM artigo WHERE ART_INT_ID = ?";
                $stmtTitulo = $conection->prepare($queryTitulo);

                if ($stmtTitulo) {
                    $stmtTitulo->bind_param("i", $artigoId);
                    $stmtTitulo->execute();
                    $stmtTitulo->bind_result($tituloArtigo);
                    $stmtTitulo->fetch();
                    $stmtTitulo->close();

                    if ($tituloArtigo) {
                        $mensagem = 'Confira este artigo: <a href="artigo.php?token=' . htmlspecialchars($tokenArtigo, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars($tituloArtigo, ENT_QUOTES, 'UTF-8') . '</a>';
                    } else {
                        $mensagem = 'Confira este artigo!';
                    }
                } else {
                    error_log("Erro ao buscar título do artigo: " . $conection->error);
                    echo json_encode(['success' => false, 'message' => 'Erro ao buscar título do artigo']);
                    exit;
                }
            } else {
                error_log("Token do artigo inválido ou não encontrado: $tokenArtigo");
                echo json_encode(['success' => false, 'message' => 'Token do artigo inválido']);
                exit;
            }
        } else {
            error_log("Erro ao preparar consulta para obter ID do artigo: " . $conection->error);
            echo json_encode(['success' => false, 'message' => 'Erro ao buscar ID do artigo']);
            exit;
        }
    }

    // Inserir mensagem na tabela
    $query = "INSERT INTO mensagens (CONV_INT_ID, USU_INT_ID, MSG_VAR_CONTEUDO, MSG_TIPO, MSG_ARTIGO_TOKEN, MSG_DAT_ENVIO) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("iissss", $conversaId, $usuarioId, $mensagem, $tipoMensagem, $tokenArtigo, $dataEnvio);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            error_log("Erro ao executar inserção: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Erro ao enviar mensagem']);
        }
        $stmt->close();
    } else {
        error_log("Erro ao preparar inserção: " . $conection->error);
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta']);
    }
} else {
    error_log("Dados insuficientes recebidos: " . json_encode($_POST));
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
}
?>
