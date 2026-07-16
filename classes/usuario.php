<?php

require_once __DIR__ . "/model.php";

class Usuario extends Model
{
    protected string $table = "usuarios";

    public function create(array $dados): int
    {
        $sql = $this->db->prepare("
            INSERT INTO usuarios
            (
                nome,
                email,
                senha
            )
            VALUES
            (
                :nome,
                :email,
                :senha
            )
        ");

        $sql->execute([

            "nome" => $dados["nome"],
            "email" => strtolower($dados["email"]),
            "senha" => password_hash($dados["senha"], PASSWORD_DEFAULT)

        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $dados): bool
    {
        $sql = $this->db->prepare("
            UPDATE usuarios SET

                nome = :nome,
                email = :email

            WHERE id = :id
        ");

        return $sql->execute([

            "id"=>$id,
            "nome"=>$dados["nome"],
            "email"=>strtolower($dados["email"])

        ]);
    }

    public function alterarSenha(int $id, string $senha): bool
    {
        $sql = $this->db->prepare("
            UPDATE usuarios
            SET senha = :senha
            WHERE id = :id
        ");

        return $sql->execute([

            "id"=>$id,
            "senha"=>password_hash($senha, PASSWORD_DEFAULT)

        ]);
    }

    public function emailExiste(string $email): bool
    {
        $sql = $this->db->prepare("
            SELECT id
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ");

        $sql->execute([strtolower($email)]);

        return $sql->rowCount() > 0;
    }

    public function getByEmail(string $email)
    {
        $sql = $this->db->prepare("
            SELECT *
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ");

        $sql->execute([strtolower($email)]);

        return $sql->fetch();
    }

    public function validarLogin(string $email, string $senha)
    {
        $usuario = $this->getByEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($senha, $usuario["senha"])) {
            return false;
        }

        return $usuario;
    }
}