<?php 
    require_once('../config/db.php');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: DELETE");

    if(!isset($_GET['id'])) {
        http_response_code(401);
        echo json_encode(['message' => 'id manquant']);
        exit(1);
    }

    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(400);
        echo json_encode(['message' => 'Utilisateur non trouvé']);
        exit(1);
    }

    $Query = $conn->prepare("DELETE FROM users WHERE id=?");
    $Query->execute([$user['id']]);
    if ($Query->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(['message' => 'Utilisateursupprimé avec success']);
    }
?>