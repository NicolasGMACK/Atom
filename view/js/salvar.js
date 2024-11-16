(function() {
    const saveButtons = document.querySelectorAll('.Salvar');
    const notification = document.getElementById('notification');
    const usuarioId = document.querySelectorAll('usuarioId').value; // Captura o ID do usuário do input hidden

    // Função para verificar quais artigos estão salvos
    const verificarArtigosSalvos = async () => {
        const response = await fetch('php/verificar_artigos_salvos.php');
        const data = await response.json();
    
        if (data.success) {
            const artigosSalvos = data.artigosSalvos;
            // Marcar os botões "Em biblioteca" para os artigos já salvos
            saveButtons.forEach(button => {
                const artigoId = button.getAttribute('data-artigo-id');
                if (artigosSalvos.includes(parseInt(artigoId))) {
                    button.textContent = 'Em biblioteca';
                    button.classList.add('saved');
                }
            });
        } else {
            console.error(data.error);
        }
    };
    

    // Função para salvar ou remover artigo
    const salvarArtigo = async (button, artigoId) => {
        try {
            const isSaved = button.classList.contains('saved');
            const action = isSaved ? 'remover' : 'salvar';

            // Faz a requisição para salvar ou remover o artigo
            const response = await fetch('php/salvar_artigo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `usuario_id=${usuarioId}&artigo_id=${artigoId}&action=${action}`
            });

            const data = await response.json();

            if (data.success) {
                if (action === 'salvar') {
                    button.textContent = 'Em biblioteca';
                    button.classList.add('saved');
                } else {
                    button.textContent = 'Salvar';
                    button.classList.remove('saved');
                }

                // Exibe a notificação de sucesso
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 500);
                }, 3000);
            } else {
                alert(data.error || 'Erro ao processar o artigo');
            }
        } catch (error) {
            console.error('Erro ao salvar/remover o artigo:', error);
        }
    };

    // Adicionar evento de clique nos botões de salvar
    saveButtons.forEach(button => {
        button.addEventListener('click', () => {
            const artigoId = button.getAttribute('data-artigo-id');
            salvarArtigo(button, artigoId);
        });
    });

    // Verifica os artigos salvos ao carregar a página
    verificarArtigosSalvos();
})();
