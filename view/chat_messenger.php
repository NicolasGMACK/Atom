<?php
require_once('../view/php/protect.php');
require_once '../view/php/conection.php';

// Obter usuário logado
$userId = $_SESSION['id'];

// Obter lista de conversas
$sqlConversas = "SELECT c.CONV_INT_ID, u.USU_VAR_NAME, u.USU_INT_ID FROM conversas c
                 JOIN usuario u ON (u.USU_INT_ID = c.USU_INT_ID_1 OR u.USU_INT_ID = c.USU_INT_ID_2)
                 WHERE (c.USU_INT_ID_1 = $userId OR c.USU_INT_ID_2 = $userId) AND u.USU_INT_ID != $userId";
$resultConversas = mysqli_query($conection, $sqlConversas);

// Selecionar conversa
$conversaId = isset($_GET['conversa']) ? $_GET['conversa'] : 0;
$sqlMensagens = "SELECT m.USU_INT_ID, m.MSG_VAR_CONTEUDO, m.MSG_DAT_ENVIO FROM mensagens m WHERE m.CONV_INT_ID = $conversaId ORDER BY m.MSG_DAT_ENVIO ASC";
$resultMensagens = mysqli_query($conection, $sqlMensagens);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<link rel="stylesheet" href="../view/css/chat.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <h2>Bate-papos</h2>
        <div class="conversas-list">
            <?php while ($conversa = mysqli_fetch_assoc($resultConversas)) { 
                $userName = $conversa['USU_VAR_NAME'];
                $idConversa = $conversa['CONV_INT_ID'];
                ?>
                <a href="?conversa=<?= $idConversa ?>" class="conversa">
                    <p><?= $userName ?></p>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="chat">
        <div class="chat-header">
            <h2>Chat</h2>
        </div>
        <div class="chat-messages">
            <?php while ($msg = mysqli_fetch_assoc($resultMensagens)) { 
                $isUser = $msg['USU_INT_ID'] == $userId;
                $msgClass = $isUser ? 'message user' : 'message other';
                ?>
                <div class="<?= $msgClass ?>">
                    <p><?= $msg['MSG_VAR_CONTEUDO'] ?></p>
                    <span class="timestamp"><?= $msg['MSG_DAT_ENVIO'] ?></span>
                </div>
            <?php } ?>
        </div>
        <div class="chat-input">
            <form action="php/enviarMensagem.php" method="post">
                <input type="hidden" name="conversa_id" value="<?= $conversaId ?>">
                <input type="text" name="mensagem" placeholder="Escreva uma mensagem..." autocomplete="off">
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
