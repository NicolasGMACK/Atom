 // Função para tratar o clique nos botões de salvar/remover
 $(".botoes.Salvar").on("click", function() {
    var artigoId = $(this).data("artigo-id");  // Obtém o ID do artigo do botão
    var action = $(this).data("action");  // Obtém a ação (salvar ou remover)

    $.ajax({
        type: 'POST',
        url: 'caminho/para/seu/script.php',  // O caminho para o seu script PHP que processa a ação
        data: { artigo_id: artigoId, action: action },
        success: function(response) {
            const data = JSON.parse(response);
            
            if (data.success) {
                console.log(data.message); // Mensagem de sucesso no console
                alert(data.message); // Exibe a mensagem para o usuário (opcional)
            } else {
                console.log(data.error); // Mensagem de erro no console
                alert(data.error); // Exibe o erro para o usuário (opcional)
            }

            // Recarregar a página após a ação
            location.reload();  // Recarrega a página após salvar/remover o artigo
        },
        error: function() {
            console.log("Erro na requisição AJAX");
            location.reload();  // Recarrega a página em caso de erro
        }
    });
});