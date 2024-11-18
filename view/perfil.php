<?php
require_once('../view/php/protect.php');
require_once('../view/php/verificacao_perfil.php');
include('../view/php/criar_token_pessoal.php');
include('../view/php/listar_compartilhar.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/artigo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <!-- Bloco de notificação -->
    <div class='notification' id='notification'>
                            <h4 id='notificationTitle'>Arquivo salvo com sucesso!</h4>
                            <p id='notificationText'>Você pode encontrar o arquivo no seu perfil.</p>
                        </div>          
        <!-- Capa do perfil -->
         <div class="topo1">            
            <div class="topo1-bloco"> 

               <?php require_once('../view/php/carregar_perfil_usuario.php') ?>
                  
            </div>
        </div>
        
        <div class="tela espaco" id="publicacoes" style="display: flex;">
    <!-- Conteúdo das Publicações -->
    <div class="tela-coluna">
        <div class="lado-esquerdo1">
            <div class="bloco">
                <div class="sobre">
                    <h1>Sobre</h1>
                    <div class="biografia"><br>
                    <p><?php echo $desc; ?></p></div>
                    <br><div class="localizacao">
                    <p><strong>Localização:</strong> <?php echo $cidade; ?></p>
                    </div>
                    <br><div class="trabalho">
                    <p><strong>Trabalho:</strong> <?php echo $ocupacao; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lado-direito1">
            <div class="lista1">
                <?php include ('php/carregar_artigos_perfil.php') ?>
            </div>
        </div>
    </div>
</div>

<div class="tela espaco" id="biblioteca" style="display: none;">
    <!-- Conteúdo da Biblioteca -->
    <div class="tela-coluna">
        <div class="lado-esquerdo1">
            <div class="bloco">
                <?php require_once('php/mostrar_dados_artigos_salvos.php') ?>
                <div class="sobre">
                    <h1>Lista salva</h1>                    
                    <br><div class="localizacao">
                    <p><strong>Artigos salvos:</strong> <?= $numArtigosSalvos ?>.</p>
                    </div>
                    <br><div class="trabalho">
                    <p><strong>Autores:</strong> <?= $numAutoresDistintos ?>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lado-direito1">
            <div class="lista1">
                <?php include ('php/carregar_artigos_salvos.php') ?>                
            </div>
        </div>
    </div>
</div>
</body>
<!-- Popup Compartihar-->
<div class="compartilhar" id="compartilhar" style="display: none">
    <div class="compartilhar-conteudo">
        <h1>Compartilhe a publicação com quem você conhece</h1>
        <br>

        <!-- Verifica se há usuários para exibir -->
        <?php if (count($usuariosConversa) > 0): ?>
            <ul class="lista-sugestao">
                <?php foreach ($usuariosConversa as $usuario): ?>
                    <?php
                    $imagemPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';
                    $convId = $usuario['CONV_INT_ID']; // Pegando o ID da conversa
                    $userName = $usuario['USU_VAR_NAME'];
                    $userIdConversa = $usuario['USU_INT_ID'];
                    ?>
                    <li class="user-linha" data-conv-id="<?= $convId ?>" data-user-id="<?= $userIdConversa ?>">
                        <img src="<?= $imagemPerfil ?>" alt="Profile">
                        <span><?= $userName ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="lista-sugestao">
                <h3>Você não interagiu com nenhum usuário ainda.</h3>
            </div>
        <?php endif; ?>

        <!-- Input oculto para armazenar o token do artigo -->
        <input type="hidden" id="tokenArtigoInput" />

        <div class="compartilhar-footer">
            <button id="fecharCompartilhar" class="cancelar-btn">Cancelar</button>
            <button class="compartilhar-btn" onclick="compartilharArtigo()">Compartilhar</button>
        </div>
    </div>
</div>
            
    <script src="../view/js/showCompartilhar.js"></script>
    <script src="../view/js/compartilharArtigo.js"></script>     
    <script src="js/upvote.js"></script>
    <script src='../view/js/salvar.js'></script>    
    <script src="../view/js/alternarTelasPerfil.js"></script>  
                           
            
</html>
