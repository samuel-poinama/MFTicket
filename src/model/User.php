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



    public static function getUserInDataBase($email, $password) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];

            return new User($data['id'], $data['email'], $data['password']);
        }

        return null;
    }
}