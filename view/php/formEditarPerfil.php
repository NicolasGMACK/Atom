<!-- Seção do botão Editar Perfil -->
<div class="profile-actions">
    <button class="btn" onclick="mostrarFormulario()">Editar Perfil</button>
</div>
<?php
// A variável $FotoPerfil deverá conter o caminho da foto de perfil existente ou um valor padrão
$FotoPerfil = !empty($usuario['USU_VAR_IMGPERFIL']) ? $usuario['USU_VAR_IMGPERFIL'] : '../view/img/user.jpg';
?>

<div id="modalEditarPerfil" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="fecharFormulario()">&times;</span>
        <h2>Editar Perfil</h2>
        <form action="../view/php/atualizar_perfil.php" method="POST" enctype="multipart/form-data">
            <!-- Nome -->
            <div class="form-group">
                <label for="USU_VAR_NAME">Nome:</label>
                <input type="text" name="USU_VAR_NAME" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            
            <!-- Foto de Perfil -->
            <div class="form-group">
                <label for="USU_VAR_IMGPERFIL">Foto de Perfil:</label>
                
                <!-- Se já tiver uma foto de perfil, exibe a imagem atual -->
                <div>
                    <img src="<?php echo $FotoPerfil; ?>" alt="Foto de Perfil" width="100" height="100">
                </div>

                <!-- Campo para enviar uma nova foto -->
                <input type="file" name="USU_VAR_IMGPERFIL">
                
                <!-- Checkbox para remover a foto de perfil -->
                <label>
                    <input type="checkbox" name="removerFotoPerfil" value="sim"> Remover foto de perfil
                </label>

            </div>
            
            <!-- Imagem de Fundo -->
            <div class="form-group">
                <label for="USU_VAR_IMGBACK">Imagem de Fundo:</label>
                <input type="file" name="USU_VAR_IMGBACK">
                <label><input type="checkbox" name="removerFotoBanner" value="sim"> Remover imagem de fundo</label>

            </div>
            
            <!-- Descrição -->
            <div class="form-group">
                <label for="USU_VAR_DESC">Descrição:</label>
                <textarea name="USU_VAR_DESC" maxlength="250"><?php echo htmlspecialchars($desc); ?></textarea>
            </div>
            
            <!-- Cidade -->
            <div class="form-group">
                <label for="USU_VAR_CIDADE">Cidade:</label>
                <input type="text" name="USU_VAR_CIDADE" value="<?php echo htmlspecialchars($cidade); ?>">
            </div>
            
            <!-- Ocupação -->
            <div class="form-group">
                <label for="USU_VAR_OCUPACAO">Ocupação:</label>
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
<style>
    .modal {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 999;
    }
    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .close {
        font-size: 24px;
        float: right;
        cursor: pointer;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .form-group textarea {
        resize: vertical;
        height: 100px;
    }
    .form-group button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-group button:hover {
        background-color: #45a049;
    }
</style>

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
