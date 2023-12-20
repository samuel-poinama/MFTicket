<?php

require_once __DIR__ . '/User.php';

class Ticket {
    private int $id;
    private string $name;
    private bool $isDone;

    public function __construct(int $id, string $name, bool $isDone) {
        $this->id = $id;
        $this->name = $name;
        $this->isDone = $isDone;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }


    public function isDone(): bool {
        return $this->isDone;
    }

    public function setDone(bool $isDone) {
        $this->isDone = $isDone;
    }

    public static function getAllTickets() {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM `tickets`");

        $tickets = [];

        foreach ($result->fetchAll() as $data) {
            $tickets[] = new Ticket($data['id'], $data['name'], $data['is_done']);
        }

        return $tickets;
    }

    public static function getTicketByName(string $name) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM `tickets` WHERE name = '$name'");

        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            return new Ticket($data['id'], $name, $data['is_done']);
        }

        return null;
    }

}