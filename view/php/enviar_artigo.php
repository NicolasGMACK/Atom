<?php
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
    $conversaId = $_POST['conversaId']; // ID da conversa existente
    $mensagem = $_POST['mensagem']; // Mensagem a ser enviada
    $tipoMensagem = $_POST['tipo']; // Tipo da mensagem (texto, artigo, etc.)
    $tokenArtigo = $_POST['tokenArtigo'] ?? null; // Token do artigo (se for uma mensagem de artigo)
    $dataEnvio = date('Y-m-d H:i:s'); // Data e hora do envio

    
    // Prevenir ataques XSS - escapar a mensagem
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');

    // **Ajuste da mensagem se for um compartilhamento de artigo**
    if ($tipoMensagem === 'artigo' && $tokenArtigo) {
        // Buscar o id do artigo com base no token na tabela 'tokens_artigo'
        $queryToken = "SELECT ART_INT_ID FROM tokens_artigo WHERE token = ?";
        $stmtToken = $conection->prepare($queryToken);

        if ($stmtToken) {
            // Vincula o parâmetro do tokenArtigo como string
            $stmtToken->bind_param("s", $tokenArtigo);
            $stmtToken->execute();
            $stmtToken->bind_result($artigoId);
            $stmtToken->fetch();
            $stmtToken->close();

            // Se o artigo foi encontrado com o token
            if ($artigoId) {
                // Buscar o título do artigo com base no id do artigo
                $queryTitulo = "SELECT ART_VAR_TITULO FROM artigo WHERE ART_INT_ID = ?";
                $stmtTitulo = $conection->prepare($queryTitulo);

                if ($stmtTitulo) {
                    // Vincula o parâmetro do id do artigo
                    $stmtTitulo->bind_param("i", $artigoId);
                    $stmtTitulo->execute();
                    $stmtTitulo->bind_result($tituloArtigo);
                    $stmtTitulo->fetch();
                    $stmtTitulo->close();

                    // Se o título foi encontrado, substitua na mensagem
                    if ($tituloArtigo) {
                        $mensagem = 'Confira este artigo: <a href="artigo.php?token=' . htmlspecialchars($tokenArtigo, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars($tituloArtigo, ENT_QUOTES, 'UTF-8') . '</a>';
                    } else {
                        // Se o título não for encontrado, mensagem padrão
                        $mensagem = 'Confira este artigo!';
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erro ao buscar título do artigo']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Token do artigo inválido']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao buscar ID do artigo']);
            exit;
        }
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
