// Função para exibir/esconder as respostas de um comentário
function toggleReplies(commentId) {
    // Seleciona a seção de respostas pelo ID
    const replySection = document.getElementById(`replies-${commentId}`);
    // Seleciona o botão de mostrar/esconder respostas pelo atributo onclick
    const showReplyBtn = document.querySelector(`[onclick="toggleReplies(${commentId})"]`);

    // Alterna a exibição da seção de respostas
    if (replySection.style.display === 'none' || replySection.style.display === '') {
        replySection.style.display = 'block';
        // Atualiza o texto do botão para "Esconder Respostas"
        showReplyBtn.textContent = 'Esconder Respostas';
    } else {
        replySection.style.display = 'none';
        // Atualiza o texto do botão para "Mostrar Respostas"
        showReplyBtn.textContent = 'Mostrar Respostas';
    }
}

// Função para exibir/esconder o formulário de resposta de um comentário
function toggleReplyForm(commentId) {
    // Seleciona o formulário de resposta pelo ID
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    
    // Alterna a exibição do formulário de resposta
    replyForm.style.display = replyForm.style.display === 'none' || replyForm.style.display === '' ? 'block' : 'none';
}

// Função para simular o envio de uma resposta
function submitReply(commentId) {
    // Seleciona o formulário de resposta pelo ID
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    // Seleciona a área de texto dentro do formulário
    const textarea = replyForm.querySelector('textarea');

    // Verifica se o campo de texto não está vazio
    if (textarea.value.trim() !== '') {
        alert(`Resposta enviada: ${textarea.value}`);  // Simulação de envio
        textarea.value = '';  // Limpa o campo de texto após o envio
    } else {
        alert('Digite algo para enviar a resposta.');  // Alerta se o campo estiver vazio
    }

    // Aqui, você pode integrar com um back-end para enviar a resposta ao banco de dados
}
