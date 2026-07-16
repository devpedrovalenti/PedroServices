<?php

require_once __DIR__ . "/model.php";

class Projeto extends Model
{
    protected string $table = "projetos";

    public function create(array $dados): int
    {
        $sql = $this->db->prepare("
            INSERT INTO projetos
            (
                cliente_id,
                titulo,
                descricao,
                tipo,
                valor,
                prazo,
                status
            )
            VALUES
            (
                :cliente_id,
                :titulo,
                :descricao,
                :tipo,
                :valor,
                :prazo,
                :status
            )
        ");

        $sql->execute([

            "cliente_id" => $dados["cliente_id"],
            "titulo" => $dados["titulo"],
            "descricao" => $dados["descricao"],
            "tipo" => $dados["tipo"],
            "valor" => $dados["valor"],
            "prazo" => $dados["prazo"],
            "status" => $dados["status"] ?? "Orçamento"

        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $dados): bool
    {
        $sql = $this->db->prepare("
            UPDATE projetos SET

                titulo = :titulo,
                descricao = :descricao,
                tipo = :tipo,
                valor = :valor,
                prazo = :prazo,
                status = :status

            WHERE id = :id
        ");

        return $sql->execute([

            "id"=>$id,
            "titulo"=>$dados["titulo"],
            "descricao"=>$dados["descricao"],
            "tipo"=>$dados["tipo"],
            "valor"=>$dados["valor"],
            "prazo"=>$dados["prazo"],
            "status"=>$dados["status"]

        ]);
    }

    public function getByCliente(int $cliente): array
    {
        $sql = $this->db->prepare("
            SELECT *
            FROM projetos
            WHERE cliente_id = ?
            ORDER BY created_at DESC
        ");

        $sql->execute([$cliente]);

        return $sql->fetchAll();
    }

    public function alterarStatus(int $id, string $status): bool
    {
        $sql = $this->db->prepare("
            UPDATE projetos
            SET status = ?
            WHERE id = ?
        ");

        return $sql->execute([$status, $id]);
    }

    public function totalEmOrcamento(): int
    {
        return $this->db
            ->query("SELECT COUNT(*) FROM projetos WHERE status='Orçamento'")
            ->fetchColumn();
    }

    public function totalFinalizados(): int
    {
        return $this->db
            ->query("SELECT COUNT(*) FROM projetos WHERE status='Finalizado'")
            ->fetchColumn();
    }

    public function faturamentoPrevisto(): float
    {
        return (float)$this->db
            ->query("
                SELECT IFNULL(SUM(valor),0)
                FROM projetos
                WHERE status <> 'Cancelado'
            ")
            ->fetchColumn();
    }
}