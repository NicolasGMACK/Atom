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
});

// Função para compartilhar o artigo com o usuário selecionado
// Função para compartilhar o artigo com o usuário selecionado
function compartilharArtigoComUsuario(usuarioId, conversaId) {
    const tokenArtigo = document.getElementById('tokenArtigoInput').value; // Pega o token do input
    if (tokenArtigo) {
        // Define o tipo de mensagem como 'artigo'
        const tipoMensagem = 'artigo';
        
        // Mensagem padrão pode ser apenas texto indicando o compartilhamento
        const mensagem = `Confira este artigo!`;

        // Montar os dados para enviar
        const dados = {
            conversaId: conversaId,
            usuarioId: usuarioId,
            mensagem: mensagem,
            tipo: tipoMensagem,
            tokenArtigo: tokenArtigo
        };

        // Enviar a mensagem de compartilhamento do artigo
        enviarMensagem(dados);

        // Fecha o popup após enviar
        document.getElementById('compartilhar').style.display = 'none';
    } else {
        console.error("Token do artigo não encontrado.");
    }
}

