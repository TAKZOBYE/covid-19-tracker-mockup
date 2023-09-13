<?php
    include '../lib/mysql.php';

    // if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    //     return http_response_code(400);
    // }

    try {

        function getStatus($infectedDate, $healDate, $recoveredDate, $deadDate)
        {
            if ($infectedDate && !$healDate && !$recoveredDate && !$deadDate) {
                return 'ติดเชื้อ';
            } else if ($healDate && !$recoveredDate && !$deadDate) {
                return 'กำลังรักษา';
            } else if ($recoveredDate && !$deadDate) {
                return 'หายแล้ว';
            } else if ($deadDate) {
                return 'เสียชีวิต';
            }

            return '';
        }

        session_start();

        // $data = json_decode(file_get_contents('php://input'), true);

        $type = $_GET['type'] ?? null;
        $type = $type != 'all' ? $type : null;
        $date = $_GET['date'] ?? null;

        $queryText = '';

        if ($type) {
            $additionalText = '';

            if ($type == 'infected') {
                $additionalText = 'AND heal_date IS NULL OR NOT heal_date <> ""';
            } else if ($type == 'heal') {
                $additionalText = 'AND (recovered_date IS NULL OR NOT recovered_date <> "") AND (dead_date IS NULL OR NOT dead_date <> "")';
            }

            if ($date) {
                $queryText = 'SELECT patients.id AS patientId, first_name, last_name, age, sex, hospital_id, infected_date, heal_date, recovered_date, dead_date, name, label 
                FROM patients
                INNER JOIN hospital_info ON patients.hospital_id = hospital_info.id
                WHERE ' . $type . '_date = :date' . $additionalText;
            } else {
                $queryText = "SELECT patients.id AS patientId, first_name, last_name, age, sex, hospital_id, infected_date, heal_date, recovered_date, dead_date, name, label 
                    FROM patients 
                    INNER JOIN hospital_info ON patients.hospital_id = hospital_info.id
                    WHERE " . $type . "_date IS NOT NULL AND " . $type . "_date <> ''"  . $additionalText;
            }
        } else if (!$type && $date) {
                $queryText = 'SELECT patients.id AS patientId, first_name, last_name, age, sex, hospital_id, infected_date, heal_date, recovered_date, dead_date, name, label 
                    FROM patients 
                    INNER JOIN hospital_info ON patients.hospital_id = hospital_info.id 
                    WHERE infected_date = :date OR heal_date = :date OR recovered_date = :date OR dead_date = :date';
        } else {
                $queryText = 'SELECT patients.id AS patientId, first_name, last_name, age, sex, hospital_id, infected_date, heal_date, recovered_date, dead_date, name, label 
                    FROM patients 
                    INNER JOIN hospital_info 
                    ON patients.hospital_id = hospital_info.id';
        }

        $stmt = $conn->prepare($queryText);
        if ($date) {
            $stmt->bindParam(':date', $date);
        }
        $stmt->execute();
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($patients); $i++) {
            $patients[$i]['hospitalName'] = $patients[$i]['name'];
            $patients[$i]['hospitalLabel'] = $patients[$i]['label'];
            $patients[$i]['firstName'] = $patients[$i]['first_name'];
            $patients[$i]['lastName'] = $patients[$i]['last_name'];
            $patients[$i]['hospitalId'] = $patients[$i]['hospital_id'];
            $patients[$i]['infectedDate'] = $patients[$i]['infected_date'];
            $patients[$i]['healDate'] = $patients[$i]['heal_date'];
            $patients[$i]['recoveredDate'] = $patients[$i]['recovered_date'];
            $patients[$i]['deadDate'] = $patients[$i]['dead_date'];

            unset($patients[$i]['name']);
            unset($patients[$i]['first_name']);
            unset($patients[$i]['last_name']);
            unset($patients[$i]['hospital_id']);
            unset($patients[$i]['infected_date']);
            unset($patients[$i]['heal_date']);
            unset($patients[$i]['recovered_date']);
            unset($patients[$i]['dead_date']);

            $patients[$i]['status'] = getStatus($patients[$i]['infectedDate'], $patients[$i]['healDate'], $patients[$i]['recoveredDate'], $patients[$i]['deadDate']);
        }

        echo json_encode($patients);
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
