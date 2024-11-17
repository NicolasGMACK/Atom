<?php
// Função para exibir a mensagem
function exibirMensagem($mensagem, $dataAnterior = null) {
    // Formata a data da mensagem
    $dataMensagem = date("Y-m-d", strtotime($mensagem['MSG_DAT_ENVIO']));
    $horaMinuto = date("H:i", strtotime($mensagem['MSG_DAT_ENVIO']));

    // Verifica se a data mudou em relação à mensagem anterior
    if ($dataMensagem !== $dataAnterior) {
        echo '<div class="date-separator">' . date("d/m/Y", strtotime($dataMensagem)) . '</div>';
    }

    // Prepara o conteúdo da mensagem
    $conteudo = htmlspecialchars($mensagem['MSG_VAR_CONTEUDO']); // Escapa por padrão

    // Verifica se a mensagem é do tipo 'artigo' ou contém links
    if ($mensagem['MSG_TIPO'] === 'artigo' && !empty($mensagem['MSG_ARTIGO_TOKEN'])) {
        $tokenArtigo = $mensagem['MSG_ARTIGO_TOKEN'];

        // Busca o título do artigo
        $sqlArtigo = "SELECT ART_VAR_TITULO FROM artigo WHERE ART_INT_ID = (
                        SELECT ART_INT_ID FROM tokens_artigo WHERE TOK_ART_VAR_TOK = ?)";
        global $conection; // Acessando a variável de conexão no escopo global
        $stmtArtigo = $conection->prepare($sqlArtigo);
        $stmtArtigo->bind_param('s', $tokenArtigo);
        if ($stmtArtigo->execute()) {
            $stmtArtigo->bind_result($tituloArtigo);
            $stmtArtigo->fetch();
            $stmtArtigo->close();
        } else {
            $tituloArtigo = null;
        }

        // Gera o link do artigo
        $conteudo = !empty($tituloArtigo)
            ? 'Confira este artigo: <a href="artigo.php?token=' . htmlspecialchars($tokenArtigo) . '" target="_blank">' . htmlspecialchars($tituloArtigo) . '</a>'
            : 'Confira este artigo: <a href="artigo.php?token=' . htmlspecialchars($tokenArtigo) . '" target="_blank">Clique aqui para ver o artigo</a>';
    } elseif (strpos($conteudo, '<a ') !== false) {
        // Decodifica o HTML para mensagens com links
        $conteudo = html_entity_decode($conteudo, ENT_QUOTES, 'UTF-8');
    }

    // Gera o HTML da mensagem
    echo '<div class="message ' . ($mensagem['USU_INT_ID'] == $_SESSION['id'] ? 'user' : 'other') . '">';
    echo '  <div class="message-content">'; // Contêiner para o texto da mensagem
    if ($mensagem['MSG_TIPO'] === 'artigo') {
        echo $conteudo;
    } else {
        echo nl2br($conteudo); // Exibe como texto simples com quebras de linha
    }
    echo '  </div>';
    echo '  <span class="timestamp">' . $horaMinuto . '</span>'; // Timestamp sempre fora do contêiner do texto
    echo '</div>';

    // Retorna a data atual para a próxima chamada da função
    return $dataMensagem;
}
?>
