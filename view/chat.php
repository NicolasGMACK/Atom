<?php
require_once('../view/php/conection.php');
require_once('../view/php/protect.php');
require_once('../view/php/verificacaoChat.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style type="text/css">
        .message-bar {
            position: fixed;
            bottom: 0; /* Fixa na parte inferior da tela */
            left: 0;
            width: 100%; /* Ocupa a largura total da tela */
            background-color: #f1f1f1;
            padding: 10px;
            box-shadow: 0px -2px 8px rgba(0, 0, 0, 0.2); /* Sombras para destacar */
            display: flex; /* Flexbox para organizar o conteúdo */
            align-items: center;
        }

        .message-bar input[type="text"] {
            width: 85%; /* Ocupa a maior parte da barra */
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .message-bar input[type="submit"] {
            padding: 8px 16px;
            background-color: #8c52ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message-bar input[type="submit"]:hover {
            background-color: #45a049;
        }


        .message {
            max-width: 60%; /* Limita a largura da mensagem */
            margin: 10px; /* Espaçamento entre mensagens */
            padding: 10px 15px;
            margin-top: 70px;
            border-radius: 15px;
            background-color: lightgray; /* Cor de fundo similar ao WhatsApp */
            position: relative; /* Para posicionar a data de envio */
            font-family: Arial, sans-serif;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para a mensagem do próprio usuário */
        .message.user {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        /* Estilo para a mensagem do outro usuário */
        .message.other {
            background-color: lightgray;
            align-self: flex-start;
            margin-bottom: 60px;
        }

        /* Nome do usuário em negrito */
        .message .user-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Estilo para a data de envio no canto inferior direito */
        .message .timestamp {
            position: absolute;
            bottom: 5px;
            right: 10px;
            font-size: 0.75em;
            color: #555;
        }
        /* Estilo geral para o cabeçalho da conversa */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #8c52ff; /* Cor similar ao WhatsApp */
            color: white;
            padding: 0 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
            box-sizing: border-box;
        }

        /* Estilo para o botão de voltar */
        header a {
            text-decoration: none;
            color: white;
            font-size: 1.2em;
        }

        /* Estilo para o nome do usuário */
        header .user-name {
            flex-grow: 1;
            text-align: center;
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <?php 
        $sqlChat = "SELECT CONV_INT_ID, USU_INT_ID_1, USU_INT_ID_2 FROM conversas WHERE (USU_INT_ID_1 = $userChat1 AND USU_INT_ID_2 = $userChat2) OR
        (USU_INT_ID_1 = $userChat2 AND USU_INT_ID_2 = $userChat1)";
        $exSqlChat = mysqli_query($conection, $sqlChat);
        $chat = mysqli_fetch_assoc($exSqlChat);
        $usuarioChat1 =  $chat['USU_INT_ID_1'];
        $usuarioChat2 = $chat['USU_INT_ID_2'];
        $conversaId = $chat['CONV_INT_ID'];
    ?>
    <header class="conversa">
        <a href="home.php">Voltar</a>
        <div class="user-name">
            <?php 
            if ($usuarioChat1 == $_SESSION['id']) { 
                $selectNomeChat = "SELECT USU_VAR_NAME FROM usuario WHERE USU_INT_ID = $usuarioChat2";
                $exSelectNomeChat = mysqli_query($conection, $selectNomeChat);
                $nomeChat = mysqli_fetch_assoc($exSelectNomeChat);
                echo $nomeChat['USU_VAR_NAME'];
            } else {
                $selectNomeChat = "SELECT USU_VAR_NAME FROM usuario WHERE USU_INT_ID = $usuarioChat1";
                $exSelectNomeChat = mysqli_query($conection, $selectNomeChat);
                $nomeChat = mysqli_fetch_assoc($exSelectNomeChat);
                echo $nomeChat['USU_VAR_NAME'];
            } 
            ?>
        </div>
    </header>

    <div class="mensagens">
    <?php 
    require_once('../view/php/enviarMensagem.php');

    // Adicionando filtro de CONV_INT_ID para mostrar apenas mensagens da conversa atual
    $sqlPesquisaChat = "SELECT u.USU_VAR_NAME, m.CONV_INT_ID, m.USU_INT_ID, m.MSG_VAR_CONTEUDO, 
                               m.MSG_TIPO, m.MSG_ARTIGO_TOKEN, m.MSG_DAT_ENVIO
                        FROM usuario u
                        JOIN mensagens m ON u.USU_INT_ID = m.USU_INT_ID
                        WHERE m.CONV_INT_ID = $conversaId
                        ORDER BY m.MSG_DAT_ENVIO ASC";
    $sqlPesquisaChatExecute = mysqli_query($conection, $sqlPesquisaChat);

    while ($conversa = mysqli_fetch_assoc($sqlPesquisaChatExecute)) {
        $conteudo = $conversa['MSG_VAR_CONTEUDO'];
        $tipoMensagem = $conversa['MSG_TIPO'];
        $tokenArtigo = $conversa['MSG_ARTIGO_TOKEN'];

        // Verificar o tipo da mensagem
        if ($tipoMensagem === 'artigo' && !empty($tokenArtigo)) {
            // Mensagem é um compartilhamento de artigo
            $conteudo = 'Confira este artigo: <a href="artigo.php?token=' . $tokenArtigo . '" target="_blank">Clique aqui para ver o artigo</a>';
        }

        // Exibir a mensagem
        echo '
            <div class="message other">
                <p class="user-name">' . $conversa['USU_VAR_NAME'] . '</p>
                <p>' . $conteudo . '</p>
                <span class="timestamp">' . $conversa['MSG_DAT_ENVIO'] . '</span>
            </div>';
    }
    ?>
    <div>
        <form action="" method="post" class="message-bar">
            <input type="hidden" name="idChat" value="<?php echo $conversaId; ?>" id="">
            <input type="hidden" name="idUser" value="<?php echo $_SESSION['id']; ?>" id="">
            <input type="text" name="mensagem" id="">
            <input type="submit" name="Enviar" value="Enviar">
        </form>
    </div>
</div>


</body>
</html>