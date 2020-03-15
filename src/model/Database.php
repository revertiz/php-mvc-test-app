<?php declare(strict_types = 1);

namespace Kodas\Model;

use PDO;
use Kodas\Config;


class Database
{
    private $host = Config::DB_HOST;
    private $user = Config::DB_USER;
    private $password = Config::DB_PASSWORD;
    private $db = Config::DB_NAME;
    protected $pdo;

    public function connect()
    {
        if ($this->pdo == null) {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
        return $pdo;
        }
        return $this->pdo;
    }

//    public function connect()
//    {
//        if ($this->pdo == null) {
//            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
//            $pdo = new PDO($dsn, $this->user, $this->password);
//            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//            $this->pdo = $pdo;
//            return $pdo;
//        }
//        return $this->pdo;
//    }

}
