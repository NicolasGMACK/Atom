<?php
require_once('protect.php');
require_once('conection.php');
include('criar_token_pessoal.php'); // Inclui o token pessoal

$erro = ''; // Variável para armazenar mensagens de erro

if ($tokenPessoal && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Nome e informações de texto
    $nome = $_POST['USU_VAR_NAME'];
    $desc = $_POST['USU_VAR_DESC'];
    $cidade = $_POST['USU_VAR_CIDADE'];
    $ocupacao = $_POST['USU_VAR_OCUPACAO'];

    // Caminhos de imagens padrão
    $fotoPerfilPath = null;
    $fotoBackPath = null;

    // Diretório completo para upload de imagens (caminho físico)
    $uploadDir = __DIR__ . '/../../uploads/perfis/'; // Caminho relativo para garantir que seja criado dentro de Atom
    $uploadDir = str_replace('\\', '/', $uploadDir); // Ajusta barras invertidas para barras normais

    // Verifica se o diretório existe e cria se não existir
    if (!is_dir($uploadDir)) {
        if (mkdir($uploadDir, 0777, true)) {
            echo "Diretório $uploadDir criado com sucesso.<br>";
        } else {
            echo "Erro ao criar o diretório $uploadDir.<br>";
            $erro = "O diretório de upload não existe e não pode ser criado.";
        }
    } else {
        echo "Diretório $uploadDir já existe e tem permissão de escrita.<br>";
    }

    // Processa a imagem de perfil (se não for removida)
    if (isset($_POST['removerFotoPerfil']) && $_POST['removerFotoPerfil'] == 'sim') {
        // Busca o caminho da foto atual no banco antes de excluir
        $sql = "SELECT USU_VAR_IMGPERFIL FROM usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                WHERE t.TOK_USU_VAR_TOK = ?";
        $stmt = $conection->prepare($sql);
        $stmt->bind_param('s', $tokenPessoal);
        $stmt->execute();
        $stmt->bind_result($fotoAtual);
        $stmt->fetch();
        $stmt->close();
    
        // Se o caminho da foto existe e não é um caminho vazio, tenta deletar o arquivo
        if ($fotoAtual && file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoAtual)) {
            if (unlink($_SERVER['DOCUMENT_ROOT'] . $fotoAtual)) {
                echo "Arquivo de foto de perfil removido do servidor.<br>";
            } else {
                echo "Erro ao tentar remover o arquivo de foto de perfil do servidor.<br>";
            }
        }
    
        // Atualiza o banco de dados com NULL para foto de perfil
        $sqlUpdate = "UPDATE usuario u
                      JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                      SET u.USU_VAR_IMGPERFIL = NULL
                      WHERE t.TOK_USU_VAR_TOK = ?";
        $stmtUpdate = $conection->prepare($sqlUpdate);
        $stmtUpdate->bind_param('s', $tokenPessoal);
        $stmtUpdate->execute();
        $stmtUpdate->close();
        
        echo "Caminho da foto de perfil removido do banco de dados.<br>";
    }
    
    
 elseif (!empty($_FILES['USU_VAR_IMGPERFIL']['name']) && $_FILES['USU_VAR_IMGPERFIL']['error'] == 0) {
        $fotoPerfil = $_FILES['USU_VAR_IMGPERFIL'];
        $fotoPerfilName = uniqid() . '_' . basename($fotoPerfil['name']);
        $fotoPerfilPath = $uploadDir . $fotoPerfilName;

        // Caminho do arquivo temporário
        echo "Caminho do arquivo temporário de upload: " . $fotoPerfil['tmp_name'] . "<br>";

        // Tenta mover o arquivo usando move_uploaded_file
        if (move_uploaded_file($fotoPerfil['tmp_name'], $fotoPerfilPath)) {
            echo "Foto de perfil movida com sucesso. <br>";
        } else {
            $erro = "Erro ao mover o arquivo de foto de perfil. Código de erro: " . $_FILES['USU_VAR_IMGPERFIL']['error'];
            echo "Erro: $erro <br>";
        }

        // Caminho absoluto do arquivo no servidor
        $fotoPerfilPath = realpath($fotoPerfilPath);  // Obtém o caminho completo do arquivo
        $fotoPerfilPath = str_replace('\\', '/', $fotoPerfilPath);  // Corrige o caminho

        // Caminho público para o banco de dados
        $fotoPerfilPublicPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fotoPerfilPath);
        echo "Caminho público da foto de perfil: $fotoPerfilPublicPath <br>";
    }

    // Processa a imagem de fundo (se não for removida)
    if (isset($_POST['removerFotoBanner']) && $_POST['removerFotoBanner'] == 'sim') {
        // Busca o caminho da foto de fundo atual no banco antes de excluir
        $sql = "SELECT USU_VAR_IMGBACK FROM usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                WHERE t.TOK_USU_VAR_TOK = ?";
        $stmt = $conection->prepare($sql);
        $stmt->bind_param('s', $tokenPessoal);
        $stmt->execute();
        $stmt->bind_result($fotoBackAtual);
        $stmt->fetch();
        $stmt->close();
    
        // Se o caminho do banner existe e não é vazio, tenta deletar o arquivo
        if ($fotoBackAtual && file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoBackAtual)) {
            if (unlink($_SERVER['DOCUMENT_ROOT'] . $fotoBackAtual)) {
                echo "Arquivo de banner removido do servidor.<br>";
            } else {
                echo "Erro ao tentar remover o arquivo de banner do servidor.<br>";
            }
        }
    
        // Atualiza o banco de dados com NULL para foto de fundo
        $sqlUpdate = "UPDATE usuario u
                      JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                      SET u.USU_VAR_IMGBACK = NULL
                      WHERE t.TOK_USU_VAR_TOK = ?";
        $stmtUpdate = $conection->prepare($sqlUpdate);
        $stmtUpdate->bind_param('s', $tokenPessoal);
        $stmtUpdate->execute();
        $stmtUpdate->close();
        
        echo "Caminho da imagem de fundo removido do banco de dados.<br>";
    }
    

     elseif (!empty($_FILES['USU_VAR_IMGBACK']['name']) && $_FILES['USU_VAR_IMGBACK']['error'] == 0) {
        $fotoBack = $_FILES['USU_VAR_IMGBACK'];
        $fotoBackName = uniqid() . '_' . basename($fotoBack['name']);
        $fotoBackPath = $uploadDir . $fotoBackName;

        echo "Caminho do arquivo temporário de upload de banner: " . $fotoBack['tmp_name'] . "<br>";

        if (move_uploaded_file($fotoBack['tmp_name'], $fotoBackPath)) {
            echo "Banner movido com sucesso. <br>";
        } else {
            $erro = "Erro ao mover o arquivo de banner. Código de erro: " . $_FILES['USU_VAR_IMGBACK']['error'];
            echo "Erro: $erro <br>";
        }

        $fotoBackPath = realpath($fotoBackPath);  // Caminho completo do arquivo
        $fotoBackPath = str_replace('\\', '/', $fotoBackPath);  // Corrige o caminho

        $fotoBackPublicPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fotoBackPath);
        echo "Caminho público do banner: $fotoBackPublicPath <br>";
    }

    // Se não houve erro, continua com o update no banco
    if (empty($erro)) {
        // Atualiza os dados no banco
        $sql = "UPDATE usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                SET u.USU_VAR_NAME = ?, u.USU_VAR_DESC = ?, u.USU_VAR_CIDADE = ?, u.USU_VAR_OCUPACAO = ?, 
                    u.USU_VAR_IMGPERFIL = COALESCE(?, u.USU_VAR_IMGPERFIL), 
                    u.USU_VAR_IMGBACK = COALESCE(?, u.USU_VAR_IMGBACK)
                WHERE t.TOK_USU_VAR_TOK = ?";
        
        $stmt = $conection->prepare($sql);
        $stmt->bind_param('sssssss', $nome, $desc, $cidade, $ocupacao, $fotoPerfilPublicPath, $fotoBackPublicPath, $tokenPessoal);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Perfil atualizado com sucesso!');
                    window.location.href = '../perfil_pessoal.php?token=$tokenPessoal';
                  </script>";
            exit();
        } else {
            $erro = "Erro ao atualizar o perfil.";
            echo "Erro: $erro <br>";
        }
    }
} else {
    $erro = "Acesso inválido.";
    echo "Erro: $erro <br>";
}

// Exibe a mensagem de erro como um alert, caso haja erro
if (!empty($erro)) {
    echo "<script>
            alert('$erro');
            window.location.href = '../perfil_pessoal.php?token=$tokenPessoal';
          </script>";
    exit();
}
?>
