<?php declare(strict_types = 1);


namespace Kodas\Model;

use Kodas\Model\TimeManager;
use PDO;
use Kodas\Model\Database;

class Specialist
{
    protected $id;
    protected $name;
    protected $averageServiceTime;
    private $pdo;
    private $timeManager;

    function __construct($data = [])
    {
        $this->id = $data['specialist_id'];
        $this->name = $data['specialist_name'];
        $this->averageServiceTime = $data['avg_time'];

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
//Situos reiktu perdaryt, kad imtu avgservicetime is time managerio
    public function getAvgServiceTime() : string
    {
        return gmdate("H:i:s", $this->averageServiceTime);
    }
//Situos reiktu perdaryt, kad imtu avgservicetime is time managerio
    public function getAvgServiceTimeSeconds() : string
    {
        return $this->averageServiceTime;
    }

    //Situos reiktu perdaryt, kad imtu avgservicetime is time managerio
    public function getAllSpecialists() : array
    {
        $sql = "SELECT * FROM specialist";
//        $sql = "SELECT specialist_id, specialist_name, TIME_TO_SEC(TIMEDIFF(service_end, service_start)) as timediff FROM specialist LEFT JOIN service_time ON specialist.specialist_id = service_time.fk_specialist_id";
//        $sql = "SELECT * FROM specialist LEFT JOIN user ON user.fk_specialist = specialist.specialist_id ORDER BY user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $specialistObjects = array();
        foreach ($results as $data) {
//            $timeManager = New TimeManager();
//            $avgServiceTime = $timeManager->calculateAvgServiceTime($data['specialist_id']);
            $avgServiceTime = $this->timeManager->calculateAvgServiceTime($data['specialist_id']);
            $data['avg_time'] = $avgServiceTime;
            array_push($specialistObjects, new Specialist($data));
        }

        return $specialistObjects;
    }

    public function getSpecialistById(string $id) : object
    {
        $sql = "SELECT * FROM specialist WHERE specialist_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);

        $results = $stmt->fetchAll();
        return new Specialist($results[0]);

    }

    public function serviceClientById(string $userId, string $specialistId)
    {
        $sql = "UPDATE user SET serviced = 1 WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userId]);

//        $timeManager = New TimeManager();
        $this->timeManager->setServiceTimeEnd($userId, $specialistId);
    }

}
