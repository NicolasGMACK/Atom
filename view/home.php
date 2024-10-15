<?php
require_once('../view/php/protect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/home.css">
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
                <a href="perfil.php">Visualizar perfil</a>
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
                                        <option value="" disabled selected>Escolha o tema</option>
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
                    
                </div>                
                <div class="bloco">
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

<!-- formulario Artigo-->
<div id="popupForm" class="popup">
    <div class="popup-content">
        <span class="close" id="closePopup">&times;</span>
        <div class="rodape center"><h1>Publicar Artigo</h1></div>
        <form class="formulario">
            <input class="estilo" type="text" id="titulo" name="titulo" placeholder="Título do Artigo">

            
            <textarea class="estilo" id="descricao" name="descricao" placeholder="Descrição do Artigo"></textarea>            
            <select class="estilo" required id="tema" name="tema">
                <option value="" disabled selected>Escolha o tema</option>
                <option value="geografia">Geografia</option>
                <option value="historia">História</option>
                <option value="ciencias">Ciências</option>
                <option value="literatura">Literatura</option>
            </select>

          
            <div class="status-group">
                <h3>Status do Projeto:</h3>
                <div class="status-bloco">
                    <div class="status-option">
                        <input type="radio" id="em-andamento" name="status" value="em-andamento">
                        <label for="em-andamento">Em andamento</label>
                    </div>
                    <div class="status-option">
                        <input type="radio" id="concluido" name="status" value="concluido">
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

<script src="../view/js/showArtigo.js"></script>

<!-- Popup Compartihar-->

<div class="compartilhar" id="compartilhar">
    <div class="compartilhar-conteudo">
        <h1>Compartilhe a publicação com quem você conhece</h1>
        <br>
        <div class="linha-compartilhar">
            <input class="pesquisa-compartilhar" type="text" placeholder="Pessoas com quem você quer compartilhar...">
        </div>
        <br>
        <ul class="lista-sugestao">
            <li class="user-linha">
                <img src="../view/img/capeleti.png" alt="Profile">
                <span>Vitor Capeleti</span>
            </li>
            <li class="user-linha">
                <img src="../view/img/capeleti.png" alt="Profile">
                <span>Abhinav Pandey</span>
            </li>
            <li class="user-linha">
                <img src="../view/img/capeleti.png" alt="Profile">
                <span>Sanket Nandan</span>
            </li>
            <li class="user-linha">
                <img src="../view/img/capeleti.png" alt="Profile">
                <span>Prasanta K. Panigrahi</span>
            </li>
            <li class="user-linha">
                <img src="../view/img/capeleti.png" alt="Profile">
                <span>Jose ANGEL Alvarez Garcia</span>
            </li>
        </ul>
        <div class="compartilhar-footer">
            <button id="fecharCompartilhar" class="cancelar-btn">Cancelar</button>
            <button class="compartilhar-btn">Compartilhar</button>
        </div>
    </div>
</div>
<script src="../view/js/showCompartilhar.js"></script>

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
</html>