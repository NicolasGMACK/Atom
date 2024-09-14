// Abrir o pop-up
document.getElementById('openPopup').addEventListener('click', function() {
    document.getElementById('popupForm').style.display = 'flex';
});

// Fechar o pop-up
document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('popupForm').style.display = 'none';
});

// Fechar ao clicar fora do formulário
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('popupForm')) {
        document.getElementById('popupForm').style.display = 'none';
    }
});
