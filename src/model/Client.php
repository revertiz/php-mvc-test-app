<?php declare(strict_types = 1);


namespace Kodas\Model;

use Kodas\Model\TimeManager;
use PDO;
use Kodas\Model\Database;

class Client
{

    private $id;
    private $name;
    private $specialistId;
    private $serviced = 0;
    public $waitTime = 0;
    public $expectedServiceTime;
    private $pdo;
    private $timeManager;


//    function __construct(TimeManager $timeManager, $data = [])
    function __construct($data = [])
    {
        $this->id = $data['user_id'];
        $this->name = $data['user_name'];
        $this->specialistId = $data['fk_specialist'];
        $this->serviced = $data['serviced'];
        $this->getQueuePosition();
//        $this->timeManager = $timeManager;
        $this->timeManager = new TimeManager();
    }

    private function connect()
    {
        if ($this->pdo === null) {
            $database = new Database();
            $this->pdo = $database->connect();
        }
        return $this->pdo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getServiced()
    {
        return $this->serviced;
    }

    public function isServiced()
    {
        if($this->serviced == 1) {
            return true;
        }
        return false;
    }

    public function getSpecialistId()
    {
        return $this->specialistId;
    }
    public function getExpServTime()
    {
        return date('H:i:s', $this->expectedServiceTime);
    }

    public function getWaitTime()
    {
        $sql = "SELECT service_start FROM service_time WHERE fk_user_id = :fk_user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(["fk_user_id" => $this->id]);
        $results = $stmt->fetchAll();

        $expectedServiceTime = strtotime($results[0]['service_start']) + $this->waitTime;
//        var_dump($expectedServiceTime);
        $timeLeft = $expectedServiceTime - strtotime(date("H:i:s"));
        if ($timeLeft > 0) {
            return gmdate('H:i:s', $timeLeft);
    }
        return null;
    }

    public function getWaitTimeSeconds()
    {
        $datetime = date("H:i:s");
        $timestamp = strtotime($datetime);
        $time = $timestamp + $this->waitTime;
        return date("H:i:s", $time);
    }

    protected function resultObjectsArray($results)
    {
        $clientObjects = array();
        foreach ($results as $data) {
            array_push($clientObjects, new Client($data));
        }
        //sita gal perkelt i kontroleri? ir su GET susiet sortus dar koki padaryt kad pasitestint
        $clientObjects = $this->sortByWaitTime($clientObjects);

        return $clientObjects;
    }

    function sortByWaitTime( $objectArray ) {
        usort($objectArray, function ($attribute1, $attribute2) {
            return $attribute1->waitTime <=> $attribute2->waitTime;
        });
        return $objectArray;
    }

    public function getAllUnservicedClients() : array
    {
        $sql = "SELECT * FROM user WHERE serviced = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $this->resultObjectsArray($results);
    }

    public function getAllUnserviced()
    {
        $sql = "SELECT user_id, user_name, fk_specialist, serviced, service_time.service_start FROM user LEFT JOIN service_time ON user_id = fk_user_id WHERE serviced = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        var_dump($results);
    }

    public function getAllServiced($userId)
    {
        $sql = "SELECT user_id, user_name, fk_specialist, serviced, service_start, service_end FROM user LEFT JOIN service_time ON user_id = fk_user_id WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        var_dump($results);
    }

    public function getClientById(string $id) : object
    {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

        $results = $stmt->fetchAll();
        return new Client($results[0]);
    }

    public function deleteClientById(string $id)
    {
        $sql = "DELETE FROM user WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $sql = "DELETE FROM service_time WHERE fk_user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

    }

    public function registerClient(string $name, string $specialistId)
    {
        // lastInsertId(); veikia tik ant to pacio connectiono
        $sql = "INSERT INTO user(user_name , fk_specialist) VALUES(? , ?)";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $specialistId]);
        $userId = $pdo->lastInsertId();

        $this->timeManager->setServiceTimeStart($userId, $specialistId);

    }

    public function getSpecialist() : object
    {
        $specialist = new Specialist();
        return $specialist->getSpecialistById($this->specialistId);
    }

    public function getVisitLength(string $userId) : string
    {
        return $this->timeManager->getVisitLength($userId);

    }

    public function getWaitTimes()
    {
        $sql = "SELECT user.user_id, user.fk_specialist, service_time.service_start FROM user LEFT JOIN service_time ON user.user_id = service_time.fk_user_id WHERE user.serviced = 0 AND fk_specialist = :fk_specialist ORDER BY service_time.service_start AND service_time.fk_specialist_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['fk_specialist' => $this->specialistId]);
        $results = $stmt->fetchAll();

        return $results;
    }

    public function getQueuePosition()
    {
        $data = $this->getWaitTimes();

        $index = 1;
        foreach ($data as $key => $value) {
            if ($this->id == $value['user_id'] && $this->specialistId == $value['fk_specialist']) {
                //sita perdet i atskira funkcija, kitaip cia perdaryti
                $timeManager = new TimeManager();
                $avgServiceTime = $timeManager->calculateAvgServiceTime($this->specialistId);

//                $avgServiceTime = $this->timeManager->calculateAvgServiceTime($this->specialistId);
                $this->waitTime = $index * $avgServiceTime;
                $this->expectedServiceTime = strtotime($value['service_start']) + $this->waitTime;
            }
            $index++;
        }
    }

}
