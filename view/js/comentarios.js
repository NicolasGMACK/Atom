// Função para exibir/esconder as respostas de um comentário
function toggleReplies(commentId) {
    const replySection = document.querySelector(`#replies-${commentId}`);
    const showReplyBtn = document.querySelector(`[onclick="toggleReplies(${commentId})"]`);

    if (replySection.style.display === 'none' || replySection.style.display === '') {
        // Carrega respostas via AJAX se elas ainda não estiverem carregadas
        if (!replySection.classList.contains('loaded')) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `/pi-atom/atom/view/php/carregar_respostas.php?comentario_id=${commentId}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    replySection.innerHTML = xhr.responseText;
                    replySection.classList.add('loaded');  // Marca como carregado
                } else {
                    console.error('Erro ao carregar respostas: ', xhr.status);
                }
            };
            xhr.send();
        }

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
    const textarea = commentId === 0 ? document.getElementById('novo-comentario') : document.querySelector(`#reply-form-${commentId} textarea`);

    if (textarea.value.trim() !== '') {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/pi-atom/atom/view/php/inserir_comentario.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `conteudo=${encodeURIComponent(textarea.value)}&usuario_id=${userId}&artigo_id=${artigoId}&pai_id=${commentId}`;

        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert('Comentário enviado!');  // Exibe a mensagem de sucesso
                        textarea.value = '';  // Limpa o campo de texto
                        location.reload();  // Atualiza a página
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


