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
            <li><a class="atom" href="home.php">Atom<img src="../view/img/logo3.png" alt=""></a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/about.html">Sobre</a></li>
            <li class="hideOnMobile"><a class="topic" href="../view/project.html">Projeto</a></li>
            <li class="profile">
                <div id="profileDropdown" class="topic usuario">
                <div  id="profileDropdown" class="foto user-space">
                    <img id="profileDropdown" src="../view/img/user.jpg" alt="">
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

               <?php require_once('../view/php/carregar_perfil_usuario.php') ?>
                  
            </div>
        </div>
        
<div class="tela espaco" id="publicacoes" style="display: non">
    <div class="tela-coluna">
        <div class="lado-esquerdo1">
            <div class="bloco">
                <div class="sobre">
                    <h1>Sobre</h1>
                    <div class="biografia"><br>
                    <?php echo $desc; ?>
                     </div>
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
    

<div class="tela espaco">

</div>

            </body>
</html>
