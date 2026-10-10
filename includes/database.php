<?php

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/../classes/database.php";

// A conexão é aberta só quando alguém chama db() — assim a página pública
// continua abrindo mesmo que o banco esteja fora do ar.
function db(): PDO
{
    return Database::getInstance();
}
