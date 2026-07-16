<?php

require_once __DIR__ . "/database.php";

abstract class Model
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        $sql = $this->db->prepare("SELECT * FROM {$this->table}");
        $sql->execute();
        return $sql->fetchAll();
    }

    public function find(int $id)
    {
        $sql = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $sql->execute([$id]);
        return $sql->fetch();
    }

    public function delete(int $id): bool
    {
        $sql = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function count(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM {$this->table}")
            ->fetchColumn();
    }
}