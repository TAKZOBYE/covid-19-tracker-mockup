<?php 
    include '../lib/mysql.php';

    session_start();

    // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //     return http_response_code(400);
    // }

    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $password = $data['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result || !$result[0] || !$result[0]['password']) {
        echo json_encode(['isAuthenticated' => false, 'message' => 'Username not valid']);

        return;
    };

    // echo json_encode($result);

    if (!password_verify($password, $result[0]['password'])) {
        echo json_encode(['isAuthenticated' => false, 'message' => 'Password not valid']);

        return;
    };

    $_SESSION['isAuthenticated'] = true;
    $_SESSION['type'] = $result[0]['type'];
    $_SESSION['hospitalId'] = $result[0]['hospital_id'];

    echo json_encode(['isAuthenticated' => true, 'sessionId' => session_id()]);
