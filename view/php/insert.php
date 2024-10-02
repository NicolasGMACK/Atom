<?php
require_once('../view/php/conection.php');

function inserirUsuarios($conection){
    if(isset($_POST['cadastrar']) AND !empty($_POST['nome']) AND !empty($_POST['email']) AND !empty($_POST['password'])){
        $erros = array();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($conection, $_POST['nome']);
        $senha = sha1($_POST['password']);

        if($_POST['password'] != $_POST['repetepassword']){
            $erros[] = "Senhas não conferem"; 
        }
        $queryEmail = "SELECT USU_VAR_EMAIL FROM usuario WHERE USU_VAR_EMAIL = '$email'";
        $buscaEmail = mysqli_query($conection, $queryEmail);
        $verifica = mysqli_num_rows($buscaEmail);

        if(!empty($verifica)){
            $erros[] = "email já cadastrado";
        }
        if(empty($erros)){
            //inserir o usuario no Banco de dados
            $query = "INSERT INTO `usuario`(`USU_VAR_NAME`, `USU_VAR_EMAIL`, `USU_VAR_PASSWORD`)
             VALUES ('$nome','$email','$senha')";
            $executar = mysqli_query($conection, $query);
            if($executar){
                echo "Usuário Inserido com sucesso";
            }else{
                echo "Erro ao inserir usuário";
            }


        }else{
            foreach($erros as $erro){
                echo"<p>$erro</p>";
            }
        }

    }
}

?>