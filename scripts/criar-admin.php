<?php
// Uso (terminal):  php scripts/criar-admin.php
// Cria (ou atualiza a senha de) um administrador com e-mail e senha que VOCÊ escolhe.

if (PHP_SAPI !== "cli") {
    http_response_code(404);
    exit;
}

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../classes/database.php";

function perguntar(string $texto): string
{
    echo $texto;
    return trim((string)fgets(STDIN));
}

$nome  = perguntar("Nome: ");
$email = perguntar("E-mail: ");
$senha = perguntar("Senha (mín. 10 caracteres): ");

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 10 || $nome === "") {
    fwrite(STDERR, "Dados inválidos. Informe nome, e-mail válido e senha com pelo menos 10 caracteres.\n");
    exit(1);
}

$db   = Database::getInstance();
$hash = password_hash($senha, PASSWORD_DEFAULT);

$existe = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
$existe->execute([$email]);

if ($id = $existe->fetchColumn()) {
    $db->prepare("UPDATE usuarios SET nome = ?, senha = ? WHERE id = ?")->execute([$nome, $hash, $id]);
    echo "Administrador atualizado.\n";
} else {
    $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)")->execute([$nome, $email, $hash]);
    echo "Administrador criado.\n";
}
