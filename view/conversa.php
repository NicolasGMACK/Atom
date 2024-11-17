<?php
require_once('../view/php/conection.php');
require_once('../view/php/protect.php');
require_once('../view/php/listar_compartilhar.php');
require_once('../view/php/ObterOuCriarToken.php');
require_once('../view/php/funcao_mensagem.php'); // Inclui a função de exibir mensagem
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Simulado</title>
  <link rel="stylesheet" href="css/chat.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <nav>
        <ul class="sidebar">
            <li><a href=""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a class="topic" href="../view/about.html">Sobre</a></li>
            <li><a class="topic" href="../view/project.html">Projeto</a></li>
            <li><a class="topic" href="../view/chat.php"><i class="fa-solid fa-comments"></i></a></li>            
        </ul>
        <ul>            
            <li><a class="atom" href="home.php">Atom<img src="../view/img/logo3.png" alt=""></a></li>
            <li><a class="topic" href="../view/chat.php"><i class="fa-solid fa-comments"></i></a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/about.html">Sobre</a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/project.html">Projeto</a></li>                  
            <li class="profile">
            <div id="profileDropdown" class="topic usuario">
                <div  id="profileDropdown" class="foto user-space">
                <?php   if (empty($_SESSION['ftperfil'])) {
                    $_SESSION['ftperfil'] = '../view/img/user.jpg';
                } echo '<img id="profileDropdown" src="' . $_SESSION['ftperfil'] . '" alt="">'; ?>

                </div>
               <?php echo $_SESSION['name'] ?>
            </div>
            </li>
               
                <div id="dropdownMenu" class="dropdown-content">
                <a href="perfil_pessoal.php?token=<?php echo $tokenPessoal; ?>">Visualizar perfil</a>
                    <a href="#">Configurações</a>
                    <a href="../view/php/logout.php">Sair</a>
                    
                </div>
                <script src="js/perfilDropdown.js"></script>
            <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </nav>
<div class="tudo">
        <div class="sidebar1">
            <h1>Conversas</h1>
            <div class="user-list">
                <?php if (isset($usuariosConversa) && count($usuariosConversa) > 0): ?>
                    <?php foreach ($usuariosConversa as $usuario): ?>
                        <?php
                        $imagemPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';
                        $userName = htmlspecialchars($usuario['USU_VAR_NAME']);
                        $idConversa = $usuario['CONV_INT_ID'];
                        $tokenConversa = obterOuCriarToken($conection, 'conversa', $idConversa);
                        ?>
                        <a href="conversa.php?token=<?= $tokenConversa; ?>">
                            <div class="user" data-conv-id="<?= $idConversa; ?>">
                                <img src="<?= $imagemPerfil; ?>" alt="<?= $userName; ?>">
                                <span><?= $userName; ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma conversa encontrada.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            // Busca o ID da conversa e identifica o outro usuário
            $sqlConversa = "
                SELECT c.CONV_INT_ID, 
                    u.USU_VAR_NAME AS NOME_USUARIO, 
                    u.USU_VAR_IMGPERFIL AS IMAGEM_USUARIO
                FROM conversas c
                JOIN usuario u ON u.USU_INT_ID = 
                    (CASE 
                        WHEN c.USU_INT_ID_1 = ? THEN c.USU_INT_ID_2 
                        ELSE c.USU_INT_ID_1 
                    END)
                WHERE c.CONV_INT_ID = (
                    SELECT CONV_INT_ID FROM tokens_conversa WHERE TOK_CON_VAR_TOK = ? 
                )";
            $stmtConversa = $conection->prepare($sqlConversa);
            $stmtConversa->bind_param('is', $_SESSION['id'], $token);
            $stmtConversa->execute();
            $resultConversa = $stmtConversa->get_result();

            if ($resultConversa->num_rows > 0) {
                $conversa = $resultConversa->fetch_assoc();
                $ConvId = $conversa['CONV_INT_ID'];
                $nome = htmlspecialchars($conversa['NOME_USUARIO']);
                $foto = !empty($conversa['IMAGEM_USUARIO']) ? $conversa['IMAGEM_USUARIO'] : '../view/img/user.jpg';

                // Consulta as mensagens da conversa
                $sqlMensagens = "
                    SELECT u.USU_VAR_NAME, 
                        u.USU_VAR_IMGPERFIL, 
                        m.MSG_VAR_CONTEUDO, 
                        m.MSG_TIPO, 
                        m.MSG_ARTIGO_TOKEN, 
                        m.MSG_DAT_ENVIO,
                        m.USU_INT_ID
                    FROM mensagens m
                    JOIN usuario u ON u.USU_INT_ID = m.USU_INT_ID
                    WHERE m.CONV_INT_ID = ? 
                    ORDER BY m.MSG_DAT_ENVIO ASC";
                $stmtMensagens = $conection->prepare($sqlMensagens);
                $stmtMensagens->bind_param('i', $ConvId);
                $stmtMensagens->execute();
                $resultMensagens = $stmtMensagens->get_result();
            }
        }
        ?>

        <div class="chat">
            <?php if (isset($ConvId)): ?>
                <div class="chat-header">
                    <img src="<?= htmlspecialchars($foto); ?>" alt="<?= htmlspecialchars($nome); ?>">
                    <span><?= htmlspecialchars($nome); ?></span>
                </div>
                <div class="chat-content">
            <?php if ($resultMensagens->num_rows > 0): ?>
                <?php
                $dataAnterior = null; // Inicializa a variável para controlar a mudança de data
                ?>
                <?php while ($mensagem = $resultMensagens->fetch_assoc()): ?>
                    <?php
                    // Chama a função de exibição de mensagem, passando a data anterior
                    $dataAnterior = exibirMensagem($mensagem, $dataAnterior);
                    ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p></p>
            <?php endif; ?>
        </div>


                <div class="chat-input">
                    <form id="chatForm">
                        <input type="hidden" name="idChat" value="<?= $ConvId; ?>">
                        <input type="hidden" name="token" value="<?= $token; ?>"> <!-- Token da conversa -->
                        <input  class="mandar_msg" type="text" name="mensagem" placeholder="Escreva uma mensagem..." required id="mensagem">
                        <button type="submit" name="Enviar">Enviar</button>
                    </form>
                </div>

            <?php else: ?>
                <p>Conversa não encontrada ou inválida.</p>
            <?php endif; ?>
        </div>
</div>
</body>
<script>
    document.getElementById("chatForm").addEventListener("submit", function(e) {
        e.preventDefault(); // Impede o envio tradicional do formulário

        const formData = new FormData(this); // Pega os dados do formulário
        const mensagem = document.getElementById("mensagem").value.trim(); // Pega a mensagem

        if (mensagem) {
            // Envia a mensagem via AJAX
            fetch('php/enviarMensagem.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Mensagem enviada com sucesso!')) {
                    // Limpa o campo de entrada de mensagem
                    document.getElementById("mensagem").value = '';
                    // Atualiza a conversa sem recarregar a página
                    loadMessages();
                } else {
                    alert('Erro ao enviar mensagem');
                }
            })
            .catch(error => {
                console.error('Erro ao enviar a mensagem:', error);
                alert('Erro ao enviar mensagem');
            });
        }
    });

    // Função para carregar as mensagens atualizadas
    function loadMessages() {
        const convId = document.querySelector('input[name="idChat"]').value;
        
        // Faz a requisição para obter as mensagens mais recentes
        fetch(`php/atualizarMensagem.php?convId=${convId}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.chat-content').innerHTML = data;
                scrollToBottom();
            })
            .catch(error => {
                console.error('Erro ao carregar mensagens:', error);
            });
    }

    // Função para rolar a tela até a última mensagem
    function scrollToBottom() {
        const chatContent = document.querySelector('.chat-content');
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    // Carregar as mensagens assim que a página for carregada
    window.onload = loadMessages;
</script>
</html>
