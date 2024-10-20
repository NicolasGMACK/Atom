<?php
require_once('conection.php');

// Definir o fuso horário para garantir que os timestamps sejam corretos
date_default_timezone_set('America/Sao_Paulo'); // Ajuste conforme o fuso horário desejado

// Função para exibir o tempo desde o comentário
function tempoDesde($data) {
    $agora = new DateTime();
    $diferenca = $agora->diff(new DateTime($data));
    
    if ($diferenca->y > 0) {
        return $diferenca->y . ' anos atrás';
    } elseif ($diferenca->m > 0) {
        return $diferenca->m . ' meses atrás';
    } elseif ($diferenca->d > 0) {
        return $diferenca->d . ' dias atrás';
    } elseif ($diferenca->h > 0) {
        return $diferenca->h . ' horas atrás';
    } elseif ($diferenca->i > 0) {
        return $diferenca->i . ' minutos atrás';
    } else {
        return 'agora';
    }
}

// Função para renderizar cada comentário e suas respostas
function renderComentario($comentario, $tempoDesdeComentario) {
    global $conection;

    // Obter as respostas do comentário
    $respostas = exibirRespostas($conection, $comentario['COM_INT_ID']); 

    return '
    <div class="comentarios-comentario" data-comment-id="' . $comentario['COM_INT_ID'] . '">
        <div class="um-comentario">
            <div class="comentarios-cabecalho">
                <img src="../view/img/user.jpg" alt="Imagem de perfil do comentário" class="comentarios-imagem-perfil">
                <span class="comentarios-usuario">' . htmlspecialchars($comentario['USU_VAR_NAME']) . '</span>
                <span class="comentarios-acoes">' . $tempoDesdeComentario . '</span>
            </div>
            <div class="comentarios-corpo">' . htmlspecialchars($comentario['COM_VAR_CONTEUDO']) . '</div>
            <button class="comentarios-responder-btn" onclick="toggleReplyForm(' . $comentario['COM_INT_ID'] . ')">Responder</button>
            <span class="comentarios-mostrar-resposta-btn" onclick="toggleReplies(' . $comentario['COM_INT_ID'] . ')">Mostrar Respostas</span>
            <div class="comentarios-secao-respostas" id="replies-' . $comentario['COM_INT_ID'] . '" style="display: none;">
                ' . $respostas . ' <!-- Aqui aparecem as respostas -->
            </div>
            <div class="comentarios-formulario-resposta" id="reply-form-' . $comentario['COM_INT_ID'] . '" style="display: none;">
                <textarea rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
                <button class="comentarios-enviar-btn" onclick="submitReply(' . $comentario['COM_INT_ID'] . ')">Enviar</button>
            </div>
        </div>
    </div>';
}

// Função para exibir as respostas de um comentário
function exibirRespostas($conection, $comentarioId) {
    $sqlRespostas = "
        SELECT c.*, u.USU_VAR_NAME 
        FROM comentario c
        JOIN usuario u ON c.USU_INT_ID = u.USU_INT_ID
        WHERE c.COM_INT_COM_ID = ?
    ";
    $stmtRespostas = $conection->prepare($sqlRespostas);
    $stmtRespostas->bind_param('i', $comentarioId);
    $stmtRespostas->execute();
    $resultRespostas = $stmtRespostas->get_result();

    $respostasHtml = '';

    while ($resposta = $resultRespostas->fetch_assoc()) {
        $dataCriacao = isset($resposta['COM_DAT_POSTAGEM']) ? $resposta['COM_DAT_POSTAGEM'] : null;
        $tempoDesdeResposta = tempoDesde($dataCriacao);

        $respostasHtml .= renderComentario($resposta, $tempoDesdeResposta); // Renderiza cada resposta
    }

    return $respostasHtml;
}

// Carrega os comentários principais (sem pai)
$sql = "
    SELECT c.*, u.USU_VAR_NAME 
    FROM comentario c
    JOIN usuario u ON c.USU_INT_ID = u.USU_INT_ID
    WHERE c.COM_INT_COM_ID IS NULL
    AND c.ART_INT_ID = ?
";
$stmt = $conection->prepare($sql);
$stmt->bind_param('i', $artigoId); // Certifique-se de que $artigoId seja passado corretamente
$stmt->execute();
$result = $stmt->get_result();

// Exibe cada comentário principal
while ($comentario = $result->fetch_assoc()) {
    $dataCriacao = isset($comentario['COM_DAT_POSTAGEM']) ? $comentario['COM_DAT_POSTAGEM'] : null;
    $tempoDesdeComentario = tempoDesde($dataCriacao);

    echo renderComentario($comentario, $tempoDesdeComentario);
}
?>
