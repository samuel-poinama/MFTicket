<?php

require_once __DIR__ . '/DataBaseConnection.php';

class Group {
    private string $name;


    public function __construct(string $name) {
        $this->name = $name;
    }

    public function isAdmin(): bool {
        return $this->name == "admin";
    }

    public function isPermissionGranted(string $name): bool {
        return $this->isAdmin() || $this->name == $name;
    }

    public static function getGroupWithId($id) {
        $db = new DataBaseConnection();
        $result = $db->query("SELECT * FROM `groups` WHERE groups_id = $id");
        
        if ($result->rowCount() == 1) {
            $data = $result->fetchAll()[0];
            
            if (!self::isGroupExists($data['name'])) {
                self::setGroupWithId($id, "staff");
                $data['name'] = "staff";
            }
            
            return new Group($data['name']);
        } else {
            self::setGroupWithId($id, "staff");
            return new Group("staff");
        }

        return null;
    }

    private static function setGroupWithId($id, $name) {
        $db = new DataBaseConnection();
        $result = $db->execute("REPLACE INTO `groups` (groups_id, name) VALUES ($id, '$name')");
    }


    public static function createGroup($name) {
        if (self::isGroupExists($name)) {
            return;
        }

        $json = file_get_contents(__DIR__ . '/../../config.json');
        $data = json_decode($json, true);
        $data['groups'][] = $name;
        $json = json_encode($data);
        file_put_contents(__DIR__ . '/../../config.json', $json);
    }

    public static function deleteGroup($name) {
        $json = file_get_contents(__DIR__ . '/../../config.json');
        $data = json_decode($json, true);
        $index = array_search($name, $data['groups']);
        unset($data['groups'][$index]);
        $json = json_encode($data);
        file_put_contents(__DIR__ . '/../../config.json', $json);
    }

    public static function isGroupExists($name) {
        $json = file_get_contents(__DIR__ . '/../../config.json');
        $data = json_decode($json, true);
        return in_array($name, $data['groups']);
    }
}
