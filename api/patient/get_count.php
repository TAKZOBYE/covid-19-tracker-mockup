<?php 
    include '../lib/mysql.php';
    
    $currentDate = date("Y-m-d");

    $stmt = $conn->prepare('SELECT COUNT(infected_date), COUNT(recovered_date), COUNT(dead_date) FROM patients');
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;

    if (!$result) {
        echo 'No data available';
        return;
    }

    $infectedCount = $result['COUNT(infected_date)'];
    $recoveredCount = $result['COUNT(recovered_date)'];
    $deadCount = $result['COUNT(dead_date)'];

    $stmt = $conn->prepare('SELECT COUNT(heal_date) FROM patients WHERE (heal_date IS NOT NULL AND heal_date <> "") AND (recovered_date IS NULL OR NOT recovered_date <> "") AND (dead_date IS NULL OR NOT dead_date <> "")');
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;

    if (!$result) {
        echo 'No data available';
        return;
    }

    $healCount = $result['COUNT(heal_date)'];

    $stmt = $conn->prepare('SELECT COUNT(infected_date) FROM patients WHERE infected_date = :currentDate');
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;
    if (!$result) {
        echo 'No data available';
        return;
    }

    $todayInfectedCount = $result['COUNT(infected_date)'];

    $stmt = $conn->prepare('SELECT COUNT(heal_date) FROM patients WHERE heal_date = :currentDate');
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;
    if (!$result) {
        echo 'No data available';
        return;
    }

    $todayHealCount = $result['COUNT(heal_date)'];

    $stmt = $conn->prepare('SELECT COUNT(recovered_date) FROM patients WHERE recovered_date = :currentDate');
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;
    if (!$result) {
        echo 'No data available';
        return;
    }

    $todayRecoveredCount = $result['COUNT(recovered_date)'];

    $stmt = $conn->prepare('SELECT COUNT(dead_date) FROM patients WHERE dead_date = :currentDate');
    $stmt->bindParam(':currentDate', $currentDate);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = $result[0] ?? null;
    if (!$result) {
        echo 'No data available';
        return;
    }

    $todayDeadCount = $result['COUNT(dead_date)'];

    $data = [
        "infected" => [
            "sum" => $infectedCount,
            "new" => $todayInfectedCount,
        ],
        "heal" => [
            "sum" => $healCount,
            "new" => $todayHealCount,
        ],
        "recovered" => [
            "sum" => $recoveredCount,
            "new" => $todayRecoveredCount,
        ],
        "dead" => [
            "sum" => $deadCount,
            "new" => $todayDeadCount,
        ],
    ];

    echo json_encode($data);
?>