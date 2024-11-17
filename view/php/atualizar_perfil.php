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
    $uploadDir = __DIR__ . '/../../uploads/perfis/';
    $uploadDir = str_replace('\\', '/', $uploadDir);

    // Verifica se o diretório existe e cria se não existir
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            $erro = "O diretório de upload não existe e não pode ser criado.";
        }
    }

    // Processa a imagem de perfil (se não for removida)
    if (isset($_POST['removerFotoPerfil']) && $_POST['removerFotoPerfil'] == 'sim') {
        $sql = "SELECT USU_VAR_IMGPERFIL FROM usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                WHERE t.TOK_USU_VAR_TOK = ?";
        $stmt = $conection->prepare($sql);
        $stmt->bind_param('s', $tokenPessoal);
        $stmt->execute();
        $stmt->bind_result($fotoAtual);
        $stmt->fetch();
        $stmt->close();

        if ($fotoAtual && file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoAtual)) {
            if (!unlink($_SERVER['DOCUMENT_ROOT'] . $fotoAtual)) {
                $erro = "Erro ao tentar remover o arquivo de foto de perfil do servidor.";
            }
        }

        $sqlUpdate = "UPDATE usuario u
                      JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                      SET u.USU_VAR_IMGPERFIL = NULL
                      WHERE t.TOK_USU_VAR_TOK = ?";
        $stmtUpdate = $conection->prepare($sqlUpdate);
        $stmtUpdate->bind_param('s', $tokenPessoal);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        $_SESSION['ftperfil'] = NULL;
    } elseif (!empty($_FILES['USU_VAR_IMGPERFIL']['name']) && $_FILES['USU_VAR_IMGPERFIL']['error'] == 0) {
        $fotoPerfil = $_FILES['USU_VAR_IMGPERFIL'];
        $fotoPerfilName = uniqid() . '_' . basename($fotoPerfil['name']);
        $fotoPerfilPath = $uploadDir . $fotoPerfilName;

        if (!move_uploaded_file($fotoPerfil['tmp_name'], $fotoPerfilPath)) {
            $erro = "Erro ao mover o arquivo de foto de perfil. Código de erro: " . $_FILES['USU_VAR_IMGPERFIL']['error'];
        }

        $fotoPerfilPath = realpath($fotoPerfilPath);
        $fotoPerfilPath = str_replace('\\', '/', $fotoPerfilPath);
        $fotoPerfilPublicPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fotoPerfilPath);

        $_SESSION['ftperfil'] = $fotoPerfilPublicPath;
    }

    // Processa a imagem de fundo (se não for removida)
    if (isset($_POST['removerFotoBanner']) && $_POST['removerFotoBanner'] == 'sim') {
        $sql = "SELECT USU_VAR_IMGBACK FROM usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                WHERE t.TOK_USU_VAR_TOK = ?";
        $stmt = $conection->prepare($sql);
        $stmt->bind_param('s', $tokenPessoal);
        $stmt->execute();
        $stmt->bind_result($fotoBackAtual);
        $stmt->fetch();
        $stmt->close();

        if ($fotoBackAtual && file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoBackAtual)) {
            if (!unlink($_SERVER['DOCUMENT_ROOT'] . $fotoBackAtual)) {
                $erro = "Erro ao tentar remover o arquivo de banner do servidor.";
            }
        }

        $sqlUpdate = "UPDATE usuario u
                      JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                      SET u.USU_VAR_IMGBACK = NULL
                      WHERE t.TOK_USU_VAR_TOK = ?";
        $stmtUpdate = $conection->prepare($sqlUpdate);
        $stmtUpdate->bind_param('s', $tokenPessoal);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        $_SESSION['ftbackground'] = NULL;
    } elseif (!empty($_FILES['USU_VAR_IMGBACK']['name']) && $_FILES['USU_VAR_IMGBACK']['error'] == 0) {
        $fotoBack = $_FILES['USU_VAR_IMGBACK'];
        $fotoBackName = uniqid() . '_' . basename($fotoBack['name']);
        $fotoBackPath = $uploadDir . $fotoBackName;

        if (!move_uploaded_file($fotoBack['tmp_name'], $fotoBackPath)) {
            $erro = "Erro ao mover o arquivo de banner. Código de erro: " . $_FILES['USU_VAR_IMGBACK']['error'];
        }

        $fotoBackPath = realpath($fotoBackPath);
        $fotoBackPath = str_replace('\\', '/', $fotoBackPath);
        $fotoBackPublicPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fotoBackPath);

        $_SESSION['ftbackground'] = $fotoBackPublicPath;
    }

    // Atualiza o banco de dados se não houve erro
    if (empty($erro)) {
        $sql = "UPDATE usuario u
                JOIN tokens_usuario t ON u.USU_INT_ID = t.USU_INT_ID
                SET u.USU_VAR_NAME = ?, u.USU_VAR_DESC = ?, u.USU_VAR_CIDADE = ?, u.USU_VAR_OCUPACAO = ?, 
                    u.USU_VAR_IMGPERFIL = COALESCE(?, u.USU_VAR_IMGPERFIL), 
                    u.USU_VAR_IMGBACK = COALESCE(?, u.USU_VAR_IMGBACK)
                WHERE t.TOK_USU_VAR_TOK = ?";

        $stmt = $conection->prepare($sql);
        $stmt->bind_param('sssssss', $nome, $desc, $cidade, $ocupacao, $fotoPerfilPublicPath, $fotoBackPublicPath, $tokenPessoal);

        if ($stmt->execute()) {
            $_SESSION['name'] = $nome;
            echo "<script>window.location.href = '../perfil_pessoal.php?token=$tokenPessoal';</script>";
            exit();
        } else {
            $erro = "Erro ao atualizar o perfil.";
        }
    }
} else {
    $erro = "Acesso inválido.";
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
