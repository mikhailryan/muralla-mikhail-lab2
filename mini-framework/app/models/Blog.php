<?php

namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;

class Blog extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getAllBlogs() {
        $sql = "SELECT b.*, u.first_name, u.username
                FROM blog b
                LEFT JOIN users u ON b.author_id = u.id
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBlogsByUser($userId) {
        $sql = "SELECT b.*, u.first_name, u.username
                FROM blog b
                LEFT JOIN users u ON b.author_id = u.id
                WHERE b.author_id = :author_id
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['author_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBlogById($id) {
        $sql = "SELECT * FROM blog WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateBlog($id, $title, $content) {
        $sql = "UPDATE blog SET title = :title, content = :content, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'id' => $id
        ]);
    }

    public function createBlog($data) {
        $sql = "INSERT INTO blog (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'author_id' => $data['author_id']
        ]);
        return $this->db->lastInsertId();
    }

    public function deleteBlog($id) {
        $sql = "DELETE FROM blog WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
