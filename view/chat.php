<?php
require_once('../view/php/conection.php');
require_once('../view/php/protect.php');
require_once ('../view/php/listar_compartilhar.php');
require_once ('../view/php/ObterOuCriarToken.php');
require_once('../view/php/verificacaoChat.php');

             

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Simulado</title>
  <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    

<div class="sidebar">
    <h1>Conversas</h1>
    <div class="user-list">
        <?php if (count($usuariosConversa) > 0): ?>
            <?php foreach ($usuariosConversa as $usuario): ?>
                <?php
                $imagemPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg'; // Caminho da foto de perfil0';
                $userName = htmlspecialchars($usuario['USU_VAR_NAME']); // Nome do usuário
                $idConversa = $usuario['CONV_INT_ID']; // ID da conversa
                $tokenConversa = obterOuCriarToken($conection, 'conversa', $idConversa);  
                ?>
                <a href="conversa.php?token=<?=$tokenConversa?>"><div class="user" data-conv-id="<?= $idConversa ?>">
                    <img src="<?= $imagemPerfil ?>" alt="<?= $userName ?>">
                    <span><?= $userName ?></span>
                </div></a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma conversa encontrada.</p>
        <?php endif; ?>
    </div>
</div>


<!-- <div class="chat" style="display: none;">
    <div class="chat-header">
      <img src="https://via.placeholder.com/40" alt="Rafael Lima">
      <span>Rafael Lima</span>
    </div>
    <div class="chat-content">
      <div class="message user">Oi, tudo bem?</div>
      <div class="message other">Tudo sim, e você?</div>
      <div class="message user">Trabalhando no layout agora...</div>
    </div>
    <div class="chat-input">
      <input type="text" placeholder="Escreva uma mensagem...">
      <button>Enviar</button>
    </div>
  </div> -->
  
  <div class="no_chat">
    <h1>Selecione uma conversa ou encontre um usuário para iniciar uma.</h1>
  </div> 
</body>

<!-- JavaScript 
<script>
document.addEventListener("DOMContentLoaded", function () {
    const users = document.querySelectorAll(".user");

    users.forEach((user) => {
        user.addEventListener("click", function () {
            const idConversa = this.getAttribute("data-conv-id"); // Pega o ID da conversa

            // Fazendo a requisição para carregar mensagens
            fetch("php/get_messages.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `conv_id=${idConversa}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const chatContent = document.querySelector(".chat-content");
                        chatContent.innerHTML = ""; // Limpa mensagens anteriores

                        data.messages.forEach((message) => {
                            const messageDiv = document.createElement("div");
                            messageDiv.classList.add("message");
                            messageDiv.classList.add(
                                message.sender_id === <?= $userId ?> ? "user" : "other"
                            );
                            messageDiv.textContent = message.content;
                            chatContent.appendChild(messageDiv);
                        });
                    } else {
                        alert("Erro ao carregar as mensagens.");
                    }
                })
                .catch((error) => {
                    console.error("Erro ao carregar mensagens:", error);
                });
        });
    });
});
</script>-->

</html>
