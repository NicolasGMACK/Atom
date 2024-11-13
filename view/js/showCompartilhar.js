// Seleciona todos os botões com a classe 'openCompartilhar'
const shareButtons = document.querySelectorAll('.openCompartilhar');
const compartilharPopup = document.getElementById('compartilhar');
const closeButton = document.getElementById('fecharCompartilhar');

// Adiciona o evento de clique a cada botão para abrir o pop-up
shareButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Verifica se o elemento de popup existe
        if (compartilharPopup) {
            compartilharPopup.style.display = 'flex'; // Exibe o popup de compartilhamento
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
