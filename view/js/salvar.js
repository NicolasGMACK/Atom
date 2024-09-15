const saveButton = document.getElementById('Salvar');

    saveButton.addEventListener('click', function() {
        if (saveButton.classList.contains('saved')) {
            saveButton.textContent = 'Salvar';
            saveButton.classList.remove('saved');
        } else {
            saveButton.textContent = 'Em biblioteca';
            saveButton.classList.add('saved');
        }
    });