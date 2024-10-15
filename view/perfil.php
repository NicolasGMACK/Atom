<?php
require_once('../view/php/protect.php');

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
            <li><a href="home.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="">Blog</a></li>
            <li><a href="">Products</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Forum</a></li>
            <li><a href="">Login</a></li>
        </ul>
        <ul>
            <li><a class="atom" href="">Atom<img src="../view/img/logo3.png" alt=""></a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/about.html">Sobre</a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/project.html">Projeto</a></li>
            <li class="profile">
                <div id="profileDropdown" class="topic usuario">
                <div  id="profileDropdown" class="foto user-space">
                    <img id="profileDropdown" src="../view/img/capeleti.png" alt="">
                </div>
               <?php echo $_SESSION['name'] ?>
            </div>
            </li>
               
                <div id="dropdownMenu" class="dropdown-content">
                    <a href="#">Visualizar perfil</a>
                    <a href="#">Configurações</a>
                    <a href="../view/php/logout.php">Sair</a>
                    
                </div>
                <script src="js/perfilDropdown.js"></script>
            <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </nav>         
        <!-- Capa do perfil -->
         <div class="topo1">            
            <div class="topo1-bloco">                
                <div class="cover-photo">
                    <img src="../view/img/background-img-2.png">
                </div>
                
                <!-- Informações do perfil -->
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="../view/img/kayky.png" alt="Foto de Perfil">
                    </div>
                    <div class="profile-name">
                        <h1>Kayky Paiva</h1>
                        <div class="seguintes">
                            <p><strong>567</strong> seguindo</p>
                            <p><strong>321</strong> seguidores</p>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button class="btn">Seguir</button>
                        <button class="btn msg">Mensagem</button>
                    </div>
                </div>

                <!-- Navegação do perfil -->
                <div class="profile-navigation">
                    <div class="opcao marcada">Publicações</div>
                   <div class="opcao selecionar">Seguidores</div>
                    <div class="opcao selecionar">Biblioteca</div>           
                </div>
            </div>
        </div>
        <div class="tela espaco">
            <div class="tela-coluna">
            <div class="lado-esquerdo1">
                <div class="bloco">
                    <div class="sobre">
                        <h1>Sobre</h1>
                        <div class="biografia"><br>
                        <strong>Biografia:</strong>
                        Kayky Brandão de Paiva é um apaixonado
                        por estudos climáticos e suas implicações
                        na agricultura. Natural de Xique-Xique,
                        Bahia, sua pesquisa é voltada para a análise
                        das transformações ambientais em regiões
                        vulneráveis e o desenvolvimento de práticas
                        das mudanças climáticas.</div>
                        <br><div class="localizacao">
                        <p><strong>Localização:</strong> Xique Xique</p>
                        </div>
                        <br><div class="trabalho">
                        <p><strong>Trabalho:</strong> Estudante</p>
                        </div>
                    </div>
                </div>
            </div>
          <div class="lado-direito1">
                <div class="bloco1">
                            <div class="bloco-top">
                                <p>Relacionado a <strong>Geografia</strong></p>
                            </div>
                            <div class="bloco-mid">
                                    <div class="cabecalho">
                                        <div class="foto user">
                                            <img src="../view/img/kayky.png" alt="img teste" class="user-photo">
                                        </div>
                                        <div class="profile-artigo">
                                            <div class="nome">Kayky Paiva</div>                        
                                            <p>Publicou um <a>artigo</a></p>
                                        </div>
                                    </div>
                                    <div class="conteudo">
                                        <a href="artigo.php">Mudanças Climáticas e Impactos na Agricultura: Um Estudo de Caso em Xique Xique, Bahia.</a>
                                        <br><br>
                                        <span>Agosto 2024 &#8226; Em andamento</span>
                                    </div>
                            </div>                    
                            <div class="bloco-bot">
                                <div class="rodape">
                                    <div class="rod">
                                        <button class="relevante" onclick="toggleLike(this)">
                                            <span class="material-symbols-outlined">shift</span><div class="vote">Relevante</div>
                                        </button>                            
                                        <button id="goToComments" class="comentarios"><i class="fa-regular fa-comment"></i>37</button>
                                        <script>
                                            document.getElementById('goToComments').addEventListener('click', function() {
                                                window.location.href = 'artigo.php#comments';
                                                });

                                        </script>   
                                        <button class="botoes" id="Salvar">Salvar</button>  
                                    </div>
                                            <div class="notification" id="notification">
                                                <h4 id="notificationTitle">Arquivo salvo com sucesso!</h4>
                                                <p id="notificationText">Você pode encontrar o arquivo no seu perfil.</p>                                        
                                            </div>                                    
                                    <script src="../view/js/salvar.js"></script>   

                                    
                                    <div class="ape">
                                        <button id="openCompartilhar" class="botoes">Compartilhar</button>
                                    </div>
                                <script src="js/upvote.js"></script>
                                </div>
                            </div>                      
                        </div>
                    </div>
                    </div>
                </div>
    
</body>
</html>
