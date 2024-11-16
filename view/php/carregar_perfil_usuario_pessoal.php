<?php   
require_once('conection.php');

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');
    
// Verifica se o token foi passado
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta no banco de dados para validar o token
    $sqlToken = "SELECT USU_INT_ID FROM tokens_usuario WHERE TOK_USU_VAR_TOK = ?";
    $stmtToken = $conection->prepare($sqlToken);
    $stmtToken->bind_param('s', $token);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    if ($resultToken->num_rows > 0) {
        // Se o token for válido, pega o ID do usuario
        $usuario = $resultToken->fetch_assoc();
        $PerfilId = $usuario['USU_INT_ID'];

        // Busca informações do usuario
        $sqlUsuario = "SELECT USU_VAR_NAME, USU_VAR_IMGPERFIL, USU_VAR_IMGBACK, USU_VAR_DESC, USU_VAR_CIDADE, USU_VAR_OCUPACAO
        FROM usuario
        WHERE USU_INT_ID = ?";
        $stsmtUsuario = $conection->prepare($sqlUsuario);
        $stsmtUsuario->bind_param('i', $PerfilId);
        $stsmtUsuario->execute();
        $resultUsuario = $stsmtUsuario->get_result();

        if ($resultUsuario->num_rows > 0) {
            // Usuario encontrado
            $usuario = $resultUsuario->fetch_assoc();

            $nome = $usuario['USU_VAR_NAME'];
            $FotoPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg'; 
            $FotoBanner = !empty($usuario['USU_VAR_IMGBACK']) ? $usuario['USU_VAR_IMGBACK'] : '../view/img/background-default.png'; 
            $desc = !empty($usuario['USU_VAR_DESC']) ? $usuario['USU_VAR_DESC'] : 'Sem descrição.';
            $cidade = !empty($usuario['USU_VAR_CIDADE']) ? $usuario['USU_VAR_CIDADE'] : 'Não especificado.';
            $ocupacao = !empty($usuario['USU_VAR_OCUPACAO']) ? $usuario['USU_VAR_OCUPACAO'] : 'Não especificado.';

            // Echo do HTML
                    echo '<div class="cover-photo">
                <img src="' . $FotoBanner . '" alt="Foto de Capa">
            </div>
            <div class="profile-info">
                <div class="profile-picture">
                    <img src="' . $FotoPerfil . '" alt="Foto de Perfil">
                </div>
                <div class="profile-name">
                    <h1>' . $nome . '</h1>
                    <div class="seguintes">
                        <p><strong>567</strong> seguindo</p>
                        <p><strong>321</strong> seguidores</p>
                    </div>
                </div>
                <div class="profile-actions">';                   
                        include_once('formEditarPerfil.php');
               echo '</div>
            </div>
            <div class="profile-navigation">
                <div class="opcao marcada" id="publicacoesBtn">Publicações</div>
                <div class="opcao selecionar" id="bibliotecaBtn">Biblioteca</div>           
            </div>';

        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "Token inválido.";
    }
} else {
    echo "Parâmetros inválidos.";
    exit();
}
?>
