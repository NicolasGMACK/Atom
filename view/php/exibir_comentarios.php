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

// Função para contar respostas de um comentário
function contarRespostas($conection, $comentarioId) {
    $sqlContar = "SELECT COUNT(*) AS total FROM comentario WHERE COM_INT_COM_ID = ?";
    $stmtContar = $conection->prepare($sqlContar);
    $stmtContar->bind_param('i', $comentarioId);
    $stmtContar->execute();
    $resultContar = $stmtContar->get_result();
    $contagem = $resultContar->fetch_assoc();

    return $contagem['total'];
}

// Função para renderizar cada comentário e suas respostas
function renderComentario($comentario) {
    global $conection;

    // Contar respostas do comentário
    $numRespostas = contarRespostas($conection, $comentario['COM_INT_ID']);
    $tempoDesdeComentario = tempoDesde($comentario['COM_DAT_POSTAGEM']);
    $respostaTexto = $numRespostas === 1 ? '1 resposta' : "$numRespostas respostas";
    $displayRespostas = $numRespostas > 0 ? '' : 'style="display: none;"';

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
            <span class="comentarios-mostrar-resposta-btn" ' . $displayRespostas . ' onclick="toggleReplies(' . $comentario['COM_INT_ID'] . ')">' . $respostaTexto . '</span>
            <div class="comentarios-secao-respostas" id="replies-' . $comentario['COM_INT_ID'] . '" style="display: none;">
                ' . exibirRespostas($conection, $comentario['COM_INT_ID']) . ' <!-- Aqui aparecem as respostas -->
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
        $respostasHtml .= renderComentario($resposta); // Renderiza cada resposta
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
    echo renderComentario($comentario);
}
?>
