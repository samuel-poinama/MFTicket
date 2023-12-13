<?php
require_once __DIR__ . '/DataBaseConnection.php';
require_once __DIR__ . '/Token.php';


class Credentials {
    private $id;
    private $email;
    private $token;
    private $db;

    public function __construct($id, $email) {
        $this->id = $id;
        $this->email = $email;
        $this->token = null;
        $this->db = new DataBaseConnection();
    }



    public static function getCredentials($email, $password) {
        $db = new DataBaseConnection();


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $db->query("SELECT * FROM credentials WHERE email = '$email'");


        if ($result->rowCount() == 1) {
            if (password_verify($password, $hashedPassword)) {
                $data = $result->fetchAll()[0];
                $creds = new Credentials($data['id'], $data['email'], $data['hash']);
                $creds->generateToken();
            }
        }

        return null;
    }


    private function generateToken() {
        $token = md5(uniqid(mt_rand()));
        $this->token = Token::getTokenFromDatabase($this->id);
        if ($this->token == null || $this->token->isExpired()) {
            $this->token = Token::generateToken($this->id);
        }
       
        
        return $token;
    }
}