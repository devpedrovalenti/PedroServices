<?php

require_once __DIR__ . "/model.php";

class Portfolio extends Model
{
    protected string $table = "portfolio";

    public function create(array $dados): int
    {
        $sql = $this->db->prepare("
            INSERT INTO portfolio
            (
                titulo,
                descricao,
                imagem,
                link,
                categoria,
                destaque
            )
            VALUES
            (
                :titulo,
                :descricao,
                :imagem,
                :link,
                :categoria,
                :destaque
            )
        ");

        $sql->execute([

            "titulo"=>$dados["titulo"],
            "descricao"=>$dados["descricao"],
            "imagem"=>$dados["imagem"],
            "link"=>$dados["link"],
            "categoria"=>$dados["categoria"],
            "destaque"=>$dados["destaque"] ?? 0

        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $dados): bool
    {
        $sql = $this->db->prepare("
            UPDATE portfolio SET

                titulo=:titulo,
                descricao=:descricao,
                imagem=:imagem,
                link=:link,
                categoria=:categoria,
                destaque=:destaque

            WHERE id=:id
        ");

        return $sql->execute([

            "id"=>$id,
            "titulo"=>$dados["titulo"],
            "descricao"=>$dados["descricao"],
            "imagem"=>$dados["imagem"],
            "link"=>$dados["link"],
            "categoria"=>$dados["categoria"],
            "destaque"=>$dados["destaque"]

        ]);
    }

    public function getDestaques(): array
    {
        $sql = $this->db->prepare("
            SELECT *
            FROM portfolio
            WHERE destaque = 1
            ORDER BY created_at DESC
        ");

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCategorias(): array
    {
        $sql = $this->db->query("
            SELECT DISTINCT categoria
            FROM portfolio
            ORDER BY categoria
        ");

        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    public function buscar(string $texto): array
    {
        $sql = $this->db->prepare("
            SELECT *
            FROM portfolio
            WHERE titulo LIKE ?
               OR descricao LIKE ?
               OR categoria LIKE ?
        ");

        $busca = "%{$texto}%";

        $sql->execute([
            $busca,
            $busca,
            $busca
        ]);

        return $sql->fetchAll();
    }

    public function removerImagem(int $id): bool
    {
        $sql = $this->db->prepare("
            UPDATE portfolio
            SET imagem = NULL
            WHERE id = ?
        ");

        return $sql->execute([$id]);
    }
}