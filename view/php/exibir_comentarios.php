<?php     // Exibir os comentários do banco de dados

date_default_timezone_set('America/Sao_Paulo'); // Ajuste para o seu fuso horário

$sqlComentarios = "
                                        SELECT c.*, u.USU_VAR_NAME 
                                        FROM comentario c
                                        JOIN usuario u ON c.USU_INT_ID = u.USU_INT_ID
                                        WHERE c.ART_INT_ID = ? AND c.COM_INT_COM_ID IS NULL";
$stmtComentarios = $conection->prepare($sqlComentarios);
$stmtComentarios->bind_param('i', $artigoId);
$stmtComentarios->execute();
$resultComentarios = $stmtComentarios->get_result();

while ($comentario = $resultComentarios->fetch_assoc()) {
// Formatar a data de criação
$dataCriacao = isset($comentario['COM_DAT_POSTAGEM']) ? $comentario['COM_DAT_POSTAGEM'] : null;    


// Usar a função tempoDesde para calcular quanto tempo faz
$tempoDesdeComentario = tempoDesde($dataCriacao);

// Renderizar o comentário com a data formatada
echo renderComentario($comentario, $tempoDesdeComentario);
}

function renderComentario($comentario, $tempoDesdeComentario) {
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

<div class="comentarios-formulario-resposta" id="reply-form-' . $comentario['COM_INT_ID'] . '" style="display: none;">
<textarea rows="3" placeholder="Escreva sua resposta aqui..."></textarea>
<button class="comentarios-enviar-btn" onclick="submitReply(' . $comentario['COM_INT_ID'] . ')">Enviar</button>
</div>
</div>
<div class="comentarios-secao-respostas" id="replies-' . $comentario['COM_INT_ID'] . '" style="display: none;"></div>
</div>';
}

function tempoDesde($data) {
$agora = new DateTime();
$dataComentario = new DateTime($data);
$diferenca = $agora->diff($dataComentario);

if ($diferenca->y > 0) {
return $diferenca->y . ' ano' . ($diferenca->y > 1 ? 's' : '') . ' atrás';
} elseif ($diferenca->m > 0) {
return $diferenca->m . ' mês' . ($diferenca->m > 1 ? 'es' : '') . ' atrás';
} elseif ($diferenca->d > 0) {
return $diferenca->d . ' dia' . ($diferenca->d > 1 ? 's' : '') . ' atrás';
} elseif ($diferenca->h > 0) {
return $diferenca->h . ' hora' . ($diferenca->h > 1 ? 's' : '') . ' atrás';
} elseif ($diferenca->i > 0) {
return $diferenca->i . ' minuto' . ($diferenca->i > 1 ? 's' : '') . ' atrás';
} else {
return 'agora';
}
}
?>