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

Ao exibir os comentários, use a função tempoDesde() para mostrar o tempo desde a postagem:

echo "Comentário: " . $comentario['COM_VAR_CONTEUDO'];
echo "Postado " . tempoDesde($comentario['COM_DAT_POSTAGEM']);


Exibir Comentários e Respostas:


