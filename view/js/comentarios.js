// Função para exibir/esconder as respostas de um comentário
function toggleReplies(commentId) {
    const replySection = document.querySelector(`#replies-${commentId}`);
    const showReplyBtn = document.querySelector(`[onclick="toggleReplies(${commentId})"]`);

    if (replySection.style.display === 'none' || replySection.style.display === '') {
        replySection.style.display = 'block';
        showReplyBtn.textContent = 'Esconder Respostas';
    } else {
        replySection.style.display = 'none';
        showReplyBtn.textContent = 'Mostrar Respostas';
    }
}

// Função para exibir/esconder o formulário de resposta de um comentário
function toggleReplyForm(commentId) {
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    replyForm.style.display = replyForm.style.display === 'none' || replyForm.style.display === '' ? 'block' : 'none';
}

// Função para enviar o comentário
function submitReply(commentId) {
    // Se commentId for 0, pega o valor do textarea principal
    const textarea = commentId === 0 ? document.getElementById('novo-comentario') : document.querySelector(`#reply-form-${commentId} textarea`);

    if (textarea.value.trim() !== '') {
        const xhr = new XMLHttpRequest();
        // Ajuste o caminho para o inserir_comentario.php
        xhr.open('POST', '/pi-atom/atom/view/php/inserir_comentario.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `conteudo=${encodeURIComponent(textarea.value)}&usuario_id=${userId}&artigo_id=${artigoId}&pai_id=${commentId}`;

        
        xhr.onload = function () {
            console.log('Status:', xhr.status); // Adiciona o código de status no console
            console.log('Response:', xhr.responseText); // Adiciona a resposta no console
        
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert('Comentário enviado!');
                        textarea.value = '';
                    } else {
                        alert('Erro ao enviar comentário: ' + response.message);
                    }
                } catch (e) {
                    console.error('Falha ao analisar JSON:', e);
                    alert('Erro ao processar a resposta do servidor: ' + xhr.responseText);
                }
            } else {
                alert('Erro ao enviar comentário: ' + xhr.status);
            }
        };
        

        xhr.send(data);
    } else {
        alert('Digite algo para enviar a resposta.');
    }
}


