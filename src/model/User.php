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
    private Ticket|null $ticket;

    public function __construct(int $id, string $email) {
        $this->id = $id;
        $this->email = $email;
        $this->token = null;
        $this->group = null;
        $this->ticket = null;
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

    public function getTicket(): Ticket|null {
        return $this->ticket;
    }

    public function getToken(): Token|null {
        return $this->token;
    }

    private function generateToken() {
        $this->token = Token::getTokenFromDatabase($this->id);
        $isExpired = $this->token == null || $this->token->isExpired();
        if ($isExpired) {
            $this->token = Token::generateToken($this->id);
        }
    }

    public function getUserByToken() {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT id, email, expire FROM users JOIN mfticket.tokens t on users.id = t.token_id WHERE token = '{$this->token->getToken()}'");
        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->token = new Token($this->token->getToken(), strtotime($data['expire']));
            $this->getTicketFromDatabase();
            if ($this->token->isExpired()) {
                var_dump('expired');
                session_unset();
                return;
            }

            $_SESSION['user'] = $this;
        }
    }

    public function getTicketFromDatabase() {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT tickets.id, name, isDone FROM tickets JOIN mfticket.users u on tickets.id = u.ticket_id WHERE u.id = {$this->id}");
        if ($result->rowCount() == 1) {
            var_dump('ok');
            $data = $result->fetchAll()[0];
            $this->ticket = new Ticket($data['id'], $data['name'], $data['isDone']);
        }
    }

    static public function isEmailExists($email): bool {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM users WHERE email = '$email'");

        return $result->rowCount() == 1;
    }

    public static function getUser($email, $password) {
        $db = new DataBaseConnection();

        $result = $db->query("SELECT users.id, email, hash FROM users JOIN mfticket.tickets t on t.id = users.ticket_id WHERE email = '$email'");


        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            if (password_verify($password, $data['hash'])) {
                $user = new User($data['id'], $data['email']);
                $user->generateToken();
                $user->group = Group::getGroupWithId($data['id']);

                return $user;
            }
        }

        return null;
    }

    public static function createUser($email, $hash) : bool {
        if (self::isEmailExists($email)) {
            return false;
        }

        $db = new DataBaseConnection();
        $db->execute("INSERT INTO users (email, hash) VALUES ('$email', '$hash')");
        return true;
    }

    public static function deleteUser($email) : bool {
        if (!self::isEmailExists($email)) {
            return false;
        }

        $db = new DataBaseConnection();
        $db->execute("DELETE FROM users WHERE email = '$email'");
        return true;
    }


    public static function getAllUsersEmailByGroup($group) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT users.id, t.id, email, g.name, t.name, isDone FROM users
        JOIN mfticket.`groups` g on users.id = g.groups_id
        LEFT JOIN mfticket.tickets t on users.ticket_id = t.id WHERE g.name ='$group';");

        $users = [];
        foreach ($result->fetchAll() as $data) {
            $user = new User($data[0], $data['email']);
            $user->group = new Group($data[3]);
            if ($data['id'] != null)
                $user->ticket = new Ticket($data['id'], $data['name'], $data['isDone']);
            $users[] = $user;
        }

        return $users;
    }

    public static function changeGroup($id, $group) : bool {
        if (!Group::isGroupExists($group)) {
            return false;
        }

        $db = new DataBaseConnection();
        $db->execute("UPDATE `groups` SET name = '$group' WHERE groups_id = $id");
        return true;
    }

}