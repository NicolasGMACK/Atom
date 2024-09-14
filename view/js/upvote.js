function toggleLike(button) {
    const isLiked = button.classList.contains('liked');
    const likeIcon = button.querySelector('.like-icon');
    
    if (!isLiked) {
        // Se ainda não foi curtido, adiciona a classe 'liked'
        button.classList.add('liked');
        button.innerHTML = `<span class="material-symbols-outlined like-icon">shift</span><span class="like-count">3.9K</span>`; // Coloque o número de likes aqui
    } else {
        // Alterna para o estado original
        button.classList.remove('liked');
        button.innerHTML = `<span class="material-symbols-outlined">shift</span><div class="vote">Relevante</div>`;
    }
}
