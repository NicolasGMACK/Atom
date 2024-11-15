<?php
require_once('../view/php/protect.php');
include('../view/php/mensagens_postagem.php');
include('../view/php/criar_token_pessoal.php');
include('../view/php/compartilhar_artigos.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
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
    <div class="tela">
        <div class="lado-esquerdo">
            <div class="lista">
                <div class="bloco">
                    <div class="linha">
                        <input class="pesquisar" type="text" placeholder="Procure por artigos, assuntos, pessoas, etc.">
                    </div>
                </div>

                <div class="bloco">
                    <div class="titulo-filtro"><h2>Filtrar Resultados</h2></div>
                       <div class="space-categoria"><div class="filtro-categoria">
                            <h3>Por Data</h3>
                            <ul class="opcoes" >
                                <li class="topico"><a class="texto" href="#">Qualquer período</a></li>
                                <li class="topico"><a class="texto" href="#">Desde 2024</a></li>
                                <li class="topico"><a class="texto" href="#">Desde 2023</a></li>
                                <li class="topico"><a class="texto" href="#">Desde 2020</a></li>
                                <li class="margin topico">
                                    <p class="texto" id="openIntervalo">Intervalo personalizado...</p>
                                </li>
                            </ul>
                            <script src="js/filtroIntervalo.js"></script>
                            <div class="intervalo">
                                <div>
                                    <input placeholder="Início" type="number" class="year-input" min="2000" max="2059">
                                    ____
                                    <input placeholder="Fim" type="number" class="year-input"  min="2000" max="2059">
                                    <input type="submit" value="Buscar">
                                    <script src="js/digitos-input-filtro.js"></script>
                                </div>
                                
                            </div>
                        </div></div>                
                        <div class="space-categoria">
                            <div class="filtro-categoria">
                                <h3>Tipo de Conteúdo</h3>                                
                                    <select>
                                        <option value="" disabled selected>Escolha a categoria</option>
                                        <option value="geografia">Geografia</option>
                                        <option value="historia">História</option>
                                        <option value="ciencias">Ciências</option>
                                        <option value="literatura">Literatura</option>
                                    </select>                                
                                <div>
                                    <input type="checkbox" id="patents">
                                    <label for="patents">Em andamento</label>
                                </div>
                                <div class="filtro-bottom">
                                    <input type="checkbox" id="citations">
                                    <label for="citations">Concluído</label>
                                </div>
                            </div>
                        </div>                    
                        <div class="space-categoria line-bottom">
                            <div class="filtro-categoria">
                                <h3>Ordenar por</h3>
                                <ul class="opcoes" >
                                    <li class="topico"><a class="texto" href="#">Relevância</a></li>
                                    <li class="topico margin"><a class="texto" href="#">Data</a></li>
                                </ul>
                            </div>
                        </div> <div class="space-bottom"></div>
                
                    
                </div>
            </div>
        </div>
        <div class="lado-direito">
        <div class="lista">

            <!-- Primeira div bloco -->
            <div class="bloco">
                <div class="bloco-mid">
                    <div class="cabecalho-postagem">                              
                        <div class="conteudo-postagem">
                            <a>Interessado em publicar seu projeto? Faça sua postagem!</a>
                        </div>
                        <div class="butao">
                            <button class="publicar" id="openPopup">PUBLICAR</button>                            
                        </div> 
                    </div>
                </div>
                <div class="upload-mid">
                    <input type="file" id="file-upload" class="none">
                </div>
            </div> <!-- Fecha a primeira div.bloco -->


            <!-- Segunda div bloco -->
            <?php
// Incluir o arquivo que carrega os artigos
            include ('php/carregar_artigos.php');            
            ?>
            <div class='notification' id='notification'>
                            <h4 id='notificationTitle'>Arquivo salvo com sucesso!</h4>
                            <p id='notificationText'>Você pode encontrar o arquivo no seu perfil.</p>
                        </div>
<script src='../view/js/salvar.js'></script>            
<script src="js/upvote.js"></script>

        </div> <!-- Fecha a div.lista -->
    </div> <!-- Fecha a div.lado-direito -->
</div> <!-- Fecha a div.tela -->
            

<!-- Popup Compartihar-->
<div class="compartilhar" id="compartilhar" style="display: none">
    <div class="compartilhar-conteudo">
        <h1>Compartilhe a publicação com quem você conhece</h1>
        <br>
    <!--    <div class="linha-compartilhar">
           <input class="pesquisa-compartilhar" type="text" placeholder="Pessoas com quem você quer compartilhar...">
        </div>-->
        <br>
        
        <!-- Verifica se há usuários para exibir -->
        <?php if (count($usuariosConversa) > 0): ?>
            <ul class="lista-sugestao">
                <?php foreach ($usuariosConversa as $usuario): ?>
                    <li class="user-linha">
                        <?php
                        // Verifica se a imagem do usuário está definida e não é nula
                        $imagemPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';
                        ?>
                        <img src="<?= $imagemPerfil ?>" alt="Profile">
                        <span><?= $usuario['USU_VAR_NAME'] ?></span>
                    </li>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="lista-sugestao">
                        <h3>Você não interagiu com nenhum usuário ainda.</h3>
                    </div>
                <?php endif; ?>
            </ul>
        
        
        <div class="compartilhar-footer">
            <button id="fecharCompartilhar" class="cancelar-btn">Cancelar</button>
            <button class="compartilhar-btn">Compartilhar</button>
        </div>
    </div>
</div>

  
    

<!-- formulario Artigo-->
<div id="popupForm" class="popup">
    <div class="popup-content">
        <span class="close" id="closePopup">&times;</span>
        <div class="rodape center"><h1>Publicar Artigo</h1></div>
        <form action="../view/php/postagem.php" method="post" enctype="multipart/form-data" class="formulario">
            <input class="estilo" type="text" id="titulo" name="titulo" placeholder="Título do Artigo">
             <textarea class="estilo" id="descricao" name="descricao" placeholder="Descrição do Artigo"></textarea>            

                <select class="estilo" required id="categoria" name="categoria">
                    <option value="" disabled selected>Escolha o categoria</option>
                    <option value="Geografia">Geografia</option>
                    <option value="História">História</option>
                    <option value="Ciências">Ciências</option>
                    <option value="Literatura">Literatura</option>
                </select>
                <div class="status-group">
                    <h3>Status do Projeto:</h3>
                    <div class="status-bloco">
                        <div class="status-option">
                            <input type="radio" id="em-andamento" name="status" value="Em andamento">
                            <label for="em-andamento">Em andamento</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="concluido" name="status" value="Concluído">
                            <label for="concluido">Concluído</label>
                        </div>
                    </div>
                </div>
        <!-- Input para adicionar PDF -->
        <input class="estilo" type="file" id="pdf" name="pdf" accept=".pdf">
    <button class="add" type="submit">Adicionar Artigo</button>
        </form>
    </div>
</div>

<script src="../view/js/showFormulario.js"></script>




    </div>
</div>

    <script>
        function showSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'flex'
        }
        function hideSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'none'
        }
    </script>    
</body>
<script src="../view/js/showCompartilhar.js"></script>
</html>