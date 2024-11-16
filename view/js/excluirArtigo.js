function excluirArtigo(idArtigo) {
    if (confirm("Tem certeza que deseja excluir este artigo?")) {
        fetch(`php/excluir_artigo.php?id=${idArtigo}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Artigo excluído com sucesso!");
                window.location.href = 'home.php';
            } else {
                alert("Erro ao excluir o artigo.");
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            alert("Erro ao excluir o artigo.");
        });
    }
}
