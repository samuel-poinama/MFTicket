<?php
    // credentials for database connection

    class DataBaseConnection {
        private $pdo;

        public function __construct() {
            // connect to database
            $host = $_SERVER['HOST'];
            $port = $_SERVER['PORT'];
            $database = $_SERVER['DATABASE'];
            $user = $_SERVER['USER'];
            $password = $_SERVER['PASSWORD'];
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $user, $password);


            // throw exception if database not connected
            if (!$this->pdo) {
                throw new Exception("Database not connected");
            }
        }


        public function query($query) {
            // execute query
            $result = $this->pdo->query($query);


            // return result
            return $result;
        }
    }