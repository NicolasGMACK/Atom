<?php
require_once('../view/php/protect.php');
$userId = $_SESSION['id']; // ID do usuário logado

include('../view/php/criar_token_pessoal.php');
include('../view/php/listar_compartilhar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <li><a href="">Blog</a></li>
            <li><a href="">Products</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Forum</a></li>
            <li><a href="">Login</a></li>
        </ul>
        <ul>
            <li><a class="atom" href="home.php">Atom<img src="../view/img/logo3.png" alt=""></a></li>
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
    <div class="tela1">
    <div class='topo'>
        <div class='topo-bloco'>
            <div class='voltar'>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
                <div class='circulo-padding'>
                    <div class='circulo'>
                        <a onclick='goBack()'>
                            <i class='fa-solid fa-arrow-left'></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class='cartao'>
                <?php
            require_once('php/carregar_perfil_artigos.php');
            ?>
                <div class='cartao-bot'>
                    <div class='rod'>
                        <button class='votos'>
                            <span class='material-symbols-outlined'>shift</span>
                            <p><?php echo $numLikes; ?></p> <!-- Exibe o número de upvotes -->
                        </button>
                        <button id='scrollToComments' class='comentarios'>
                            <i class='fa-regular fa-comment'></i>
                            <?php echo $numComentarios; ?> <!-- Exibe o número de comentários -->
                        </button>
                    </div>
                    <div class='ape'>
                        <button class='botoes' id='Salvar'>Salvar</button>
                        <div class='notification' id='notification'>
                            <h4 id='notificationTitle'>Arquivo salvo com sucesso!</h4>
                            <p id='notificationText'>Você pode encontrar o arquivo no seu perfil.</p>
                        </div>
                        <script src='../view/js/salvar.js'></script>
                        <button class='botoes openCompartilhar' data-token-artigo='<?= $tokenArtigo ?>'>Compartilhar</button>
                        <button class='baixar' onclick="window.location.href='../view/php/baixar_artigo.php?token=<?php echo $token; ?>'">
                            <i class='fa-regular fa-circle-down'></i><p>Download</p>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
        <div class="tela2">
        <div class="telas-da-tela2">
            <div class="tela2-esquerda">
                <div class="desc-bloco">
                    <div class="desc-title">
                        <h4>Descrição</h4>
                    </div>
                    <div class="desc-text">
                        <p><?php echo $descricao;?></p>
                    </div>
                </div>
                <div class="desc-bloco comentarios-space">
                    <div class="desc-title">
                        <h4>Comentários</h4>
                    </div>
                    <script>                                               
                        document.getElementById('scrollToComments').addEventListener('click', function() {
                        document.getElementById('comments').scrollIntoView({ behavior: 'smooth' });
                        });
                    </script>
                    <div id="comments" class="comentarios-bloco">
                            <div class="my-comment">
                                <textarea rows="3" placeholder="Adicione um comentário..." id="novo-comentario"></textarea>
                                <div class="comment-btn">
                                    <button class="comentarios-enviar-btn" onclick="submitReply(0)">Enviar</button>
                                </div>
                            </div>

                             <!-- Aqui você vai inserir os comentários do banco de dados -->
                             <?php  
                            include('php/exibir_comentarios.php');
                            ?>

                        
                        
                        <script>
    // Definindo userId e artigoId com os valores correspondentes do PHP
                        const userId = <?php echo json_encode($_SESSION['id']); ?>; // O ID do usuário logado
                        const artigoId = <?php echo json_encode($artigoId); ?>; // O ID do artigo atual
                    </script>
                        <script src="../view/js/comentarios.js"></script>
                    </div>
                </div>
            </div>
            <div class="tela2-direita">
                <div class="desc-bloco autores">
                    <div class="follow-title">
                        Acompanhe os autores
                    </div>
                    <div class="autor-follow">
                        <div class="autor-bloco">
                            <div class="autor-entrar">
                           <div class="autor-foto">
                           <?php echo '<img src="'.$autorFoto.'" alt="">  '?>                          
                           </div>
                           <div class="autor-nome"><p><?php echo $autor; ?></p></div>
                        </div>
                           <div class="follow"><p>Seguir</p></div>
                        </div>                        
                         <div class="space-bottom"></div>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
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
    </div>
</body>
<script src="../view/js/showCompartilhar.js"></script>
<script src="../view/js/compartilharArtigo.js"></script> 
    

</html>