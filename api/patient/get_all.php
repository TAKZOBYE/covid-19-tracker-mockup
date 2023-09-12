<?php 
    include '../mysql.php';

    $stmt = $conn->prepare('SELECT * FROM patients');
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>