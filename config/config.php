<?php
// config/config.php

// Função simples para simular o carregamento do .env caso não use o Composer
function carregarEnv($caminho) {
    if (!file_exists($caminho)) return;

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        if (strpos(trim($linha), '#') === 0) continue; // Ignora comentários

        list($nome, $valor) = explode('=', $linha, 2);
        $_ENV[trim($nome)] = trim($valor);
    }
}

// Carrega o arquivo .env localizado na raiz do projeto
carregarEnv(__DIR__ . '/../.env');

$host    = $_ENV['DB_HOST'] ?? 'localhost';
$db      = $_ENV['DB_NAME'] ?? 'humananucleo';
$user    = $_ENV['DB_USER'] ?? 'root';
$pass    = $_ENV['DB_PASS'] ?? '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em produção, mude para exibir uma mensagem genérica e logar o erro real
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}