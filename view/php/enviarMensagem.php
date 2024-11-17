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
                         VALUES (?, ?, ?, ?)";  // A coluna MSG_ARTIGO_TOKEN é opcional, dependendo de como você está tratando os artigos
            $stmt = $conection->prepare($sqlEnvio);

            if ($stmt) {
                // Vincula os parâmetros: ID da conversa, ID do usuário, conteúdo da mensagem e token (se houver)
                $stmt->bind_param('iiss', $idChat, $idUser, $mensagem, $token);

                // Executa a consulta e verifica se foi bem-sucedida
                if ($stmt->execute()) {
                    echo "Mensagem enviada com sucesso!";
                } else {
                    echo "Erro ao enviar mensagem: " . htmlspecialchars($stmt->error);
                }
                $stmt->close();
            } else {
                echo "Erro ao preparar a consulta: " . htmlspecialchars($conection->error);
            }
        } else {
            echo "Mensagem não pode estar vazia.";
        }
    } else {
        echo "Erro: ID da conversa, mensagem ou token não enviados.";
    }
} else {
    echo "Requisição inválida.";
}
?>
