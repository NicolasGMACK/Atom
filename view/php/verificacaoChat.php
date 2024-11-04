<?php
require_once('conection.php');
require_once('protect.php');
if(isset($_GET['token'])){
    $tokenusu = $_GET['token'];
    $sqlToken = "SELECT USU_INT_ID FROM tokens_usuario WHERE TOK_USU_VAR_TOK = ?";
    $stmtToken = $conection->prepare($sqlToken);
    $stmtToken->bind_param('s', $tokenusu);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();
    //$userChat2test = $resultToken->fetch_assoc();
    //var_dump($userChat2test);
    if ($resultToken->num_rows > 0) {
    
    $userChat1 = $_SESSION['id'];
    $userChat2test = $resultToken->fetch_assoc();
    $userChat2 = $userChat2test['USU_INT_ID'];
    
    $sqlChat = "SELECT CONV_INT_ID FROM conversas WHERE USU_INT_ID_1 = $userChat1 AND USU_INT_ID_2 = $userChat2 OR
    USU_INT_ID_1 = $userChat2 AND USU_INT_ID_2 = $userChat1";
    $exSqlChat = mysqli_query($conection, $sqlChat);
    $usertest = $exSqlChat->fetch_assoc();
    //var_dump($usertest);
    $verifica = mysqli_num_rows($exSqlChat);
    if($verifica < 1){
        $sqlInsertChat = "INSERT INTO conversas (USU_INT_ID_1, USU_INT_ID_2) VALUES ($userChat1, $userChat2)";
        $exSqlInsertChat = mysqli_query($conection, $sqlInsertChat);
        $verificaInsert = mysqli_num_rows($exSqlInsertChat);
        if($verificaInsert == 1){
            //echo'chat iniciado com sucesso';
            #header('Location: conversa.php'); 
            return $tokenusu;
        }else{
            die('erro ao iniciar o chat'. $exSqlInsertChat->$error);
        }
    }else{
        #header('Location: conversa.php');
        //echo'chat iniciado com sucesso';
        return $tokenusu;
    }
    }else{
        echo'Erro no token';
    }
}

?>