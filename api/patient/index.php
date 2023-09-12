<?php 
    include '../mysql.php';

    session_start();

    // $data = json_decode(file_get_contents('php://input'), true);

    $type = $_GET['type'] ?? null;
    $date = $_GET['date'] ?? null;

    $queryText = '';

    if ($type && $date) {
        $queryText = 'SELECT * FROM patients WHERE ' . $type . '_date = :date';
    } else if ($type && !$date) {
        $queryText = 'SELECT * FROM patients WHERE ' . $type . '_date IS NOT NULL';
    } else if (!$type && $date) {
        $queryText = 'SELECT * FROM patients WHERE infected_date = :date OR heal_date = :date OR recovered_date = :date OR dead_date = :date';
    } else {
        $queryText = 'SELECT * FROM patients';
    }

    $stmt = $conn->prepare($queryText);
    if ($date) {
        $stmt->bindParam(':date', $date);
    }

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>