<?php 
    include '../lib/mysql.php';

    // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //     return http_response_code(400);
    // }

    session_start();

    // if (empty($_SESSION['isAuthenticated']) || ($_SESSION['type'] != 'admin' && $_SESSION['type'] != 'hospital_admin')){
    //     echo json_encode([ 'message' => 'Authenticatation Failed' ]);
    // };

    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $patientId = $data['patientId'] ?? null;
        $firstName = $data['firstName'] ?? null;
        $lastName = $data['lastName'] ?? null;
        $age = $data['age'] ?? null;
        $sex = $data['sex'] ?? 'o';
        $hospitalId = $data['hospitalId'] ?? null;
        $infectedDate = $data['infectedDate'] ?? null;
        $healDate = $data['healDate'] ?? null;
        $recoveredDate = $data['recoveredDate'] ?? null;
        $deadDate = $data['deadDate'] ?? null;
    
        if (!$patientId || !$firstName || !$lastName || !$age) {
            echo json_encode([ 'message' => 'Incomplete information filled in' ]);
            return;
        };

        $stmt = $conn->prepare('UPDATE patients SET first_name = :firstName, last_name = :lastName, age = :age, sex = :sex, hospital_id = :hospitalId, infected_date = :infectedDate, heal_date = :healDate, recovered_date = :recoveredDate, dead_date = :deadDate WHERE id = :patientId');
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':hospitalId', $hospitalId);
        $stmt->bindParam(':infectedDate', $infectedDate);
        $stmt->bindParam(':healDate', $healDate);
        $stmt->bindParam(':recoveredDate', $recoveredDate);
        $stmt->bindParam(':deadDate', $deadDate);
        $stmt->bindParam(':patientId', $patientId);
    
        $stmt->execute();
    
        echo json_encode([
            "message" => "Successfully"
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
