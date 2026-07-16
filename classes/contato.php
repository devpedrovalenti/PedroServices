<?php

require_once __DIR__ . "/model.php";

class Contato extends Model
{
    protected string $table = "contatos";

    public function create(array $dados): int
    {
        $sql = $this->db->prepare("\n            INSERT INTO contatos (nome, email, telefone, assunto, mensagem, lido)\n            VALUES (:nome, :email, :telefone, :assunto, :mensagem, :lido)\n        ");

        $sql->execute([
            "nome" => $dados["nome"],
            "email" => $dados["email"],
            "telefone" => $dados["telefone"] ?? "",
            "assunto" => $dados["assunto"] ?? "",
            "mensagem" => $dados["mensagem"],
            "lido" => $dados["lido"] ?? 0
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function marcarComoLido(int $id): bool
    {
        $sql = $this->db->prepare("UPDATE contatos SET lido = 1 WHERE id = ?");
        return $sql->execute([$id]);
    }
}
