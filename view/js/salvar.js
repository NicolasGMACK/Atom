(function() {
    const saveButtons = document.querySelectorAll('.Salvar');
    const notification = document.getElementById('notification');
    const notificationTitle = document.getElementById('notificationTitle');
    const notificationText = document.getElementById('notificationText');

    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (button.classList.contains('saved')) {
                button.textContent = 'Salvar';
                button.classList.remove('saved');
            } else {
                button.textContent = 'Em biblioteca';
                button.classList.add('saved');

                notification.style.display = 'block';
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);

                setTimeout(function() {
                    notification.classList.remove('show');
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }, 3000);
            }
        });
    });
})();
