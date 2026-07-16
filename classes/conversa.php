<?php

require_once __DIR__ . "/model.php";

class Conversa extends Model
{

    protected string $table = "conversas";

    public function create(array $dados)
    {

        $sql = $this->db->prepare("
            INSERT INTO conversas
            (
                cliente_id,
                pergunta,
                resposta,
                valor_min,
                valor_max,
                complexidade,
                status
            )

            VALUES
            (
                :cliente,
                :pergunta,
                :resposta,
                :min,
                :max,
                :complexidade,
                :status
            )
        ");

        $sql->execute([

            "cliente"=>$dados["cliente_id"],

            "pergunta"=>$dados["pergunta"],

            "resposta"=>$dados["resposta"],

            "min"=>$dados["valor_min"],

            "max"=>$dados["valor_max"],

            "complexidade"=>$dados["complexidade"],

            "status"=>"Novo"

        ]);

        return $this->db->lastInsertId();

    }

}