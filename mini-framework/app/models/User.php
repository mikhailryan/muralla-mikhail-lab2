<?php

namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;

class User extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUser($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $sql = "INSERT INTO users (first_name, last_name, username, password, created_at, updated_at) 
                VALUES (:first_name, :last_name, :username, :password, NOW(), NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'password' => $data['password']
        ]);
        return $this->db->lastInsertId();
    }

    public function updateUser($data) {
        $sql = "UPDATE users 
                SET first_name = :first_name, last_name = :last_name, username = :username, 
                    password = :password, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'password' => $data['password']
        ]);
        return "Record UPDATED successfully";
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return "Record DELETED successfully";
    }
}
