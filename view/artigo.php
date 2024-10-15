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
    <div class="tela1">
        <div class="topo">
            <div class="topo-bloco">
            <div class="voltar">
            <script>
        function goBack() {
            window.history.back();
        }
    </script>
                <div class="circulo-padding">
                    <div class="circulo">                   
                        <a onclick="goBack()">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>                    
                    </div>
                </div>
            </div>
            <div class="cartao">
                <div class="cartao-top">
                    <div class="status">Em andamento</div><div class="tema">Geografia</div>  
                </div>
                    <h1>Mudanças Climáticas e Impactos na Agricultura: Um Estudo de Caso em Xique Xique, Bahia.</h1>
                    <div class="linha-autor"><div class="autor">Kayky Paiva.</div></div>
                    <div class="data-postagem">Postado em 26 de outubro, 2024.</div>
                <div class="cartao-bot">
                    <div class="rod">
                        <button class="votos"><span class="material-symbols-outlined">shift</span><p>3.956</p></button>
                        <button id="scrollToComments" class="comentarios"><i class="fa-regular fa-comment"></i>37</button>
                    </div>
                    <div class="ape">
                        <button class="botoes" id="Salvar">Salvar</button>
                                <div class="notification" id="notification">
                                    <h4 id="notificationTitle">Arquivo salvo com sucesso!</h4>
                                    <p id="notificationText">Você pode encontrar o arquivo no seu perfil.</p>                                        
                                </div><script src="../view/js/salvar.js"></script>
                        <button id="openCompartilhar" class="botoes">Compartilhar</button>
                        <button class="baixar"><i class="fa-regular fa-circle-down"></i><p>Download</p></button>
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
                        <p>Este artigo analisa como as mudanças climáticas têm impactado a agricultura em Xique Xique, uma cidade localizada no semiárido baiano. A região, já caracterizada por um clima seco e chuvas irregulares, enfrenta agora desafios ainda maiores devido ao aquecimento global. O aumento das temperaturas médias e a imprevisibilidade dos períodos de chuva afetam diretamente a produtividade de culturas como milho, feijão e mandioca, que são fundamentais para a economia local. As secas prolongadas e as chuvas intensas em períodos curtos contribuem para a erosão do solo e a perda de safras, impactando negativamente a segurança alimentar dos pequenos agricultores.

                            O estudo baseia-se em dados meteorológicos e entrevistas com agricultores, revelando que as mudanças climáticas têm intensificado a vulnerabilidade da agricultura familiar na região. O prolongamento das estiagens e a redução da umidade do solo estão dificultando o cultivo e aumentando os custos de produção. Além disso, o surgimento de novas pragas, impulsionado pelas alterações no clima, tem contribuído para o declínio da produtividade. Esses fatores têm levado muitos agricultores a reconsiderarem suas práticas agrícolas e buscarem novas formas de adaptação para garantir a sobrevivência de suas plantações.
                            
                            A pesquisa também explora as estratégias adotadas pelos agricultores de Xique Xique para mitigar os efeitos das mudanças climáticas, como o uso de tecnologias de irrigação, sistemas de captação de água da chuva e a adoção de técnicas de manejo sustentável. O artigo discute a importância de políticas públicas que incentivem o uso dessas tecnologias e garantam o suporte necessário para que os agricultores possam se adaptar às novas condições climáticas. O caso de Xique Xique serve como um alerta para outras regiões semiáridas, destacando a necessidade de ações urgentes e coordenadas para enfrentar os impactos do aquecimento global na agricultura.</p>
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
                                <textarea rows="3" placeholder="Adicione um comentário..."></textarea>
                            <div class="comment-btn">
                                <button class="comentarios-enviar-btn" onclick="submitReply(1)">Enviar</button>
                            </div>
                        </div>
                            <!-- Comentário principal -->
                            <div class="comentarios-comentario" data-comment-id="1">

                                <div class="um-comentario">
                                    <div class="comentarios-cabecalho">
                                        <img src="../view/img/sara.jpg" alt="Imagem de perfil do comentário" class="comentarios-imagem-perfil">
                                        <span class="comentarios-usuario">Sara Camilly</span>
                                        <span class="comentarios-acoes">2 dias atrás</span>
                                    </div>

                                    <div class="comentarios-corpo">
                                    Parabéns pelo artigo Kayky, achei super positivo!
                                    </div>
                                    <button class="comentarios-responder-btn" onclick="toggleReplyForm(1)">Responder</button>
                                    <span class="comentarios-mostrar-resposta-btn" onclick="toggleReplies(1)">Mostrar Respostas</span>
                            
                                    <!-- Formulário de resposta para o comentário principal -->
                                    <div class="comentarios-formulario-resposta" id="reply-form-1">
                                        <textarea rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                                        <button class="comentarios-enviar-btn" onclick="submitReply(1)">Enviar</button>
                                    </div>
                                </div>
                                <!-- Respostas ao comentário principal -->
                                <div class="comentarios-secao-respostas" id="replies-1">
                                    <div class="comentarios-comentario" data-comment-id="2">

                                       <div class="um-comentario">
                                        <div class="comentarios-cabecalho">
                                            <img src="../view/img/capeleti.png" alt="Imagem de perfil do comentário" class="comentarios-imagem-perfil">
                                            <span class="comentarios-usuario">Vitor Capeleti</span>
                                            <span class="comentarios-acoes">1 dia atrás</span>
                                        </div>
                                        <div class="comentarios-corpo">
                                            Boaa Sara, tá certinho.
                                        </div>
                                        <button class="comentarios-responder-btn" onclick="toggleReplyForm(2)">Responder</button>
                                        <span class="comentarios-mostrar-resposta-btn" onclick="toggleReplies(2)">Mostrar Respostas</span>
                                        <!-- Formulário de resposta para a resposta -->
                                        <div class="comentarios-formulario-resposta" id="reply-form-2">
                                            <textarea rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                                            <button class="comentarios-enviar-btn" onclick="submitReply(2)">Enviar</button>
                                        </div>
                                    </div>
                                        <!-- Respostas à resposta -->
                                        <div class="comentarios-secao-respostas" id="replies-2">
                                            <div class="comentarios-comentario" data-comment-id="3">
                                                <div class="um-comentario">
                                                    <div class="comentarios-cabecalho">
                                                        <img src="../view/img/nicolas.jpeg" alt="Imagem de perfil do comentário" class="comentarios-imagem-perfil">
                                                        <span class="comentarios-usuario">Nicolas Gmack</span>
                                                        <span class="comentarios-acoes">1 dia atrás</span>
                                                    </div>
                                                    <div class="comentarios-corpo">
                                                        ãhn?
                                                    </div>
                                                    <button class="comentarios-responder-btn" onclick="toggleReplyForm(3)">Responder</button>
                                                     <!-- Formulário de resposta para a resposta -->
                                        <div class="comentarios-formulario-resposta" id="reply-form-3">
                                            <textarea rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                                            <button class="comentarios-enviar-btn" onclick="submitReply(3)">Enviar</button>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                    
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
                            <img src="../view/img/kayky.png" alt="">                            
                           </div>
                           <div class="autor-nome"><p>Kayky Paiva</p></div>
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