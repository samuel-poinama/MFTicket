<?php
require_once __DIR__ . '/DataBaseConnection.php';


class User {
    private $id;
    private $email;
    private $password;

    public function __construct($id, $email, $password) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }


    public function isValidCredentials() {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM users WHERE email = '$this->email' AND password = '$this->password'");
        

        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];

        $this->id = $data['id'];

        return true;
        }
        return false;
    }
}