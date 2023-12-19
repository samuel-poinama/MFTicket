<?php
require_once __DIR__ . '/DataBaseConnection.php';
require_once __DIR__ . '/Token.php';
require_once __DIR__ . '/Groups.php';


class Credentials {
    private int $id;
    private string $email;
    private Token|null $token;
    private Group $group;

    public function __construct(int $id, string $email) {
        $this->id = $id;
        $this->email = $email;
        $this->token = null;
    }

    public function getGroup(): Group {
        return $this->group;
    }


    private function generateToken() {
        $this->token = Token::getTokenFromDatabase($this->id);
        $isExpired = $this->token == null || $this->token->isExpired();
        if ($isExpired) {
            $this->token = Token::generateToken($this->id);
        }
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
                $creds->group = Group::getGroupWithId($data['id']);

                return $creds;
            }
        }

        return null;
    }
}