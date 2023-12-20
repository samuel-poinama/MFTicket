<?php
require_once __DIR__ . '/DataBaseConnection.php';
require_once __DIR__ . '/Token.php';
require_once __DIR__ . '/Groups.php';
require_once __DIR__ . '/Tasks.php';


class User {
    private int $id;
    private string $email;
    private Token|null $token;
    private Group|null $group;
    private Task|null $task;

    public function __construct(int $id, string $email) {
        $this->id = $id;
        $this->email = $email;
        $this->token = null;
        $this->group = null;
        $this->task = null;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getGroup(): Group|null {
        return $this->group;
    }

    public function getTask(): Task|null {
        return $this->task;
    }

    private function generateToken() {
        $this->token = Token::getTokenFromDatabase($this->id);
        $isExpired = $this->token == null || $this->token->isExpired();
        if ($isExpired) {
            $this->token = Token::generateToken($this->id);
        }
    }

    public static function getUser($email, $password) {
        $db = new DataBaseConnection();

        $result = $db->query("SELECT * FROM credentials WHERE email = '$email'");


        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            if (password_verify($password, $data['hash'])) {
                $user = new User($data['id'], $data['email'], $data['hash']);
                $user->generateToken();
                $user->group = Group::getGroupWithId($data['id']);

                return $user;
            }
        }

        return null;
    }


    public static function getAllUsersEmailByGroup($group) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT id, email, g.name, t.name, isDone FROM credentials
            JOIN mfticket.`groups` g on credentials.id = g.groups_id
            LEFT JOIN mfticket.tasks t on credentials.id = t.tasks_id
            WHERE g.name = '$group';");

        $users = [];
        foreach ($result->fetchAll() as $data) {
            $user = new User($data['id'], $data['email']);
            $user->group = new Group($data[2]);
            if ($data['name'] != null)
                $user->task = new Task($data['name'], $data['isDone']);
            $users[] = $user;
        }

        return $users;
    }
}