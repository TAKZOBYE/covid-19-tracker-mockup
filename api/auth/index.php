<?php 
    include '../lib/mysql.php';

    session_start();

    $array = array(
        'isAuthenticated' => !empty($_SESSION['isAuthenticated']),
        'type' => !empty($_SESSION['type']) ? $_SESSION['type'] : null,
        'hospitalId' => !empty($_SESSION['hospitalId']) ? $_SESSION['hospitalId'] : null,
        'sessionId' => session_id()
    );

    echo json_encode($array);
?>