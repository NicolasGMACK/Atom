<link rel="stylesheet" href="css/editperfil.css">
<!-- Seção do botão Editar Perfil -->
<div class="profile-actions">
    <button class="btn" onclick="mostrarFormulario()">Editar Perfil</button>
</div>
<?php
// A variável $FotoPerfil deverá conter o caminho da foto de perfil existente ou um valor padrão
$FotoPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';
?>

<div id="modalEditarPerfil" class="modal">
    <div class="modal-content">
        <h2>Editar Perfil</h2>
        <form action="../view/php/atualizar_perfil.php" method="POST" enctype="multipart/form-data">
            <!-- Nome -->
            <div class="form-group">
                <label class="fgl b" for="USU_VAR_NAME">Nome de Usuário:</label>
                <input style="font-size: 30px; border: none; background-color: #fff; outline: none;" class="nome_usuario" type="text" name="USU_VAR_NAME" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>

            <!-- Foto de Perfil -->
            <div class="form-group">
                <label class="fgl" for="USU_VAR_IMGPERFIL">Foto de Perfil:</label>
                <div class="foto-upload">
                    <img src="<?php echo $FotoPerfil; ?>" alt="Foto de Perfil" width="100" height="100" style="border-radius: 50%;">
                        <div class="file-input">
                            <input type="file" name="USU_VAR_IMGPERFIL" accept="image/*">
                            <label class="fgl" for="USU_VAR_IMGPERFIL">Escolher Foto</label>
                        </div>
                        <label class="deletes"><input type="checkbox" name="removerFotoPerfil" value="sim"> Remover foto de perfil</label>                    
                </div>
            </div>
            <!-- Imagem de Fundo -->
            <div class="form-group">
                <label class="fgl" for="USU_VAR_IMGBACK">Imagem de Fundo:</label>
                <div class="foto-upload1">
                    <img src="<?php echo $FotoBanner; ?>" alt="Foto de Fundo" width="100%" height="100">
                    <div class="agrupar">
                        <div class="file-input">
                            <input type="file" name="USU_VAR_IMGBACK" accept="image/*">
                            <label class="fgl" for="USU_VAR_IMGBACK">Escolher Imagem</label>
                        </div>
                        <label class="deletes"><input type="checkbox" name="removerFotoBanner" value="sim"> Remover imagem de fundo</label>
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label class="fgl" for="USU_VAR_DESC">Descrição:</label>
                <textarea name="USU_VAR_DESC" maxlength="250"><?php echo htmlspecialchars($desc); ?></textarea>
            </div>

            <!-- Cidade -->
            <div class="form-group">
                <label class="fgl" for="USU_VAR_CIDADE">Cidade:</label>
                <input type="text" name="USU_VAR_CIDADE" value="<?php echo htmlspecialchars($cidade); ?>">
            </div>

            <!-- Ocupação -->
            <div class="form-group">
                <label class="fgl" for="USU_VAR_OCUPACAO">Ocupação:</label>
                <input type="text" name="USU_VAR_OCUPACAO" value="<?php echo htmlspecialchars($ocupacao); ?>">
            </div>

            <!-- Botão para salvar -->
            <div class="form-group">
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>


<!-- Estilos CSS para o Modal -->


<script>
    // Função para abrir o modal
    function mostrarFormulario() {
        document.getElementById('modalEditarPerfil').style.display = 'flex';
    }

    // Função para fechar o modal
    function fecharFormulario() {
        document.getElementById('modalEditarPerfil').style.display = 'none';
    }

    // Fechar modal se clicar fora do formulário
    window.onclick = function(event) {
        var modal = document.getElementById('modalEditarPerfil');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
