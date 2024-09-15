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

        // Show notification with the title and text
        notificationTitle.textContent = `Arquivo salvo com sucesso!`;
        notificationText.textContent = `Você pode encontrar o arquivo no seu perfil.`;
        notification.style.display = 'block';

        // Hide the notification after 3 seconds
        setTimeout(function() {
            notification.style.display = 'none';
        }, 3000);
    }
});