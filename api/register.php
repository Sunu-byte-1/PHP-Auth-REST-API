<?php 
    require_once('../config/db.php');


    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'),true);

    if (!$data['nom'] || !$data['email'] || !$data['password']) {
        http_response_code(400);
        echo json_encode(['message' => 'les champs ne doivent pas etre vide']);
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            http_response_code(500);
            echo json_encode(['message' => 'c mail existe deja']);
        } else {
            $hashedPwd = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(prenom, nom, email, password) VALUES (?,?,?,?)");
            $ok = $stmt->execute([
                $data['prenom'],
                $data['nom'],
                $data['email'],
                $hashedPwd
            ]);

            if ($ok) {
                http_response_code(201);
                echo json_encode(['message' => 'inscription reussie']);
            }
        } 
    }

   

