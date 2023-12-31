<?php
include '../lib/mysql.php';

try {
    // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //     return http_response_code(400);
    // }

    session_start();

    // if (empty($_SESSION['isAuthenticated']) || ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'hospital_admin')) return;

    $data = json_decode(file_get_contents('php://input'), true);

    $firstName = $data['firstName'] ?? null;
    $lastName = $data['lastName'] ?? null;
    $age = $data['age'] ?? null;
    $sex = $data['sex'] ?? 'o';
    $hospitalId = $_SESSION['hospitalId'] ?? null;
    $infectedDate = $data['infectedDate'] ?? null;
    $healDate = $data['healDate'] ?? null;
    $recoveredDate = $data['recoveredDate'] ?? null;
    $deadDate = $data['deadDate'] ?? null;

    if (!$firstName || !$lastName || !$age) {
        echo json_encode(['message' => 'Incomplete information filled in']);
        return;
    };

    $stmt = $conn->prepare('INSERT INTO patients (first_name, last_name, age, sex, hospital_id, infected_date, heal_date, recovered_date, dead_date) VALUES (:firstName, :lastName, :age, :sex, :hospitalId, :infectedDate, :healDate, :recoveredDate, :deadDate)');
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':hospitalId', $hospitalId);
    $stmt->bindParam(':infectedDate', $infectedDate);
    $stmt->bindParam(':healDate', $healDate);
    $stmt->bindParam(':recoveredDate', $recoveredDate);
    $stmt->bindParam(':deadDate', $deadDate);

    $stmt->execute();

    echo json_encode(['message' => 'Add Successfully']);
} catch (PDOException $e) { 
    echo json_encode(['message' => $e->getMessage()]);
}
