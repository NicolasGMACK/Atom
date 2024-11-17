<?php
require_once('protect.php');
require_once('conection.php');
require_once('funcao_mensagem.php'); // Incluindo a função de exibição de mensagens

if (isset($_GET['convId'])) {
    $convId = $_GET['convId'];

    // Consulta para buscar as mensagens da conversa
    $sqlMensagens = "SELECT u.USU_VAR_NAME, u.USU_VAR_IMGPERFIL, m.USU_INT_ID, m.MSG_VAR_CONTEUDO, 
                             m.MSG_TIPO, m.MSG_ARTIGO_TOKEN, m.MSG_DAT_ENVIO
                      FROM usuario u
                      JOIN mensagens m ON u.USU_INT_ID = m.USU_INT_ID
                      WHERE m.CONV_INT_ID = ?
                      ORDER BY m.MSG_DAT_ENVIO ASC";
    $stmtMensagens = $conection->prepare($sqlMensagens);
    $stmtMensagens->bind_param('i', $convId);
    $stmtMensagens->execute();
    $resultMensagens = $stmtMensagens->get_result();

    if ($resultMensagens->num_rows > 0) {
        $dataAnterior = null; // Inicializa o controle de data

        while ($mensagem = $resultMensagens->fetch_assoc()) {
            // Exibe a mensagem com separação por data
            $dataAnterior = exibirMensagem($mensagem, $dataAnterior);
        }
    }
}
?>
