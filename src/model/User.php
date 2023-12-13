<?php
require_once __DIR__ . '/DataBaseConnection.php';
require_once __DIR__ . '/Token.php';


class Credentials {
    private int $id;
    private string $email;
    private Token|null $token;

    public function __construct(int $id, string $email) {
        $this->id = $id;
        $this->email = $email;
        $this->token = null;
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

                return $creds;
            }
        }

        return null;
    }


    private function generateToken() {
        $token = md5(uniqid(mt_rand()));
        $this->token = Token::getTokenFromDatabase($this->id);
        $isExpired = $this->token == null || $this->token->isExpired();
        var_dump("ok");
        if ($isExpired) {
            var_dump("ok");
            $this->token = Token::generateToken($this->id);
        }
    }
}