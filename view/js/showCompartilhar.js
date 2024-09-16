// Abrir o pop-up
document.getElementById('openCompartilhar').addEventListener('click', function() {
    document.getElementById('compartilhar').style.display = 'flex';
});

// Fechar o pop-up
document.getElementById('fecharCompartilhar').addEventListener('click', function() {
    document.getElementById('compartilhar').style.display = 'none';
});

// Fechar ao clicar fora do formulário
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('compartilhar')) {
        document.getElementById('compartilhar').style.display = 'none';
    }
});
