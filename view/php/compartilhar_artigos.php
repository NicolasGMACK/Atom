<?php
require_once('conection.php'); // Conexão com o banco de dados

require_once('protect.php'); //
// Função para carregar usuários com quem o usuário tem conversa
function carregarUsuariosConversa($conection, $userId) {
    // Consulta para buscar usuários com quem o usuário tem conversa
    $query = "
        SELECT DISTINCT 
            u.USU_INT_ID, 
            u.USU_VAR_NAME, 
            u.USU_VAR_IMGPERFIL 
        FROM conversas c
        JOIN usuario u ON u.USU_INT_ID = CASE 
            WHEN c.USU_INT_ID_1 = $userId THEN c.USU_INT_ID_2 
            ELSE c.USU_INT_ID_1 
        END
        WHERE c.USU_INT_ID_1 = $userId OR c.USU_INT_ID_2 = $userId";
    
    $resultado = mysqli_query($conection, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuarios = [];
        while ($usuario = mysqli_fetch_assoc($resultado)) {
            // Salva as informações do usuário em um array
            $usuarios[] = $usuario;
        }
        return $usuarios; // Retorna a lista de usuários
    } else {
        return []; // Retorna um array vazio caso não haja conversa
    }
}

// Carregar os usuários com quem o usuário tem conversa
$usuariosConversa = carregarUsuariosConversa($conection, $userId);
?>
