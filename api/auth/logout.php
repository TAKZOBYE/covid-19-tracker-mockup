<?php 
    session_start();
    
    // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //     return http_response_code(400);
    // }
    
    $_SESSION['isAuthenticated'] = null;
    $array = array('isAuthenticated' => false);

    echo json_encode($array);

    session_destroy();
?>