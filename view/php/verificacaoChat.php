<?php
require_once('conection.php');
require_once('protect.php');

if (isset($_GET['token'])) {
    $tokenusu = $_GET['token'];

    // Busca o ID do usuário com base no token
    $sqlToken = "SELECT USU_INT_ID FROM tokens_usuario WHERE TOK_USU_VAR_TOK = ?";
    $stmtToken = $conection->prepare($sqlToken);
    $stmtToken->bind_param('s', $tokenusu);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    if ($resultToken->num_rows > 0) {
        $userChat1 = $_SESSION['id']; // ID do usuário atual
        $userChat2 = $resultToken->fetch_assoc()['USU_INT_ID']; // ID do outro usuário

        // Verifica se já existe uma conversa entre os dois usuários
        $sqlChat = "SELECT CONV_INT_ID FROM conversas 
                    WHERE (USU_INT_ID_1 = ? AND USU_INT_ID_2 = ?) 
                       OR (USU_INT_ID_1 = ? AND USU_INT_ID_2 = ?)";
        $stmtChat = $conection->prepare($sqlChat);
        $stmtChat->bind_param('iiii', $userChat1, $userChat2, $userChat2, $userChat1);
        $stmtChat->execute();
        $resultChat = $stmtChat->get_result();

        if ($resultChat->num_rows > 0) {
            // Conversa já existe, obtém o ID
            $chatId = $resultChat->fetch_assoc()['CONV_INT_ID'];
        } else {
            // Cria uma nova conversa
            $sqlInsertChat = "INSERT INTO conversas (USU_INT_ID_1, USU_INT_ID_2) VALUES (?, ?)";
            $stmtInsertChat = $conection->prepare($sqlInsertChat);
            $stmtInsertChat->bind_param('ii', $userChat1, $userChat2);

            if ($stmtInsertChat->execute()) {
                $chatId = $stmtInsertChat->insert_id; // Pega o ID da nova conversa
            } else {
                die('Erro ao iniciar o chat.');
            }
        }

        // Verifica se já existe um token para a conversa
        $sqlTokenConversa = "SELECT TOK_CON_VAR_TOK FROM tokens_conversa WHERE CONV_INT_ID = ?";
        $stmtTokenConversa = $conection->prepare($sqlTokenConversa);
        $stmtTokenConversa->bind_param('i', $chatId);
        $stmtTokenConversa->execute();
        $resultTokenConversa = $stmtTokenConversa->get_result();

        if ($resultTokenConversa->num_rows > 0) {
            // Token já existe
            $tokenConversa = $resultTokenConversa->fetch_assoc()['TOK_CON_VAR_TOK'];
        } else {
            // Cria um novo token para a conversa
            $tokenConversa = bin2hex(random_bytes(16)); // Gera um token único e seguro
            $sqlInsertTokenConversa = "INSERT INTO tokens_conversa (CONV_INT_ID, TOK_CON_VAR_TOK) VALUES (?, ?)";
            $stmtInsertTokenConversa = $conection->prepare($sqlInsertTokenConversa);
            $stmtInsertTokenConversa->bind_param('is', $chatId, $tokenConversa);

            if (!$stmtInsertTokenConversa->execute()) {
                die('Erro ao gerar token para a conversa.');
            }
        }

        // Redireciona para a tela da conversa
        header("Location: conversa.php?token=$tokenConversa");
        exit;
    } else {
        echo 'Erro: Token de usuário inválido.';
    }
} 
