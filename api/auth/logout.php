<?php 
    session_start();
    $_SESSION['isAuthenticated'] = null;

    $array = array('isAuthenticated' => !empty($_SESSION['isAuthenticated']));

    echo json_encode($array);

    session_destroy();
?>