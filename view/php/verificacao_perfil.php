<?php
require_once('conection.php');
require_once('criar_token_pessoal.php');
 // Verifica se o usuário está logado

// Verifica se o token foi passado
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Exibe valores para depuração
  //  echo "User Token (session): " . $tokenPessoal . "<br>";
  //  echo "Token (GET): " . $token . "<br>";

    // Compara os valores e redireciona se forem iguais
    if ($tokenPessoal == $token) {
        // Redireciona para perfil_pessoal.php
        header("Location: perfil_pessoal.php?token=$tokenPessoal");
        exit();
    }// else {
       // echo "IDs não correspondem.";
   // }
} //else {
    //echo "Token não foi passado.";
//}
?>
    