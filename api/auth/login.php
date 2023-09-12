<?php 
    include '../mysql.php';

    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $password = $data['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result || !$result[0] || !$result[0]['password']) return;

    // echo json_encode($result);

    if (!password_verify($password, $result[0]['password'])) return;

    echo 'Verified';

    session_start();
    $_SESSION['isAuthenticated'] = TRUE;
    $_SESSION['type'] = $result[0]['type'];
    $_SESSION['hospitalId'] = $result[0]['hospital_id'];
?>