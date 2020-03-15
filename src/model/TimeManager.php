<?php declare(strict_types = 1);


namespace Kodas\Model;

use Kodas\Model\Database;

class TimeManager
{
    private $pdo;

    private function connect()
    {
        if ($this->pdo === null) {
            $database = new Database();
            $this->pdo = $database->connect();
        }
        return $this->pdo;
    }

    public function setServiceTimeStart($userId, $specialistId)
    {
        $datetime = date_create()->format('Y-m-d H:i:s');
        $sql = "INSERT INTO service_time (service_start, fk_specialist_id, fk_user_id) VALUES(?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$datetime, $specialistId, $userId]);
    }

    public function setServiceTimeEnd($userId, $specialistId)
    {
        $datetime = date_create()->format('Y-m-d H:i:s');
        $sql = "UPDATE service_time SET service_end = :service_end WHERE fk_specialist_id = :fk_specialist_id AND fk_user_id = :fk_user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            ':service_end' => $datetime,
            ':fk_specialist_id' => $specialistId,
            ':fk_user_id' => $userId
        ]);
    }

    public function getVisitLength($userId)
    {
        $sql = "SELECT TIMEDIFF(service_end, service_start) AS timediff FROM service_time WHERE fk_user_id = :fk_user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'fk_user_id' => $userId
        ]);
        $results = $stmt->fetchAll();
        return $results[0]['timediff'];
    }

    public function getWaitTime($specialistId)
    {

    }

    public function calculateAvgServiceTime($specialistId)
    {
//        $sql = "SELECT specialist_id, specialist_name, TIME_TO_SEC(TIMEDIFF(service_end, service_start)) as timediff FROM specialist LEFT JOIN service_time ON specialist.specialist_id = service_time.fk_specialist_id";
        $sql = "SELECT AVG(TIMEDIFF(service_end, service_start)) as timediff FROM service_time WHERE fk_specialist_id = :fk_specialist_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'fk_specialist_id' => $specialistId
        ]);
        $results = $stmt->fetchAll();
//      return as seconds
        $results = intval($results[0]['timediff']);
        return $results;
    }

    public function getCountBySpecialist($specialistId)
    {
        $sql = "SELECT COUNT(fk_specialist_id) as count FROM service_time WHERE fk_specialist_id = :fk_specialist_id GROUP BY fk_specialist_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'fk_specialist_id' => $specialistId
        ]);
        $results = $stmt->fetchAll();
        var_dump($results[0]['count']);
    }
}
