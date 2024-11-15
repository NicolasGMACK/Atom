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
    const usuariosLinhas = document.querySelectorAll('.user-linha');
    usuariosLinhas.forEach(user => {
        user.addEventListener('click', function() {
            // Remove a classe 'selected' de todas as linhas
            usuariosLinhas.forEach(u => u.classList.remove('selected'));

            // Adiciona a classe 'selected' à linha clicada
            this.classList.add('selected');
        });
    });
});

// Função para compartilhar o artigo com o usuário selecionado
function compartilharArtigo() {
    // Pega o token do artigo do input
    const tokenArtigo = document.getElementById('tokenArtigoInput').value;

    // Pega o usuário selecionado
    const selectedUser = document.querySelector('.user-linha.selected');

    // Se o token do artigo e o usuário selecionado existirem
    if (tokenArtigo && selectedUser) {
        const usuarioId = selectedUser.getAttribute('data-user-id');
        const conversaId = selectedUser.getAttribute('data-conv-id');

        // Define o tipo de mensagem como 'artigo'
        const tipoMensagem = 'artigo';

        // Mensagem padrão para o compartilhamento de artigo
        const mensagem = `Confira este artigo!`;

        // Chama a função para enviar a mensagem
        enviarMensagem(conversaId, usuarioId, mensagem, tipoMensagem, tokenArtigo);

        // Fecha o popup após enviar
        document.getElementById('compartilhar').style.display = 'none';
    } else {
        console.error("Token do artigo ou usuário não selecionado.");
    }
}

// Função para enviar a mensagem via fetch
function enviarMensagem(conversaId, usuarioId, mensagem, tipo, tokenArtigo) {
    console.log('Enviando mensagem:', conversaId, usuarioId, mensagem, tipo, tokenArtigo); // Verifique os valores aqui
    fetch('php/enviar_artigo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `conversaId=${conversaId}&usuarioId=${usuarioId}&mensagem=${encodeURIComponent(mensagem)}&tipo=${tipo}&tokenArtigo=${tokenArtigo}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Artigo compartilhado com sucesso!');
        } else {
            alert('Erro ao compartilhar o artigo.');
        }
    })
    .catch(error => {
        console.error('Erro ao compartilhar o artigo:', error);
        alert('Houve um erro ao tentar compartilhar o artigo. Tente novamente.');
    });
}
