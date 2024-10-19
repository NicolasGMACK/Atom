<?php
// Verificar se existe uma mensagem de sucesso
if (isset($_SESSION['mensagem_sucesso'])) {
    $mensagemSucesso = $_SESSION['mensagem_sucesso'];
    echo "<script>
        window.onload = function() {
            var mensagem = '$mensagemSucesso';
            alert(mensagem); // Mostra um alert, pode substituir por um popup
        }
    </script>";
    unset($_SESSION['mensagem_sucesso']); // Limpa a mensagem da sessão
}

// Verificar se existe uma mensagem de erro
if (isset($_SESSION['mensagem_erro'])) {
    $mensagemErro = $_SESSION['mensagem_erro'];
    echo "<script>
        window.onload = function() {
            var mensagem = '$mensagemErro';
            alert(mensagem); // Mostra um alert, pode substituir por um popup
        }
    </script>";
    unset($_SESSION['mensagem_erro']); // Limpa a mensagem da sessão
}
?>
