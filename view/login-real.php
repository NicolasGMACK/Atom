<?php
require_once('../view/php/conection.php');
if(isset($_POST['email']) || isset($_POST['password'])){
    if(strlen($_POST['email']) == 0){
        echo"preencha seu email";
    }else if(strlen($_POST['password']) == 0){
        echo"preencha sua senha";
    }else{
        $email = $conection->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql_code = "SELECT * FROM usuario WHERE USU_VAR_EMAIL='$email'";
        $sql_query = $conection->query($sql_code) or die("Erro no código sql" . $conection->error);
        $quantidade = $sql_query->num_rows;
        if($quantidade == 1){
            $usuario = $sql_query->fetch_assoc();
            //var_dump($usuario);
            if(password_verify($password, $usuario['USU_VAR_PASSWORD'])){
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['id'] = $usuario['USU_INT_ID'];
                $_SESSION['name'] = $usuario['USU_VAR_NAME'];
                $_SESSION['email'] = $usuario['USU_VAR_EMAIL'];
                $_SESSION['ftperfil'] = $usuario['USU_VAR_IMGPERFIL'];
                $_SESSION['ftfundo'] = $usuario['USU_VAR_IMGBACK'];
    
                header('Location: home.php');
                }else{
                    echo"<script>window.alert('falha ao logar Email ou Senha incorretos')</script>";
                    }
            }else{
                echo"<script>window.alert('falha ao logar Email ou Senha incorretos')</script>";}
    }
}


?>


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
        <div class="logo"><label>Atom</label><img src="../view/img/Atom-icon.png" alt=""></div>
        <div class="image">
            <img src="../view/img/mocas.png" alt="">
        </div>
       </div>
    <div class="tela2">
        <div class="login-cadastro">
            <form action="" method="post" class="login">
                <h2 class="title">LOGIN</h2>
                <div class="caixa-texto">
                    <div class="simbolo"><img src="../view/img/user-cinza.png" alt=""></div>
                    <input type="text" required name="email" placeholder="Digite seu e-mail...">
                </div>
                <div class="caixa-texto">
                    <div class="simbolo"><img src="../view/img/lock-cinza.png" alt=""></div>
                    <input type="password" required name="password" placeholder="Digite sua senha...">
                </div>
                <div class="esquecer">
               <!-- <label class="subtexto"for="">Esqueceu sua senha?</label> -->
               </div>
                <div class="bloco-botao">
                    <div class="botao-justify">
                        <input type="submit" value="Entrar" class="btn" id="sign-in-btn">
                        <div class="esquecer">
                         <label for="" class="subtexto1">Não tem uma conta? <a href="cadastro-real.php"><strong>Cadastrar-se</strong></a></label>
                        </div>
                    </div>
                </div>
            </form>
           
        </div>
    </div>
</div>
    
</body>
</html>

