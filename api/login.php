<?php 
    require_once('../config/db.php');

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['email'] || empty($data['password']))) {
        http_response_code(400);
        echo json_encode(['message' => 'les champs sont requis']);
        exit(1);
    } 
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$data['email']]);
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$users) {
        http_response_code(400);
        echo json_encode(['message' => 'adresse mail ou mot de passe incorrect']);
        exit(1);
    }
    if(!password_verify($data['password'], $users['password'])) {
        http_response_code(400);
        echo json_encode(['message' => 'adresse mail ou mot de passe incorrect']);
    } else {
        http_response_code(200);
        echo json_encode([
            'message' => 'Connexion reussie',
            'data' => $users
        ]);
    }