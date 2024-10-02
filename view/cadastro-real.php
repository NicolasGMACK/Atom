<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style4.css">  
    <title>Document</title>    
</head>
<body>
    <div class="corpo">
       <div class="tela1">
        <div class="logo"><label>Atom</label><img src="/view/img/Atom-icon.png" alt=""></div>
        <div class="image">
            <img src="../view/img/mocas.png" alt="">
        </div>
       </div>
<?php
require_once('../view/php/conection.php');
require_once('../view/php/insert.php');
inserirUsuarios($conection);
?>
    <div class="tela2">
        <div class="login-cadastro">
            <form action="" method="post" class="login">
                <h2 class="title">CADASTRO</h2>
                <div class="caixa-texto1">
                    <div class="simbolo"><img src="../view/img/user.png" alt=""></div>
                    <input type="text" name="nome" placeholder="Digite seu nome...">
                </div>
                <div class="caixa-texto1">
                    <div class="simbolo"><img src="../view/img/e-mail2.png" alt=""></div>
                    <input type="text" name="email" placeholder="Digite seu e-mail...">
                </div>
                <div class="caixa-texto1">
                    <div class="simbolo"><img src="../view/img/lock-cinza.png" alt=""></div>
                    <input type="password" name="password" placeholder="Digite sua senha...">
                </div>
                <div class="caixa-texto1">
                    <div class="simbolo"><img src="../view/img/lock-cinza.png" alt=""></div>
                    <input type="password" name="repetepassword" placeholder="Confirme sua senha...">
                </div>
                <div class="esquecer">
               </div>
                <div class="bloco-botao">
                    <div class="botao-justify">
                        <input type="submit" name="cadastrar" value="Cadastrar" class="btn">
                        <div class="esquecer">
                         <label for="" class="subtexto1">Já tem uma conta? <a href="login-real.html"><strong>Entrar</strong></a></label>
                        </div>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>
    
</body>
</html>

