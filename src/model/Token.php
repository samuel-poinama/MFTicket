<?php
require_once __DIR__ . '/DataBaseConnection.php';


class Token {

    private string $token;
    private int $expire;

    public function __construct(string $token, int $expire) {
        $this->token = $token;
        $this->expire = $expire;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function isExpired(): bool {
        return $this->expire < time();
    }

    public static function getTokenFromDatabase(int $id) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM tokens WHERE token_id = $id");

        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            $time = strtotime($data['expire']);
            return new Token($data['token'], $time);
        }

        return null;
    }

    public static function generateToken(int $id) {
        $token = md5(uniqid(mt_rand()));
        // 60 * 60 * 24 = 1 day in seconds
        $expire = time() + 60 * 60 * 24;
        $formated = date('Y-m-d H:i:s', $expire);
        $db = new DataBaseConnection();

        $result = $db->execute("REPLACE INTO tokens (token_id, token, expire) VALUES ($id, '$token', '$formated')");

        return new Token($token, $expire);
    }

}