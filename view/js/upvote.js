function toggleLike(button, articleId) {
    const isLiked = button.classList.contains('liked');

    fetch('php/like_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ articleId, action: isLiked ? 'unlike' : 'like' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recarrega a página para atualizar os likes
            location.reload();
        } else {
            console.error('Erro ao processar a solicitação:', data.error);
        }
    })
    .catch(error => console.error('Erro geral:', error));
}
