<?php
require_once('conection.php');
require_once('protect.php');

        if(isset($_POST['Enviar'])){
            $idChat = $_POST['idChat'];
            $idUser = $_POST['idUser'];
            $mensagem = mysqli_real_escape_string($conection, $_POST['mensagem']);
            #$data_atual = date('Y-m-d H:i:s');
            $sqlEnvio = "INSERT INTO `mensagens`(`CONV_INT_ID`, `USU_INT_ID`, `MSG_VAR_CONTEUDO`) 
            VALUES ('$idChat','$idUser','$mensagem')";
            $exSqlEnvio = mysqli_query($conection, $sqlEnvio);
            //$test = var_dump($exSqlEnvio);
            #verificação momentânea
            #$verificaEnvio = mysqli_num_rows($exSqlEnvio);
            //$sqlPesquisaChat = "SELECT u.USU_VAR_NAME, m.CONV_INT_ID, m.USU_INT_ID, m.MSG_VAR_CONTEUDO, m.MSG_DAT_ENVIO
            //FROM usuario u, mensagens m
            //WHERE u.USU_INT_ID = $idUser or  u.USU_INT_ID = $idUser";
            //$sqlPesquisaChatExecute = mysqli_query($conection, $sqlPesquisaChat);
            if($exSqlEnvio == true){
                #echo"<script>window.alert('Mensagem enviada com sucesso')</script>";
                #while($conversa = mysqli_fetch_assoc($sqlPesquisaChatExecute)){
                    //echo'
                    //<div style="display=coloum;">
                       //<h1>' . $conversa['USU_VAR_NAME'] . '</h1>
                        //<p>' . $conversa['MSG_VAR_CONTEUDO'] . '</p>
                        //<p>' . $conversa['MSG_DAT_ENVIO'] . '</p>
                    //</div>';
                #}
            }else{
                echo"<script>window.alert('Erro ao enviar mensagem')</script>";
            }
        }

?>