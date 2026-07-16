<?php

require_once __DIR__ . "/model.php";

class Cliente extends Model
{

    protected string $table = "clientes";

    public function create(array $dados)
    {

        $sql = $this->db->prepare("
            INSERT INTO clientes
            (
                nome,
                email,
                telefone,
                empresa
            )
            VALUES
            (
                :nome,
                :email,
                :telefone,
                :empresa
            )
        ");

        $sql->execute([

            "nome" => $dados["nome"],

            "email" => $dados["email"],

            "telefone" => $dados["telefone"],

            "empresa" => $dados["empresa"]

        ]);

        return $this->db->lastInsertId();

    }

    public function update(int $id, array $dados)
    {

        $sql = $this->db->prepare("
            UPDATE clientes SET

            nome=:nome,

            email=:email,

            telefone=:telefone,

            empresa=:empresa

            WHERE id=:id
        ");

        return $sql->execute([

            "id"=>$id,

            "nome"=>$dados["nome"],

            "email"=>$dados["email"],

            "telefone"=>$dados["telefone"],

            "empresa"=>$dados["empresa"]

        ]);

    }

}