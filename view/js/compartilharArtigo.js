document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões com a classe 'openCompartilhar'
    const shareButtons = document.querySelectorAll('.openCompartilhar');
    const compartilharPopup = document.getElementById('compartilhar');
    const closeButton = document.getElementById('fecharCompartilhar');

    // Adiciona o evento de clique a cada botão para abrir o pop-up
    shareButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Obter o token do artigo do botão clicado
            const tokenArtigoSelecionado = this.getAttribute('data-token-artigo');

            // Verifica se o elemento de popup existe
            if (compartilharPopup) {
                compartilharPopup.style.display = 'flex'; // Exibe o popup de compartilhamento
            }

            // Passa o token para o input do popup
            const inputTokenArtigo = document.getElementById('tokenArtigoInput'); // ID do input no popup
            if (inputTokenArtigo) {
                inputTokenArtigo.value = tokenArtigoSelecionado;
            }
        });
    });

    // Adiciona o evento para fechar o pop-up ao clicar no botão de fechar
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            compartilharPopup.style.display = 'none'; // Oculta o popup de compartilhamento
        });
    }

    // Adiciona o evento para fechar o pop-up ao clicar fora dele
    window.addEventListener('click', function(event) {
        if (event.target === compartilharPopup) {
            compartilharPopup.style.display = 'none'; // Oculta o popup de compartilhamento
        }
    });

    // Evento de clique nas linhas dos usuários
    // Evento de clique nas linhas dos usuários
const usuariosLinhas = document.querySelectorAll('.user-linha');
usuariosLinhas.forEach(user => {
    user.addEventListener('click', function() {
        // Verifica se a linha já possui a classe 'selected'
        if (this.classList.contains('selected')) {
            // Se sim, remove a classe 'selected'
            this.classList.remove('selected');
        } else {
            // Se não, adiciona a classe 'selected'
            this.classList.add('selected');
        }
    });
});

});

// Função para compartilhar o artigo com o usuário selecionado
// Função para compartilhar o artigo com os usuários selecionados
// Função para compartilhar o artigo com os usuários selecionados
// Função para compartilhar o artigo com os usuários selecionados
function compartilharArtigo() {
    const tokenArtigo = document.getElementById('tokenArtigoInput').value;
    const selectedUsers = document.querySelectorAll('.user-linha.selected');

    if (tokenArtigo && selectedUsers.length > 0) {
        const totalCompartilhamentos = selectedUsers.length;
        let sucessoCount = 0; 
        let erroCount = 0;

        selectedUsers.forEach(selectedUser => {
            const usuarioId = selectedUser.getAttribute('data-user-id');
            const conversaId = selectedUser.getAttribute('data-conv-id');
            const tipoMensagem = 'artigo';
            const mensagem = `Confira este artigo!`;

            // Chama a função para enviar a mensagem
            enviarMensagem(conversaId, usuarioId, mensagem, tipoMensagem, tokenArtigo)
                .then((sucesso) => {
                    if (sucesso) {
                        sucessoCount++;
                    } else {
                        erroCount++;
                    }

                    // Verifica se todos os compartilhamentos foram processados
                    if (sucessoCount + erroCount === totalCompartilhamentos) {
                        if (sucessoCount === 1) {
                            alert('Artigo compartilhado com sucesso!');
                        } else if (sucessoCount > 1) {
                            alert('Artigos compartilhados com sucesso!');
                        }

                        if (erroCount > 0) {
                            alert(`${erroCount} compartilhamento(s) falhou(aram).`);
                        }
                    }
                });
        });

        // Fecha o popup após iniciar o processo de envio
        document.getElementById('compartilhar').style.display = 'none';
    } else {
        console.error("Token do artigo ou nenhum usuário selecionado.");
    }
}




// Função para enviar a mensagem via fetch
// Função para enviar a mensagem via fetch
function enviarMensagem(conversaId, usuarioId, mensagem, tipo, tokenArtigo) {
    return fetch('php/enviar_artigo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `conversaId=${conversaId}&usuarioId=${usuarioId}&mensagem=${encodeURIComponent(mensagem)}&tipo=${tipo}&tokenArtigo=${tokenArtigo}`
    })
    .then(response => response.text())  // Recebe a resposta como texto
    .then(data => {
        console.log('Resposta do servidor:', data); 
        try {
            const jsonData = JSON.parse(data);  
            return jsonData.success;
        } catch (e) {
            console.error('Erro ao fazer parse do JSON:', e);
            return false;
        }
    })
    .catch(error => {
        console.error('Erro ao compartilhar o artigo:', error);
        return false;
    });
}


