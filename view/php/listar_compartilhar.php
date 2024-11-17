<?php
require_once('conection.php'); // Conexão com o banco de dados
require_once('protect.php'); //

$userId = $_SESSION['id'];
// Função para carregar usuários com quem o usuário tem conversa
function carregarUsuariosConversa($conection, $userId) {
    // Consulta para buscar usuários com quem o usuário tem conversa e incluir CONV_INT_ID
    $query = "
        SELECT DISTINCT 
            c.CONV_INT_ID,  -- Inclua o ID da conversa
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
            $usuarios[] = $usuario;
        }
        return $usuarios;
    } else {
        return []; 
    }
}

// Carregar os usuários com quem o usuário tem conversa
$usuariosConversa = carregarUsuariosConversa($conection, $userId);
?>
