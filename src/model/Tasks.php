<?php

require_once __DIR__ . '/User.php';

class Task {
    private string $name;
    private bool $isDone;

    public function __construct(string $name, bool $isDone) {
        $this->name = $name;
        $this->isDone = $isDone;
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

    public static function getTaskById(int $id): Task|null {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM tasks WHERE tasks_id = $id");

        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            return new Task($data['name'], $data['isDone']);
        }

        return null;
    }

}