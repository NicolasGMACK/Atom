const saveButton = document.getElementById('Salvar');
const notification = document.getElementById('notification');
const notificationTitle = document.getElementById('notificationTitle');
const notificationText = document.getElementById('notificationText');

saveButton.addEventListener('click', function() {
    if (saveButton.classList.contains('saved')) {
        saveButton.textContent = 'Salvar';
        saveButton.classList.remove('saved');
    } else {
        saveButton.textContent = 'Em biblioteca';
        saveButton.classList.add('saved');

        // Mostra a notificação
        notification.style.display = 'block';
        setTimeout(() => {
            notification.classList.add('show'); // Aparece com transição de opacidade
        }, 10); // Atraso pequeno para garantir que o estilo é aplicado

        // Esconde a notificação após 3 segundos
        setTimeout(function() {
            notification.classList.remove('show'); // Inicia o fade out
            setTimeout(function() {
                notification.style.display = 'none'; // Esconde completamente
            }, 500); // Aguarda a transição de 0.5s para finalizar
        }, 3000);
    }
});