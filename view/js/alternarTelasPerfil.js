
    document.addEventListener("DOMContentLoaded", function() {
        // Botões de navegação
        const publicacoesBtn = document.getElementById('publicacoesBtn');
        const bibliotecaBtn = document.getElementById('bibliotecaBtn');
        
        // Telas
        const publicacoes = document.getElementById('publicacoes');
        const biblioteca = document.getElementById('biblioteca');
        
        // Função para trocar a exibição das telas
        function showScreen(showPublicacoes) {
            // Trocar display das telas
            if (showPublicacoes) {
                publicacoes.style.display = 'flex';
                biblioteca.style.display = 'none';

                // Salvar a escolha no localStorage
                localStorage.setItem('selectedScreen', 'publicacoes');

                // Refresh da página ao exibir a tela de Publicações
                location.reload();  // Isso recarrega a página
            } else {
                publicacoes.style.display = 'none';
                biblioteca.style.display = 'flex';

                // Salvar a escolha no localStorage
                localStorage.setItem('selectedScreen', 'biblioteca');

                // Refresh da página ao exibir a tela da Biblioteca
                location.reload();  // Isso recarrega a página
            }

            // Trocar as classes dos botões
            if (showPublicacoes) {
                publicacoesBtn.classList.add('marcada');
                publicacoesBtn.classList.remove('selecionar');
                bibliotecaBtn.classList.add('selecionar');
                bibliotecaBtn.classList.remove('marcada');
            } else {
                bibliotecaBtn.classList.add('marcada');
                bibliotecaBtn.classList.remove('selecionar');
                publicacoesBtn.classList.add('selecionar');
                publicacoesBtn.classList.remove('marcada');
            }
        }

        // Verificar qual aba foi salva no localStorage ao carregar a página
        const selectedScreen = localStorage.getItem('selectedScreen');
        if (selectedScreen === 'biblioteca') {
            // Exibir a biblioteca e trocar as classes
            publicacoes.style.display = 'none';
            biblioteca.style.display = 'flex';
            bibliotecaBtn.classList.add('marcada');
            bibliotecaBtn.classList.remove('selecionar');
            publicacoesBtn.classList.add('selecionar');
            publicacoesBtn.classList.remove('marcada');
        } else {
            // Exibir as publicações e trocar as classes
            publicacoes.style.display = 'flex';
            biblioteca.style.display = 'none';
            publicacoesBtn.classList.add('marcada');
            publicacoesBtn.classList.remove('selecionar');
            bibliotecaBtn.classList.add('selecionar');
            bibliotecaBtn.classList.remove('marcada');
        }

        // Ao clicar em "Publicações"
        publicacoesBtn.addEventListener('click', function() {
            showScreen(true);
        });

        // Ao clicar em "Biblioteca"
        bibliotecaBtn.addEventListener('click', function() {
            showScreen(false);
        });
    });