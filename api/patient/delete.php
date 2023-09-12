<?php 
    include '../lib/mysql.php';

    session_start();

    if (empty($_SESSION['isAuthenticated']) || ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'hospital_admin')) return;

    $data = json_decode(file_get_contents('php://input'), true);

    $patientId = $data['patientId'] ?? null;

    if (!$patientId) {
        echo 'Incomplete information filled in';
        return;
    };

    $stmt = $conn->prepare('DELETE FROM patients WHERE id = :patientId');
    $stmt->bindParam(':patientId', $patientId);

    $stmt->execute();

    echo 'Delete Success'
?>