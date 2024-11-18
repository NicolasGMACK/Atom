<?php
require_once('conection.php');
require_once('protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos obrigatórios foram enviados
    if (isset($_POST['idChat'], $_POST['mensagem'], $_POST['token'])) {
        $idChat = $_POST['idChat'];
        $idUser = $_SESSION['id']; // Pega o ID do usuário logado na sessão
        $mensagem = trim($_POST['mensagem']); // Remove espaços desnecessários
        $token = $_POST['token']; // Pega o token da conversa

        // Verifica se a mensagem não está vazia
        if (!empty($mensagem)) {
            // Prepara a consulta para inserir a mensagem
            $sqlEnvio = "INSERT INTO mensagens (CONV_INT_ID, USU_INT_ID, MSG_VAR_CONTEUDO, MSG_ARTIGO_TOKEN) 
                         VALUES (?, ?, ?, ?)";
            $stmt = $conection->prepare($sqlEnvio);

            if ($stmt) {
                // Vincula os parâmetros: ID da conversa, ID do usuário, conteúdo da mensagem e token (se houver)
                $stmt->bind_param('iiss', $idChat, $idUser, $mensagem, $token);

                // Executa a consulta e verifica se foi bem-sucedida
                if ($stmt->execute()) {
                    // Retorna o ID da mensagem recém-criada
                    $lastMessageId = $stmt->insert_id;
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Mensagem enviada com sucesso!',
                        'lastMessageId' => $lastMessageId,
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Erro ao enviar mensagem: ' . htmlspecialchars($stmt->error),
                    ]);
                }
                $stmt->close();
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao preparar a consulta: ' . htmlspecialchars($conection->error),
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mensagem não pode estar vazia.',
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID da conversa, mensagem ou token não enviados.',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Requisição inválida.',
    ]);
}
?>
