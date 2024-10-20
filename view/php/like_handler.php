<?php
require_once('conection.php');
session_start(); // Para obter o ID do usuário logado

$data = json_decode(file_get_contents('php://input'), true);
$articleId = $data['articleId'];
$action = $data['action'];
$userId = $_SESSION['id']; // Assumindo que o ID do usuário está salvo na sessão

if ($action === 'like') {
    // Verifica se o usuário já curtiu o artigo
    $checkLike = "SELECT * FROM upvote WHERE UP_USU_INT_ID = $userId AND UP_ART_INT_ID = $articleId";
    $resultCheck = mysqli_query($conection, $checkLike);

    if (mysqli_num_rows($resultCheck) === 0) {
        // Insere o like no banco de dados
        $query = "INSERT INTO upvote (UP_USU_INT_ID, UP_ART_INT_ID, UP_DAT_DATA) VALUES ($userId, $articleId, NOW())";
        mysqli_query($conection, $query);
    }
} else if ($action === 'unlike') {
    // Remove o like do banco de dados
    $query = "DELETE FROM upvote WHERE UP_USU_INT_ID = $userId AND UP_ART_INT_ID = $articleId";
    mysqli_query($conection, $query);
}

// Retorna o número atualizado de likes
$queryLikes = "SELECT COUNT(*) AS totalLikes FROM upvote WHERE UP_ART_INT_ID = $articleId";
$resultLikes = mysqli_query($conection, $queryLikes);
$totalLikes = mysqli_fetch_assoc($resultLikes)['totalLikes'];

echo json_encode(['success' => true, 'totalLikes' => $totalLikes]);
?>
